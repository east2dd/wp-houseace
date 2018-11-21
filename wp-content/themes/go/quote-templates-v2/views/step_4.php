<?php
$projectId = $_POST['projectId'];
$projectPrice = $_POST['projectPrice'];
$time = $projectPrice / 850;
$time = number_format($time, 1, '.', '');
?>


<div style="position:relative;">
	

							<div class="container">
									<div class="col-md-4">
									<div class="panel panel-bordered">
										<div class="panel-body text-center">
											<div class="font-size-30 red-800">
												$<?php echo $projectPrice; ?>
											</div><small>inc gst</small>
											<hr> 
											<p>
												Your project will take approximatley <div class="inline red-800"><?php echo $time; ?> days
											</p>
										</div>
										<hr>
										<a href="<?php bloginfo('url'); ?>/?p=<?php echo $projectId; ?>" class="btn btn-primary btn-raised btn-block">View Live Quote</a>							
									</div>
									
										<div class="steps steps-vertical">
                    <div class="step">
                      <span class="step-number">1</span>
                      <div class="step-desc">
                        <span class="step-title">Phone Call</span>
                        <p>Your manager will call you on the number provided to confirm the details of the quote.</p>
                      </div>
                    </div>
                    <div class="step">
                      <span class="step-number">2</span>
                      <div class="step-desc">
                        <span class="step-title">Final Quote</span>
                        <p>Your manager usually will be able to give you a fixed and final quote but if not they'll organise a time to meet.</p>
                      </div>
                    </div>
                    <div class="step current">
                      <span class="step-number">3</span>
                      <div class="step-desc">
                        <span class="step-title">Accept Quote</span>
                        <p>Happy with the quote? Accept online and away you go.</p>
                      </div>
                    </div>
                  </div>
	
									
								</div>
	</div>
								<div class="col-md-8">
									
								
    							<div class="panel panel-bordered">
          

            <div class="panel-body bg-grey-100">
				<div class="row">
				</div>
							
	<?php $projectScope = get_field('projectScopes',$projectId);

$arrayNames = array();
foreach($projectScope as $pS) {

	$scopeId = $pS;

	$scopeData = get_field('scopeData',$scopeId);
	$scopeDataDecoded = base64_decode($scopeData);
	$scopeDataArray = json_decode($scopeDataDecoded,true);
	$scopeLevel = get_field('scopeLevel',$scopeId);
	$scopeLevel = get_term( $scopeLevel, 'selection_level' );
	$scopeLevel = $scopeLevel->name;
  $scopePriceTemp = get_field('scopePrice',$scopeId);
  $scopeAdjustment = get_field('totalAdjustment',$scopeId);
  $scopePrice = $scopePriceTemp + $scopeAdjustment;
	$scopeTemplateId = get_field('scopeTemplate',$scopeId);
	$scopeTemplateFields = get_field('quote_fields',$scopeTemplateId);

	$scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

	$message = '<div class="margin-top-20">';

	foreach($scopeDetails as $sD) {

	$valueKeyFirst = $sD['section_title'];
	$valueKeyFirst = preg_replace("/[^a-zA-Z]/", "", $valueKeyFirst);
	$valueKeyFirst = strtolower($valueKeyFirst);

	  $message .= '<div>';
	  $message .= '<div class="font-size-20 margin-0 blue-grey-700"><b>' . $sD['section_title'] . '</b></div>';
	  foreach($sD['section_values'] as $value) {

		if($value == NULL) {
			$message .= 'N/A';
		}
		else {
		  $message .= '<p class="blue-grey-800">' . $value . '</p>';
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
												  $message .= "<p class='margin-0 blue-grey-800'>(" . $desc . ")</p><br /> ";
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

	$message .= '</div>';
	$editor .= $message;

} ; ?>
							<div class="text-left">
								<div class="font-size-20 margin-bottom-30 blue-grey-800">Quote Summary</div>
				<?php echo $editor ;?>
							</div>
							
				</div>
				
												</div>
									
									</div>
								
								
							</div>

