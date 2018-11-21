<?php
/**
 * The template for displaying Archive pages
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content container" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title">
				<?php
				if ( is_day() ) :
					printf( 'Daily News: %s', get_the_date() );
					elseif ( is_month() ) :
						printf( 'Monthly News: %s', get_the_date('F Y') );
					elseif ( is_year() ) :
						printf( 'Yearly News: %s', get_the_date('Y') );
					else :
						_e( 'News' );
					endif;
					?>
				</h1>
			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-thumbnail">
			<?php //the_post_thumbnail(); ?>
				<h1 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
		</div>

		<div class="entry-meta">
			<?php // houseace_entry_meta(); ?>
			<?php // edit_post_link( __( 'Edit', 'houseace' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

</article><!-- #post -->

			<?php endwhile; ?>

			<?php houseace_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
