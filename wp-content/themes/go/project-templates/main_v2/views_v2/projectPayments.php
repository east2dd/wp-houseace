<?php
require_once( ABSPATH . 'wp-load.php');
// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();

$projectPayments = get_field('payments',$projectId);
$projectTotal = getProjectTotal($projectId);

$projectCoupon = get_field('coupon', $coupon);


$projectPaid = get_field('paid',$projectId);
if(!$projectPaid) { $projectPaid = 0; }
$projectPaid = number_format($projectPaid, 2, '.', '');
$projectToPay = get_field('topay',$projectId);
if(!$projectToPay) { $projectToPay = 0; }
$projectToPay = number_format($projectToPay, 2, '.', '');
?>

<?php // Project milestones ?>
<div class="panel panel-bordered">
            <div class="padding-10 bg-grey-200 blue-grey-800">
             <div class="hidden-xs">
     <div class="font-size-30 margin-20 inline">
               Payments <div class="inline pull-right">
              $<?php echo displayProjectTotal($projectId); ?>
               </div> 
      </div><div class="font-size-20 inline">
     <i class="icon fa-cc-mastercard" aria-hidden="true"></i> <i class="icon fa-cc-visa" aria-hidden="true"></i> <i class="icon fa-cc-amex" aria-hidden="true"></i> <i class="icon fa-cc-jcb" aria-hidden="true"></i> <i class="icon fa-cc-diners-club" aria-hidden="true"></i> 
      </div>		
              </div>
          <div class="visible-xs">
 <div class="font-size-30 margin-20 inline">
               Payments 
            </div>
              </div>
  </div>
            <div class="panel-body bg-white">
  <div class="table-responsive hidden-xs">
            <table class="table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Description</th>
                        <?php if(!is_contractor()) : ?> <th>Total</th>
                        <th class="text-center hidden-print">Actions</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($projectPayments) : $i=0;
                    foreach($projectPayments as $payment) : $i++; ?>
                        <?php // get payment (milestone data)
                        $percent = $payment['percent'];
                        $price = ($percent * $projectTotal) / 100;
                        $price = number_format($price, 2, '.', '');
                        $stripay = $price * 100;
                        if($payment['status'] == 'pending') {
                            $status_class = "default";
                        }
                        elseif($payment['status'] == 'active') {
                            $status_class = "info";
                        }
                        elseif($payment['status'] == 'done') {
                            $status_class = "primary";
                        }
                        elseif($payment['status'] == 'paid') {
                            $status_class = "success";
                        }
                        ?>
                        <tr id="payment_<?php echo $i; ?>">
                            <td class="work-status" style="width:10%;">
                                <span class="label  hidden-print label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $payment['status']; ?>
                            </span>
                          </td>
                            <td class="subject">
                                <div class="table-content">
                                    <p class="blue-grey-500">
                                        <?php echo $payment['title']; ?>
                                    </p>
                                    <p class="blue-grey-400">
                                        <?php echo $payment['description']; ?>
                                    </p>
                                </div>
                            </td>
                            <?php if(!is_contractor()) : ?>
                            <td class="total">
                                <span class="blue-grey-800 inline">$<?php echo $price; ?></span>
                                <p class="blue-grey-400 inline">
                                    (% <?php echo $percent; ?> of total)
                                </p>
                                
                              <?php if($payment['status'] == 'done'): ?><?php  echo do_shortcode( '[stripe name="Houseace" prefill_email="true" description="' .$payment['title']. '" amount="' .$stripay. '"]' ); ?><?php endif; ?>
                            </td>
                            <td class="actions hidden-print text-center">
                                <div class="table-content">
                                    <?php
                                    if($payment['status'] == 'pending') {
                                        go_payment_actions(array('adjust'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'active') {
                                        go_payment_actions(array('mark_done','adjust'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'done') {
                                        go_payment_actions(array('done','invoice','mark_paid'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'paid') {
                                        go_payment_actions(array('done','invoice','paid'),$projectId,$i);
                                    }
                                    ?>
                                </div>

                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if(is_array($payment['adjustments'])) : $j=0;
                        foreach($payment['adjustments'] as $adj) : $j++; ?>
                            <tr style="background: #F9F9F9;">
                                <td style="padding: 10px 8px;"></td>
                                <td style="padding: 10px 8px;" class="text-center">
                                    <i data-toggle='tooltip' data-placement='top' data-trigger='hover' data-original-title='Milestone adjustment' title='' class="icon wb-help-circle grey-400"></i>
                                </td>
                                <td style="padding: 10px 8px;">
                                    <p class="blue-grey-500">
                                        <?php echo $adj['title']; ?>
                                    </p>
                                    <p class="blue-grey-400">
                                        <?php echo $adj['description']; ?>
                                    </p>
                                </td>
                                <td style="padding: 10px 8px;">
                                    $
                                    <?php echo $adj['price']; ?>
                                </td>
                                <td style="padding: 10px 8px;" class="hidden-print text-center">
                                    <?php if($payment['status'] == 'pending' || $payment['status'] == 'active') : ?>
                                        <a style="cursor:pointer;" class="delete_adjustment" data-quote='<?php echo $quote_id; ?>' data-milestone='<?php echo $i; ?>' data-adj='<?php echo $j; ?>' data-toggle='tooltip' data-placement='left' data-trigger='hover' data-original-title='Remove adjustment'
                                            title=''><i class="icon wb-close-mini red-600"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    <?php endforeach; else : ?>
                        <tr class="text-center">
                            <td colspan="5">
                                        <div class="blue-grey-800 text-center font-size-20">
                                          Payments to be confirmed</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
              <div class="visible-xs">
                    <?php if($projectPayments) : $i=0;
                    foreach($projectPayments as $payment) : $i++; ?>
                        <?php // get payment (milestone data)
                        $percent = $payment['percent'];
                        $price = ($percent * $projectTotal) / 100;
                        $price = number_format($price, 2, '.', '');
                        $stripay = $price * 100;
                        if($payment['status'] == 'pending') {
                            $status_class = "default";
                        }
                        elseif($payment['status'] == 'active') {
                            $status_class = "info";
                        }
                        elseif($payment['status'] == 'done') {
                            $status_class = "primary";
                        }
                        elseif($payment['status'] == 'paid') {
                            $status_class = "success";
                        }
                        ?>
                        <div class="row" id="payment_<?php echo $i; ?>">
                            <div class="col-xs-12">
                               <span class="label hidden-print label-<?php echo $status_class; ?>" style="text-transform: capitalize;"><?php echo $payment['status']; ?>
                                  </span>   
                                  <p class="blue-grey-500">
                                        <?php echo $payment['title']; ?>
                                    </p>
                                    <p class="blue-grey-400">
                                        <?php echo $payment['description']; ?>
                                    </p>
                            </div>
                            <?php if(!is_contractor()) : ?>
                            <div class="text-center">
                                <span class="blue-grey-800 inline">$<?php echo $price; ?></span>
                                <p class="blue-grey-400 inline">
                                    (% <?php echo $percent; ?> of total)
                                </p>
                                
                              <?php if($payment['status'] == 'done'): ?><?php  echo do_shortcode( '[stripe name="Houseace" prefill_email="true" description="' .$payment['title']. '" amount="' .$stripay. '"]' ); ?><?php endif; ?>
                            </div>
                            <div class="actions col-xs-12 text-center">
                                    <?php
                                    if($payment['status'] == 'pending') {
                                        go_payment_actions(array('adjust'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'active') {
                                        go_payment_actions(array('mark_done','adjust'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'done') {
                                        go_payment_actions(array('done','invoice','mark_paid'),$projectId,$i);
                                    }
                                    elseif($payment['status'] == 'paid') {
                                        go_payment_actions(array('done','invoice','paid'),$projectId,$i);
                                    }
                                    ?>
                            </div>
                        </div><hr>
                        <?php endif; ?>
                    <?php endforeach; else : ?>
                        <div class="text-center">
                                        <div class="blue-grey-800 text-center font-size-20">
                                          Payments to be confirmed</div>
                        </div>
                    <?php endif; ?>
                </div>
              
        <div id="adjust_response"></div></div>
  <div class="panel-footer hidden-print bg-grey-200">
			<div class="row">				
				<?php if(!empty($coupon_message)): ?>
					<div class="black text-<?php echo $coupon_message['status']; ?> col-md-7"><?php echo $coupon_message['message']; ?></div>
				<?php endif; ?>
				<?php if(empty($projectCoupon)): ?>
					<form class="form-group margin-0 form-inline pull-right" method="POST" action="<?php echo get_permalink(); ?>#projectPayments">
							<div class="col-xs-12 col-md-6">
               <input type="text" class="form-control margin-0 inline-block" name="coupon" placeholder="Enter coupon">          
            </div>
														<div class="col-xs-12 col-md-6">
               <button class="btn btn-primary btn-raised btn-block inline-block">Apply Promo</button>
            </div>
						</form>
				<?php endif; ?>
			</div>
  </div>
          </div>




