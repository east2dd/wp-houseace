<?php
/*
Template Name: Business Page
*/
$args = array( 
	'meta_key' => 'user_type',
	'meta_value' => 'Agent'
);

$agents_count = count(get_users($args));
$agents_per_page = 20;
$page = isset($_GET['p']) ? $_GET['p'] : 1;
$total_pages = ceil($agents_count / $agents_per_page);
$offset = $users_per_page * ($page - 1);

$base = './business-page';

$args['number'] = $agents_per_page;
$args['offset'] = $offset;
$agents = get_users( $args );
?>
<?php get_header(); ?>
<div class="page animsition">	
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="section-title"><?php the_title(); ?></h1>
			</div>
			<div class="row">
				<?php $j=1; ?>
				<?php foreach($agents as $agent): ?>
					<?php $agent_data = go_userdata($agent->ID); ?>
					<div class="col-md-3">
						<div class="widget text-center padding-top-20 padding-bottom-20">
							<div class="widget-header">
								<div class="widget-header-content">
									<a href="/profile/<?php echo $agent->data->user_login; ?>" >
										<div class="avatar avatar-lg">
											<img src="<?php echo $agent_data->avatar; ?>">
										</div>
									</a>
									<h4 class="profile-user"><?php echo $agent_data->first_name; ?> <?php echo $agent_data->last_name; ?></h4>
									<div class="profile-job">
										<p> <?php the_field('business_name','user_' . $agent->ID); ?> </p>
									</div>
									<a href="/profile/<?php echo $agent->data->user_login; ?>" >
										More info
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php if($j%4 == 0 ): ?>
						</div>
						<div class="row">
					<?php endif; ?>
					<?php $j++; ?>
				<?php endforeach; ?>
			</div>
		</div>
		
		
	</div>    
</div>

 <?php get_footer(); ?>