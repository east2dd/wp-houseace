<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content container" role="main">
			<?php
			while ( have_posts() ) :
				the_post();
				?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php houseace_post_nav(); ?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
