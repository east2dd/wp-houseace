<?php

global $need_starrating;

$need_starrating = array(
	'styles' => true,
	'scripts' => true
);

// getting defaults
$projectId = get_the_ID();

// get all Scope prices and store them in Project custom field
go_recalculate_project($projectId);

// getting project participants
$clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
$clientData = go_userdata($clientId);

$agentsId = get_field('agent_id',$projectId);
$agentsArray = array();
foreach($agentsId as $a) {
	$agentsArray[] = $a['ID'];
}

$contractorsId = get_field('contractor_id',$projectId);
$contractorsArray = array();
foreach($contractorsId as $c) {
	$contractorsArray[] = $c['ID'];
}

// get project details
$projectStatus = go_project_status($projectId);
$projectCity = get_field('projectCity',$projectId);
$projectTimeframe = get_field('projectTimeframe',$projectId);
$projectPayments = get_field('payments',$projectId);
$projectVariations = get_field('add_payments',$projectId);

// set client approvement based on project status
if($projectStatus->status == 'live' || $projectStatus->status == 'completed') {
	$clientApprove = true;
}
else {
	$clientApprove = false;
}

// get total of project based on subtotals of scopes
$projectTotal = getProjectTotal($projectId);

$client_string = get_field('client','options');
$contractor_string = get_field('contractor','options');
$agent_string = get_field('agent','options');
$head_string = get_field('head_contractor','options');

    global $post;
    $post_slug=$post->post_name;

$logo = get_field('invLogo','user_' . $agentsId); 
$size = "medium"; 
$clogo = wp_get_attachment_image_src( $logo, $size );

?>

<?php get_header(); ?>

<div class="navbar navbar-default navbar-fixed-top bg-white">
  <div class="navbar-container container-fluid">
    <div class="navbar-brand bg-red-600">
      <a href="https://www.houseace.com.au">
        <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" title="Houseace">
      </a>
    </div>    
  </div>			
</div>

   
<div class="container">

<div class="row padding-top-20">
      <div class="visible-xs">
        <?php echo $projectStatus->status; ?>
      </div>

      <div class="col-md-8">
        <div class="panel">
        <div class="panel-body">

          <div class="font-size-25 font-weight-400 blue-grey-800"><?php the_title(); ?></div>
          <div class="font-size-20 blue-grey-800">
            <i class="icon wb-map margin-right-10 blue-grey-800" aria-hidden="true"></i>
            <span class="text-break newAddress"><?php echo $clientData->address; ?></span>
          </div>

          <div class="row padding-10">
            <div class="col-md-12 col-sm-12">
              <div class="font-size-15 font-weight-400 blue-grey-800 inline">Quote Number: </div>
              <div class="font-size-15 cyan-800 inline"> #<?php echo $post_slug; ?> || </div>
              <div class="font-size-15 font-weight-400 blue-grey-800 inline"> Quote Date: </div>
              <div class="font-size-15 blue-grey-500 inline"> <?php echo get_the_date('d-m-y');?> || </div>
              <div class="font-size-15 blue-grey-500 inline">
                <i class="icon wb-time  margin-right-10 blue-grey-800"></i>&nbsp;&nbsp;
                <span class="updateTimeframe"><?php echo $projectTimeframe; ?></span>
              </div>
            </div>
          </div>

          <div class="row padding-top-20 padding-bottom-20">
            <div class="col-md-12">
              <div class="font-size-30 inline blue-grey-800">Schedule/Timings</div>
              <hr>
              <?php include('views_v2/projectSchedulePublic.php'); ?>
            </div>
          </div>

          <div class="row"> <?php include('views_v2/projectReview.php'); ?> </div>

          <div id="projectCompletingResponse"></div>
          <div id="projectAcceptingResponse"></div>
													
          <div class="row">
														
<?php $projectScope = get_field('projectScopes',$project_id);

$arrayNames = array();
foreach($projectScope as $pS) {

	$scopeId = $pS;

	$scopeData = get_field('scopeData',$scopeId);
	$scopeDataDecoded = base64_decode($scopeData);
	$scopeDataArray = json_decode($scopeDataDecoded,true);
	$scopeLevel = get_field('scopeLevel',$scopeId);
	$scopeLevel = get_term( $scopeLevel, 'selection_level' );
	$scopeLevel = $scopeLevel->name;
    $scopePrice = getScopePrice($scopeId, $projectId);
	$scopeTemplateId = get_field('scopeTemplate',$scopeId);
	$scopeTemplateFields = get_field('quote_fields',$scopeTemplateId);
	
	$customQuoteFieldTitle = $scopeDataArray['customQuoteFieldTitle'];
	$customQuoteFieldDescription = $scopeDataArray['customQuoteFieldDescription'];

	$scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

	$message = '<div class="row margin-top-20">';
	$message .= '<div class="col-md-6"><div class="font-size-20 blue-grey-800 font-weight-100">' . $scopeDataArray["projectName"] . '</div></div>';
	$message .= '</div><hr>';
	$message .= '<div class="row padding-20">';
	foreach($scopeDetails as $sD) {

	$valueKeyFirst = $sD['section_title'];
	$valueKeyFirst = preg_replace("/[^a-zA-Z]/", "", $valueKeyFirst);
	$valueKeyFirst = strtolower($valueKeyFirst);

	  $message .= '<div class="col-md-12">';
	  $message .= '<div class="font-size-20 margin-0 blue-grey-700"><b>' . $sD['section_title'] . '</b></div><hr>';
	  foreach($sD['section_values'] as $value) {

		if($value == NULL) {
			$message .= 'N/A';
		}
		else {
		  $message .= '<p class="blue-grey-500">' . $value . '</p>';
		  $cleanValue = explode(' x', $value);
		  $cleanValue = $cleanValue[0];
		  $valueKeyLast = preg_replace("/[^a-zA-Z]/", "", $cleanValue);
	  	  $valueKeyLast = strtolower($valueKeyLast);
		  $valueKey = $valueKeyFirst . '_' . $valueKeyLast;
		  $arrayNames[$valueKey] = $sD['section_title'] . ': ' . $value;

		  // looking for description
		  $count = count($scopeTemplateFields);
		  $i=1;
		  while($i <= $count) {
				  if($scopeTemplateFields[$i]['title'] == $sD['section_title']) {
						  foreach($scopeTemplateFields[$i]['fields'] as $field) {
								  if($field['title'] == $cleanValue) {
										  if($field['description'] != '') {
											  	$desc = $field['description'];
													 $desc = strip_tags($desc);
												  $message .= "<p class='margin-0 blue-grey'>(" . $desc . ")</p><br />";
										  }
										  else {
												  $message .= "";
										  }

								  }
						  }
				  }
				  $i++;
		  }

		}
	  }
	  $message .= '</div>';
	}
	//View Repeater's fields
	foreach($customQuoteFieldTitle as $customFieldId => $title ){
		$message .= '<div class="col-md-12">';
			$message .= "<div class=\"font-size-20 margin-0 blue-grey-700\"><b>$title</b></div><hr>";
			
			$message .= $customQuoteFieldDescription[$customFieldId] ? "<p class=\"blue-grey-500\">$customQuoteFieldDescription[$customFieldId]</p><hr>" : "";
		$message .= '</div>';
	}

	$message .= '</div>';
	$editor .= $message;

} ; ?>
              <div class="col-md-12 text-left"><?php echo $editor ;?></div>						
            </div>
                        
          </div>
        </div>
      </div>

      <div class="col-md-4">
                  <?php // PL ?>
                  <?php
                    $projectAgentLead = get_field('plMain',$projectId);
                    if($projectAgentLead['ID']) {
                      $projectAgentLead = $projectAgentLead['ID'];
                    }
                    else {
                      $projectAgentLead = $projectAgentLead[0];
                    }
                    foreach($agentsArray as $agentId) :
                      $agentData = go_userdata($agentId);
                      if($agentId == $projectAgentLead) {
                        $agentLead = true;
                      }
                      else {
                        $agentLead = false;
                      }
                  ?>

		    <div class="widget text-center">
          <div class="widget-header bg-red-600 padding-20">
            <a href="<?php bloginfo('url'); ?>"><img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" alt=""></a>
          </div>
          <div class="widget-header">
            <div class="widget-header-content">
              <div class="avatar padding-top-10 avatar-lg">
                <img src="<?php echo $agentData->avatar; ?>">
              </div>
              <h4 class="profile-user"><?php echo $agentData->first_name; ?> <?php echo $agentData->last_name; ?></h4>
              <div class="profile-job">
                <p> <?php the_field('invCompany_name','user_' . $agentId); ?> </p>
              </div>
              <div class="profile-job">
                <p><?php echo $agentData->email; ?></p>
                <p><?php echo $agentData->phone; ?></p>
              </div>
            </div>
          </div>
        </div>
            
                      <?php endforeach; ?>
                    <?php // *** END PL ?>
  
		  </div>
	  </div>
  </div>
<?php get_footer(); ?>