<?php
if($_GET['projectId']) {
  $projectId = $_GET['projectId']; $projectId = intval($projectId);
}
elseif($_POST['projectId']) {
  $projectId = $_POST['projectId']; $projectId = intval($projectId);
}
else {
  $projectId = 0;
}
if($_GET['token']) {
  $agentToken = $_GET['token'];
}
$current_user_id = current_user_id(); 
?>

<style>
@media (min-width: 768px)
.modal-fill-in .modal-dialog>* {
    width: 80%;
    margin-top: 80px;
}
.modal-fill-in .modal-dialog>* {
    width: 80%;
    margin-top: 80px;
}
</style>

<div class="row blue-grey-800 margin-top-20 text-center">
	<div class="font-size-30">
		Choose your quote
	</div><p>
Click on the buttons below to view the available quote generators, we've made it super easy by grouping the forms by the type of trade or project associated.	
	</p><hr>
	<div class="col-md-6 col-xs-12 col-md-offset-3">
			<div class="col-md-6 col-xs-6">
		<figure class="quote_option panel height-200 bg-red-800 white text-center" data-target="#painting" data-toggle="modal">
                    <figcaption class="padding-40">
							<div class="verticle-align-middle">
                <i class="icon pe-paint" aria-hidden="true" style="font-size: 60px;"></i>
								<div class="icon-title font-size-20"><b>PAINTING</b></div></div>
			     </figcaption>
                  </figure>
	</div>
				<div class="col-md-6 col-xs-6">
		<figure class="quote_option panel height-200 bg-red-800 white text-center" data-target="#allquotes" data-toggle="modal">
                    <figcaption class="padding-40">
							<div class="verticle-align-middle">
                <i class="icon pe-home" aria-hidden="true" style="font-size: 60px;"></i>
								<div class="icon-title font-size-20"><b>RENOVATIONS</b></div></div>
			     </figcaption>
                  </figure>
	</div>
					
				<div class="col-md-6 col-xs-6">
		<figure class="quote_option panel height-200 bg-red-800 white text-center" data-target="#floor" data-toggle="modal">
                    <figcaption class="padding-40">
							<div class="verticle-align-middle">
                <i class="icon pe-expand1" aria-hidden="true" style="font-size: 60px;"></i>
								<div class="icon-title font-size-20"><b>FLOORING</b></div></div>
			     </figcaption>
                  </figure>
					</div>
					
				<div class="col-md-6 col-xs-6">
		<figure class="quote_option panel height-200 bg-red-800 white text-center" data-target="#build" data-toggle="modal">
                    <figcaption class="padding-40">
							<div class="verticle-align-middle">
                <i class="icon pe-hammer" aria-hidden="true" style="font-size: 60px;"></i>
								<div class="icon-title font-size-20"><b>CARPENTRY</b></div></div>
			     </figcaption>
                  </figure>
	</div>
	
		</div>
					
  <!-- Modal -->
    <div class="modal modal-fill-in fade" id="painting" aria-hidden="true" aria-labelledby="painting"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
          <div class="modal-header">
            <a class="close btn-sm btn-raised btn-round btn-danger white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </a>
          </div>
          <div class="modal-body">
						
          	 <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'painting' );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>



       <div class="col-md-3 col-xs-6">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<div class='font-size-30 blue-grey-700'>Your quote templates will show here once we've set them up</div>";
    }
    ?>
	
	
                    </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
			
	 <!-- Modal -->
    <div class="modal modal-fill-in fade" id="allquotes" aria-hidden="true" aria-labelledby="allquotes"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
         <div class="modal-header">
            <a class="close btn-sm btn-raised btn-round btn-danger white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </a>
          </div>
          <div class="modal-body">
						
          	 <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'main' );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>



       <div class="col-md-3 col-xs-6">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<div class='font-size-30 blue-grey-700'>Your quote templates will show here once we've set them up</div>";
    }
    ?>
	
	
                    </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
			
 <!-- Modal -->
    <div class="modal modal-fill-in fade" id="floor" aria-hidden="true" aria-labelledby="floor"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
          <div class="modal-header">
            <a class="close btn-sm btn-raised btn-round btn-danger white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </a>
          </div>
          <div class="modal-body">
						
          	 <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'plumbing' );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>



       <div class="col-md-3 col-xs-6">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<div class='font-size-30 blue-grey-700'>Your quote templates will show here once we've set them up</div>";
    }
    ?>
	
	
                    </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
			
    <!-- Modal -->
    <div class="modal modal-fill-in fade" id="build" aria-hidden="true" aria-labelledby="build"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
        <div class="modal-header">
            <a class="close btn-sm btn-raised btn-round btn-danger white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </a>
          </div>
          <div class="modal-body">
						
          	 <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'meta_key'=>'by_type','meta_value'=>'building' );
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>



       <div class="col-md-3 col-xs-6">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-30"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
    <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<div class='font-size-30 blue-grey-700'>Your quote templates will show here once we've set them up</div>";
    }
    ?>
	
	
                    </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->
			
    <!-- Modal -->
    <div class="modal fade" id="startProject" aria-hidden="true" aria-labelledby="startProject"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Instant Quote</h4>
          </div>
          <div class="modal-body">
          <div class="modal-footer text-center">
            <button type="button" class="btn btn-success btn-lg btn-block startProject" <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>Start Project</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

</div>
			
</div>