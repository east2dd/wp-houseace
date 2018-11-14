<?php
add_action('init', 'register_custom_styles');
function register_custom_styles() {
	//scripts for project review
	wp_register_style('fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css');
	wp_register_style('fontawesome-stars', get_template_directory_uri().'/assets/js/jquery-bar-rating/themes/fontawesome-stars.css');
	wp_register_style('fullcalendar', get_template_directory_uri().'/assets/examples/css/fullcalendar/fullcalendar.min.css');
}

//styles for project review
add_action('wp_enqueue_scripts', 'print_project_review_styles');
function print_project_review_styles(){
	global $need_starrating;
	
	if( !$need_starrating['styles'] ) return;
	
	wp_enqueue_style('fontawesome');
	wp_enqueue_style('fontawesome-stars');
}

//styles for fullcalendar
add_action('wp_enqueue_scripts', 'print_fullcalendar_styles');
function print_fullcalendar_styles(){
	global $need_fullcalendar;
	
	if( !$need_fullcalendar ) return;
	
	wp_enqueue_style('fullcalendar');
}

add_action('wp_print_styles', 'dequeue_and_deregister_styles');
function dequeue_and_deregister_styles(){
	wp_dequeue_style('custom-css');
	wp_deregister_style('custom-css');
}
?>
