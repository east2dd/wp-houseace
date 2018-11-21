<?php
/*
Template Name: Fix Project Fields
*/

if( ! current_user_can('administrator') ) { 
	get_template_part( 404 ); 
	exit();
}

$fields = array(
	"projectScopes", 
//	"agent_id"
);
$args = array('post_type'=>'project', 'posts_per_page'=>-1 );
$projects = get_posts($args);
	
?>
<?php get_header(); ?>

<ul>
<!-- the loop -->
<?php foreach($projects as $project) :  ?>
	<?php
		$fixed_fields = array();
		foreach($fields as $field){
			$value = get_field($field,$project->ID);
			if( !is_array($value) && !empty($value)){
				update_field($field, array($value), $project->ID);
				$fixed_fields[] = $field;
			}
		}
	?>
	
	<?php if( !empty($fixed_fields) ): ?>
		<li>
			Project ID: <?php echo $project->ID; ?>. Fields:
			<ol>
				<?php foreach($fixed_fields as $field): ?>
					<li><?php echo $field; ?></li>
				<?php endforeach; ?>
			</ol>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
 <?php get_footer(); ?>