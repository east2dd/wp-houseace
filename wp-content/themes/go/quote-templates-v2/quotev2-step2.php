<?php
/*
Template Name: Quote v2. Step 2
*/
?>
<?php
if(!$_POST) {
  wp_redirect( home_url() . "/add_quote" );
}
global $need_sticky;

$need_sticky = true;

$agentId = get_post_field( 'post_author', $_POST['templateId']); 
$logo = get_field('invLogo','user_' . $agentId); 
$size = "medium"; 
$clogo = wp_get_attachment_image_src( $logo, $size );

?>
  <?php get_header(); ?>
<style>
  label{
      display: inline-block;
  }
  label img{
      pointer-events: none;
  }
</style>

<!-- Page -->

        <div class="container" id="step1">
           
                    <div class="row">
                                    
											<?php include('views/step_2.php'); ?>


                    </div>

        </div>
			

  
<?php get_footer(); ?>
