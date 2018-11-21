<?php
/**
 * Template Name: Blog Page Template
 */

get_header(); 
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

$query_params = array(
  'post_type' => 'post',
  'paged' => $paged 
  );

if(isset($_GET['orderby']) && !empty($_GET['orderby']))
{
  $query_params['orderby'] = $_GET['orderby'];
}

if(isset($_GET['order']) && !empty($_GET['order']))
{
  $query_params['order'] = $_GET['order'];
}

if(isset($_GET['terms']) && !empty($_GET['terms']))
{

  $tax_query = array('relation'=>'OR');
  $filtered_terms = explode(',', $_GET['terms']);

  foreach($filtered_terms as $filtered_term)
  {
    $tax_query[] = array(
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $filtered_term
      );
  }
  
  $query_params['tax_query'] = $tax_query;
}

$featured_post_query = new WP_Query(
  array(
    'post_type' => 'post'
    )
  );

//$featured_post = get_field("featured_post", $featured_post->ID);
$featured_post_query->the_post();
$featured_post = $post;
wp_reset_postdata();

$query = new WP_Query( $query_params );
?>

<div id="primary" class="content-area">
  <div id="content" class="site-content" role="main">
  <?php if ( have_posts() ) : ?>
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
<?php
get_sidebar();
get_footer();