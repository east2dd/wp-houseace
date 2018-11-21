<?php

global $need_starrating;

$need_starrating = array(
	'styles' => true,
	'scripts' => true
);

// getting defaults
$currentUserId = current_user_id();
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

$current_user = get_user_by('id', $current_user_id); 

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

<div class="container">
<div class="page-main padding-bottom-50">
		<div class="page-content bg-white">
					
       <div class="navbar navbar-default navbar-fixed-top bg-white">
            		<div class="navbar-brand bg-red-600">
          <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" title="Houseace">
         </a>
        </div>
          <div class="row">

						<div class="pull-left hidden-xs padding-10">
							<a class="btn hidden-print btn-raised btn-<?php echo $projectStatus->status_class; ?> inline-block" data-toggle="modal" data-target="#manageStatus"><i class="white icon wb-pencil"></i> <?php echo $projectStatus->status_string; ?></a>
							
						<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<a class="btn hidden-print inline-block btn-success btn-raised projectAccept" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="Please review the scope, schedule and payments before acceting" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Secure Booking</a>
							<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="inline-block btn hidden-print btn-raised btn-primary" data-toggle="tooltip" data-placement="right" data-trigger="hover" data-original-title="Add another room or service to this project" title="">Add Scope</a>
					<?php endif; ?>
			 
					<?php if($projectStatus->status == 'live') : ?>
					 <a class="btn hidden-print btn-success btn-raised inline-block projectComplete" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Complete</a>
					<?php endif; ?>
              <a target="_blank" class="btn hidden-print inline-block btn-default btn-raised" href="<?php bloginfo('url'); ?>/tcpdf/scope/scope.php?project_id=<?php echo get_the_ID(); ?>">PDF</a>
													</div>

				 <div class="pull-right">
          
					  <ul class="nav navbar-toolbar">
               <li>
			<a class="nav-item bg-grey-100 red-700 font-size-20 font-weight-500" href="#">$<?php echo displayProjectTotal($projectId); ?></a>
              </li>
             <li class="dropdown">
                                        <a data-toggle="dropdown" href="javascript:void(0)" title="Notifications" aria-expanded="false" data-animation="scale-up" role="button">
                                                <i class="icon wb-bell" aria-hidden="true"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
																					<li class="dropdown-menu-header" role="presentation">
                                                        <h5>NOTIFICATIONS</h5>
                                           </li>
																					 <li class="list-group" role="presentation">
                                                        <div data-role="container">
                                                                <div data-role="content">
                                                                 	<?php include('views_v2/activity.php'); ?>
																													</div>
																						 </div>
																					</li>
												 </ul>
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
      <div class="col-md-12">
        
      
      		      
      			<div class="col-md-6">
           <a class="btn hidden-print btn-sm btn-block margin-bottom-5 btn-default" data-toggle="modal" data-target="#addAgent">Add Manager</a>   
        </div>
        	        			<div class="col-md-6">
                          <a class="btn hidden-print btn-sm btn-block margin-bottom-5 btn-default" data-toggle="modal" data-target="#addContractor">Add Tradesperson</a></div>
							    <div class="font-size-30 blue-grey-800 inline-block updateTitle"><?php the_title(); ?>
										<a class="btn hidden-print btn-xs btn-raised btn-primary btn-icon" data-toggle="modal" data-target="#manageTitle"><i class="icon white wb-pencil"></i></a>
									</div>
								<div class="font-size-20 blue-grey-800"><i class="icon wb-map margin-right-10 blue-grey-800" aria-hidden="true"></i>
                  <span class="text-break newAddress"><?php echo $clientData->address; ?></span>
                  </div>
                <div class="font-size-20 blue-grey-800">
									<i class="icon wb-time  margin-right-10 blue-grey-800"></i>&nbsp;&nbsp;<span class="updateTimeframe"><?php echo $projectTimeframe; ?></span>
										<a class="btn hidden-print btn-xs btn-round btn-default btn-icon" data-toggle="modal" data-target="#manageTimeframe"><i class="icon white wb-pencil"></i></a>
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
            <div class="font-size-15 font-weight-400 blue-grey-800 inline">
								Valid For: 
								<div class="font-size-15 blue-grey-500 inline">
								30 Days</div>
							</div>
      </div>
       
      </div>
			
		<hr>
	            </div>
      
      <div class="col-md-8 hidden-print">

					 <div class="font-size-30 blue-grey-800 inline">Manage Payments</div>
					<a class="panel-action pull-right btn hidden-print btn-outline btn-default managePaymentsTab" onclick="managePaymentsShow(<?php echo $projectId; ?>);">Manage Payments</a>
					<a class="panel-action pull-right btn hidden-print btn-outline btn-default manageVariationsTab" onclick="manageVariationsShow(<?php echo $projectId; ?>);">Manage Variations</a>
           <hr>
					<ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
					<li style="display:none;" role="presentation"><a class="managePaymentsTabClick" data-toggle="tab" href="#projectPaymentsManage" aria-controls="projectPaymentsManage" role="tab">Manage Payments</a></li>
           <li style="display:none;" role="presentation"><a class="manageVariationsTabClick" data-toggle="tab" href="#projectVariationsManage" aria-controls="projectVariationsManage" role="tab">Manage Variations</a></li>
           </ul>
				<div class="tab-content">
						<div class="tab-pane" id="projectPaymentsManage" role="tabpanel">
		                	<?php include('views_v2/projectPaymentsManage.php'); ?>
		                </div>
                        <div class="tab-pane" id="projectVariationsManage" role="tabpanel">
		                	<?php include('views_v2/projectVariationsManage.php'); ?>
		                </div>
					</div>
						<?php include('views_v2/projectPayments.php'); ?>
                    <?php include('views_v2/projectVariations.php'); ?>
								
		
      
      </div>
      <div class="col-md-4">
				
						<div class="blue-grey-800 panel-bordered">
            <div class="panel-heading bg-grey-200 blue-grey-800">
												<div class="font-size-15 font-weight-400">CLIENT:</div>										
							</div>	
              <div class="panel-body">
               <a class="avatar width-50 pull-left img-bordered" href="javascript:void(0)">
                                                        <img src="<?php echo $clientData->avatar; ?>" alt="">
                                                </a>
																					<div class="frontEndManage" style="top:15px; right:10px;">
								    <a class="btn hidden-print btn-xs btn-primary btn-raised btn-icon" data-toggle="modal" data-target="#manageClient"><i class="icon white wb-pencil margin-horizontal-0"></i></a>
								</div>
                                                <div class="pull-right relative">
                                                        <div class="font-size-15 font-weight-400 margin-bottom-15 newNames"><?php echo $clientData->first_name; ?>&nbsp;<?php echo $clientData->last_name; ?></div>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $clientData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $clientData->phone; ?></span>
                                                        </p>
                                                        																									                                                       
                           <a class="btn hidden-print btn-xs btn-primary btn-raised preview" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $clientId; ?>" data-toggle="slidePanel"><i class="icon wb-eye"></i> View Profile</a>
                                                </div>
                                      
						</div>	
          </div>
						<div class="blue-grey-800 panel-bordered">
						
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

                     
            <div class="panel-heading bg-grey-200 blue-grey-800">
												<div class="font-size-15 font-weight-400">PROJECT MANAGER:</div>										
							</div> 
                            <div class="panel-body">

                                                <a class="avatar width-50 pull-left img-bordered" href="javascript:void(0)">
                                                        <img src="<?php echo $agentData->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-right relative">
                                                      <div class="font-size-15 font-weight-400 margin-bottom-15 newNames"><?php echo $agentData->first_name; ?>&nbsp;<?php echo $agentData->last_name; ?></div>
																										<div class="frontEndManage" style="top:15px; right:10px;">
											                                                <a class="btn hidden-print btn-xs btn-primary btn-raised btn-icon removeAgentMiddleware" data-agent="<?php echo $agentId; ?>" data-names="<?php echo $agentData->first_name; ?> <?php echo $agentData->last_name; ?>" data-toggle="modal" data-target="#removeAgent"><i class="icon wb-close-mini margin-horizontal-0"></i></a>
																							<br />
																							<?php if($agentLead == true) : ?>
																								<a style="cursor:default;" class="btn hidden-print btn-xs btn-primary btn-raised btn-icon margin-top-5 agent_<?php echo $agentId; ?> alreadyLead" data-agent="<?php echo $agentId; ?>" data-project="<?php echo $projectId; ?>"><i class="icon wb-star yellow-600 margin-horizontal-0"></i></a>
											                                                <?php else : ?>
											                                                    <a class="btn hidden-print btn-xs btn-primary btn-raised btn-icon margin-top-5 agent_<?php echo $agentId; ?> makeLead" data-agent="<?php echo $agentId; ?>" data-project="<?php echo $projectId; ?>"><i class="icon wb-star-outline margin-horizontal-0"></i></a>
											                                                <?php endif; ?>

											                              </div>
																									   <p class="margin-bottom-5 text-nowrap"><i class="icon fa-bullhorn margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break"><?php the_field('invCompany_name','user_' . $agentId); ?></span>
                                                        </p>  
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $agentData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $agentData->phone; ?></span>
                                                        </p>
             <a class="btn hidden-print btn-xs btn-primary btn-raised preview" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $agentId; ?>" data-toggle="slidePanel"><i class="icon wb-eye"></i> View Profile</a>

                                                </div>
              </div>
              
												<?php endforeach; ?>
										<?php // *** END PL ?>
						</div>

						<div class="blue-grey-800 panel-bordered">
						
										<?php foreach($contractorsArray as $contractorId) :
											$contractorData = go_userdata($contractorId);
										?>
                     
            <div class="panel-heading bg-grey-200 blue-grey-800">
												<div class="font-size-15 font-weight-400">TRADESPERSON:</div>										
							</div> 
                                       <div class="panel-body">
                       <a class="avatar width-50 pull-left img-bordered" href="javascript:void(0)">
                                                        <img src="<?php echo $contractorData->avatar; ?>" alt="">
                                                </a>
                                                <div class="pull-right relative">
                                                      <div class="font-size-15 font-weight-400 margin-bottom-15 newNames"><?php echo $contractorData->first_name; ?>&nbsp;<?php echo $contractorData->last_name; ?></div>
																										<div class="frontEndManage" style="top:15px; right:10px;">
											                                                <a class="btn hidden-print btn-xs btn-primary btn-raised btn-icon removeAgentMiddleware" data-agent="<?php echo $contractortId; ?>" data-names="<?php echo $contractorData->first_name; ?> <?php echo $contractorData->last_name; ?>" data-toggle="modal" data-target="#removeAgent"><i class="icon wb-close-mini margin-horizontal-0"></i></a>
																							<br />
											                              </div>
																									  <p class="margin-bottom-5 text-nowrap"><i class="icon fa-bullhorn margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break"><?php the_field('business_name','user_' . $contractorId); ?></span>
                                                        </p>  
                                                        <p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break"><?php echo $contractorData->email; ?></span>
                                                        </p>
                                                        <p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10 blue-grey-400" aria-hidden="true"></i>
                                                                <span class="text-break newPhone"><?php echo $contractorData->phone; ?></span>
                                                        </p>

                           <a class="btn hidden-print btn-xs btn-primary btn-raised preview" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $contractorId; ?>" data-toggle="slidePanel"><i class="icon wb-eye"></i> View Profile</a>
              </div>
              </div> 
              
												<?php endforeach; ?>
										<?php // *** END PL ?>
						</div>
      </div>
			<div class="row">
						<?php include('views_v2/projectReview.php'); ?>
						</div>
			<div id="projectCompletingResponse"></div>
			<div id="projectAcceptingResponse"></div>
			
      <div class="visible-xs">
							<a class="btn hidden-print btn-raised btn-sm btn-block margin-bottom-5 btn-<?php echo $projectStatus->status_class; ?> " data-toggle="modal" data-target="#manageStatus"><i class="white icon wb-pencil"></i> <?php echo $projectStatus->status_string; ?></a>
							
						<?php // Approval by Cltient (show only when projectStatus == pending) ?>
					<?php if($clientApprove != true && $projectStatus->status == 'quote' || $projectStatus->status == 'pending') : ?>
					
							<a class="btn hidden-print btn-success btn-sm btn-block margin-bottom-5 btn-raised projectAccept" data-toggle="tooltip" data-placement="left" data-trigger="hover" data-original-title="Please review the scope, schedule and payments before accepting" title="" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Secure Booking</a>
							<a href="<?php bloginfo('url'); ?>/add_quote?projectId=<?php echo $projectId; ?>" class="btn-sm btn btn-block hidden-print margin-bottom-5 btn-raised btn-primary" data-toggle="tooltip" data-placement="right" data-trigger="hover" data-original-title="Add another room or service to this project" title="">Add Scope</a>
					<?php endif; ?>
			 
					<?php if($projectStatus->status == 'live') : ?>
					 <a class="btn hidden-print btn-success btn-raised btn-sm btn-block margin-bottom-5 projectComplete" data-project='<?php echo $projectId; ?>' data-user='<?php echo $currentUserId; ?>'>Complete</a>
					<?php endif; ?>
													</div>

     <hr>
			
			<?php if($_GET['test'] == true && $projectStatus->status == 'pending') : ?>
					<div class="row padding-30">
						<?php 
							$availableContractors = [];
							if(!empty($clientData->address)){
								$availableContractors = getAvailabelContractors($clientData->address, get_the_date('Y-m-d'));
								//remove already selected contractors
								foreach($contractorsArray as $contractorId){
									if(!empty($availableContractors[$contractorId]) ) unset($availableContractors[$contractorId]);
								}
							}
							$i = 0;
						?>
						<?php foreach($availableContractors as $contractorId => $contractor): ?>
							<div class="col-md-4">
								<div class="height-200 blue-grey-800 panel-bordered">
									<div>     
										<div class="row padding-bottom-10">
											<div style="border-bottom: 1px solid" class="font-size-15 font-weight-400 red-800">AVAILABLE TRADESPERSON:</div>										
										</div> 
										<a class="avatar width-50 pull-left img-bordered" href="javascript:void(0)">
											<img src="<?php echo $contractor['avatar']; ?>" alt="">
										</a>
										<div class="pull-right relative">
											<div class="font-size-15 font-weight-400 margin-bottom-15 newNames"><?php echo $contractor['full_name']; ?></div>
											<p class="margin-bottom-5 text-nowrap"><i class="icon fa-bullhorn margin-right-10 blue-grey-400" aria-hidden="true"></i>
												<span class="text-break"><?php echo $contractor['business_name']; ?></span>
											</p>  
											<p class="margin-bottom-5 text-nowrap"><i class="icon wb-envelope margin-right-10 blue-grey-400" aria-hidden="true"></i>
												<span class="text-break"><?php echo $contractor['email']; ?></span>
											</p>
											<p class="margin-bottom-5 text-nowrap"><i class="fa fa-phone margin-right-10 blue-grey-400" aria-hidden="true"></i>
												<span class="text-break newPhone"><?php echo $contractor['phone']; ?></span>
											</p>

											<a class="btn hidden-print btn-xs btn-primary btn-raised preview" data-url="<?php bloginfo('url'); ?>/contact_preview?contact_id=<?php echo $contractorId; ?>" data-toggle="slidePanel"><i class="icon wb-eye"></i> View Profile</a>
										</div>
									</div>
								</div>
							</div>
							<?php 
								if($i == 2) break;
								else $i++;
							?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?><hr/>
               
											
         <div class="panel panel-bordered">							
						 	<div class="row padding-30">
														
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

	  $message .= '<div class="col-md-9">';
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
		$message .= '<div class="col-md-9">';
			$message .= "<div class=\"font-size-20 margin-0 blue-grey-700\"><b>$title</b></div><hr>";
			
			$message .= $customQuoteFieldDescription[$customFieldId] ? "<p class=\"blue-grey-500\">$customQuoteFieldDescription[$customFieldId]</p><hr>" : "";
		$message .= '</div>';
	}

	$message .= '</div>';
	$editor .= $message;

} ; ?>
								<div class="font-size-30 margin-bottom-30 blue-grey-800">Quote Summary</div>
											<div class="row">
                        <div class="margin-10 hidden">
                       	<?php include('views_v2/scope.php'); ?>
												<div id="showScopeResponse"></div>		
                                                  </div>
                        <div class="col-md-12 col-xs-12">
					 <?php include('views_v2/projectNotes.php'); ?>
                        </div> </div>
       <div class="col-md-12 text-left">
					<?php echo $editor ;?>
<div class="col-md-3 pull-right">
	<div class="font-size-30 text-center red-600">
							$<?php echo $projectTotal; ?>
	</div>
								</div>
								</div>
									
							</div>
							</div>
			
					 <br/>
					<div class="padding-30 hidden-print"> <div class="font-size-30 blue-grey-800">Questions/Answers</div><hr>
						<?php include('views_v2/messages.php'); ?>
							<?php include('views_v2/uploads.php'); ?></div>

										
		<div class="padding-30" id="schedule">
			<div class="row">
				<div class="col-md-12">
					<?php // project Schedule ?>
         <div class="font-size-30 inline blue-grey-800">Schedule/Timings</div>
					<a class="panel-action pull-right btn hidden-print btn-outline btn-default manageSchedules" onclick="manageSchedulesShow(<?php echo $projectId; ?>);">Manage Schedules</a>
					<hr>
					
						<div class="padding-20">
							<div class="row">
								<div class="col-md-12">
									<?php include('views_v2/projectSchedule.php'); ?>
									<div id="manageSchedulesResponse"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		    											

			<?php // project Agreement ?>
					 <div class="padding-30 panel is-collapse">
				      <div class="font-size-30 inline blue-grey-800">Terms and Conditions</div>					   
						 <div class="panel-action inline-block pull-right">
					   <a class="btn hidden-print btn-outline btn-default" data-toggle="panel-collapse" aria-hidden="true">View Terms</a>
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
				
		     <a class="btn hidden-print btn-link btn-xs pull-right white" href="/">Powered by Houseace</a>

		</div>


<?php include('manage_v2/managePopupsHead.php'); ?>
<?php get_footer(); ?>

