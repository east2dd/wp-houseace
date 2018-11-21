<?php
/*
Template Name: landing
*/

global $need_starrating;

$need_starrating = array(
	'styles' => true
);
$agent_id = 569;
?>

<?php get_header(); ?>

<style>
	
	/*-------------------------------*/
    /*      Code snippet by          */
    /*      @maridlcrmn              */
    /*-------------------------------*/
  .section {
    padding-top: 100px;
    padding-bottom: 100px;
    min-height: 100%;
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

  <section id="main" class="section house-bg">
       <div class="container">
				<div class="row padding-top-40 text-center">
          <div class="font-size-40 white font-weight-800 margin-bottom-10"> 
       Houseace is Your Trusted Partner For Home Improvement</div>
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
       <div class="font-size-20 white">
              We've created the easiest way to improve your home with instant, online quotes, dedicated service at every step and top licensed & insured tradespeople </div>
       <br/>
       <a class="btn btn-lg btn-primary btn-raised scroll_to font-weight-600" href="#quote">GET STARTED</a>
       <a class="btn btn-lg bg-white btn-raised btn-outline font-weight-700"  data-toggle="modal" data-target="#quoteform">CONTACT</a>
                      
         </div>						
       </div>
     </div>

      </div>

  </section>

<div class="bg-white padding-40">
  <div class="container">
    <div class="row text-center">
        <div class="font-size-50 black text-center font-weight-800 margin-bottom-10"> 
         Our Services
      </div>
      <div class="font-size-20 blue-grey-800 text-center margin-bottom-30">
                   All your Hassle-Free home improvement services under 1 roof
                  </div>
      <div class="col-md-3">
        <div class="font-size-20 black">
        <a class="btn btn-link font-size-20" href="/services/painting">     <i class="icon pe-paint"></i>
          Residential Painting </br/>& Decorating</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="font-size-20 black">
             <a class="btn btn-link font-size-20" href="/services/timber-flooring">      <i class="icon pe-keypad"></i>
               Timber Floor Sanding, </br/>Staining & Polishing</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="font-size-20 black">
          <a class="btn btn-link font-size-20" href="/services/home-renovations/">             <i class="icon pe-refresh"></i>
            Complete Home </br/>Renovations & Improvement</a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="font-size-20 black">
           <a class="btn btn-link font-size-20" href="/services/commercial/">            <i class="icon fa-building"></i>
             Commercial, Industrial</br/> & Strata Projects</a>
        </div>
      </div>
      
    </div>
  </div>
</div>
         
<section id="how-it-works" class="padding-top-30 bg-white">
       <div class="container">
				<div class="row">
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
      <div class="font-size-50 black text-center font-weight-800 margin-bottom-10"> 
         How it Works
      </div>
                  <div class="font-size-20 blue-grey-800 text-center">
                    Get started with a free, instant quote
                  </div>
                       </div>						
       </div>
               <?php $image1 = get_field('image_1'); ?>
               <?php $image2 = get_field('image_2'); ?>
               <?php $image3 = get_field('image_3'); ?>
          <div class="row margin-20">
          <div class="col-md-6">
            <div class="padding-50 margin-top-50">
             <?php the_field('content_1'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="">
 <img class="img-square img-responsive" src="<?php echo $image1['url']; ?>" alt="...">
            </div>
          </div>
                    </div>
          <div class="row margin-top-10">
          <div class="col-md-6">
            <div class="">
 <img class="img-square img-responsive" src="<?php echo $image2['url']; ?>" alt="...">
            </div>
          </div>
          <div class="col-md-6">
            <div class="padding-50 margin-top-50">
             <?php the_field('content_2'); ?>
            </div>
          </div>
          </div>
          <div class="row margin-top-10">
          <div class="col-md-6">
            <div class="padding-50 margin-top-50">
             <?php the_field('content_3'); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="">
 <img class="img-square img-responsive" src="<?php echo $image3['url']; ?>" alt="...">
            </div>
          </div>
          </div>
     </div>

      </div>

  </section>
<div class="bg-white">
   <div class="container">
     <div class="row black">
        <div class="font-size-50 black text-center font-weight-800 margin-bottom-10"> 
         Our Difference
      </div>
                  <div class="font-size-20 blue-grey-800 text-center">
                    House<b>ace</b> is your trusted partner for home improvement
                  </div>
       <div class="margin-20"></div>
						  <div class="col-md-3">
							 <div class="padding-20 text-center">
                  <i class="icon fa-flash black margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                   <b>We always confirm.</b>
<br/>
We stay in constant communication with our clients. The end result? Beautiful projects and relationships.
                 </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-20 text-center">
                  <i class="icon wb-chat-working margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We check-in.</b><br/> We'll stay in touch every step of the way — from the first consultation until you’re enjoying the finished product.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-20 text-center">
                  <i class="icon pe-date margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We arrive on time.</b><br/> Your time is important. We will always offer superior services that meet your schedule - and your budget.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-20 text-center">
                  <i class="icon wb-time margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We Quote in Real-time.</b><br/>We dont like wasting your time so when we say we'll give you a quote its done on the spot, in real-time.
                    </div><br/>
                  </div>
						 </div>
     </div>
     
   </div>
</div>


<section id="quote" class="cosy-bg section">
       <div class="container">
				<div class="row padding-top-80 text-center">
           <div class="col-md-10 col-md-offset-1">
     <div clss="row">  
      <div class="font-size-40 font-weight-600 white margin-bottom-10"> 
        Get your fully-inclusive quote now
                  </div>
                                    <div class="margin-top-20 row padding-5">
                    <form action="/add_quote" method="get">
          <div class="col-md-3 col-xs-12">
            <div class="font-size-30 font-weight-600 white inline">
              I want to:
            </div>
                      </div>
          <div class="col-md-6 col-xs-12 padding-0">
         <select data-plugin="selectpicker" data-live-search="true" data-style="btn-lg bg-white" style="border-bottom: 1px solid" class="show-tick form-control" name="templateId" id="templatId">
                    <optgroup data-icon="pe-paint" label="Interior Painting">
                    <option selected="selected" data-tokens="paint interior painting house painters" data-icon="pe-paint" value="10129">Paint my House Interior</option>
                    <option data-icon="pe-paint" value="10129">Paint my Apartment Interior</option>
                    <option data-icon="pe-paint" value="11704">Paint my office Interior</option>
                    <option data-icon="pe-paint" value="10130">Paint a Single Room</option>
                    <option data-icon="pe-paint" value="12249">Paint a Single Wall/Ceiling</option>
                    <option data-icon="pe-paint" value="12250">Paint my Doors or Windows</option>
                    </optgroup>
                    <optgroup data-icon="pe-paint" label="Exterior Painting">
                    <option data-icon="pe-paint" value="10131">Paint my House Exterior</option>
                    <option data-icon="pe-paint" value="8522">Paint my Roof</option>
                    <option data-icon="pe-paint" value="12249">Paint a Single wall/Ceiling</option>
                     </optgroup> 
                     <optgroup data-icon="pe-paint" label="Rendering & Repairs">
                    <option data-icon="pe-paint" value="11405">Render my House Exterior</option>
                    <option data-icon="pe-paint" value="11405">Fix Rendering cracks</option>
                    <option data-icon="pe-paint" value="8462">Plaster my interior</option>
                     </optgroup> 
                    <optgroup data-icon="pe-keypad" label="Flooring">
                    <option data-icon="pe-keypad" value="10309">Sand & Polish my Floors</option>
                    <option data-icon="pe-keypad" value="10309">Stain my Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Lime/White Wash my Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Carpet my Floor</option>
                    <option data-icon="pe-keypad" value="10306">Tile my Floor</option>
                    <option data-icon="pe-keypad" value="10309">Vinyl my floor</option>
                     </optgroup>
                    <optgroup data-icon="pe-coffee" label="Renovations">
                    <option data-icon="pe-coffee" value="13504">Renovate my Bathroom</option>
                    <option data-icon="pe-coffee" value="8197">Renovate my Kitchen</option>
                    <option data-icon="pe-coffee" value="13502">Renovate my Laundry</option>
                    <option data-icon="pe-coffee" value="13503">Renovate my Toilet</option>
                     </optgroup>
                   <optgroup data-icon="pe-home" label="Carpentry">
                    <option data-icon="pe-home" value="178">Build a deck</option>
                    <option data-icon="pe-home" value="177">Build a fence</option>
                    <option data-icon="pe-home" value="10376">Hire a Handyman</option>
                    <option data-icon="pe-home" value="13506">Install Roofing</option>
                     </optgroup>
                  </select>
           </div>
          <div class="col-md-3 col-xs-12">
            <button type="submit" class="btn btn-lg hidden-xs btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i> GET STARTED</b></button>
            <button type="submit" class="btn btn-lg visible-xs margin-top-15 btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i> GET STARTED</b></button>
          </div>
            </form>
             </div>
                  
         </div>						
       </div>
     </div>

      </div>

  </section>

 <div class="bg-white hidden">
   <div class="container">
     <div class="row black">
       <div class="font-size-30 margin-top-30 text-center black">
        Why Choose House<b>ace</b> 
       </div>
       <div class="margin-20"></div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon fa-flash black margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                   <b>We always confirm.</b>
<br/>
We stay in constant communication with our clients. The end result? Beautiful projects and relationships.
                 </div><br/>
                  </div>
						 </div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon icon wb-emoticon margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We improve lives, 
not houses.</b><br/> Our work goes beyond color chips and paintbrushes. We create a space that you'll love to call home.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon pe-star margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We respect everyone's property.</b><br/>Your home, property and furniture are treated as if they were our own. It’s that simple.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon wb-chat-working margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We check-in.</b><br/> We'll stay in touch every step of the way — from the first consultation until you’re enjoying the finished product.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon pe-date margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>We arrive on time.</b><br/> Your time is important. We will always offer superior services that meet your schedule - and your budget.
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-4 height-250">
							 <div class="padding-35 text-center">
                  <i class="icon wb-time margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      <b>The fastest Quotes</b><br/>We dont like wasting your time so when we say we'll give you a quote its done on the same day and usually hour.
                    </div><br/>
                  </div>
						 </div>
     </div>
     
   </div>
</div>
   <div class="bg-white hidden margin-top-30">
     <div class="container padding-bottom-20">
          <div class="row">
          <div class="font-size-30 black margin-top-30">The House<b>ace</b> way.</div>
            <div class="font-size-20 blue-grey-800">
We've made it our mission to make home improvement hassle free and it all starts with our powerful online platform<br/>
              <br/>
House<b>ace</b> is the simple, smart way to get your project done. Our easy-to-use platform allows you to see an exact project price in a couple of minutes and our dedicated personal service on each step makes the process to update your home more simple & more transparent. 

            </div>
            
    
            <div class="nav-tabs-vertical hidden nav-tabs-animate margin-top-20">
                  <ul class="nav nav-tabs nav-tabs-line margin-right-25 col-md-4 black " data-plugin="nav-tabs" role="tablist">
                    <li class="active" role="presentation"><a class="btn btn-raised padding-30 text-left" data-toggle="tab" href="#exampleTabsLineLeftOne" aria-controls="exampleTabsLineLeftOne" role="tab" aria-expanded="false"> <div class="font-size-30 font-weight-600 black">
                  Quality Comes first.
                         </div>
                         <div class="font-size-15 black">We’ve thoroughly vetted every Licensed & Insured<br/> tradesperson in our network to ensure that we have <br/>the best professionals in the industry               
                       </div></a></li>
                    <li role="presentation" class=""><a class="btn btn-raised padding-30 text-left" data-toggle="tab" href="#exampleTabsLineLeftTwo" aria-controls="exampleTabsLineLeftTwo" role="tab" aria-expanded="false"><div class="font-size-30 font-weight-600 black">
                  Live, Online Quotes.
                         </div><div class="font-size-15 black">Any of the quote generators will give you <br/>a fully transparent price that includes labour, material<br/> and tax. All in just 2 minutes           
                       </div></a></li>
                    <li role="presentation" class=""><a class="btn btn-raised padding-30 text-left" data-toggle="tab" href="#exampleTabsLineLeftThree" aria-controls="exampleTabsLineLeftThree" role="tab" aria-expanded="false"><div class="font-size-30 font-weight-600 black">
               Guaranteed Happiness.
                           </div>
                         <div class="font-size-15 black">Your happiness is our goal. If you're not happy,<br/> we'll work to make it right. Our friendly project <br/>managers are available 24 hours a day, 7 days a week           
                       </div></a></li>
                  </ul>
                  <div class="tab-content hidden-xs padding-vertical-15 col-md-7">
                    <div class="tab-pane active animation-slide-bottom" id="exampleTabsLineLeftOne" role="tabpanel">
                     <img class="img-square margin-50 img-responsive" src="<?php bloginfo('template_url'); ?>/assets/images/s3.png" alt="...">
                    </div>
                    <div class="tab-pane animation-slide-bottom" id="exampleTabsLineLeftTwo" role="tabpanel">
                     <img class="img-square margin-50 img-responsive" src="<?php bloginfo('template_url'); ?>/assets/images/s1.png" alt="...">
                    </div>
                    <div class="tab-pane animation-slide-bottom" id="exampleTabsLineLeftThree" role="tabpanel">
                     <img class="img-square margin-50 img-responsive" src="<?php bloginfo('template_url'); ?>/assets/images/s4.png" alt="...">
                    </div>
                  </div>
                </div>   
  </div>
</div>
</div>

<div class="bg-white hidden"> 
  <div class="container padding-top-30">
        <div class="font-size-30 black text-center">Popular Projects</div>
        <div class="font-size-20 blue-grey-600 text-center">Instantly get a price for any of the projects below or just message to make an appointment</div>
    		<div class="row padding-top-30">
           <div class="col-md-3">       
             <div class="font-size-30 black">Painting</div>
          </div>
<div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=10129"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/int.jpg" alt="..."></a>
  <div class="font-size-20 blue-grey-600">Interior Painting</div><small>Houses, Units, Apartments</small>
          </div>
         <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=10131"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/ext.jpg" alt="..."></a>
    <div class="font-size-20 blue-grey-600">Exterior Painting</div><small>Terrace homes, Brick or Weatherboards</small>
          </div>
          <div class="col-md-3">
<a href="<?php bloginfo('url'); ?>/add_quote/?templateId=11704"><img class="img-rounded img-bordered img-bordered-red img-responsive"  src="<?php bloginfo('template_url'); ?>/assets/images/home/office.jpg" alt="..."></a>
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
    
    <div class="row padding-top-30 hidden padding-bottom-30">
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

<div class="bg-white hidden">
   <div class="container">
     <div class="font-size-30 black text-center">
       Super Affordable
     </div>
      <div class="font-size-20 text-center blue-grey-600">
Our pricing is very competitive because our platform streamlines the process from start to finish, so everyone involved is much better off.
     </div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="height-300 price-bg">
         
        </div> 
      </div>
     </div>
  </div>
</div>

<div class="bg-grey-100">
  <div class="container">
    <div class="row margin-20">
      <div class="col-md-6">
                     <div class="font-size-30 black margin-top-30">We Think Our Tradespeople are <b>Ace</b></div>
         <div class="font-size-20 blue-grey-600">
           All of our tradespeople go through a rigorious vetting process
         </div><br/>
        
      </div>
       <div class="col-md-6">
         <ul style="list-style: none">
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">20+ Years of trade experience</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Trade licensed</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Full Liability Insurance</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Customer centric approach to work</div></li>
         </ul>
         
      </div>
    </div>
  </div>
</div>
 
<div class="bg-white"> 
  <div class="container padding-30">
    		<div class="row">
			<div class="col-md-12">
        <div class="font-size-30 black text-center">Recent Reviews</div>
				<div class="carousel slide" style="max-height:400px; overflow: scroll"  id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  
          <div class="col-md-6 col-md-offset-3">
                    
  <?php if(get_field('reviews','user_' . $agent_id)) : ?>
	<?php $reviews = get_field('reviews','user_' . $agent_id); ?>
	<?php foreach($reviews as $review) : ?>
		<?php 
			$reviewUserId = get_field('client_id',$review['projectId']);
			if($reviewUserId['ID']) {
				$reviewUserId = $reviewUserId['ID'];
			}
			elseif($reviewUserId[0]) {
				$reviewUserId = $reviewUserId[0];
			}
			$reviewUserData = go_userdata($reviewUserId);
		?>
		<?php if(get_the_title($review['projectId']) != '') : ?>
			<div class="widget widget-shadow bg-blue-grey-100">
				<div class="widget-body">
					<div class="avatar avatar-sm pull-left margin-right-10 margin-top-5">
						<img src="<?php echo $reviewUserData->avatar; ?>" alt="">
					</div>
					<div class="info margin-bottom-25">
						<div class="blue-grey-700 text-uppercase"><?php echo $reviewUserData->first_name; ?></div>
						<div class="blue-grey-400 text-capitalize"><?php echo get_the_title($review['projectId']); ?></div>
					</div>
					<div class="br-theme-fontawesome-stars">
						<div class="br-widget rating rating-lg" data-score="<?php echo $review['rating']; ?>" data-plugin="rating">
							<?php for($i = 1; $i <=5; $i++): ?>
								<a 
									data-alt="<?php echo $i; ?>" 
									class="<?php if($i <= $review['rating'] ): ?>br-selected<?php endif; ?>
								"></a>
							<?php endfor; ?>
							<input name="score" type="hidden" value="<?php echo $review['rating']; ?>">
						</div>
					</div>
					<p class=""><?php echo $review['review']; ?></p>
				</div>
			</div>
		<?php endif; ?> 							
	<?php endforeach; ?>
<?php else : ?>
	<p class="text-center">No reviews yet.</p>
<?php endif; ?>
             
				</div>
			</div>							
		</div>
	</div>
</div>

			

		
			</div>

<?php get_footer(); ?>