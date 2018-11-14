<?php
require_once(ABSPATH . "wp-load.php");

// saving project coupon
function project_save_coupon($coupon,$projectId) {
	$coupon = trim($coupon);
	$coupon_meta_query = array(
		'relation' => 'AND',
		array(
			'key'     => 'meta_coupon_code',
			'value'   => $coupon,
			'compare' => '='
		),
		array(
			'key'     => 'meta_expiry',
			'value'   => date('Y-m-d'),
			'compare' => '>='
		)
	);
	
	$coupon_args = [
		'post_type' => 'coupon',
		'meta_query' => $coupon_meta_query
	];
	
	$coupons = get_posts($coupon_args);
	if(empty($coupons)) return [
		'status' => 'danger',
		'message' => 'Sorry, the coupon doesn`t exist, or has expired'
	];
	
	$discount = get_post_meta($coupons[0]->ID, 'wps_coupon_offer', true);
	
	update_field('coupon', $coupon, $projectId);
	update_field('discount', $discount, $projectId);

	return [
		'status' => 'success',
		'message' => 'The coupon has been activated successfully'
	];
}

function getProjectTotal($projectId){
	$projectTotal = get_field('total',$projectId);

	$projectDiscount = get_field('discount', $projectId);
	return round($projectTotal * (100 - $projectDiscount) / 100, 2);
}

function displayProjectTotal($projectId){
	$projectTotal = get_field('total',$projectId);

	$projectDiscount = get_field('discount', $projectId);
	$projectTotalWithDiscount = getProjectTotal($projectId);
	
	if(empty($projectDiscount)) return $projectTotal;
	
	return "<s>{$projectTotal}</s> {$projectTotalWithDiscount}(-{$projectDiscount}%)";
}

function getScopePrice($scopeId, $projectId){
	$scopePriceTemp = get_field('scopePrice',$scopeId);
	$scopeAdjustment = get_field('totalAdjustment',$scopeId);
	$scopePrice = $scopePriceTemp + $scopeAdjustment;
	
	$projectDiscount = get_field('discount', $projectId);
	
	return $scopePrice * (100 - $projectDiscount) / 100;
}
?>
