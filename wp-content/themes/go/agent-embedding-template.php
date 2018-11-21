<?php
/*
Template Name: Agent Page For Embedding
*/

$agent_name = get_query_var('agent_name');
$agent = get_user_by('login', $agent_name);
$user_type = get_field('user_type', "user_$agent->ID");

if( $user_type != "Agent") { 
	get_template_part( 404 ); 
	exit();
}

$agentToken = $agentToken ? $agentToken : 0;
$agent_data = go_userdata($agent->ID);
?>
<html>
	<head>		
        <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/images/favicon.ico">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/site.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/agent-embedding.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">
		<script src="<?php bloginfo('template_url'); ?>/vendor/jquery/jquery.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/jRedirect.js"></script>
		<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/quotev2.js"></script>
	</head>
	<body>
		<div class="row margin-top-10">	
			<?php
				$by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1, 'author'  =>  $agent->ID );
				$by_project_templates = get_posts($by_project_args);
			?>
			<?php foreach($by_project_templates as $template) : ?>
				<div class="col-md-3 col-xs-6">
					<figure
						class="quote_option text-center startProject"
						data-name="<?php echo $template->post_title; ?>"
						data-project="<?php echo $projectId; ?>"
						data-template="<?php echo $template->ID; ?>"
						data-token="<?php echo $agentToken; ?>"
					>
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
	</body>
</html>