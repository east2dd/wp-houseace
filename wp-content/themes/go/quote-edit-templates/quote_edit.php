<?php
/*
Template Name: Scope Edit
*/
?>
<?php
$currentUserId = current_user_id();
$projectId = $_GET['projectId'];
$scopeId = $_GET['scopeId'];

// redirect to DASH if current user is contractor
if(is_contractor()) {
    wp_redirect(home_url() . "/dash");
    die;
}
// redirect to DASH if projectId or scopeId unset
if($projectId == '' || $scopeId == '') {
    wp_redirect(home_url() . "/dash");
    die;
}
// redirect to DASH if current user is client but he is not a client of project
$clientId = get_field('client_id',$projectId);
if($clientId[0] == NULL) {
        $clientId = $clientId['ID'];
}
else {
        $clientId = $clientId[0];
}
$clientData = go_userdata($clientId);
if(is_client()) {
    if($currentUserId != $clientId) {
        wp_redirect(home_url() . "/dash");
        die;
    }
}
// redirect to DASH if scopeID is invalid
$projectScopes = get_field('projectScopes',$projectId);
if(!in_array($scopeId,$projectScopes)) {
    wp_redirect(home_url() . "/dash");
    die;
}

// *** END OF checking
$client = go_userdata($client_id);
$scopeTemplate = get_field('scopeTemplate',$scopeId);
$scopeData = get_field('scopeData',$scopeId);
$scopeLevel = get_field('scopeLevel',$scopeId);
$scopeDataDecoded = base64_decode($scopeData);
$scopeDataArray = json_decode($scopeDataDecoded,true);
$scopeMargin = get_field('scopeMargin',$scopeId);

$scopeTitle = get_the_title($scopeId);
?>
<?php get_header(); ?> 
<div style="position: fixed; right: 0;">
	<button class="btn btn-lg margin-bottom-0 margin-top-10 btn-raised bg-white navbar-btn red-700 font-weight-500" id="total-quote" href="#">$0.00</button>
</div>
<style>
label{
    display: inline-block;
}
label img{
    pointer-events: none;
}
</style>
<script src="<?php bloginfo('template_url'); ?>/vendor/jquery/jquery.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit.js"></script>
<!-- Page -->
<div class="container">
        <div class="page-content">


               <div class="col-md-8 col-md-offset-2">
									 
            
                <form id="editedScope">
                <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
                <input type="hidden" name="scopeId" value="<?php echo $scopeId; ?>">
                <input type="hidden" name="templateId" value="<?php echo $scopeTemplate; ?>">

               
								
    							<div class="panel panel-bordered margin-bottom-50">
          

            <div class="panel-body">

                          
                            <div class="row margin-bottom-40">
															<div class="col-md-6 col-md-offset-3">
                                <?php if(is_headcontractor() || is_agent()) : ?>
            <div class="form-group">
              <h4>Margin</h4>
              <input class="form-control" type="number" name="scopeMargin" placeholder="Profit margin, %" data-min="-50" data-plugin='TouchSpin' data-step='1' data-decimals='0' data-boostat='5' data-maxboostedstep='10' data-postfix='%' value="<?php echo $scopeMargin; ?>">
            </div><hr>
        <?php else : ?>
            <input class="form-control" type="hidden" name="scopeMargin" value="<?php echo $scopeMargin; ?>">
        <?php endif; ?>
                                
                              </div>
                            </div>

						               	<hr>
                             <div class="form-group">
                                    <h4>Quote Name</h4>
                                    <input class="form-control" type="text" name="projectName" placeholder="Scope Name" value="<?php echo $scopeDataArray['projectName']; ?>">
                                  </div>
                            <?php

                            if( have_rows('quote_fields',$scopeTemplate) ) {

                              while ( have_rows('quote_fields',$scopeTemplate) ) : the_row();

                                // checking if this template has Width and Height rows
                                if( get_row_layout() == 'width_and_length' ) {
                                  $slug = null;
                                  $slug = get_sub_field('slug');  
                                  $thisValueWidth = empty($scopeDataArray["{$slug}_width"]) ? "0.00" : $scopeDataArray["{$slug}_width"];
                                  $thisValueLength = empty($scopeDataArray["{$slug}_length"]) ? "0.00" : $scopeDataArray["{$slug}_length"];
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width</h4><div class='text-center'>";
								
                                  echo "<input type='text' class='form-control input-lg' name='{$slug}_width' data-plugin='TouchSpin' data-min='0' data-max='1000000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='{$thisValueWidth}'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
								  echo "<input type='text' class='form-control input-lg' name='{$slug}_length' data-plugin='TouchSpin' data-min='0' data-max='1000000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='{$thisValueLength}'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><hr>";
                                }
															
															    if( get_row_layout() == 'price_and_area' ) {
                                  $thisValuePrice = null;
                                  $thisValueArea = null;
                                  $slug = null;
                                  $slug = get_sub_field('slug');
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Width</h4><div class='text-center'>";
                                  if(array_key_exists($slug . '_price',$scopeDataArray)) {
                                      $thisValuePrice = $scopeDataArray[$slug . '_price'];
                                  }
                                  if(array_key_exists($slug . '_area',$scopeDataArray)) {
                                      $thisValueArea = $scopeDataArray[$slug . '_area'];
                                  }
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_price' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='$' value='" . $thisValuePrice . "'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Area</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "_area' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M2' value='" . $thisValueArea . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><hr>";
                                }
															
                              // checking if this template has Note
                        			if( get_row_layout() == 'additional_notes' ) {
                        				echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr>";
                        				echo "<div class='row'><div class='col-md-6 col-md-offset-3'><div class='row'>";
                        				echo "<div class='form-group text-center margin-top-10'>";
																                        $slug = get_sub_field('slug');
                                                        $temp = null;
                                                        $temp = $scopeDataArray[$slug];
                        				echo "<textarea class='quote_textarea' name='" . get_sub_field('slug') . "'>" . $temp . "</textarea>";
                        				echo "</div>";
                        				echo "</div></div></div><hr>";
                        			}
															
                                // checking if this template has Width and height rows
                                if( get_row_layout() == 'width_and_height' ) {
                                  $slug = null;
                                  $slug = get_sub_field('slug');
								  $thisValueWidth = empty($scopeDataArray["{$slug}_width"]) ? "0.00" : $scopeDataArray["{$slug}_width"];
								  $thisValueHeight = empty($scopeDataArray["{$slug}_height"]) ? "0.00" : $scopeDataArray["{$slug}_height"];
                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Length</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='{$slug}_width' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='{$thisValueWidth}'>";
                                  echo "</div></div>";
                                  echo "<div class='col-md-6 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='{$slug}_height' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='{$thisValueHeight}'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><hr>";
                                }

                                if( get_row_layout() == 'panel_title' ) {
                                  echo "<h3 class='text-center'>" . get_sub_field('title') . "</h3><div class='text-center'><p class='text-center'>" . get_sub_field('description') . "</p></div><hr>";
                                }

                                      // checking if this template has Width and Height rows
                                if( get_row_layout() == 'length' ) {

                                    $thisValue = null;
                                    $slug = null;
                                    $slug = get_sub_field('slug');
                                    if(array_key_exists($slug ,$scopeDataArray)) {
                                        $thisValue = $scopeDataArray[$slug];
                                    }

                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='form-group text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValue . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><hr>";
                                }

															       // checking if this template has Width and Height rows
                                if( get_row_layout() == 'height' ) {

                                    $thisValue = null;
                                    $slug = null;
                                    $slug = get_sub_field('slug');
                                    if(array_key_exists($slug ,$scopeDataArray)) {
                                        $thisValue = $scopeDataArray[$slug];
                                    }

                                  echo "<div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div>";
                                  echo "<div class='row'><div class='col-md-12'><div class='row'>";
                                  echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>Height</h4><div class='form-group text-center'>";
                                  echo "<input type='text' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-max='100000000000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='" . $thisValue . "'>";
                                  echo "</div></div>";
                                  echo "</div></div></div><hr>";
                                }
															
                                // checking if this template has Image radio or checkbox rows
                                if( get_row_layout() == 'fields' ) {
                                  echo "<style>input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;  }</style>";
                                  $slug = get_sub_field('slug');
                                  $type = get_sub_field('type_of_fields');
                                  if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
                                  elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
                                  echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr><div class='text-center'>";

                                  $temp = null;
                                  $temp = $scopeDataArray[$slug];

                                  $i=0;
                                  while(has_sub_field('fields')) :
                                    $qnt = get_sub_field('quantity');
                                    $value = get_sub_field('title');
                                    $value_string = get_sub_field('title');
                                    $value = preg_replace("/[^a-zA-Z0-9]/", "", $value);
                                                                  $tooltip = get_sub_field('tooltip');
                                                                  if($tooltip != '') {
                                                                          $tooltit_text = 'data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="' . $tooltip . '" title=""';
                                                                  }
                                                                  else {
                                                                       $tooltit_text = '';
                                                                  }

                                    $value = strtolower($value);


                                    // check if options selected
                                    $value_string_m = addslashes($value_string);
                                    if(is_array($temp) && in_array($value_string_m,$temp)) {
                                            $temp_selected = 'checked';
                                    }
                                    elseif($value_string_m == $temp) {
                                            $temp_selected = 'checked';
                                    }
                                    else {
                                           $temp_selected = '';
                                    }


                                    echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
                                    echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\" " . $temp_selected . ">";
                                    echo "<img src=" . get_sub_field('image') . ">";
                                    echo "<span>" . get_sub_field('title') . "</span>";
                                    if($qnt == true) {
                                      $qnt_of_field = 0; $qnt_of_field = $scopeDataArray[$value];
                                      //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100000000000' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
                                    echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='". $qnt_of_field ."'>";
                                    echo "<div style='position: absolute; right: 4px; top: 126px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
                                    echo "<div style='position: absolute; left: 4px; top: 126px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
                                  }
                                      echo "</label>";
                                    echo "</span>";
                                  $i++;
                                  endwhile;

                                  echo "</div><hr>";
                                }
                              
    if(is_headcontractor() || is_agent()) {
     if( get_row_layout() == 'exclusions' ) {
                                  echo "<style>input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;  }</style>";
                                  $slug = get_sub_field('slug');
                                  $type = get_sub_field('type_of_fields');
                                  if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
                                  elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
                                  echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><h4 class='example-title text-center'>" . get_sub_field('title') . "</h4><div class='text-center'>" . get_sub_field('description') . "</div><hr><div class='text-center'>";

                                  $temp = null;
                                  $temp = $scopeDataArray[$slug];

                                  $i=0;
                                  while(has_sub_field('fields')) :
                                    $qnt = get_sub_field('quantity');
                                    $value = get_sub_field('title');
                                    $value_string = get_sub_field('title');
                                    $value = preg_replace("/[^a-zA-Z0-9]/", "", $value);
                                                                  $tooltip = get_sub_field('tooltip');
                                                                  if($tooltip != '') {
                                                                          $tooltit_text = 'data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="' . $tooltip . '" title=""';
                                                                  }
                                                                  else {
                                                                       $tooltit_text = '';
                                                                  }

                                    $value = strtolower($value);


                                    // check if options selected
                                    $value_string_m = addslashes($value_string);
                                    if(is_array($temp) && in_array($value_string_m,$temp)) {
                                            $temp_selected = 'checked';
                                    }
                                    elseif($value_string_m == $temp) {
                                            $temp_selected = 'checked';
                                    }
                                    else {
                                           $temp_selected = '';
                                    }


                                    echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
                                    echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\" " . $temp_selected . ">";
                                    echo "<img src=" . get_sub_field('image') . ">";
                                    echo "<span>" . get_sub_field('title') . "</span>";
                                    if($qnt == true) {
                                      $qnt_of_field = 0; $qnt_of_field = $scopeDataArray[$value];
                                      //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100000000000' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
                                    echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='". $qnt_of_field ."'>";
                                    echo "<div style='position: absolute; right: 4px; top: 126px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
                                    echo "<div style='position: absolute; left: 4px; top: 126px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
                                  }
                                      echo "</label>";
                                    echo "</span>";
                                  $i++;
                                  endwhile;

                                  echo "</div><hr>";
                                }
                              
                               }

                              endwhile;

                            }

                            ?>
                                <?php if(is_headcontractor() || is_agent()) : ?>

	<?php if( /*get_row_layout() == 'display_repeater'*/get_field('display_repeater', $scopeTemplate) ): ?>
		<?php 
			$customQuoteFieldTitle = $scopeDataArray['customQuoteFieldTitle'];
			$customQuoteFieldDescription = $scopeDataArray['customQuoteFieldDescription'];
			$customQuoteFieldPrice = $scopeDataArray['customQuoteFieldPrice'];
			include('views/customQuoteFieldContainer.php'); 
		?>
                                                                
	<?php endif; ?>
              <?php endif; ?>
                            <div id="saveScopeResponse" class="margin-top-40"></div>

                            <div class="row margin-bottom-40">
                              <div class="col-md-12">
                                <a class="btn btn-danger btn-block btn-raised margin-top-40 margin-horizontal-10 saveScope">Update Quote <i class="icon pe-gleam"></i></a>
                              </div>
                            </div>

                        </div>
                </div>

                </form>



        </div>
</div>
<!-- End Page -->

<?php get_footer(); ?>
