<?php
/*
Template Name: Agent Profile
*/

global $need_starrating;

$need_starrating = array(
	'styles' => true
);

$agent_name = get_query_var('agent_name');
$agent = get_user_by('login', $agent_name);
$user_type = get_field('user_type', "user_$agent->ID");



$agent_data = go_userdata($agent->ID);
?>
<?php get_header(); ?>
<div class="page animsition">	
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="blue-grey-800 font-size-30"><?php the_field('business_name','user_' . $agent->ID); ?></div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="widget text-center">
						<div class="widget-header">
							<div class="widget-header-content">
								<div class="avatar avatar-lg">
									<img src="<?php echo $agent_data->avatar; ?>">
								</div>
								<h4 class="profile-user"><?php echo $agent_data->first_name; ?> <?php echo $agent_data->last_name; ?></h4>
								<div class="profile-job">
									<p> <?php the_field('business_name','user_' . $agent->ID); ?> </p>
								</div>
								<div class="profile-job">
									<p><?php echo $agent_data->email; ?></p>
									<p><?php echo $agent_data->phone; ?></p>
								</div>
								<div class="profile-job margin-top-10">
									<p> <?php echo $agent_data->address; ?> </p>
								</div>
							</div>
						</div>
					</div>
				</div>						
				<div class="col-md-9">
					<div class="panel">
						<div class="panel-body">
							<h3 class="section-title"> Available Quotes </h3>
							<div class="row feature-group">
								<div class="col-lg-12 wow fadeIn animated">
									<?php
										$by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $agent->ID );
										$by_project_templates = get_posts($by_project_args);
									?>
									<?php foreach($by_project_templates as $template) : ?>
										<div class="col-md-3 col-xs-6 height-300">
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
										<div>Sorry, there are no templates here yet.</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-body">
							<h3 class="section-title"> Reviews </h3>
							<?php 
								$agent_id = $agent->ID; 
								include('contacts-templates/previews/page-parts/project-reviews.php'); 
							?>
						</div>
					</div>					
				</div>
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