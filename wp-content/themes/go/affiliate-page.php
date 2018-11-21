<?php
/*
Template Name: affiliate
*/
?>

<?php get_header(); ?>

<style>
	
	/*-------------------------------*/
    /*      Code snippet by          */
    /*      @maridlcrmn              */
    /*-------------------------------*/


    section {
        padding-top: 100px;
        padding-bottom: 100px;
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

<div class="animsition" style="animation-duration: 800ms; opacity: 1;">
    <section class="section front-bg">
        <div class="container">
				
					                    <div class="row margin-bottom-100">
<div class="text-center white margin-top-100 margin-xs-0">
        <div class="font-size-30 font-weight-300 margin-bottom-30">Interested in partnering with House<b>ace</b>? <br/>We partner with companies in a variety of fields, see below:
</div>
      <a class="btn btn-primary btn-lg btn-raised" href="#contact">Become a Partner</a>
	
				

                </div>
					
      </div>
    </div>
    
  </section>

  <div class="padding-50 bg-grey-100">

				 <div class="row text-center">
                      <div class="font-size-20 black">
               Get it done by one of <div class="red-800 inline">135</div> Top rated, Pre-vetted local tradespeople, Guaranteed to be Licensed, Insured, and ready to start within <div class="inline red-600">48</div> hours

           </div>					 
			</div>
			</div>
 
	<div id="how-it-works" class="container">
		<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class=" font-size-30">
                     Real Estate
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
We specialize in helping you get the most value when selling your property - whether you’re an agent, a realty firm, or a property owner.
									</div></div></div>

               
              </div>
    	<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class=" font-size-30">
                     Interior Designers
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
Spend less time worrying about hiring paint vendors and more time on designing. With a dedicated Houseace Project Manager on every job, we are able to manage multiple crews across all of your clients.									</div></div></div>
									</div>

       	<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class=" font-size-30">
                     Property Management
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
You need a reliable contractor who you can count on to deliver quality, cost-effective work. We have the expertise to execute most types of projects.
									</div></div></div>

               
              </div>
    	<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class=" font-size-30">
                    Insurance
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
Homeowners dealing with disaster need an honest, detail-oriented contractor who can get them back to normal. Insurers want easy to understand bids that help accelerate the claim process. Houseace.com.au delivers both.
									</div></div></div>

               
              </div>
    	<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class=" font-size-30">
                     Home Builders
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
New construction is made up of many specialized trades, and Houseace.com.au has you covered with painting, rendering, flooring, and project managers, and the subcontractors required to get the job done right.
									</div></div></div>

               
              </div>
    	<div class="row">
                <div class="col-sm-12 padding-30">
                <div class="blue-grey-700"> 
                   <div class="font-size-30">
                     Architects
                    </div><hr>
								<div class="blue-grey-800 font-size-20">
    Houseace works alongside architects to provide construction cost estimating to help align design with customer expectations. We help design and construction come together in a way that works for all stakeholders.
									</div></div></div>

               
              </div>
				
	</div>
	  		 
	  <div id="contact" class="bg-grey-200">
      <div class="container">
        <div class="row padding-50">
          <div class="text-center blue-grey-800 font-size-30">
            Want to partner with us? Send us a message and we’ll get in touch soon to start the process.
          </div><br/>
       	<?php echo do_shortcode('[contact-form-7 id="10906" title="affiliate"]'); ?>
        </div>
      </div>
  </div>
	
		
 
<?php get_footer(); ?>