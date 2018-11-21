<?php
/*
Template Name: cost guide
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

<section id="main" class="section <?php the_field('bg_class'); ?>">
       <div class="container">
				<div class="row padding-top-40">
           <div class="col-md-12">
                <div clss="row">  
      <div class="font-size-50 white font-weight-800 margin-bottom-10"> 
         <?php the_field('header_text'); ?>
 </div>
                  <div class="font-size-20 white">
                    <?php the_field('header_text_below'); ?>
                  </div>
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

 
   <div class="bg-white">
     <div class="container padding-bottom-20">
          <div class="row">
          <div class="font-size-30 black margin-top-30">The House<b>ace</b> way.</div>
            <div class="font-size-20 blue-grey-800">
              Our Secret recipe to making <?php the_field('header_text'); ?> Hassle Free
            </div>
            
            <div class="col-md-6 col-md-offset-2">
                                   <?php the_field('content_1'); ?> 
            </div>

  </div>
</div>
</div>


<div class="bg-white">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
       <div class="height-500 builder-bg">
         
        </div> 
      </div>
       <div class="col-md-6">
             <div class="font-size-30 black margin-top-30">Our tradespeople <b>ace</b> the test</div>
         <div class="font-size-20 blue-grey-600">
           All of our Ace's go through a vigorious vetting process to be considered as a member on our platform. Here are a few things we look for:
         </div><br/>
         <ul style="list-style: none">
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">5 Years of trade experience</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Appropriate trade licensing</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Full Liability Insurance</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Multiple References</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Portfolio of recent relative work</div></li>
           <li><i style="font-size: 30px" class="icon wb-star yellow-600"></i> <div class="font-size-20 inline black">Customer centric approach to business</div></li>
         </ul>
         <div class="font-size-20 margin-top-10 inline black">
           Sound like you?    <a href="/partners" class="btn btn-primary btn-raised">Become an <b>ace</b></a>
         </div>
      </div>
    </div>
  </div>
</div>

<div class="good-bg"> 
  <div class="container padding-30">
    		<div class="row">
			<div class="col-md-12">
        <div class="font-size-30 white text-center">Verified Reviews</div>
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  
          <div class="col-md-6 col-md-offset-3">
            
            <div class="carousel-inner">
              <div class="item active">
              <div class="widget height-500 margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Etienne R</h4>
                <p class="blue-grey-600">Newport, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
                       <p>From the beginning, the team at houseace have demonstrated excellent client service and made the whole transaction an extremely pleasurable experience. At a time when my and I family were very stressed handling busy work lives and an upcoming overseas move the houseace team have taken enormous pressure of us in getting our house ready to be rented out and that in the space of one week only. David (who managed the job on-site) and his team of painting professionals have done a fantastic job. I'm superbly happy with the diligence and the quality of their work. They have been great and uncomplicated to deal with, were very courteous and cleaned up after they were done with their work. A big Thank You to everyone who we have worked with at Houseace. I can only give you the highest recommendation. I wish I had known you earlier. </p>
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
					    <div class="item">
              <div class="widget height-500 margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Sandra L</h4>
                <p class="blue-grey-600">Newtown, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
                                        <p>Everything looks great. I'm very happy with the job that they've done. We've even had one of our contractors come by and ask who our painter was because they were so impressed with their work. Thankyou to you too for all of the project management. It has been great dealing with you, and I've greatly appreciated your flexibility and understanding with the scheduling difficulties we've had to work around. </p>
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
				      <div class="item">
              <div class="widget height-500 margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Julia P</h4>
                <p class="blue-grey-600">Emu Plains, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
                   <p>The process was so easy and fast with a fantastic project manager and crew. I would highly recommend using this service to paint
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
				      
              <div class="item">
              <div class="widget height-500 margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Elizabeth L</h4>
                <p class="blue-grey-600">Manly Beach, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
              <p>So easy! I didn't have to waste time meeting different contractors on site, they gave me an instant price and started 2 days later. Highly recommended. </p>
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
        
              <div class="item">
              <div class="widget height-500 margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Shana M</h4>
                <p class="blue-grey-600">Darlington, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
                   <p>Super easy throughout the whole process. Having a dedicated job manager on board to co-ordinate the painter was great and thank you for help with the colours. Will definitely recommend this site. A++</p>
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
        
				  </div>
				</div>
			</div>							
		</div>
	</div>
</div>

			

		
			</div>


       
<div class="bg-white padding-30">
       <div class="container">
				<div class="row text-center">
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
      <div class="font-size-30 black margin-bottom-10"> 
        Start your project now 
 </div>
                  <div class="font-size-20 blue-grey-600">
                    It's fast, easy, and free!
                  </div>
                                    <div class="margin-top-20 row btn-raised bg-red-600 panel padding-5">
                    <form action="/add_quote" method="get">
          
     <div class="col-md-8 col-xs-9 padding-0">
         <select data-plugin="selectpicker" data-live-search="true"  data-style="btn-lg bg-white" title='What do you need done?' class="show-tick form-control" name="templateId" id="templatId">
                    <optgroup data-icon="pe-paint" label="Interior Painting">
                    <option data-tokens="paint interior painting house painters" data-icon="pe-paint" value="10129">House/Terrace Interior</option>
                    <option data-icon="pe-paint" value="10129">Apartment/unit Interior</option>
                    <option data-icon="pe-paint" value="11704">Office Interior</option>
                    <option data-icon="pe-paint" value="10130">Single Room</option>
                    <option data-icon="pe-paint" value="12249">Single Wall/Ceiling</option>
                    <option data-icon="pe-paint" value="12250">Doors or Windows</option>
                    </optgroup>
                    <optgroup data-icon="pe-paint" label="Exterior Painting">
                    <option data-icon="pe-paint" value="10131">House/Terrace Exterior</option>
                    <option data-icon="pe-paint" value="10131">Apartment/Unit Exterior</option>
                    <option data-icon="pe-paint" value="8522">House/Building Roof</option>
                    <option data-icon="pe-paint" value="12249">Single Area</option>
                     </optgroup> 
                    <optgroup data-icon="pe-keypad" label="Flooring">
                    <option data-icon="pe-keypad" value="10309">Sand & Polish Floors</option>
                    <option data-icon="pe-keypad" value="10309">Stain Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Lime/White Wash Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Carpet Floor</option>
                    <option data-icon="pe-keypad" value="10306">Tile Floor</option>
                    <option data-icon="pe-keypad" value="10309">Vinyl floor</option>
                     </optgroup>
                    <optgroup data-icon="pe-coffee" label="Renovations">
                    <option data-icon="pe-coffee" value="13504">Bathroom Renovation</option>
                    <option data-icon="pe-coffee" value="8197">Kitchen Renovation</option>
                    <option data-icon="pe-coffee" value="13502">Laundry Renovation</option>
                    <option data-icon="pe-coffee" value="13503">Toilet Renovation</option>
                     </optgroup>
                   <optgroup data-icon="pe-home" label="Carpentry">
                    <option data-icon="pe-home" value="178">Decking</option>
                    <option data-icon="pe-home" value="177">Fencing</option>
                    <option data-icon="pe-home" value="10376">Handyman</option>
                    <option data-icon="pe-home" value="13506">Roofing</option>
                     </optgroup>
                  </select>
           </div>
          <div style="margin-left: -2px" class="col-md-4 col-xs-3 padding-0">
             <button type="submit" class="hidden-xs btn btn-lg btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i>Free Quote</b></button>
            <button type="submit" class="visible-xs btn btn-lg btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i>GO</b></button>
              </div>
            </form>
             </div>
         </div>						
       </div>
     </div>

      </div>

  </div>

<?php get_footer(); ?>