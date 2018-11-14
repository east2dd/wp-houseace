<?php
require_once(ABSPATH . "wp-load.php");

// retrieving Invoice statistic of user
function go_invoice_statistic($id) {
	$object = new stdClass();
	$user_data = get_userdata($id);
	$pending = 0;
	$paid = 0;
	if($user_data != false) {
		$user_type = get_field('user_type','user_' . $id);
		if($user_type == 'Client') {
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice','meta_key'=>'client_id','meta_value'=>$id);
		}
		elseif($user_type == 'Agent') {
                        $agent_cleints = get_field('clients','user_' . $id);
                        $agent_cleints_to_show = array();
                        $agent_cleints_to_show[] = 0;
                        foreach($agent_cleints as $ac) {
                              $agent_cleints_to_show[] = array('key'=>'client_id','value'=>$ac['ID']);
                        }
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice','meta_query'=>array('relation' => 'OR',$agent_cleints_to_show));
		}
		else {
			$args = array('posts_per_page'=>-1,'post_type'=>'invoice');
		}
		
		$all_invoices = get_posts($args);
		foreach($all_invoices as $invoice) {
			$status = get_field('status',$invoice->ID);
			if($status == 'Pending') {
				$pending++;
			}
			elseif($status == 'Paid') {
				$paid++;
			}			
		}
		
		$object->pending = $pending;
		$object->paid = $paid;
	}
	else {
		$object = false;
	}
	
	return $object;
}

function go_invoice_actions($actions,$id) {
        $action_code = '';
        foreach($actions as $act) {
                if($act == 'paid') {
                        $action_code = $action_code . "<i class='icon wb-order green-600 margin-right-20' style='cursor:default;' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Marked as Paid' title=''></i>";
                }
                elseif($act == 'mark_paid') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Approve' title=''><i data-target='#paid' data-toggle='modal' data-invoice='" . $id . "' class='icon wb-check green-600 paid'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='paid' aria-hidden='true' aria-labelledby='paid' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to mark invoice as Paid?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='paid_invoice_respopnse'></div>
                                				<div class='paid_invoice_hidden' style='display:none;'></div>
                                				<a class='btn btn-success paid_invoice' data-invoice=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm cancel_invoice' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'remind') {
                        $action_code = $action_code . "<a data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Remind' title=''><i data-target='#remind' data-toggle='modal' data-invoice='" . $id . "' class='icon wb-bell blue-600 remind'></i></a>";
                        $action_code = $action_code . "<div class='modal fade' id='remind' aria-hidden='true' aria-labelledby='remind' role='dialog' tabindex='-1'>
                                	<div class='modal-dialog modal-center'>
                                		<div class='modal-content'>
                                			<div class='modal-header text-center'>
                                				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                					<span aria-hidden='true'>×</span>
                                				</button>
                                				<h4 class='modal-title'>Are you sure you want to remind client about invoice?</h4>
                                			</div>
                                			<div class='modal-body text-center'>
                                				<div id='remind_invoice_respopnse'></div>
                                				<div class='remind_invoice_hidden' style='display:none;'></div>
                                				<a class='btn btn-success remind_invoice' data-invoice=''>Yes, please!</a>
                                				<a class='btn btn-default btn-sm cancel_remind_invoice' data-dismiss='modal' aria-label='Close'>No, i was wrong</a>
                                			</div>
                                		</div>
                                	</div>
                                </div>";
                }
                elseif($act == 'preview') {
                        $action_code = $action_code . "<a class='preview' href='" . get_bloginfo('url') . "/?p=" . $id . "' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Details' title=''><i class='icon wb-more-horizontal'></i></a>";
                }
        }
        
        echo $action_code;
}

function go_send_invoice_email($invoice_id, $action, $who = null, $milestone_title = null){
        $title = get_the_title($invoice_id);
        $client_id = get_field('client_id',$invoice_id);
        
        /*
        *
        * SENDING EMAIL
        *
        */
        
        if($action == 'paid'){
			$subject = 'Thank you for payment!';
			$text = '<p>We have just recievd payment for ' . $inv_title . '</p><b>Kind Regards, All at Paynt</b>';
		}
		elseif($action == 'remind'){
			$subject = 'You have an outstanding invoice!';
			$text = '<p>You have an outstanding invoice ' . $inv_title . ' payment.</p><p>Invoice details: ' . get_bloginfo('url') . '/?p=' . $invoice_id . '</p><br/><p>All invoices are due on the due date. Please ignore if you have already paid. </p>';			
		}
		elseif($action == 'create'){
			$quote_id = get_field('project_id',$invoice_id);
			$subject = 'You have a new invoice';
			$title = 'Here is your new invoice: ' . $milestone_title;
			$text = '<p>You have a new invoice availible: ' . $milestone_title . '.</p><p>Job details: ' . get_bloginfo('url') . '/?p=' . $quote_id . '</p><p>New invoice generated, you can see details: ' . get_bloginfo('url') . '/?p=' . $invoice_id . '</p>';
		}
        if(!empty($text))
			go_email($subject,$title,$text,$client_id);
}

function go_create_invoice($quote_id, $client_id, $quote_milestone){
	$rand = rand(1111,9999); 
	$date = date('d/m/Y H:i');
	
	$total = getProjectTotal($quote_id);
	$client_data = go_userdata($client_id);
	$payments = get_field('payments',$quote_id);
	$payment = $payments[$quote_milestone];
	
	$number = $rand . "_" . $quote_id . "_" . $quote_milestone;
	$invoice_title = "Invoice to " . $client_data->first_name . " " . $client_data->last_name . " #" . $number;
	$milestone_title = $payment['title'];
	$invoice_status = 'Pending';
	$milestone_percent = $payment['percent'];
	$milestone_price = ($milestone_percent * $total) / 100;
	$milestone_price = number_format($milestone_price, 2, '.', '');
	$post_information = array(
		'post_title' => $invoice_title,
			'post_name' => $number,
		'post_content' => '',
		'post_type' => 'invoice',
		'post_status' => 'publish'
	);
	$new_object_id = wp_insert_post( $post_information );
	update_field('field_569d3c6969a82',$number,$new_object_id);
	update_field('field_569d0dfa85a14',$invoice_status,$new_object_id);
	update_field('field_569d0d18475dc',$milestone_title,$new_object_id);
	update_field('field_56e1e9b2c4626',$quote_milestone,$new_object_id);
	update_field('field_569d0d8c475de',$milestone_percent,$new_object_id);
	update_field('field_569d0d23475dd',$milestone_price,$new_object_id);
	update_field('field_569d0ce7475da',$client_id,$new_object_id);
	update_field('field_569d0cfe475db',$quote_id,$new_object_id);
	
	// make Notification and sent it to Client
	$notification_text = 'New invoice generated for Payment "' . $milestone_title . '"';
	go_notification($notification_text,'invoice',$date,$client_id,$new_object_id);
	
	return $new_object_id;
}	
?>