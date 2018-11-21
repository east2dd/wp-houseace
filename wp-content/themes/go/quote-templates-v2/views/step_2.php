<?php
$templateId = $_POST['templateId']; $templateId = intval($templateId);
$projectId = $_POST['projectId']; $projectId = intval($projectId);
$projectName = $_POST['projectName'];
$projectLevel = $_POST['projectLevel'];
$agentToken = $_POST['agentToken'];

?>
								
   	<div class="col-md-8 col-md-offset-2 black font-weight-400">
      
      <div class="panel panel-bordered">
         <div class="panel-heading bg-grey-100 padding-20 text-center">
          			<div class="red-700 font-size-30 font-weight-500" id="total-quote">$000.00</div><small>inc gst</small>
        </div>
       <div class="row padding-20">
 <form id="projectDetailsForm" method="POST" action="<?php bloginfo('url'); ?>/add_quote/step3">
  <input type="hidden" name="templateId" value="<?php echo $templateId; ?>">
  <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
  <input type="hidden" name="agentToken" value="<?php echo $agentToken; ?>">
  <input type="hidden" name="projectPrice" value="0">

        <?php if(is_headcontractor() || is_agent()) : ?>
           <div class="col-md-6 col-md-offset-3">
						 <div class="form-group text-center">
              <div class="font-size-20 blue-grey-800 text-center">Margin</div>
							 <p>
								 Any number you put here will add that value as a percentage on the total sum of the quote.
							 </p>
              <input class="form-control" type="number" name="scopeMargin" placeholder="Profit margin, %" data-min="-50" data-plugin='TouchSpin' data-max='100' data-step='1' data-decimals='0' data-boostat='5' data-maxboostedstep='10' data-postfix='%' value="0">
		 		    </div></div>
          
        <?php else : ?>
            <input class="form-control" type="hidden" name="scopeMargin" value="0">
        <?php endif; ?>
        <div class="row">
           <div class="col-md-12 font-size-30 blue-grey-800 text-center">
        Choose your options
   </div>
    </div>
          
   
 <div class="row">
            <div class="col-md-6 col-md-offset-3">
             <div class="form-group text-center">
                   <div class="font-size-20 blue-grey-800 text-center">Job Name</div>

        <?php
        $templateName = get_the_title($templateId);
        if($projectName != '') {
          $projectName = $projectName;
        }
        else {
          $projectName = get_the_title($templateId);
        }
        ?>
        <input class="form-control" type="text" name="projectName" placeholder="<?php echo $templateName; ?> name..." value="<?php echo $projectName; ?> Quote">
     </div>

    </div>
</div><hr>
            
    <!-- Modal -->
   
  <?php

  if( have_rows('quote_fields',$templateId) ) {

    while ( have_rows('quote_fields',$templateId) ) : the_row();

      // checking if this template has Width and Height rows
      if( get_row_layout() == 'width_and_length' ) {
        echo "<div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . " - (doesnt need to be exact)</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Width</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='3'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Length</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_length' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='3'>";
        echo "</div></div>";
        echo "</div></div></div><hr>";
      }
    
		
      if( get_row_layout() == 'width_and_height' ) {
        echo "<div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . " - (doesnt need to be exact)</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Length</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_width' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='3'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Height</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_height' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='3'>";
        echo "</div></div>";
        echo "</div></div></div><hr>";
      }

     if( get_row_layout() == 'price_and_area' ) {
        echo "<div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . " - (doesnt need to be exact)</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Price (per m2)</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_price' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='$' value='30'>";
        echo "</div></div>";
        echo "<div class='col-md-6 text-center'><div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>Area (m2)</div><div class='text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "_area' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M2' value='0'>";
        echo "</div></div>";
        echo "</div></div></div><hr>";
      }
    
      if( get_row_layout() == 'panel_title' ) {
        echo "<div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . "</div><div class='text-center'><p class='text-center padding-30'>" . get_sub_field('description') . "</p></div><hr>";
      }

            // checking if this template has length
      if( get_row_layout() == 'length' ) {
        echo "<div class='emargin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . " - (doesnt need to be exact)</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='margin-sm-0'></div><div class='form-group text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-max='10000' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='3'>";
        echo "</div></div>";
        echo "</div></div></div><hr>";
      }

		       // checking if this template has a Height rows
      if( get_row_layout() == 'height' ) {
        echo "<div class='margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . " - (doesnt need to be exact)</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div>";
        echo "<div class='row'><div class='col-md-12'><div class='row'>";
        echo "<div class='col-md-6 col-md-offset-3 text-center'><div class='margin-sm-0'></div><div class='form-group text-center'>";
        echo "<input type='number' class='form-control input-lg' name='" . get_sub_field('slug') . "' data-plugin='TouchSpin' data-min='0' data-step='0.1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='M' value='2.7'>";
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
        echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><div class='font-size-20 font-weight-400 text-center'>" . get_sub_field('title') . "</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr><div class='text-center'>";

        $i=0;
        while(has_sub_field('fields')) :
          $qnt = get_sub_field('quantity');
          $dvalue = get_sub_field('default_quantity');
          $checked = get_sub_field('checked');
          if($checked == 'yes') {
                                                $class_checked = 'checked';
                                        }
                                        else {
                                             $class_checked = '';
                                        }
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
          echo "<span style='position:relative'><label class='styled_in_ajax'>";
          echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' " . $class_checked . " value=\"" . $value_string . "\">";
          echo "<img src=" . get_sub_field('image') . ">";
          echo "<span class='font-weight-400'>" . get_sub_field('title') . "</span>";
          if($qnt == true) {
            //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
            echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='" . $dvalue . "'>";
            echo "<div style='position: absolute; right: 4px; top: 86px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
            echo "<div style='position: absolute; left: 4px; top: 86px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
          }
          echo "</label>";
          echo "</span>";
        $i++;
        endwhile;

        echo "</div><hr>";
      }

		 if( get_row_layout() == 'additional_notes' ) {
				echo "<style>{display: none; visibility: hidden}</style>";
			}
			
			// checking if this template has Note
			if( get_row_layout() == 'additional_notes' ) {
				echo "<div class='margin-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . "</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr>";
				echo "<div class='col-md-12'><div class='col-md-12'><div class='margin-30'>";
				echo "<div class='form-group text-center margin-top-10'>";
				echo "<textarea class='quote_textarea' name='" . get_sub_field('slug') . "'></textarea>";
				echo "</div>";
				echo "</div></div></div><hr>";
			}
		
    if(is_headcontractor() || is_agent()) {
    if( get_row_layout() == 'exclusions' ) {
        echo "<style>input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0;  }</style>";
        $slug = get_sub_field('slug');
        $type = get_sub_field('type_of_fields');
        if($type == "Checkbox") { $type = 'checkbox'; $type_array = '[]'; }
        elseif($type == "Radio") { $type = 'radio'; $type_array = ''; }
        echo "<div id=". $slug . " class='example-wrap margin-sm-0'></div><div class='font-size-20 blue-grey-800 text-center'>" . get_sub_field('title') . "</div><div class='text-center padding-30'>" . get_sub_field('description') . "</div><hr><div class='text-center'>";

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
          echo "<span style='position:relative'><label class='styled_in_ajax' " . $tooltit_text . ">";
          echo "<input class='chr' type='" . $type . "' title name='" . $slug . $type_array . "' value=\"" . $value_string . "\">";
          echo "<img src=" . get_sub_field('image') . ">";
          echo "<span class='font-weight-400'>" . get_sub_field('title') . "</span>";
          if($qnt == true) {
            //echo "<input type='text' class='qnt form-control input-xs' name='" . $value . "' id='" . $value . "' data-plugin='TouchSpin' data-min='1' data-max='100' data-step='1' data-decimals='2' data-boostat='5' data-maxboostedstep='10' data-postfix='' value='1'>";
            echo "<input class='qnt form-control' type='number' name='" . $value . "' id='" . $value . "' min='1' step='1' value='1'>";
            echo "<div style='position: absolute; right: 4px; top: 86px;' class='adding'><a onclick='event.preventDefault(); inputAdd(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon addInput'><i class='icon wb-plus margin-horizontal-0'></i></a></div>";
            echo "<div style='position: absolute; left: 4px; top: 86px;' class='removing'><a onclick='event.preventDefault(); inputRemove(\"" . $value . "\");' class='btn btn-xs btn-default btn-icon removeInput'><i class='icon wb-minus margin-horizontal-0'></i></a></div>";
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
		<?php if(is_headcontractor() || is_agent()): ?>
  <?php if( get_field('display_repeater', $templateId) ): ?>
  
	<div class="row margin-30">
                                                                       

	<div class="blue-grey-800">
		<div class="col-md-12 text-center">
			<div class="font-size-20 blue-grey-800 text-center">Add manual items</div><p>
			This is where you can add manual items to your quote, this is for project specific scope that you haven't created options for. All totals will be added to the grand total.
			</p>
		</div><hr>
	</div>
	<div class="customQuoteFieldContainer" data-rows="1">
		<div class="row customQuoteFieldRow">
			<div class="col-md-4">
				<div class="form-group form-control-default required">
					<label for="customQuoteFieldTitle blue-grey-800">Title</label>
					<input name="customQuoteFieldTitle[]" type="text" class="form-control margin-bottom-10 customQuoteFieldTitle" data-not-call-calculating="true" placeholder="Title" required>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group form-control-default required">
					<label for="customQuoteFieldPrice blue-grey-800">Price - inc tax</label>
					<input name="customQuoteFieldPrice[]" type="number" min="0" class="form-control margin-bottom-10 customQuoteFieldPrice" placeholder="0.00" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-control-default required">
					<label for="customQuoteFieldDescription blue-grey-800">Description</label>
					<textarea name="customQuoteFieldDescription[]" class="form-control margin-bottom-10 customQuoteFieldDescription" data-not-call-calculating="true" placeholder="Description" required></textarea>
				</div>
			</div>
			<div class="col-md-1 padding-top-35">
				<a style="display:none;" class="btn btn-xs btn-raised btn-round btn-danger btn-icon deleteCustomQuoteField">
					<i class="icon wb-minus margin-horizontal-0"></i>
				</a>
			</div>
		</div>
	</div><hr>
	<div class="row">
		<div class="col-md-12">
			<div class="text-center">
				<a class="btn btn-sm btn-primary btn-raised btn-default populateCustomQuoteField">
					<i class="icon wb-plus margin-horizontal-0"></i> ADD MORE
				</a>
			</div>
		</div>
		</div>
                                                                
  <?php endif; ?>
		  <?php endif; ?>

  </form>

   
        </div>
        	<div class="col-md-12">
        <a class="btn btn-primary margin-bottom-10 btn-lg btn-block btn-raised gotoStep3">Finish Quote <i class="icon fa-angle-right" aria-hidden="true"></i></a>
         </div>
      </div>
					
																</div>
														  
<!-- End Navbar Collapse -->
								
					


<!-- Modal -->
<div class="modal fade bg-red-700" id="resetProject" aria-hidden="true" aria-labelledby="resetProject"
role="dialog" tabindex="-1">
  <div class="modal-dialog modal-center">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Are you sure?</h4>
      </div>
      <div class="modal-body">
        <p class="text-center">All progress will be lost! Are you sure you want to restart?</p>
      </div>
      <div class="modal-footer text-center">
        <button type="button" data-project="<?php echo $projectId; ?>" class="btn btn-danger resetProject">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
