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

// $featured_post_query = new WP_Query(
//   array(
//     'post_type' => 'post'
//     )
//   );

// //$featured_post = get_field("featured_post", $featured_post->ID);
// $featured_post_query->the_post();
$featured_post = $post;
wp_reset_postdata();

$query = new WP_Query( $query_params );
?>

<div id="primary" class="content-area">
  <div id="content" class="site-content container" role="main">
    <div class="featured">
        <?php
        $attachment_id = get_post_thumbnail_id($featured_post->ID);
        if(!$attachment_id)
        {
          $attachment_id = get_field('default_featured_image', 'option', false);
        }
        $img_src = wp_get_attachment_image_url( $attachment_id );
        $img_srcset = wp_get_attachment_image_srcset( $attachment_id );
      $full_src = wp_get_attachment_image_src($attachment_id, 'full', true);
      ?>
        <img class="content-centered-md-down" src="<?php echo esc_url( $img_src ); ?>"
              srcset="<?php echo esc_attr( $img_srcset ); ?>, <?php echo esc_url($full_src[0]); ?> 2760w"
              sizes="100vw">
        <h1 class="title">HOUSEACE NEWS</h1>
    </div>

    <?php
    while ( $query->have_posts() ) :
      $query->the_post();
      ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
            <div class="entry-thumbnail">
              <?php //the_post_thumbnail(); ?>
                <h1 class="entry-title">
                  <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h1>
            </div>
          </header><!-- .entry-header -->
          <div class="entry-summary">
            <?php the_excerpt(); ?>
          </div><!-- .entry-summary -->
        </article><!-- #post -->

    <?php endwhile; ?>

    <div class="pagination text-xs-center">
    <?php
      $big = 999999999; // need an unlikely integer
      echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'prev_text'=>"PREVIOUS",
        'next_text'=>"NEXT",
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $query->max_num_pages
      ) );
      ?>
    </div>
    <?php wp_reset_postdata(); ?>

  </div><!-- #content -->
</div><!-- #primary -->
<?php
get_sidebar();
get_footer();