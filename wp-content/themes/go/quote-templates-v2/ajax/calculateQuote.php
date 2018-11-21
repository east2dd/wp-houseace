<?php
require_once("../../../../../wp-load.php");
// getting default values
$v2 = true;
if( $_POST ) {
	
	$projectData = $_POST;
	$template_id = $_POST['templateId'];
	$scopeDetailes = go_scope_details_by_scope_data($template_id, $projectData);
	$scopeSelectionsArray = go_get_default_selections($scopeDetails);
	$result = go_calculate_by_selections($projectData, $scopeSelectionsArray);
	
	$total = $result->total;
	if(!empty($_POST['customQuoteFieldPrice'])){
		foreach($_POST['customQuoteFieldPrice'] as $price){
			$total += $price;
		}
	}
	
	echo json_encode([
		'message' => $total,
		'status' => 200
	]);
}
?>
