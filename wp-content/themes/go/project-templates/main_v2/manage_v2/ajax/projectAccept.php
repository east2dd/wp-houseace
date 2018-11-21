<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $userId = $_POST['userId'];

        $clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];
        $agentId = get_field('agent_id',$projectId); $agentId = $agentId['ID'];
  
        $changeDate = date('d/m/Y H:i');
        $changeUserId = $userId;
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // make first Payment pending->active
        $projectPayments = get_field('payments',$projectId);
        /*$projectPaymentsTemp = array();
        $i=0;
        foreach($projectPayments as $p) {
			$projectPaymentsTemp[] = $p;
            $title = $p['title'];
            $description = $p['description'];
            $percent = $p['percent'];
            $date = $p['date'];
            if($i == 0) {
                    $status = 'active';
            }
            else {
                $status = $p['status'];
            }
            $done = $p['done'];
            $paid = $p['paid'];
            $invoice = $p['invoice_id'];
            $adjustments = $p['adjustments'];
            $projectPaymentsTemp[] = array('title' => $title, 'description' => $description, 'percent' => $percent, 'due_date' => $date, 'status' => $status, 'done' => $done, 'paid' => $paid, 'invoice_id' => $invoice, 'adjustments' => $adjustment);
            $i++;
        }*/
		//$projectPayments[0]['status'] = 'done';
		//$projectPayments[0]['done'] = true;
		$quoteMilestone = 0;
		$milestoneTitle = $projectPayments[$quoteMilestone]['title'];
		
		$projectPayments[$quoteMilestone]['status'] = 'done';
		$projectPayments[$quoteMilestone]['done'] = true;
		$projectPayments[$quoteMilestone]['due_date'] = date('Y/m/d');
		
		$projectPayments[$quoteMilestone+1]['status'] = 'active';
		$invoice_id = go_create_invoice($projectId, $clientId, $quoteMilestone);
		$projectPayments[$quoteMilestone]['invoice_id'] = $invoice_id;
        update_field('payments',$projectPayments,$projectId);
        //update_field('field_567eedc8a0297',$projectPaymentsTemp,$projectId);
		go_send_invoice_email($invoice_id, 'create', $changeWho, $milestoneTitle);
        // updating project status
        update_field('field_567db3a488cb0','live',$projectId);

        // make Activity row
        $activityText = $changeWho . ' changed quote status to accepted';
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

        
        $subject = 'Awesome! We have begun working on your Houseace Project.';
        $title = 'Your Job is now underway';
        $text = '<p>Your quote is now live. </p><br/> <b>Next Steps:</b><p>1: Pay your Deposit - this is done on the project screen. </p><p>2: Choose Colours - we can help you with this.</p><p>3: Sit back and relax - Enjoy the service!</p> <p>Manage payments & schedule, message your manager and upload photos to your live Job here here: ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
        
               if(is_agent()) {
                        $subject = $changeWho . ' approved project!';
                        $title = 'Quote was approved by ' . $changeWho . '!';
                        $text = '<p>' . $changeWho . ' approved the quote and now it is Live.</p><p>Quote details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p>';
                        go_email($subject,$title,$text,$agentId);
                }


        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
