<?php
/*
Template Name: success
*/

global $need_starrating;

$need_starrating = array(
	'styles' => true
);
$agent_id = 569;
?>
<?php get_header(); ?>
  
  
   
	 <!-- Hero -->
  <section class="bg-white padding-50">
    <div class="container text-center">
      <div class="content">
        <div class="font-size-40 blue-grey-800">Thank you, We'll be in touch today.</div>
        <p class="blue-grey-600">In the meantime feel free to try our online quotes below, just answer a few simple questions about the project to receive a fully inclusive quote</p>
      </div>
    </div>
  </section>
   
<div id="quote" class="bg-white padding-60">
       <div class="container">
				<div class="row text-center">
           <div class="col-md-8 col-md-offset-2">
                <div clss="row">  
      <div class="font-size-30 font-weight-600 black margin-bottom-10"> 
         What can we help you with?
                  </div>
                                    <div class="margin-top-20 row padding-5">
                    <form action="/add_quote" method="get">
          <div class="col-md-3 col-xs-12">
            <div class="font-size-30 font-weight-600 black inline">
              I want to
            </div>
                      </div>
          <div class="col-md-6 col-xs-9 padding-0">
         <select data-plugin="selectpicker" data-style="btn-lg bg-white" style="border-bottom: 1px solid" class="show-tick form-control" name="templateId" id="templatId">
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
                    <optgroup data-icon="pe-keypad" label="Flooring">
                    <option data-icon="pe-keypad" value="10309">Sand & Polish my Floors</option>
                    <option data-icon="pe-keypad" value="10309">Stain my Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Lime/White Wash my Timber Floors</option>
                    <option data-icon="pe-keypad" value="10309">Lay Carpet on my Floor</option>
                    <option data-icon="pe-keypad" value="10306">Lay Tiles on my Floor</option>
                    <option data-icon="pe-keypad" value="10309">Lay Vinyl on my floor</option>
                     </optgroup>
                    <optgroup data-icon="pe-coffee" label="Renovations">
                    <option data-icon="pe-coffee" value="13504">Renovate my Bathroom</option>
                    <option data-icon="pe-coffee" value="14120">Renovate my Kitchen</option>
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
          <div class="col-md-3 col-xs-3 padding-0">
            <button type="submit" class="margin-left-5 btn btn-lg btn-block btn-primary btn-raised"><b>LETS GO</b></button>
              </div>
            </form>
             </div>
         </div>						
       </div>
     </div>

      </div>

  </div>

     

<div style="max-height:300px; overflow: scroll" class="good-bg"> 
  <div class="container padding-30">
    		<div class="row">
			<div class="col-md-12">
        <div class="font-size-30 white text-center">Verified Reviews</div>
				<div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
				  
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