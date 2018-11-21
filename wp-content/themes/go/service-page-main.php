<?php
/*
Template Name: Services main page
*/
?>

<?php get_header(); ?>


<style>
	
	/*-------------------------------*/
    /*      Code snippet by          */
    /*      @maridlcrmn              */
    /*-------------------------------*/
  .section {
    padding-bottom: 100px;
  }

  .yellow-600 {
         color: #ffe545;
  }
  .quote {
        color: rgba(0,0,0,.1);
        text-align: center;
        margin-bottom: 30px;
    }
  

    /*-------------------------------*/
    /*    Carousel Fade Transition   */
    /*-------------------------------*/

    #fade-quote-carousel.carousel {
      padding-bottom: 60px;
  }
  #fade-quote-carousel.carousel .carousel-inner .item {
      opacity: 0;
      -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
      transition-property: opacity;
  }
  #fade-quote-carousel.carousel .carousel-inner .active {
      opacity: 1;
      -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
      transition-property: opacity;
  }
  #fade-quote-carousel.carousel .carousel-indicators {
      bottom: 10px;
  }
  #fade-quote-carousel.carousel .carousel-indicators > li {
      background-color: #e84a64;
      border: none;
  }
  #fade-quote-carousel blockquote {
    text-align: center;
    border: none;
}
#fade-quote-carousel .profile-circle {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    border-radius: 100px;
}


</style>
<!-- Page -->

<section id="main" class="section <?php the_field('bg_class'); ?>">
       <div class="container">
				<div class="row padding-top-80 text-center">
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
      <div class="font-size-50 white font-weight-800 margin-bottom-10"> 
         <?php the_field('header_text'); ?>
 </div>
                  <div class="font-size-20 white">
                    <?php the_field('header_text_below'); ?>
                  </div>
        <div class="inline"><div class="rating rating-lg" data-score="5" data-plugin="rating"><i data-alt="1" class="font-size-30 icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="font-size-30 icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="font-size-30 icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="font-size-30 icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="4.9" class="font-size-30 icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="4.9"></div><div class="font-size-15 white font-weight-600">avg. rating 4.9/5</div></div>				
         </div>						
       </div>
     </div>

      </div>

  </section>

<div class="modal fade modal-fill-in" id="quoteform" aria-hidden="false" aria-labelledby="quoteform"
                  role="dialog" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close btn-lg" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <div class="font-size-30 text-center font-weight-800 blue-grey-800" id="exampleFillInModalTitle">Enter your postcode to get started</div>
                        </div>
                        <div class="modal-body">
                          <form>
                            <div class="row">
                              <div class="col-md-6 col-md-offset-3">
                               <input style="width:100%" class="input-lg" id="address"/><br/>
                              <button class="btn margin-top-20 btn-lg btn-block btn-primary">
                                Next <i class="icon pe-gleam"></i>
                              </button> 
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

 
<div class="bg-red-600">
   <div class="container">
     <div class="row white">
       <div class="font-size-30 margin-top-10 text-center white">
        How it works
       </div>
       <div class="margin-20"></div>
        <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-flash red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      1<br/>  Get your all inclusive project price online or by phone
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon wb-chat-working red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      2<br/>  Review details with your dedicated project manager
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-credit-card red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      3<br/> Choose your colours & a start date, then book online
                    </div><br/>
                  </div>
						 </div>
               <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon pe-star red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      4<br/> Get your Houseace project done on time and in budget
                    </div><br/>
                  </div>
						 </div>
     </div>
   </div>
</div>

<div class="bg-white"> 
  <div class="container padding-top-30">
        <div class="font-size-30 black text-center">All Services</div>
        <div class="font-size-20 blue-grey-600 text-center">Instantly get a price for any of the projects below or just message to make an appointment</div>
    		<div class="row padding-top-30">
           <div class="col-md-3">       
             <div class="font-size-30 black">Painting</div>
          </div>
<div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/services/interior-painting"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/int.jpg" alt="..."></a>
  <div class="font-size-20 blue-grey-600">Interior Painting</div><small>Houses, Units, Apartments</small>
          </div>
         <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/services/exterior-painting"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/ext.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Exterior Painting</div><small>Terrace homes, Brick or Weatherboards</small>
          </div>
          <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/commercial-painting"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/office.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Office painting</div><small>Commercial, Strata, Industrial</small>
          </div>
    </div>
     <div class="row padding-top-30">
           <div class="col-md-3">       
             <div class="font-size-30 black">Renovations</div>
          </div>
<div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=13504"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/bath.png" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Bathroom Renovation</div><small>Tiled or Acrylic showers</small>
          </div>
         <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=12720"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/kitch.jpg" alt="..."></a>
   <div class="font-size-20 blue-grey-600">Kitchen Renovation</div><small>Choose your Cabinets online</small>
          </div>
          <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=13502"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/lndry.jpg" alt="..."></a>
   <div class="font-size-20 blue-grey-600">Laundry Renovation</div><small>Supply and Installation</small>
          </div>
    </div>
    
    <div class="row padding-top-30">
           <div class="col-md-3">       
             <div class="font-size-30 black">Flooring</div>
          </div>
<div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=10309"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/timber.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Timber Sanding</div><small>TImber staining, white washing or polish</small>
          </div>
         <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=10306"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/tile.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Tile Flooring</div><small>Quality laying, Competitive rates</small>
          </div>
          <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=10305"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/carpet.jpg" alt="..."></a>
   <div class="font-size-20 blue-grey-600">Carpet Flooring</div><small>Supply and Fit</small>
          </div>
    </div>
    
    <div class="row padding-top-30 padding-bottom-30">
           <div class="col-md-3">       
             <div class="font-size-30 black">Carpentry</div>
          </div>
<div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=178"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/deck.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Deck Building</div><small>Timber, Prefinished or Painted</small>
          </div>
         <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=177"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/fence.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Fencing</div><small>TImber or Aluminiumm. Gates included</small>
          </div>
          <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=13506"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/roof.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Roofing Installation</div><small>Concrete or Metal tiles, Longrun</small>
          </div>
    </div>
  </div><hr>
</div>

<div class="bg-white">
   <div class="container">
     <div class="font-size-30 black text-center">
       Super Affordable
     </div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="height-300 price-bg">
         
        </div> 
      </div>
     </div>
  </div>
</div><hr>

<?php get_footer(); ?>