<?php
/*
Template Name: thankyou
*/
?>
<!DOCTYPE html>
<?php get_template_part('header2'); ?>
  
  
 
  <div class="site-body">
   
	 <!-- Hero -->
  <section class="site-hero bg-white hero padding-50">
    <div class="container text-center">
      <div class="content">
        <h1 class="white"></h1>
      </div>
    </div>
  </section>
 
  
	 
    <!-- Content-6 -->
    <section class="section bg-white padding-50">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-small-12">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div id="post-<?php the_ID(); ?>">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
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
    </section>
    <!-- End Content-6 -->
   
  

  </div>

 <!-- Footer -->
 <?php get_footer(); ?>