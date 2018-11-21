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

<div class="container">
 			  <div class="row">
           <div class="font-size-30 font-weight-600 black margin-bottom-10"> 
         What can we help you with?
                  </div>
				<div class="col-md-12">	
				    
                      <?php
    $by_project_cnt = 0;
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1,);
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>


       <div class="col-md-2 height-250 col-xs-6 black">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-20 margin-bottom-10 blue-grey-800"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>

       </div>
   
  <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<p>Sorry, there are no templates here yet.</p>";
    }
    ?>
				</div>
				</div>
				</div>       
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
</div>
    <!-- End Modal -->

			
</div>