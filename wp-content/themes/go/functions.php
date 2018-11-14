<?php
require_once( trailingslashit( get_template_directory() ). 'functions/global.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/invoice.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/redirects.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/usertypes.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/scope_details.php' );

require_once( trailingslashit( get_template_directory() ). 'functions/emailing.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/calculations.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/contacts.php' );

require_once( trailingslashit( get_template_directory() ). 'functions/v2.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/v2_calculations.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/v2_set_default_selections.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/v2_calculate_selection.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/v2_recalculate_project.php' );

require_once( trailingslashit( get_template_directory() ). 'functions/project_total.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/schedule.php' );

require_once( trailingslashit( get_template_directory() ). 'functions/register_scripts.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/register_styles.php' );
require_once( trailingslashit( get_template_directory() ). 'functions/rewrite_rules.php' );

add_filter( 'show_admin_bar', '__return_false' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'ava', 110, 110, true );
add_image_size( 'selection', 100, 105, true );
add_image_size( 'selections', 310, 310, true );

register_nav_menus(
array(
'top_menu'=>__('Top Menu')
)
);

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// ADD OBJECTS POST TYPE AND TAXONOMY

add_action('init', 'head_templates');
function head_templates(){

  $labels = array(
    'name' => __('Quote Templates','go'),
    'singular_name' => __('Quote Template','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('template',$args);
  
   $labels = array(
  'name' => 'Postcodes',
  'singular_name' => 'Postcode',
  'menu_name' => 'Postcodes',
  );
  register_taxonomy('postcodes', array('template'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'postcodes' ),
   ));
  
   $labels = array(
  'name' => 'Categories',
  'singular_name' => 'Category',
  'menu_name' => 'Categories',
  );
  register_taxonomy('categories', array('template'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'categories' ),
   ));
}

add_action('registered_post_type', 'make_posts_hierarchical', 10, 2 );
// Runs after each post type is registered
function make_posts_hierarchical($post_type, $pto){

    // Return, if not post type posts
    if ($post_type != 'template') return;

    // access $wp_post_types global variable
    global $wp_post_types;

    // Set post type "post" to be hierarchical
    $wp_post_types['template']->hierarchical = 1;

    // Add page attributes to post backend
    // This adds the box to set up parent and menu order on edit posts.
    add_post_type_support( 'template', 'page-attributes' );
}

add_action('init', 'client_quotes');
function client_quotes(){

  $labels = array(
    'name' => __('Projects','go'),
    'singular_name' => __('Project','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('project',$args);
}

add_action('init', 'invoices_objects');
function invoices_objects(){

  $labels = array(
    'name' => __('Invoices','go'),
    'singular_name' => __('Invoice','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
	'show_in_menu' => 'edit.php?post_type=project',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('invoice',$args);

}
add_action('init', 'payment_templates_objects');
function payment_templates_objects(){

  $labels = array(
    'name' => __('Payment templates','go'),
    'singular_name' => __('Payment template','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
	'show_in_menu' => 'edit.php?post_type=project',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('payment_template',$args);

}

add_action('init', 'schedules_templates_objects');
function schedules_templates_objects(){

  $labels = array(
    'name' => __('Schedules templates','go'),
    'singular_name' => __('Schedules template','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
	'show_in_menu' => 'edit.php?post_type=project',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('schedule_template',$args);

}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> __('Global Settings','kiddi'),
		'menu_title'	=> __('Global Settings','kiddi'),
		'menu_slug'	=> 'global_kiddi.php',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Invoice Settings','kiddi'),
		'menu_title'	=> __('Invoice Settings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Emailing Settings','kiddi'),
		'menu_title'	=> __('Emailing Settings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> __('Default Proposal','kiddi'),
		'menu_title'	=> __('Default Proposal','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> __('Strings','kiddi'),
		'menu_title'	=> __('Strings','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));
  acf_add_options_sub_page(array(
		'page_title' 	=> __('Calculator','kiddi'),
		'menu_title'	=> __('Calculator','kiddi'),
		'parent_slug'	=> 'global_kiddi.php',
	));

}


//attach our function to the wp_pagenavi filter
add_filter( 'wp_pagenavi', 'ik_pagination', 10, 2 );

//customize the PageNavi HTML before it is output
function ik_pagination($html) {
    $out = '';
    //wrap a's and span's in li's
    $out = str_replace("<div","",$html);
    $out = str_replace("class='wp-pagenavi'>","",$out);
    $out = str_replace("<a","<li><a",$out);
	$out = str_replace("class='page'>","class='pager'",$out);
    $out = str_replace("</a>","</a></li>",$out);
    $out = str_replace("<span","<li class='active'><a",$out);
    $out = str_replace("</span>","</a></li>",$out);
    $out = str_replace("</div>","",$out);

    return '<ul class="pagination pagination-gap">'.$out.'</ul>';
}


// getting current user ID
function current_user_id() {
    $current_user = wp_get_current_user();
    if ( !($current_user instanceof WP_User) )
        return;
    return $current_user->ID;
}

// checking Personal Data existing of user
function user_personal_data($user_id) {
    $userdata = get_userdata( $user_id );
	$user_firstname = $userdata->first_name;
	$user_lastname = $userdata->last_name;
	$user_email = $userdata->user_email;
	$user_phone = get_field('phone','user_' . $user_id);
	$user_address = get_field('address','user_' . $user_id);

	if( $user_firstname != '' && $user_lastname != '' && $user_email != '' && $user_phone != '' && $user_address != '' ) {
		return $user_personal_data = true;
	}
	else {
		return $user_personal_data = false;
	}
}

// checking Company Data existing of user
function user_company_data($user_id) {

  	$company_name = get_field('company_name','user_' . $user_id);
	$company_phone = get_field('company_phone','user_' . $user_id);
	$company_address = get_field('company_address','user_' . $user_id);
	$company_email = get_field('company_email','user_' . $user_id);

	if( $company_name != '' && $company_phone != '' && $company_address != '' && $company_email != '') {
		return $user_company_data = true;
	}
	else {
		return $user_company_data = false;
	}
}

// checking Company Invoice Settings existing of user
function user_invoice_data($user_id) {

  	$invoice_terms = get_field('company_terms','user_' . $user_id);
	$invoice_due = get_field('company_due','user_' . $user_id);
	$invoice_acc = get_field('company_account','user_' . $user_id);


	if( $invoice_terms != '' && $invoice_due != '' && $invoice_acc != '') {
		return $user_invoice_data = true;
	}
	else {
		return $user_invoice_data = false;
	}
}

function add_wizard_form_plugin() {
	wp_enqueue_script( 'jquery-wizard-js3', get_template_directory_uri() . '/vendor/jquery-wizard/jquery-wizard.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'jquery-wizard-js', get_template_directory_uri() . '/js/components/jquery-wizard.js', array('jquery'), '1.0.6', true );
	wp_enqueue_script( 'jquery-wizard-0.4.4-js', get_template_directory_uri() . '/vendor/jquery-wizard/jquery-wizard-0.4.4.js', array('jquery'), '1.0.6', true );
}

add_action( 'wp_enqueue_scripts', 'add_wizard_form_plugin' );


// added by ipullar
function set_featured_image_from_url($post_id, $image_url){
	// Add Featured Image to Post
	$post = get_post($post_id);

  $image_name       = $post->post_name . '.jpg';
  $upload_dir       = wp_upload_dir(); // Set upload folder
  $image_data       = file_get_contents($image_url); // Get image data
  $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
  $filename         = basename( $unique_file_name ); // Create image file name

  // Check folder permission and define file location
  if( wp_mkdir_p( $upload_dir['path'] ) ) {
      $file = $upload_dir['path'] . '/' . $filename;
  } else {
      $file = $upload_dir['basedir'] . '/' . $filename;
  }

  // Create the image  file on the server
  file_put_contents( $file, $image_data );

  // Check image file type
  $wp_filetype = wp_check_filetype( $filename, null );

  // Set attachment data
  $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title'     => sanitize_file_name( $filename ),
      'post_content'   => '',
      'post_status'    => 'inherit'
  );

  // Create the attachment
  $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

  // Include image.php
  require_once(ABSPATH . 'wp-admin/includes/image.php');

  // Define attachment metadata
  $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

  // Assign metadata to attachment
  wp_update_attachment_metadata( $attach_id, $attach_data );

  // And finally assign featured image to post
  set_post_thumbnail( $post_id, $attach_id );
}


//The Following registers an api route with multiple parameters. 
add_action( 'rest_api_init', 'add_custom_users_api');
function add_custom_users_api(){
    register_rest_route( 'wq/v2', '/listings/(?P<id>[\d]+)', array(
        'methods' => 'POST',
        'callback' => 'update_listing_item',
    ));
}

function update_listing_item( $request ) {
	$post_id = $request->get_param('id');

	if(!isset($post_id))
	{
		return;
	}

	$params = $request->get_body_params();

	if (!has_post_thumbnail($post_id))
	{
		set_featured_image_from_url($post_id, $params['fields']['media']['image_1']);	
	}

	// wp_update_post( array('ID'=>$post_id, 'post_content'=>$params['fields[description]']) );
	wp_set_object_terms($post_id, $params['fields']['status'], 'status', true);
	wp_set_object_terms($post_id, explode(',', $params['fields']['property_types']), 'property-types', true);
	wp_set_object_terms($post_id, explode(',', $params['fields']['features']), 'features', true);
	wp_set_object_terms($post_id, $params['fields']['address_parts']['suburb'], 'locations', true);

	if(isset($params['fields']['display_price']))
	{
		update_post_meta( $post_id, '_listing_price', $params['fields']['display_price'] );
	}else{
		update_post_meta( $post_id, '_listing_price', $params['fields']['sold_details']['sold_price'] );
	}
	
	update_post_meta( $post_id, '_listing_bathrooms', $params['fields']['bathrooms'] );
	update_post_meta( $post_id, '_listing_gallery', $params['fields']['gallery'] );
	update_post_meta( $post_id, '_listing_bedrooms', $params['fields']['bedrooms'] );
	update_post_meta( $post_id, '_listing_zip', $params['fields']['address_parts']['postcode']);
	update_post_meta( $post_id, '_listing_state', $params['fields']['address_parts']['state_abbreviation']);
	update_post_meta( $post_id, '_listing_address', $params['fields']['address_parts']['display_address']);
	update_post_meta( $post_id, '_listing_latitude', $params['fields']['geo_location']['latitude'] );
	update_post_meta( $post_id, '_listing_longitude', $params['fields']['geo_location']['longitude'] );
}
add_filter( 'comments_open', 'listing_comments_open', 10, 2 );

function listing_comments_open( $open, $post_id ) {

	$post = get_post( $post_id );
    
	if ($post->post_type == 'listing') {$open = false;}

	return $open;
}
