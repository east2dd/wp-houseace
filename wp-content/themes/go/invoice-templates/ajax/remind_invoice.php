<?php 
/*
This is AJAX function make invoice Paid
*/
require_once("../../../../../wp-load.php");
$date = date('d/m/Y H:i');
$user_id = current_user_id();
$who = $user_data->first_name . " " . $user_data->last_name;

if($_POST && $_POST['invoice_id']) {
        $invoice_id = $_POST['invoice_id'];
       
        go_send_invoice_email($invoice_id, 'remind');
        
        /*
        *
        * END SENDING EMAIL
        *
        */
        
        // showing response message
        echo "<div class='text-center margin-vertical-20 green-600'>Reminder was sent! Page will be reloaded...</div>";
        echo "<script>$('.cancel_remind_invoice').html('Close').show(); setTimeout(function(){location.reload();},2000);</script>";
        die;
}
else {
        echo "<div class='text-center margin-bottom-20 red-800'>Something went wrong!</div>";
        echo "<script>$('.remind_invoice').show(); $('.cancel_remind_invoice').show();</script>";
        die;
}
?>