<?php
/**
 * The template for displaying Archive pages
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
				<?php
				if ( is_day() ) :
					printf( 'Daily Archives: %s', get_the_date() );
					elseif ( is_month() ) :
						printf( 'Monthly Archives: %s', get_the_date('F Y') );
					elseif ( is_year() ) :
						printf( 'Yearly Archives: %s', get_the_date('Y') );
					else :
						_e( 'Archives' );
					endif;
					?>
				</h1>
			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php houseace_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
