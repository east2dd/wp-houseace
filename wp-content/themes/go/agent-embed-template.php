<?php
/*
Template Name: Agent embed
*/

$agent_name = get_query_var('agent_name');
$agent = get_user_by('login', $agent_name);
$user_type = get_field('user_type', "user_$agent->ID");

$agent_data = go_userdata($agent->ID);
?>
<?php get_header(); ?>
<div class="bg-white">	
	<div class="container container-fluid">
			<div class="row">
				<div class="col-md-12">
						
									<?php
										$by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $agent->ID );
										$by_project_templates = get_posts($by_project_args);
									?>
									<?php foreach($by_project_templates as $template) : ?>
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
                      <div class="font-size-20 margin-bottom-30 blue-grey-800"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>
										</div>
									<?php endforeach; ?>
									<?php if( empty($by_project_templates) ): ?>
										<div>Sorry, there are no quotes availible here yet.</div>
									<?php endif; ?>
								</div>
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

 <?php get_footer(); ?>