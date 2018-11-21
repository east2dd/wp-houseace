<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $userId = $_POST['userId'];

        $changeDate = date('d/m/Y H:i');
        $changeUserId = $userId;
        $changeUserData = go_userdata($changeUserId);
        $changeWho = $changeUserData->first_name . " " . $changeUserData->last_name;

        // updating project status
        update_field('field_567db3a488cb0','completed',$projectId);

        // make Activity row
        $activityText = 'Thanks for using Houseace to complete your project';
        go_activity($activityText,'waiting',$changeDate,$changeUserId,$projectId);
  
        // sending email
        $subject = 'How did we go?';
        $title = 'Your project is now complete';
        $text = '<p> Looks like we have completed your project, hope it was a great experience. We have loved working with you.</p><p>Please login to leave a review about the service, this helps us provide the best experience for our users.  ' . get_bloginfo('url') . '/?p=' . $projectId . '</p>';
        go_email($subject,$title,$text,$clientId);
  


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
