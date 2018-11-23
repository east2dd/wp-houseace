<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $projectStatus = $_POST['projectStatus'];
        $projectStatusBefore = $_POST['projectStatusBefore'];
        $clientId = get_field('client_id',$projectId); $clientId = $clientId['ID'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = current_user_id();
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        if( $projectStatus != 'quote' && $projectStatus != 'active' && $projectStatus != 'pending' && $projectStatus != 'live' && $projectStatus != 'completed' && $projectStatus != 'cancelled' ) {
            $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Invalid Status!</div>";
                echo json_encode( array("message" => $message, "status" => 'fail') );
                die;
        }

        $projectPayments = get_field('payments',$projectId);
        if($projectStatus == 'final quote' && !is_array($projectPayments)) {
          $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You can't make project In Proposal while not set up Payments!</div>";
          echo json_encode( array("message" => $message, "status" => 'fail') );
          die;
        }

        // updating project status
        update_field('field_567db3a488cb0',$projectStatus,$projectId);

        if($projectStatus == 'quote') {
            $newStatus = 'Pre Quote';
        }
        elseif($projectStatus == 'pending') {
            $newStatus = 'Final Quote';
          
           // sending email
        $subject = 'Here is your final quote';
        $title = 'Your quote has been finalised!';
        $text = '<p>Check out your final quote, follow the link below to view online.</p><br/><p>*Remember to review the scope, schedule and payments before click the green booking button.</p><p>You can login and check the details here: ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
  
        }
        elseif($projectStatus == 'live') {
            $newStatus = 'Accepted Quote';
			
              
        $subject = 'Awesome! We have begun working on your project.';
        $title = 'Your project is now underway';
        $text = '<p>Your quote is now live. </p><br/> <b>Next Steps:</b><p>1: Pay your Deposit - this is done on the project screen. </p><p>2: Choose Colours - we can help you with this.</p><p>3: Sit back and relax!</p> <p>Manage payments & schedule, message your manager and upload photos to your live Job here here: ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
        
			//change first project payment
			$projectPayments = get_field('payments',$projectId);
			$quoteMilestone = 0;
			$milestoneTitle = $projectPayments[$quoteMilestone]['title'];
			
			$projectPayments[$quoteMilestone]['status'] = 'done';
			$projectPayments[$quoteMilestone]['done'] = true;
			$projectPayments[$quoteMilestone]['due_date'] = date('Y/m/d');
			
			$projectPayments[$quoteMilestone+1]['status'] = 'active';
			$invoice_id = go_create_invoice($projectId, $clientId, $quoteMilestone);
			$projectPayments[$quoteMilestone]['invoice_id'] = $invoice_id;
			//if(!empty($projectPayments[0]['invoice_id'])) go_send_invoice_email($projectPayments[0]['invoice_id'], 'remind');
			update_field('payments',$projectPayments,$projectId);// make Activity row
			
			go_send_invoice_email($invoice_id, 'create', $changeWho, $milestoneTitle);
			
			$date = date('d/m/Y H:i');
			$activity_text = $changeWho . ' marked Payment "' . $milestoneTitle . '" as Done.';
			go_activity($activity_text,'done',$date,$changeUserId,$projectId);
			
			// make Notification and sent it to Client
			$notification_text = $changeWho . ' marked Payment "' . $milestoneTitle . '" as Done.';
			go_notification($notification_text,'done',$date,$clientId,$projectId);
        }
        elseif($projectStatus == 'completed') {
            $newStatus = 'Completed';
          
             // sending email
        $subject = 'How did we go?';
        $title = 'Your project is now complete';
        $text = '<p> Looks like we have completed your project, hope it was a great experience. We have loved working with you.</p><p>Please login to leave a review about the service, this helps us provide the best experience for our users.  ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
  

        }
        elseif($projectStatus == 'cancelled') {
            $newStatus = 'Cancelled';
        $subject = 'You quote has been cancelled or closed';
        $title = 'Thanks for using Houseace';
        $text = '<p> We have cancelled your project!</p><p>You can login a re-open or just get back in touch if this is a mistake.  ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
        
        }

        if($projectStatusBefore == 'quote') {
            $newStatusBefore = 'Pre Quote';
        }
        elseif($projectStatusBefore == 'pending') {
            $newStatusBefore = 'Final Quote';
        }
        elseif($projectStatusBefore == 'live') {
            $newStatusBefore = 'Accepted Quote';
       
        }
        elseif($projectStatusBefore == 'completed') {
            $newStatusBefore = 'Completed';
        
        }
        elseif($projectStatusBefore == 'cancelled') {
            $newStatusBefore = 'Cancelled';
          
        }

        // make Activity row
        $activityText = $changeWho . ' updated your quote from ' . $newStatusBefore . ' to ' . $newStatus;
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);

       
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
