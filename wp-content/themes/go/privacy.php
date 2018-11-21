<?php
/*
Template Name: privacy
*/
?>
<?php get_header(); ?>
  
  <div class="bg-red-700">
		<div style="height: 100%" class="container">
			<div class="row">
				<div class="blue-grey-800 col-md-10 col-md-offset-1 col-small-12 padding-50">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>">
		<div class="white font-size-50"><?php the_title(); ?></div>
		<?php the_content(); ?>
	</div>

<?php endwhile; ?>

<?php else : ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h1>Not Found</h1>
	</div>

<?php endif; ?>          </div>
				
			</div>
		</div>
</div>
 <?php get_footer(); ?>
