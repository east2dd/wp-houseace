<?php
/*
Template Name: Default
*/
?>
<?php get_header(); ?>
  
     
<section id="main" class="section <?php the_field('bg_class'); ?>">
       <div class="container">
				<div class="row padding-50 text-center">
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
      <div class="font-size-50 white font-weight-800 margin-bottom-10"> 
         <?php the_field('header_text'); ?>
 </div>
                  <div class="font-size-20 white">
                    <?php the_field('header_text_below'); ?>
                  </div>
       </div>						
       </div>
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
		<h1 class="black"><?php the_title(); ?></h1>
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
   
  

 <!-- Footer -->
 <?php get_footer(); ?>