<?php
require_once(ABSPATH . "wp-load.php");
function getUserProjects($user_id){
	$meta_query	= array(
		'relation'		=> 'OR',
		array(
			'key'	 	=> 'contractor_id',
			'value'	  	=> "\"{$user_id}\"",
			'compare' 	=> 'LIKE',
		),
		array(
			'key'	  	=> 'agent_id',
			'value'	  	=> "\"{$user_id}\"",
			'compare' 	=> 'LIKE',
		)
	);

	$args = array(
		'post_type' => 'project',
		'meta_query' => $meta_query
	);

	return get_posts($args);	
}

function getSchedule($user_id){
	$projects = getUserProjects($user_id);

	$dates = array();
	foreach($projects as $project){
		$schedules = get_field('schedule', $project->ID);
		foreach($schedules as $schedule){
			$title = trim(explode("-", $project->post_title)[0]);
			$dates[] = array(
				'title' => "{$title}({$schedule['title']})",
				'start' => $schedule['date_from'],
				'end' => $schedule['date_to'],
			);
		}
	}
	
	return $dates;
}



function getRating($user_id){
	$projects = getUserProjects($user_id);
	
	$total_rating = 0;
	$count = count($projects);
	foreach($projects as $project){
		$rating = get_field('projectRating', $project->ID);
		if( empty($rating) ) $count--;
		else $total_rating += $rating;
	}
	
	if( empty($count) ) return 0;
	return round($total_rating/$count, 0);
}
function getCityByAddress($address){
	$ch = curl_init(); 
	$google_geocode_url = "https://maps.googleapis.com/maps/api/geocode/json";
	$geo_key = "AIzaSyB74uGdIYmNNXtwNLILLN33e6AJ75V1CPw";
	
	$address = str_replace(" ", "+", $address);
	curl_setopt($ch, CURLOPT_URL, "$google_geocode_url?address=$address&key=$geo_key"); 
	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	
	// $output contains the output string 
	$json = curl_exec($ch); 
	curl_close($ch); 
	
	$data = json_decode($json);
	foreach($data->results[0]->address_components as $component){
		if(in_array('locality', $component->types)) return $component->short_name;
	}
}
function getContractorsByCity($city){
	$meta_query = array(
		'relation' => 'AND', 
		array(
			'key'     => 'address',
			'value'   => $city,
			'compare' => 'LIKE'
		),
		array(
			'key'     => 'user_type',
			'value'   => 'Contractor',
			'compare' => '='
		)
	);
	$contractors = get_users(['meta_query' => $meta_query]);
	$output = [];
	foreach($contractors as $contractor){
		$user_data = go_userdata($contractor->ID);
		$output[$contractor->ID] = array(
			'user_id' => $contractor->ID,
			'avatar' => $user_data->avatar,
			'email' => $user_data->email,
			'phone' => $user_data->phone,
			'full_name' => "{$contractor->first_name} {$contractor->last_name}",
			'profile_link' => "/profile/{$contractor->data->user_login}",
			'business_name' => get_field('business_name',"user_{$contractor->ID}"),
			'schedule' => getSchedule($contractor->ID),
			'rating' => getRating($contractor->ID),
			'city' => $city
		);
	}
	
	return $output;
}

function sortContractorsByRating($data){
	usort($data, function ($a, $b) {
		return $a['rating'] - $b['rating'];
	});
	
	return $data;
}


function isContractorAvailable($contractor_schedule, $date){
	foreach($contractor_schedule as $interval){
		$start = strtotime($interval['start']);
		$end = strtotime($interval['start']);
		$date = strtotime($date);
		if( $start >= $date && $date < $end ) return false;
	}
	return true;
}

function getAvailabelContractors($user_address, $date){
	$city = getCityByAddress($user_address);
	$sortedContractors = sortContractorsByRating(getContractorsByCity($city));
	$availableContractors = [];
	foreach($sortedContractors as $contractor){
		//get only free contractors
		if(isContractorAvailable($contractor['schedule'], $date)) $availableContractors[$contractor['user_id']] = $contractor;
	}
	return $availableContractors;
}
?>
