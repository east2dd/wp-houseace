<?php
/*
Template Name: rapid quote
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
    padding-bottom: 100px;
    padding-top: 100px;
    min-height: 100%;
  }
  body {
    padding-top: 0px;
  }
  .yellow-600 {
         color: #ffe545;
  }
  .bg-yellow-new {
         background: #ffe545; 
  }
  .quote {
        color: rgba(0,0,0,.1);
        text-align: center;
        margin-bottom: 30px;
    }
  

 

</style>
<!-- Page -->
  <section id="main" class="section house-bg">
       <div class="container">
				<div class="row padding-top-40 text-center">
           <div class="col-md-12">
       <div clss="row">  
         
      <div class="font-size-80 white font-weight-800"> 
      Let's Paint
      </div>
      <div class="font-size-30 white">
      Get started by choosing your project type  
      </div>						
      </div>
     <div class="col-md-6 margin-top-30 col-md-offset-3">
       
    <?php
    $by_project_cnt = 0;
    $ids = get_field('type');
    $array = array_map( 'trim', explode( ',', $ids ) ); 
    $by_project_args = array('post_type'=>'template', 'posts_per_page'=>-1,'post__in' => $array,);
    $by_project_templates = get_posts($by_project_args);
    foreach($by_project_templates as $template) :
    ?>

       <div class="col-md-6 col-xs-6 white">

       <?php /* <figure class="quote_option overlay text-center" data-name="<?php echo $template->post_title; ?>" data-project="<?php echo $projectId; ?>" data-template="<?php echo $template->ID; ?>" data-target="#startProject" data-toggle="modal"> */ ?>
       <figure
            style="opacity: 1" class="quote_option text-center startProject"
            data-name="<?php echo $template->post_title; ?>"
            data-project="<?php echo $projectId; ?>"
            data-template="<?php echo $template->ID; ?>"
            <?php if($agentToken) : ?>data-token="<?php echo $agentToken; ?>"<?php else : ?>data-token="0"<?php endif; ?>>
                    <img src="<?php the_field('template_image',$template->ID); ?>">
                    <figcaption class="margin-top-10">
                      <div class="font-size-30 font-weight-300 margin-bottom-10 white"><?php echo $template->post_title; ?></div>
                    </figcaption>
                  </figure>
       </div>
   
  <?php
    $by_project_cnt++;
    endforeach;
    if($by_project_cnt == 0) {
        echo "<p>Sorry, there are no templates here yet.</p>";
    }
    ?>
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

         
<section id="main" class="section bg-white">
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

<div class="hidden bg-red-600">
   <div class="container">
     <div class="row white">
       <div class="font-size-30 margin-top-20 text-center white">
        How House<b>ace</b> Works
       </div><hr>
       <div class="margin-20"></div>
        <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-flash red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      1<br/>  Get a fully inclusive quote online or face to face at home
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon wb-chat-working red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      2<br/>  Review the details with dedicated personal assitanace
                    </div><br/>
                  </div>
						 </div>
						  <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon fa-credit-card red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      3<br/> Start with as little as 48hrs notice & even book online
                    </div><br/>
                  </div>
						 </div>
               <div class="col-md-3">
							 <div class="padding-35 text-center">
                  <i class="icon pe-star red-200 margin-bottom-10" aria-hidden="true" style="font-size: 64px;"></i><br/>
								 <div class="font-size-20">
                      4<br/> Job done on time & in budget with a 100% happiness guarantee
                    </div><br/>
                  </div>
						 </div>
     </div>
   </div>
</div>
<div class="bg-white">
   <div class="container">
     <div class="row black">
       <div class="font-size-30 margin-top-30 text-center black">
        Why choose House<b>ace</b> 
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
                      <b>The fastest Quotes</b><br/>We dont like wasting your time so when we say we'll give you a quote its done on the same day and usually hour.
                    </div><br/>
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
<section id="quote" class="bg-white padding-50">
       <div class="container">
				<div class="row text-center">
           <div class="col-md-10 col-md-offset-1">
                <div clss="row">  
      <div class="font-size-40 font-weight-600 black margin-bottom-10"> 
        Ready to get started?
                  </div>
                 <div class="margin-top-20 row padding-5">
                    <form action="/add_quote" method="get">
          <div class="col-md-3 col-xs-12">
            <div class="font-size-30 font-weight-600 black inline">
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

<?php get_footer(); ?>