<?php
/**
 * The Template for displaying all single listing posts
 *
 * @package WP Listings
 * @since 0.1.0
 */

add_action('wp_enqueue_scripts', 'enqueue_single_listing_scripts');
function enqueue_single_listing_scripts() {
	wp_enqueue_style( 'wp-listings-single' );
	wp_enqueue_style( 'font-awesome-4.7.0' );
	wp_enqueue_script( 'jquery-validate', array('jquery'), true, true );
	wp_enqueue_script( 'fitvids', array('jquery'), true, true );
	wp_enqueue_script( 'wp-listings-single', array('jquery, jquery-ui-tabs', 'jquery-validate'), true, true );
	
	wp_register_script ( 'vuejs', get_template_directory_uri() . '/js/vue.min.js' );
	wp_enqueue_script( 'vuejs', array('jquery'), true, true );
}

function single_listing_post_content() {

	global $post;
	$options = get_option('plugin_wp_listings_settings');

	?>

  <div itemscope itemtype="http://schema.org/SingleFamilyResidence" class="entry-content wplistings-single-listing">
    <div class="bg-red-600 row">
      <div class="col-md-8">
        <figure class="overlay">
          <div class="listing-image-wrap">
            <?php echo '<div class="overlay-figure" itemprop="image" itemscope itemtype="http://schema.org/ImageObject">'. get_the_post_thumbnail( $post->ID, 'listings-full', array('class' => 'single-listing-image', 'itemprop'=>'contentUrl') ) . '</div>'; ?>
          </div>
          <figcaption class="overlay-bottom text-left overlay-panel overlay-background">
            <h4>Domain Link: <a href="#">http://domain.com.au</a> </h4>
          </figcaption>
        </figure>
      </div>
      <div class="col-md-4 padding-left-0">
        <div class="navbar-brand pull-left">
          <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" title="Houseace">
          </a> <div class="font-size-10 white inline">Estimator</div>
        </div>
        <div class="white">
        <div class="col-md-6 col-xs-6">
          <label for="postcode">Postcode:</label>
          <input id="postcode" class="form-control" v-model="property.zip" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="postcode">Sale Price:</label>
          <input id="postcode" class="form-control" v-model="property.price" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="beds">Beds:</label>
          <input type="number" id="beds" class="form-control" v-model="property.bedrooms"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="baths">Baths:</label>
          <input id="baths" class="form-control" v-model="property.bathrooms" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="living">Living:</label>
          <input id="living" class="form-control" value="1" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="toilets">toilets:</label>
          <input id="toilets" class="form-control" value="0" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="type">Dwelling Type</label>
          <select id="area" class="form-control">
            <option>House</option>
            <option>Unit</option>
            <option>Apartment</option>
          </select>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="type">Levels</label>
          <select id="area" class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
          </select>
        </div>
        <div class="col-md-12 col-xs-12">
          <label for="area">Floor Area:</label>
          <input id="area" class="form-control input-lg" type="number"/>
        </div>
      </div>
    </div>
   
   <?php
   $listing_meta = sprintf( '<div class="list-group hidden">');

   if ( get_post_meta($post->ID, '_listing_hide_price', true) == 1 ) {
     $listing_meta .= (get_post_meta($post->ID, '_listing_price_alt', true)) ? sprintf( '<h4 class="list-group-item-heading">%s</h4>', get_post_meta( $post->ID, '_listing_price_alt', true ) ) : '';
   } else {
     $listing_meta .= sprintf( '<p class="list-group-item-text">%s</p>', get_post_meta( $post->ID, '_listing_price', true ));
   }

   if ( '' != wp_listings_get_property_types() ) {
     $listing_meta .= sprintf( '<h4 class="list-group-item-heading">Property Type:</h4><p class="list-group-item-text">%s</p>', get_the_term_list( get_the_ID(), 'property-types', '', ', ', '' ) );
   }

   if ( '' != wp_listings_get_locations() ) {
     $listing_meta .= sprintf( '<h4 class="list-group-item-heading">Location: </h4><p class="list-group-item-text">%s</p>', get_the_term_list( get_the_ID(), 'locations', '', ', ', '' ) );
   }
   
   if ( '' != get_post_meta( $post->ID, '_listing_bedrooms', true ) ) {
     $listing_meta .= sprintf( '<h4 class="list-group-item-heading">Beds: </h4><p class="list-group-item-text">%s</p>', get_post_meta( $post->ID, '_listing_bedrooms', true ) );
   }

   if ( '' != get_post_meta( $post->ID, '_listing_bathrooms', true ) ) {
     $listing_meta .= sprintf( '<h4 class="list-group-item-heading">Baths:</h4><p class="list-group-item-text">%s</p>', get_post_meta( $post->ID, '_listing_bathrooms', true ) );
   }


   $listing_meta .= sprintf( '</div>');

   echo $listing_meta;

   echo (get_post_meta($post->ID, '_listing_courtesy', true)) ? '<p class="wp-listings-courtesy">' . get_post_meta($post->ID, '_listing_courtesy', true) . '</p>' : '';

   ?>    
 </div>
<?php
}

if (function_exists('equity')) {

	remove_action( 'equity_entry_header', 'equity_post_info', 12 );
	remove_action( 'equity_entry_footer', 'equity_post_meta' );

	remove_action( 'equity_entry_content', 'equity_do_post_content' );
	add_action( 'equity_entry_content', 'single_listing_post_content' );

	equity();

} elseif (function_exists('genesis_init')) {

	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 ); // HTML5
	remove_action( 'genesis_before_post_content', 'genesis_post_info' ); // XHTML
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' ); // HTML5
	remove_action( 'genesis_after_post_content', 'genesis_post_meta' ); // XHTML
	remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 ); // HTML5
	remove_action( 'genesis_after_post', 'genesis_do_author_box_single' ); // XHTML

	remove_action( 'genesis_entry_content', 'genesis_do_post_content' ); // HTML5
	remove_action( 'genesis_post_content', 'genesis_do_post_content' ); // XHTML
	add_action( 'genesis_entry_content', 'single_listing_post_content' ); // HTML5
	add_action( 'genesis_post_content', 'single_listing_post_content' ); // XHTML

	genesis();

} else {

	$options = get_option('plugin_wp_listings_settings');

	get_header();
	if(isset($options['wp_listings_custom_wrapper']) && isset($options['wp_listings_start_wrapper']) && $options['wp_listings_start_wrapper'] != '') {
		echo $options['wp_listings_start_wrapper'];
	} else {
		echo '<div id="primary" class="content-area container inner">
   <div id="content" class="site-content" role="main">';
 }

		// Start the Loop.
 while ( have_posts() ) : the_post(); ?>
  <script type="text/x-template" id="project-row-head-template">
    <div class="project-row-head bg-grey-200">
      <div class="row black padding-10">
        <div class="col-md-1">
          <div class="font-size-20 font-weight-600 text-center">Area</div>
        </div>
        <div class="col-md-3">
          <div class="font-size-20 font-weight-600 text-center">{{ data.title_name }}</div>
        </div>
        <div class="col-md-4">
          <div class="font-size-20 font-weight-600 text-center">{{ data.quality_name }}</div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">Low</div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">High</div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="project-row-project-template">
    <div class="project-row-project">
      <div class="row black padding-10">
        <div class="col-md-1">
          <input type="number" class="form-control"/>
        </div>
        <div class="col-md-3">
          <div class="font-size-20 font-weight-600 text-center">
            {{ data.title }} <span><input type="checkbox" checked value="yes"/></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="col-md-4">
            <input type="radio" name="quality" value="poor"><br>Poor
          </div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">$5000</div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">$7000</div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="project-row-template">
    <div class="project-row">
      <project-row-head v-bind:data="data"/>
      <div class="project-row-projects">
        <project-row-project v-bind:data="project" v-for="project in data.projects"/>
      </div>
    </div>
  </script>

  <script>
    var projectRowHead = Vue.component('project-row-head', {
      props: {
        data: {
          type: Object,
          default: () => {}
        }
      },
      template: '#project-row-head-template'
    });

    var projectRowProject = Vue.component('project-row-project', {
      props: {
        data: {
          type: Object,
          default: () => {}
        }
      },
      template: '#project-row-project-template'
    });

    Vue.component('project-row', {
      props: {
        data: {
          type: Object,
          default: () => {}
        }
      },
      components: {
        projectRowHead
      },
      template: '#project-row-template'
    });
  </script>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div id="property-valuation-calculator" class="row margin-top-20 text-center">
      <div class="col-md-10 col-md-offset-1">
        <div class="row">
          <div class="panel panel-bordered">
            <div class="panel-heading padding-10 text-left bg-grey-200">
              <?php the_title( '<div class="font-size-30 black" itemprop="name">Estimate: ', '</div>' ); ?>
              <small><?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?></small>
            </div>

            <?php single_listing_post_content(); ?>

            <div id="project-rows" class="bg-blue-grey-700">
              <div class="row white padding-10">
                <div class="col-md-1">
                  <div class="font-size-20 font-weight-600 text-center">
                    Area
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="font-size-20 font-weight-600 text-center">
                    Project
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="font-size-20 font-weight-600 text-center">
                    Quality
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="font-size-20 font-weight-600 text-center">
                    Budget Range
                  </div>
                </div>
              </div>
            </div>

            <project-row v-bind:data="project_row" v-for="project_row in calculator_options.project_row"/>
                    
            <div class="panel-footer bg-blue-grey-700">
              <div class="font-size-30 font-weight-600 white">Total Estimate: $0.00</div><br>
              <small>**All pricing data is pulled from previous projects from the houseace platform, this is only a price guide and there is liability to these prices</small>
              <hr>
              <div class="row">
                <div class="font-size-30 font-weight-600 white">Price Assumptions</div>
                <div class="col-md-6">
                  <div class="font-size-30 font-weight-600 white">Rent Increase: 0-0%</div>
                </div>
                <div class="col-md-6">
                  <div class="font-size-30 font-weight-600 white">Value Increase: 0-0%</div>
                </div>
              </div>
            </div>
            <div class="padding-20">
              <a class="btn btn-primary btn-block btn-raised btn-lg" href="/add_quote">Get an Instant Quote</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article><!-- #post-ID -->  

  <?php
    $post->post_meta = get_post_meta($post->ID, '', true);
  ?>
  <script>
    var property_data = {
      'bathrooms': '<?php echo get_post_meta( $post->ID, 'bathrooms', true ) ?>',
      'bedrooms': '<?php echo get_post_meta( $post->ID, 'bedrooms', true ) ?>',
      'zip': '<?php echo get_post_meta( $post->ID, 'address_parts_postcode', true ) ?>',
      'floorplans_count': '<?php echo get_post_meta( $post->ID, 'floorplans_count', true ) ?>',
      'price': '<?php echo get_post_meta( $post->ID, '_listing_price', true ) ?>'.replace( /^\D+/g, '').replace(/,/g, ''),
    };
    
    var calculator_options = {
      'zip': '<?php echo get_field('postcode', 'option'); ?>',
      'sale_price': '<?php echo get_field('sale_price', 'option'); ?>',
      'beds': '<?php echo get_field('beds', 'option'); ?>',
      'baths': '<?php echo get_field('baths', 'option'); ?>',
      'living': '<?php echo get_field('living', 'option'); ?>',
      'toilets': '<?php echo get_field('toilets', 'option'); ?>',
      'dwelling_type': '<?php echo get_field('dwelling_type', 'option'); ?>',
      'levels': '<?php echo get_field('levels', 'option'); ?>',
      'floor_area': '<?php echo get_field('floor_area', 'option'); ?>',
      'project_row': <?php echo wp_json_encode(get_field('project_row', 'option')) ?>
    }
    
    console.log(calculator_options);
    console.log(property_data);
    
    var obj = <?php echo wp_json_encode($post); ?>;
    
    console.log(obj);
    
    var app = new Vue({
      el: '#property-valuation-calculator',
      data: {
        property: property_data,
        calculator_options: calculator_options
      }
    })
  </script>
  <?php
  // Previous/next post navigation.
  wp_listings_post_nav();

  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) {
    comments_template();
  }
  endwhile;

  if(isset($options['wp_listings_custom_wrapper']) && isset($options['wp_listings_end_wrapper']) && $options['wp_listings_end_wrapper'] != '') {
    echo $options['wp_listings_end_wrapper'];
  } else {
    echo '</div><!-- #content -->
    </div><!-- #primary -->';
  }

  get_footer();

}
