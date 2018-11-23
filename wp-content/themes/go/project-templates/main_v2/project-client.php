<?php

global $need_starrating;

$need_starrating = array(
	'styles' => true,
	'scripts' => true
);

// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();

if(!empty($_POST['coupon'])) $coupon_message = project_save_coupon($_POST['coupon'], $projectId);
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

// clear notification of current user
go_clear_notifications($currentUserId,$projectId);
go_clear_messages($currentUserId,$projectId);

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

/*
$t = go_set_default_selections(2433);
var_dump($t);
die;
*/
?>
<?php get_header(); ?>

 <div class="navbar navbar-default navbar-fixed-top bg-white">
          <div class="navbar-container container-fluid">
						<div class="pull-left visible-xs padding-10">
							<a class="btn btn-disabled btn-<?php echo $projectStatus->status_class; ?> inline-block"><i class="white icon wb-pencil"></i> <?php echo $projectStatus->status_string; ?></a>
            </div>
						<div class="pull-left hidden-xs padding-10">
							<a class="btn btn-disabled btn-<?php echo $projectStatus->status_class; ?> inline-block"> <?php echo $projectStatus->status_string; ?></a>
							
						<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<a class="btn inline-block btn-success projectAccept" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="Happy with the quote? Review the scope, schedule and payments before booking" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Secure Booking</a>
					<?php endif; ?>
			 
					
              <a class="btn inline-block btn-default" onclick="window.print();return false;" >Print</a>
							</div>

				 <div class="pull-right">
          
					  <ul class="nav navbar-toolbar">
               <li>
			<a class="nav-item bg-grey-100 red-700 font-size-20 font-weight-500" href="#">$<?php echo displayProjectTotal($projectId); ?></a>
              </li>
             
							 <li class="dropdown">
                        <?php if(is_user_logged_in()) : $current_user_id = current_user_id(); ?>
                                <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                                        <span class="avatar avatar-online">
                                                <?php if(get_field('ava','user_' . $current_user_id)) : ?>
                                                        <?php $ava_id = get_field('ava','user_' . $current_user_id ); $size = "ava"; $ava = wp_get_attachment_image_src( $ava_id, $size ); ?>
                                                        <img src="<?php echo $ava[0]; ?>" alt="...">
                                                        <i></i>
                                                <?php else : ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/defaults/default-ava.png" alt="...">
                                                        <i></i>
                                                <?php endif; ?>
                                        </span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/account" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Account</a>
                                        </li>
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
																									<a href="<?php bloginfo('url'); ?>/dash" role="menuitem"><i class="icon wb-briefcase" aria-hidden="true"></i> Dashboard</a>
                                        </li>
																		<li role="presentation">
																									<a href="<?php bloginfo('url'); ?>/profile/<?php echo $current_user->user_login; ?>" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> View Profile</a>
                                        </li><?php endif ;?>
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_projects" role="menuitem"><i class="icon wb-align-justify" aria-hidden="true"></i> My Quotes</a>
                                        </li>
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_contacts" role="menuitem"><i class="icon wb-users" aria-hidden="true"></i> Contacts</a>
                                        </li><?php endif ;?>
                                        <li class="divider" role="presentation"></li>
                                        <li role="presentation">
                                                <a href="<?php echo wp_logout_url( home_url() ); ?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                       
                </li>
       <?php endif; ?>   
					 </ul>
					
						</div>
                           
						
				</div>			
			</div>

    <?php if($projectStatus->status == 'quote'): ?>
<div class="section cosy-bg hidden-print">
  <div class="container">
    <div class="col-md-6">
   <div class="panel margin-top-30 black">
            <div class="bg-grey-200 padding-10 text-center">
              <div class="font-size-20">Thank you</div>
              <a style="position: absolute; right:10px; top: 10px" class="panel-action icon wb-close" data-toggle="panel-close" aria-hidden="true"></a>
              <div class="font-size-10">
                We're working on your final quote now
              </div>
     </div>
            <div class="panel-body text-center">
             <div class="pearls row">
                    <div class="pearl current col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title">Project Detailing</span><small>You're here</small>
                    </div>
                    <div class="pearl disabled col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                      <span class="pearl-title">Final Quote</span>
                    </div>
                    <div class="pearl disabled col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                      <span class="pearl-title">Confirmation</span>
                    </div>
                  </div>
              <div class="font-size-10 margin-top-30 blue-grey-800">
                We have sent you a quote to <?php echo $clientData->email; ?>
              </div>
              <div class="font-size-10 font-weight-500">
                Any Questions? Call us: <a class="inline red-600" href="tel: 0283116843">02 8311 6843</a>
              </div>
            </div>
          </div>
    </div>
  </div>
</div><?php endif ;?>

  <?php if($projectStatus->status == 'pending'): ?>
<div class="section cosy-bg hidden-print">
  <div class="container">
    <div class="col-md-6">
   <div class="panel margin-top-30 black">
            <div class="bg-grey-200 padding-10 text-center">
              <div class="font-size-20">Please Review</div>
              <a style="position: absolute; right:10px; top: 10px" class="panel-action icon wb-close" data-toggle="panel-close" aria-hidden="true"></a>
              <div class="font-size-10">
                Here's your final project offer, this is a fixed & final price. Remember to review the Scope, Schedule & Payments before securing the booking. 
              </div>
     </div>
            <div class="panel-body text-center">
             <div class="pearls row">
                    <div class="pearl current col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-user" aria-hidden="true"></i></div>
                      <span class="pearl-title black">Project Detailing</span><small>Done</small>
                    </div>
                    <div class="pearl current col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-check" aria-hidden="true"></i></div>
                      <span class="pearl-title black">Final Quote</span><small>You're here</small>
                    </div>
                    <div class="pearl disabled col-xs-4">
                      <div class="pearl-icon"><i class="icon wb-payment" aria-hidden="true"></i></div>
                      <span class="pearl-title black">Confirmation</span>
                    </div>
                  </div>
              <div class="col-md-10 col-md-offset-1">
              <a class="btn btn-block  btn-lg btn-success btn-raised projectAccept" data-toggle="tooltip" data-placement="bottom" data-trigger="hover" data-original-title="Please review the scope, schedule and payments before accepting" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Secure Booking</a> 
              </div><br/>
              <div class="font-size-10 margin-top-30 blue-grey-800">
                We have sent you a quote to <?php echo $clientData->email; ?>
              </div>
              <div class="font-size-10 font-weight-500">
                Any Questions? Call us: <a class="inline red-600" href="tel: 0283116843">02 8311 6843</a>
              </div>
            </div>
          </div>
    </div>
  </div>
</div><?php endif ;?>

<div class="container">
<div class="row padding-top-20">
         <div class="visible-xs">
						<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<a class="btn btn-success btn-sm btn-block margin-bottom-5 hidden-print projectAccept" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="Please review the scope, schedule and payments before accepting" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Accept Quote</a>
							<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="btn-sm hidden-print btn-block margin-bottom-5   btn-primary" data-toggle="tooltip" data-placement="right" data-trigger="hover" data-original-title="Add another room or service to this project" title="">Add Scope</a>
					<?php endif; ?>
			 
				
													</div>				
		
      <div class="col-md-8">
          <div class="panel">
          <div class="panel-body">
        	  <div class="font-size-30 blue-grey-800 inline-block updateTitle"><?php the_title(); ?>
									</div>
								<div class="font-size-20 blue-grey-800"><i class="icon wb-map margin-right-10 blue-grey-800" aria-hidden="true"></i>
                  <span class="text-break newAddress"><?php echo $clientData->address; ?></span>
                  </div>
               
					<div class="row padding-10">
        	<div class="col-md-12 col-sm-12">
							<div class="font-size-15 font-weight-400 blue-grey-800 inline">
								Quote Number: </div>
							 <div class="font-size-15 cyan-800 inline">
                #<?php echo $post_slug; ?>
							 || </div>
            <div class="font-size-15 font-weight-400 blue-grey-800 inline">
								Quote Date: 
							</div>
							<div class="font-size-15 blue-grey-500 inline">
							<?php echo get_the_date('d-m-y');?>
							 || </div>
            <div class="font-size-15 blue-grey-500 inline">
									<i class="icon wb-time  margin-right-10 blue-grey-800"></i>&nbsp;&nbsp;<span class="updateTimeframe"><?php echo $projectTimeframe; ?></span>
             </div>
      </div>
      </div>
        
     	<div class="row hidden-print">
						<?php include('views_v2/projectReview.php'); ?>
						</div>
			<div id="projectCompletingResponse"></div>
			<div id="projectAcceptingResponse"></div>
													
             <div class="col-md-12 col-xs-12">
					 <?php include('views_v2/projectNotes.php'); ?>
                        </div>
            
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
	$message .= '<div class="col-md-6"><div class="font-size-20  red-600 pull-right">Sub Total: $' . $scopePrice . '</div></div></div><hr>';
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
       <div class="col-md-12 text-left">
					<?php echo $editor ;?>
<div class="col-md-3 pull-right">
	<div class="font-size-30 text-center red-600">
							$<?php echo $projectTotal; ?>
	</div>
								</div>
								</div>
									
							</div>
			
            <div class="row padding-top-20">
              <div class="col-md-12">
                <?php include('views_v2/projectPayments.php'); ?>
                    <?php include('views_v2/projectVariations.php'); ?>	
              </div>
              <hr>
            </div>
            
            
            <div class="row padding-top-20 padding-bottom-20">
              <div class="col-md-12">
                 <div class="font-size-30 inline blue-grey-800">Schedule/Timings</div>
					<hr>
                									<?php include('views_v2/projectSchedule.php'); ?>
              </div>
              <hr>
            </div>
            
					<?php // project Agreement ?>
	<div class="panel is-collapse">
				 <div class="font-size-30 inline blue-grey-800">Terms and Conditions</div>					   
						 <div class="panel-action inline-block pull-right">
					   <a class="btn btn-outline hidden-print btn-default" data-toggle="panel-collapse" aria-hidden="true">View Terms</a>
						 </div>
            <hr>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<?php the_field('proposal','options'); ?>
            </div>
					</div>
				</div>
		 		
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
                          <a href="<?php bloginfo('url'); ?>">
                            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" alt=""></a></div>
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
        
        
										<?php foreach($contractorsArray as $contractorId) :
											$contractorData = go_userdata($contractorId);
										?>
                     
		 <div class="widget text-center">
             <div class="panel-heading bg-grey-200 blue-grey-800">
												<div class="font-size-15 font-weight-400">TRADESPERSON:</div>										
							</div>
       <div class="widget-header">
							<div class="widget-header-content">
								<div class="avatar padding-top-10 avatar-lg">
                       <img src="<?php echo $contractorData->avatar; ?>" alt="">
								</div>
								<h4 class="profile-user"><?php echo $contractorData->first_name; ?>&nbsp;<?php echo $contractorData->last_name; ?></h4>
								<div class="profile-job">
									<p> <?php the_field('business_name','user_' . $contractorId); ?> </p>
								</div>
								<div class="profile-job">
									<p><?php echo $contractorData->email; ?></p>
									<p><?php echo $contractorData->phone; ?></p>
                   <a class="btn btn-xs hidden btn-primary btn-raised preview" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $contractorId; ?>" data-toggle="slidePanel"><i class="icon wb-eye"></i> View Profile</a>
								</div>
							</div>
						</div>
					</div>
            
        								<?php endforeach; ?>
										<?php // *** END PL ?>
        
    <div class="panel-heading bg-grey-200 blue-grey-800 hidden-print">
												<div class="font-size-15 font-weight-400">QUESTIONS:</div>										
							</div> 
						<?php include('views_v2/messages.php'); ?>
							<?php include('views_v2/uploads.php'); ?>
		
				 </div>
			
			
	  </div>

		</div>
			

<?php include('manage_v2/managePopupsHead.php'); ?>
<?php get_footer(); ?>
