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
  
  wp_register_style ( 'bootstrap-grid', get_template_directory_uri() . '/css/bootstrap-grid.min.css' );
  wp_enqueue_style( 'bootstrap-grid' );

  wp_register_script ( 'vuejs', get_template_directory_uri() . '/js/vue.min.js' );
  wp_register_script ( 'lodash', get_template_directory_uri() . '/js/lodash.min.js' );
  wp_enqueue_script( 'vuejs', array('jquery'), true, true );
  wp_enqueue_script( 'lodash', array('jquery'), true, true );
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
          <input id="postcode" class="form-control" v-model="calculator_options.zip" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="postcode">Sale Price:</label>
          <input id="postcode" class="form-control" v-model="calculator_options.sale_price" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="beds">Beds:</label>
          <input type="number" id="beds" class="form-control" v-model="calculator_options.beds"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="baths">Baths:</label>
          <input id="baths" class="form-control" v-model="calculator_options.baths" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="living">Living:</label>
          <input id="living" class="form-control" v-model="calculator_options.living" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="toilets">toilets:</label>
          <input id="toilets" class="form-control" v-model="calculator_options.toilets" type="number"/>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="type">Dwelling Type</label>
          <select id="area" class="form-control" v-model="calculator_options.dwelling_type">
            <option value="house">House</option>
            <option value="unit">Unit</option>
            <option value="apartment">Apartment</option>
          </select>
        </div>
        <div class="col-md-6 col-xs-6">
          <label for="type">Levels</label>
          <select id="area" class="form-control" v-model="calculator_options.levels">
            <option>1</option>
            <option>2</option>
            <option>3</option>
          </select>
        </div>
        <div class="col-md-12 col-xs-12">
          <label for="area">Floor Area:</label>
          <input id="area" class="form-control input-lg" type="number" v-model="calculator_options.floor_area"/>
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
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">Area</div>
        </div>
        <div class="col-md-3">
          <div class="font-size-20 font-weight-600 text-center">{{ data.title_name }}</div>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-2">
          <input type="number" class="form-control" v-model="data.area"/>
        </div>
        <div class="col-md-3">
          <div class="font-size-20 font-weight-600 text-center">
            {{ data.title }} <span><input type="checkbox" v-model="data.checked" value="yes"/></span>
          </div>
        </div>
        <div class="col-md-3">
          <div class="d-flex">
            <div class="flex-fill" v-for="quality in data.quality">
              <label><input type="radio" v-model="data.selected_quality" v-bind:value="quality.price"><br>{{ quality.title }}</label>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">${{ minQualityPrice() }}</div>
        </div>
        <div class="col-md-2">
          <div class="font-size-20 font-weight-600 text-center">${{ maxQualityPrice() }}</div>
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
    var property_data = {
      'baths': parseInt('<?php echo get_post_meta( $post->ID, 'bathrooms', true ) ?>') || 0,
      'beds': parseInt('<?php echo get_post_meta( $post->ID, 'bedrooms', true ) ?>') || 0,
      'zip': '<?php echo get_post_meta( $post->ID, 'address_parts_postcode', true ) ?>',
      'floor_area': parseInt('<?php echo get_post_meta( $post->ID, '_listing_floors', true ) ?>') || 0,
      'sale_price': parseInt('<?php echo get_post_meta( $post->ID, '_listing_price', true ) ?>'.replace( /^\D+/g, '').replace(/,/g, '')),
    };

    var calculator_options = {
      'total_price': 0,
      'zip': '<?php echo get_field('postcode', 'option'); ?>',
      'sale_price': parseInt('<?php echo get_field('sale_price', 'option'); ?>') || 0,
      'beds': parseInt('<?php echo get_field('beds', 'option'); ?>') || 0,
      'baths': parseInt('<?php echo get_field('baths', 'option'); ?>') || 0,
      'living': parseInt('<?php echo get_field('living', 'option'); ?>') || 0,
      'toilets': parseInt('<?php echo get_field('toilets', 'option'); ?>') || 0,
      'dwelling_type': '<?php echo get_field('dwelling_type', 'option'); ?>',
      'levels': '<?php echo get_field('levels', 'option'); ?>',
      'floor_area': parseInt('<?php echo get_field('floor_area', 'option'); ?>') || 0,
      'project_row': <?php echo wp_json_encode(get_field('project_row', 'option')) ?>
    }

    calculator_options = _.defaults(property_data, calculator_options);

    // init floor area
    if( calculator_options.floor_area == 0 )
    {
      calculator_options.floor_area = calculator_options.beds * 15 
                                      + calculator_options.baths * 6
                                      + 10 //kitchen
                                      + calculator_options.living * 20 //living
                                      + 10 //dining
                                      + 4; //hallway

    }

    var app = null;
    jQuery(function(){
      app = new Vue({
        el: '#property-valuation-calculator',
        data: {
          calculator_options: calculator_options
        },
        filters: {
          round2: function(value){
            return Math.round(value * 100) / 100
          }
        },
        methods: {
          estimate: function(){
            let total_price = _.sumBy(calculator_options.project_row, (project_row)=>{

              let project_type = project_row.title_name.toLowerCase();
              let multiplier = this.calc_multiplier(project_type);

              let project_price = _.sumBy(project_row.projects, (project)=>{
                return this.calc_project_quality_price(project);
              });

              return project_price * multiplier;
            });

            calculator_options.total_price = total_price;

            return total_price;
          },
          calc_multiplier: function(project_type){
            if(project_type=="painting" || project_type=="flooring")
            {
              if(calculator_options.floor_area < 50){
                return 1.5;
              }
              if(calculator_options.floor_area < 100){
                return 1;
              }
              if(calculator_options.floor_area < 200){
                return 0.8;
              }
              return 0.8;
            }

            if(project_type=="renovations"){
              if(calculator_options.floor_area < 4){
                return 1.2;
              }
              if(calculator_options.floor_area < 6){
                return 1;
              }
              if(calculator_options.floor_area == 6){
                return 0.8;
              }
              return 0.8;
            }

            return 1;
          },
          calc_project_quality_price: function(project){
            if(project.checked==true && project.selected_quality)
            {
              return project.selected_quality * project.area;
            } else{
              return 0;
            }
          },
          calc_floor_area: function(){
            let floor_area = calculator_options.beds * 15 
                    + calculator_options.baths * 6
                    + 10 //kitchen
                    + calculator_options.living * 20 //living
                    + 10 //dining
                    + 4; //hallway

            calculator_options.floor_area = floor_area;

            return floor_area;
          },
          calc_portion: function(){
            let low = calculator_options.total_price * 85.0 / 100.0;
            let high = calculator_options.total_price * 115.0 / 100.0; 
            let portion_of_value = calculator_options.total_price / calculator_options.sale_price;
            return portion_of_value;
          }
        }
      });
    });
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
      methods:{
        minQualityPrice: function(){
          let object =  _.minBy(this.data.quality, function(o) { return o.price; });
          if(this.data.area == 0)
          {
            return object.price * calculator_options.floor_area;
          }
          return object.price * this.data.area;
        },
        maxQualityPrice: function(){
          let object =  _.maxBy(this.data.quality, function(o) { return o.price; });
          if(this.data.area == 0)
          {
            return object.price * calculator_options.floor_area;
          }
          return object.price  * this.data.area;
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

            <div class="bg-blue-grey-700">
              <div class="row white padding-10">
                <div class="col-md-2">
                  <div class="font-size-20 font-weight-600 text-center">
                    Area
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="font-size-20 font-weight-600 text-center">
                    Project
                  </div>
                </div>
                <div class="col-md-3">
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

            <div id="project-rows">
              <project-row v-bind:data="project_row" v-for="project_row in calculator_options.project_row"/>
            </div>
                    
            <div class="panel-footer bg-blue-grey-700">
              <div class="font-size-30 font-weight-600 white">Total Estimate: ${{ parseInt(estimate()) }}</div><br>
              <small>**All pricing data is pulled from previous projects from the houseace platform, this is only a price guide and there is liability to these prices</small>
              <hr>
              <div class="font-size-30 font-weight-600 white">Price Assumptions</div>
              <div class="row">
                <div class="col-md-6">
                  <div class="font-size-30 font-weight-600 white">Rent Increase: {{ calc_portion() * 1 | round2 }}-{{ calc_portion() * 1.5 | round2}}%</div>
                </div>
                <div class="col-md-6">
                  <div class="font-size-30 font-weight-600 white">Value Increase: {{ calc_portion() * 1.5 | round2 }}-{{ calc_portion() * 2.5 | round2}}%</div>
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
