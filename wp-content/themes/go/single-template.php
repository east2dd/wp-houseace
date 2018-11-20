<?php
global $is_single_template;
$is_single_template = true;

$agentId = get_post_field( 'post_author' );
session_start();
session_unset();
get_header(); 
?>

<?php if( current_user_can('administrator') || $agentId == get_current_user_id() ):?>
	<?php acf_form_head(); ?>

	<div class="bg-white">
        <div class="page-content container">
			<div class="row">
				<div class="col-sm-12 panel padding-30 btn-raised">
					<div class="font-size-50 blue-grey-800"><?php the_title(); ?></div>
					<div class="font-size-20 blue-grey-800">
						This is where you control all your automatic pricing for the <b><?php the_title(); ?></b> template, please read through the instructions and feel free to get in touch if you get stuck. 
						All formulas have been explained on each field and all default pricing is only a guideline for demo purposes. We expect all users to change the pricing to suit their own business. 
					</div><hr>
					<div class="common-fields">
						<?php acf_form(array(
							'field_groups' => array(2984)
						)); ?>
					</div>
				</div><!-- .col-sm-12 -->
			</div><!-- .row -->
		</div><!-- .page-content.container-fluid -->
	</div><!-- .page.animsition -->


<?php endif; ?>
<?php get_footer(); ?>