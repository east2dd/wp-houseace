<?php
/*
Template Name: landing quote
*/
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
    height: 100%;
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

     <section id="main" class="section bench-bg">
       <div class="container">
				<div class="row margin-bottom-100">
           <div class="col-md-6 col-md-offset-3 col-xs-12">
                <div class="black margin-top-100 margin-xs-0">
      <div class="font-size-40 font-weight-800 margin-bottom-10"> 
           Hassle Free House Painting
 </div>
            <div class="font-size-20 font-weight-400">
We've taken the pain out of house painting with online quotes & unbeatable customer service.<br/> Get an Online quote in 2 mins or <a data-toggle="modal" data-target="#contact" class="inline btn-link">send us a message</a>. 
                  </div><br/></div>
           <div class="panel padding-5 row btn-raised">  
        <form action="/add_quote" method="get">
          
     <div class="col-md-8 col-xs-8 padding-0">
        <select data-plugin="selectpicker" data-live-search="true"  data-style="btn-lg bg-white" title='What are you painting?' class="show-tick form-control" name="templateId" id="templatId">
                    <optgroup label="Interior Painting">
                    <option value="10129">House/Terrace Interior</option>
                    <option value="10129">Apartment/unit Interior</option>
                    <option value="11704">Office Interior</option>
                    <option value="10130">Single Room</option>
                    <option value="12249">Single Wall/Ceiling</option>
                    <option value="12250">Doors or Windows</option>
                    </optgroup>
                    <optgroup label="Exterior Painting">
                    <option value="10131">House/Terrace Exterior</option>
                    <option value="10131">Apartment/Unit Exterior</option>
                    <option value="8522">House/Building Roof</option>
                    <option value="12249">Single Area</option>
                     </optgroup> 
                    <optgroup label="TImber floors">
                    <option value="10309">Sand & Polish Floors</option>
                    <option value="10309">Stain Timber Floors</option>
                    <option value="10309">Lime/White Wash Timber Floors</option>
                     </optgroup>
                  </select>
           </div>
          <div style="margin-left: -2px" class="col-md-4 col-xs-3 padding-0">
            <button type="submit" class="hidden-xs btn btn-lg btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i>Free Quote</b></button>
            <button type="submit" class="visible-xs btn btn-lg btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i>GO</b></button>
          </div>
            </form>
          </div>              
             <div class="inline"><div class="rating rating-lg" data-score="5" data-plugin="rating"><i data-alt="1" class="font-size-30 icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="font-size-30 icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="font-size-30 icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="font-size-30 icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="4.9" class="font-size-30 icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="4.9"></div><div class="font-size-15 black">avg. rating 4.9/5</div></div>				
          </div>   
               <br/>      
         </div>						
       </div>
     </div>

      </div>
    </div>
    

   

  </section>

<div class="modal fade bg-red-700" id="contact" aria-hidden="true" aria-labelledby="contact"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content text-center blue-grey-800 ">
          <div class="modal-header margin-0 bg-grey-200">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
             <div class="font-size-20 blue-grey-800 font-weight-400">
                  We'll contact you in 30 mins			</div>
        <?php echo do_shortcode('[contact-form-7 id="10041" title="Front-contact"]'); ?>
          </div>
      </div>
      </div></div>

<div class="bg-grey-200 text-center padding-20">
  <div class="container">
   <i style="margin-top: -70px" class="red-700 font-size-70 icon fa-heart" aria-hidden="true"></i>
  <div class="font-size-30 blue-grey-800">
    Happiness. Guaranteed.
  </div>
  <div class="font-size-20 blue-grey-600">
    Your happiness is our goal. If you're not happy, we wont leave until you are.
  </div>
</div>
</div>
		
 <div id="how-it-works">
			<div class="container">
				 <div class="row">

					 <div class="col-md-12 margin-top-30 black">
        <div class="font-size-30 text-center margin-10 blue-grey-800">
				 How it Works
						 </div>           						        <hr>

						 <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-flash red-700 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      1.  Get your project price online or by phone
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon wb-chat-working red-700 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      2.  Review details with your project manager
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-credit-card red-700 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      3. Choose your colours, schedule & book online
                    </div><br/>
                  </div>
						 </div>
               <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon pe-star red-700 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      4. Get your project done on time and in budget
                    </div><br/>
                  </div>
						 </div>
					 </div>
				 </div>
    </div></div>

	<div class="good-bg"> 
  <div class="container height-500 padding-top-30">
    		<div class="row">
			<div class="col-md-12">
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  
          <div class="col-md-6 col-md-offset-3">
            
            <div class="carousel-inner">
              <div class="item active">
              <div class="widget margin-bottom-5 widget-shadow text-center">
            <div class="widget-header bg-grey-100 padding-10">
              <div class="widget-header-content">
                <h4 class="blue-grey-800">Etienne R</h4>
                <p class="blue-grey-600">Newport, Sydney</p>
                  </div> </div>
                <div class="panel-body black">
                       <p>From the beginning, the team at Paynt have demonstrated excellent client service and made the whole transaction an extremely pleasurable experience. At a time when my and I family were very stressed handling busy work lives and an upcoming overseas move the Paynt team have taken enormous pressure of us in getting our house ready to be rented out and that in the space of one week only. David (who managed the job on-site) and his team of painting professionals have done a fantastic job. I'm superbly happy with the diligence and the quality of their work. They have been great and uncomplicated to deal with, were very courteous and cleaned up after they were done with their work. A big Thank You to everyone who we have worked with at Paynt. I can only give you the highest recommendation. I wish I had known you earlier. </p>
                </div> 
            </div>
              <div class="text-center">
               <div class="rating rating-lg" data-score="5" data-plugin="rating" style="cursor: pointer;"><i data-alt="1" class="icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="5" class="icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="5"></div>
                </div>
    			  </div>
					    <div class="item">
              <div class="widget margin-bottom-5 widget-shadow text-center">
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
              <div class="widget margin-bottom-5 widget-shadow text-center">
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
              <div class="widget margin-bottom-5 widget-shadow text-center">
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
              <div class="widget margin-bottom-5 widget-shadow text-center">
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


  <div class="footer bg-blue-grey-800">
    <div class="footer-detail">
     <div class="container">
                <div class="row white padding-30">
                    <div class="col-md-6">
											<div class="col-md-6">
											<div class="font-size-20 font-weight-200 margin-bottom-30 white">HELP</div>
                     <ul class="nav">
                           <li><a href="/faq" class="white">FAQ</a></li> 
                           <li><a href="/terms" class="white">Terms & Conditions</a></li> 
                           <li><a href="/privacy" class="white">Privacy</a></li> 
                           <li><a href="/partners" class="white">Affiliate Partners</a></li> 
                           <li><a href="#contact" class="white">Contact</a></li> 
                           </ul>      
											</div>
											<div class="col-md-6">
											<div class="font-size-20 font-weight-200 margin-bottom-30 white">ABOUT</div>
                            <ul class="nav">
                           <li><a href="#why" class="white">About</a></li> 
                           <li><a href="#services" class="white">Services</a></li> 
                           <li><a href="/sign-in" class="white">Login</a></li> 
                           <li><a href="/sign-up" class="white">Contractor Signup</a></li> 
                           </ul>      
                    </div>
									</div>
                    <div id="contact" class="col-md-6 white">
                      <div class="col-md-6">
                      <div class="font-size-20 font-weight-200 margin-bottom-30 white">Services</div>
                        <ul class="nav">
                           <li><a href="/services/interior-painting" class="white">Interior Painting</a></li> 
                           <li><a href="/services/exterior-painting" class="white">Exterior Painting</a></li> 
                           <li><a href="/commerical" class="white">Commerical Painting</a></li> 
                           <li><a href="/services/floorsanding" class="white">Floor Sanding</a></li> 
                           <li><a href="/services/interior-painting" class="white">Apartment Painting</a></li> 
                           <li><a href="/services/interior-painting" class="white">Office Painting</a></li> 
                           <li><a href="/services" class="white">All Services</a></li> 
                                                      </ul>     
                      </div>
                  <div class="col-md-6">
                      <div class="font-size-20 font-weight-200 margin-bottom-30 white">Contact</div>
												<?php echo do_shortcode('[contact-form-7 id="10041" title="Front-contact"]'); ?>
                      </div>  
										</div>
                </div>
			 <hr/>
			 <div class="row">
				 <div class="col-md-3">
					 <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo margin-top-50" src="<?php bloginfo('template_url'); ?>/assets/images/payntwt.png" title="Paynt">
          </a>
				 </div>
				 <div class="col-md-3">
             <div class=""><div class="rating rating-lg" data-score="5" data-plugin="rating"><i data-alt="1" class="font-size-30 icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="font-size-30 icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="font-size-30 icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="font-size-30 icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="4.9" class="font-size-30 icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="4.9"></div><div class="font-size-15 white">avg. rating 4.9/5</div></div>				
                                
				 </div>
				  <div class="col-md-6">
            <div class="font-size-20 white"> We Accept: 
     <i class="icon fa-cc-mastercard" aria-hidden="true"></i> <i class="icon fa-cc-visa" aria-hidden="true"></i> <i class="icon fa-cc-amex" aria-hidden="true"></i> <i class="icon fa-cc-jcb" aria-hidden="true"></i> <i class="icon fa-cc-diners-club" aria-hidden="true"></i> 
      </div>		
					 <div class="font-size-30 white">
						ABOUT US
						</div>
						<small class="white">
				      Houseace is the easiest way to improve your home. Just answer our simple questions, and in under 2 minutes, you’ll have an accurate quote. If you like the price our project aces can start with just 48 hours notice. We assign you a dedicated project manager to help you work through all of the details. Home Improvement has never been so hassle free. 
						</small>
				 </div>
			 </div>
            </div>
    </div>
    
  
  </div>
<footer class="footer bg-blue-grey-800">
    <div class="container white padding-10">
     <div class="inline">
			 <p class="text-left">Copyright © 2018 Paynt. All Rights Reserved.</p> 
			</div> 
    </div>
  </footer>
  <!-- Footer -->
<?php get_footer(); ?>