<?php
/*
Template Name: Testing Page
*/
global $need_fullcalendar, $schedule;
$need_fullcalendar = true;

$user_id = $_GET['user_id'];
$schedule = json_encode(getSchedule($user_id));

global $need_starrating;

$need_starrating = array(
	'styles' => true
);

//$template_id = $_GET['template_id'];
$user_address = $_GET['user_address'];
	
//$args = array('post_type' => 'template', 'posts_per_page' => -1, 'post_parent' => 0 );
//$main_templates = get_posts($args);
$contractors = [];
if(!empty($user_address)){
	$city = getCityByAddress($user_address);
	$sorted_contractors = sortContractorsByRating(getContractorsByCity($city));
	foreach($sorted_contractors as $contractor){
		if(isContractorAvailable($contractor['schedule'], '2017-09-01')) $contractors[] = $contractor;
	}
	$count = count($contractors) < 6 ? count($contractors) : 6;
}
?>
<?php get_header(); ?>
<div class="page animsition">	
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="section-title"><?php the_title(); ?></h1>
			</div>
			<div class="row">
				<div id="calendar">
				</div>
			</div>
			<div class="row contractors">
				<?php for($i = 0; $i < $count; $i++): ?>
					<?php $contractor = $contractors[$i]; ?>
					<div class="col-md-4 contractor">
						<div class="widget text-center padding-top-20 padding-bottom-20">
							<div class="widget-header">
								<div class="widget-header-content">
									<a href="<?php echo $contractor['profile_link']; ?>" >
										<div class="avatar avatar-lg">
											<img src="<?php echo $contractor['avatar']; ?>">
										</div>
									</a>
									<h4 class="profile-user"><?php echo $contractor['full_name']; ?></h4>
									<div class="profile-job">
										<p> <?php echo $contractor['business_name']; ?> </p>
									</div>
									<a href="<?php echo $contractor['profile_link']; ?>" >
										More info
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endfor; ?>
			</div>
			<div>
				<ul class="pager">
				  <li><a href="#" class="previous">Previous</a></li>
				  <li><a href="#" class="next">Next</a></li>
				</ul>
			</div>
		</div>
		
		
	</div>    
</div>
<script>
jQuery(document).on('ready', () => {
	var listElement = $('.contractors');
	var perPage = 3; 
	var numItems = listElement.children().size();
	var numPages = Math.ceil(numItems/perPage);

	$('.pager').data("curr",0);

	/*var curr = 0;
	while(numPages > curr){
	  $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo('.pager');
	  curr++;
	}*/

	//$('.pager .page_link:first').addClass('active');

	listElement.children().css('display', 'none');
	listElement.children().slice(0, perPage).css('display', 'block');

	/*$('.pager li a').click(function(){
	  var clickedPage = $(this).html().valueOf() - 1;
	  goTo(clickedPage,perPage);
	});*/
	$('.pager li a.next').click(function(e){
		next();
		e.preventDefault();
	});
	$('.pager li a.previous').click(function(e){
		previous();
		e.preventDefault();
	});

	function previous(){
	  var goToPage = parseInt($('.pager').data("curr"));// - 1;
	  //if($('.active').prev('.page_link').length==true){
		goTo(goToPage);
	  //}
	}

	function next(){
	  goToPage = parseInt($('.pager').data("curr")) + 1;
	  //if($('.active_page').next('.page_link').length==true){
		goTo(goToPage);
	  //}
	}

	function goTo(page){
	  var startAt = page * perPage,
		endOn = startAt + perPage;
	  
	  listElement.children().css('display','none').slice(startAt, endOn).css('display','block');
	  $('.pager').attr("curr",page);
	  //$('.pager li a').show();
	  //if(page*perPage > numItems) $('.pager li a.next').hide();
	  //if(page == 0 ) $('.pager li a.previous').hide();
	}
});
</script>
 <?php get_footer(); ?>