<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
/*
Template Name: Contact Preview
*/
go_check_registered();
if($_GET['contact_id']) {
	$contact_id = $_GET['contact_id'];
	$quote_show = true;
	get_template_part('contacts-templates/previews/preview','details');
	die;
        
}
else {
	$quote_show = false;	
}
?>
<header class="slidePanel-header bg-blue-400">
  <div class="slidePanel-actions" aria-label="actions" role="group">
    <button type="button" class="btn btn-pure btn-inverse slidePanel-close actions-top icon wb-close"
    aria-hidden="true"></button>
  </div>
  <h1>Can't load information!</h1>
</header>
<div class="slidePanel-inner">
  
  <section class="slidePanel-inner-section">
    
	
	<div class="row">
		<div class="col-md-12 text-center">
			<p>Something went wrong! Try again.</p>
		</div>
	</div>
	
    
  </section>
  
</div>