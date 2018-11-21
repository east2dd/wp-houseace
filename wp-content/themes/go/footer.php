<?php 
if(is_singular('project') || is_singular('template') || is_page('add_quote') || is_page('edit_scope') || is_page('account') || is_page('add_quote/step2') || is_page('add_quote/step3') ) : ?>
<?php else: ?>
<div class="bg-grey-100">
  <div class="container padding-20">
    		<div class="font-size-20 black">
								We have local, Licensed and Insured Tradespeople in the following areas: 
							</div>
									<div class="row">
                    
							<div class="col-md-3">
              <h4>
								Sydney CBD
								</h4>
              <h4>
								Eastern Suburbs
								</h4>
              <h4>
								Inner West
								</h4>
							</div>
							<div class="col-md-3">
              <h4>
               North Shore
								</h4>
              <h4>
               Canterbury Bankstown
								</h4>
              <h4>
               Hills District
								</h4>
							</div>
							<div class="col-md-3">
              <h4>
								Northern Beches
								</h4>
              <h4>
								Southern Sydney
								</h4>
              <h4>
								Western Sydney
								</h4>
							</div>
							<div class="col-md-3">
                <h4>
               St George
								</h4>
                <h4>
                Forest District
								</h4>
              <h4>
                Macarthur
								</h4>
							</div>
					  </div>
</div>				
</div>
   
          <div class="modal fade bg-grey-100" id="quoteform" aria-hidden="true" aria-labelledby="quoteform"
    role="dialog" tabindex="-1">
      <div class="modal-dialog modal-center">
        <div class="modal-content text-center blue-grey-800 ">
          <div class="modal-header margin-0 bg-grey-200">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
          	<?php echo do_shortcode('[contact-form-7 id="7204" title="Quotes"]'); ?>
          </div>
      </div>
      </div></div>
    <!-- End Modal -->
          
     
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
                           <li><a href="/reviews" class="red-600 font-weight-800">Customer Reviews</a></li> 
                           </ul>      
											</div>
											<div class="col-md-6">
											<div class="font-size-20 font-weight-200 margin-bottom-30 white">ABOUT</div>
                            <ul class="nav">
                           <li><a href="/" class="white">Home</a></li> 
                           <li><a href="/about-us" class="white">About</a></li> 
                           <li><a href="/services" class="white">Services</a></li> 
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
                           <li><a href="/services/commercial" class="white">Commercial Painting</a></li> 
                           <li><a href="/services/timber-flooring" class="white">Floor Sanding</a></li> 
                           <li><a href="/services/home-renovations" class="white">Home renovations</a></li> 
                           <li><a href="/services/bathroom-renovations" class="white">Bathroom renovations</a></li> 
                           <li><a href="/services/kitchen-renovations" class="white">Kitchen renovations</a></li> 
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
				 <div class="col-md-6">
					 <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo margin-top-50" src="<?php bloginfo('template_url'); ?>/assets/images/housewt.png" title="Houseace">
          </a><br/>
           <div class=""><div class="rating rating-lg" data-score="5" data-plugin="rating"><i data-alt="1" class="font-size-30 icon wb-star yellow-600" title="bad"></i>&nbsp;<i data-alt="2" class="font-size-30 icon wb-star yellow-600" title="poor"></i>&nbsp;<i data-alt="3" class="font-size-30 icon wb-star yellow-600" title="regular"></i>&nbsp;<i data-alt="4" class="font-size-30 icon wb-star yellow-600" title="good"></i>&nbsp;<i data-alt="4.9" class="font-size-30 icon wb-star yellow-600" title="gorgeous"></i><input name="score" type="hidden" value="4.9"></div><div class="font-size-15 white">avg. rating 4.9/5</div></div>				
				 </div>
				 
				  <div class="col-md-6">
					 <div class="font-size-30 white">
						ABOUT US
						</div>
						<small class="white">
Houseace makes improving your home hassle free. We’ve streamlined home improvement from quote to cleanup by combining our fully transparent online quotes, unbeatable customer service and rigorously vetted licensed & insured tradespeople. The Houseace experience is the most satisfying home improvement experience available. 						</small>
             
				 </div>
			 </div>
            </div>
    </div>
    
  
  </div>
<footer class="footer bg-blue-grey-800">
    <div class="container white padding-10">
     <div class="inline">
			 <p class="text-left">Copyright © 2018 Houseace. All Rights Reserved.</p> 
			</div> 
    </div>
  </footer>
  <!-- Footer -->
<?php endif; ?>
<!-- Core  -->
<script>
  jQuery('.scroll_to').click(function(e){
   var jump = $(this).attr('href');
   var new_position = $(jump).offset(); 
   $('html, body').stop().animate({ scrollTop: new_position.top }, 500);
    e.preventDefault();
});
  
  (function($){
  'use strict';
    $(window).on('load', function () {
        if ($(".pre-loader").length > 0)
        {
            $(".pre-loader").fadeOut("slow");
        }
    });
})(jQuery)
 </script>
<script src="<?php bloginfo('template_url'); ?>/vendor/jquery/jquery.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap/bootstrap.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/animsition/animsition.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/asscroll/jquery-asScroll.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/asscrollable/jquery.asScrollable.all.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<!-- Plugins -->
<script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/intro-js/intro.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/screenfull/screenfull.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- <script src="<?php bloginfo('template_url'); ?>/vendor/chartist-js/chartist.min.js"></script> -->
<!-- <script src="<?php bloginfo('template_url'); ?>/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script> -->
<script src="<?php bloginfo('template_url'); ?>/vendor/alertify-js/alertify.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/vendor/select2/select2.full.min.js"></script>

<!-- Scripts -->
<script src="<?php bloginfo('template_url'); ?>/js/core.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/site.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/sections/menu.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/sections/menubar.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/sections/sidebar.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/configs/config-colors.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/configs/config-tour.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/asscrollable.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/animsition.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/slidepanel.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/switchery.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/alertify-js.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-touchspin.js"></script>


<script src="<?php bloginfo('template_url'); ?>/js/plugins/responsive-tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/plugins/closeable-tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/tabs.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-datepicker.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/js/components/panel.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-templates/js/quote_03.js"></script>

<?php if(is_page('edit')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/quote-edit-templates/js/quote_edit_image.js"></script>
<?php endif; ?>


<?php // Quote list scripts?>
<script src="<?php bloginfo('template_url'); ?>/vendor/jquery-selective/jquery-selective.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/js/app.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/apps/work.js"></script>


<?php /*
<script>
        $('.selectpicker').selectpicker({
          size: 6
        });
    </script>
*/ ?>

<script src="<?php bloginfo('template_url'); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-bootstrap/dataTables.bootstrap.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/datatables-tabletools/dataTables.tableTools.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/datatables.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/js/components/magnific-popup.min.js"></script>


<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/tables/datatable.min.js"></script>

<?php if(is_page('account')) : ?>
       <script src="<?php bloginfo('template_url'); ?>/account-templates/js/clipboard.min.js"></script>
       <script src="<?php bloginfo('template_url'); ?>/account-templates/js/account.js"></script>
<?php endif; ?>

<?php if(is_singular('project')) : ?>
        <?php $quote_id = get_the_ID(); $current_user_id = current_user_id();?>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/payments.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/scopes.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/chat_11.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/schedule.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/adjustm.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_note.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_tasks.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_proposal2.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/selection_select_13.js"></script>


        <script>
                LoadChat(<?php echo $quote_id; ?>);
        </script>

        <script src="<?php bloginfo('template_url'); ?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>


<?php endif; ?>

<?php if(is_page('all_projects') || is_page('manage_details') || is_page('project_preview')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/projects-templates/js/projects.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_note.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/project-templates/js/save_tasks.js"></script>
<?php endif; ?>

<?php if(is_page('payments')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/invoice-templates/js/invoices.js"></script>
<?php endif; ?>

<?php if(is_page('all_contacts')) : ?>
        <script src="<?php bloginfo('template_url'); ?>/contacts-templates/js/contact15.js"></script>
<?php endif; ?>

<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/bootstrap-table.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/examples/js/tables/bootstrap.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/quotev2.js"></script>
<script src="<?php bloginfo('template_url'); ?>/quote-templates-v2/js/jRedirect.js"></script>
<?php
if( $_GET['templateId'] != '' ) {
    if($_GET['templateId'] != '') { $templateId = $_GET['templateId']; }
    echo "<script>goto2step(" . $templateId . ");</script>";
}
?>

<?php if(is_page('step3') && is_user_logged_in() ) : ?>
    <?php $projectId = $_POST['projectId']; ?>
    <script>
        refreshStep3(<?php echo $projectId; ?>);
    </script>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/vendor/multi-select/jquery.multi-select.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/bootstrap-select.min.js"></script>

<script src="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/components/switchery.min.js"></script>


 <!-- End Modal -->

<?php if(is_singular('project')) : ?>
    <script src="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/dropzone.js"></script>
    <script>
    Dropzone.options.myAwesomeDropzone = {

        acceptedFiles : "image/*,application/pdf",
        init: function () {
          this.on("addedfile", function (file) {
            $('.projectUploadsButton').hide();
          });
          this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
              $('.projectUploadsButton').show();
            }
            else {

            }
          });
        }
    };
    $('.projectUploadsCancel').click(function(){
        $('.projectUploadsButton').hide();
        Dropzone.forElement("#my-awesome-dropzone").removeAllFiles(true);
    });

    Dropzone.options.scheduleDropzone = {
        acceptedFiles : "image/*",
        thumbnailWidth : 100,
        thumbnailHeight : 100,
        init: function () {
          var thisClass = this.element.classList[0];
          this.on("addedfile", function (file) {
             $(thisClass + ' .scheduleUploadsButton').hide();
          });
          this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
              $('.' + thisClass).parent().find('.scheduleUploadsButton').show();
            }
            else {

            }
          });
        }
    };
    $('.projectUploadsCancel').click(function(){
        $('.projectUploadsButton').hide();
        Dropzone.forElement("#my-awesome-dropzone").removeAllFiles(true);
    });
    $('.scheduleUploadsCancel').click(function(){
        $(this).parent().find('.scheduleUploadsButton').hide();
        var row = $(this).attr('data-row');
        Dropzone.forElement(".scheduleDropzone_" + row).removeAllFiles(true);
    });

    </script>



    <script src="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/managev2.js"></script>
    <script>
        $('.selectpicker').selectpicker({
          size: 6
        });
    </script>

    <script src="<?php bloginfo('template_url'); ?>/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/vendor/slick-carousel/slick.min.js"></script>

<?php endif; ?>

<script>
  window.intercomSettings = {
    app_id: "x9oxkmg3"
  };
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/x9oxkmg3';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
<script type="text/javascript">
    adroll_adv_id = "4LVQGEFSZNB33MFSCXA2PH";
    adroll_pix_id = "QNZNGSQFRNGRXFLV6KOKIC";

    (function () {
        var _onload = function(){
            if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
            if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
            var scr = document.createElement("script");
            var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
            scr.setAttribute('async', 'true');
            scr.type = "text/javascript";
            scr.src = host + "/j/roundtrip.js";
            ((document.getElementsByTagName('head') || [null])[0] ||
                document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
        };
        if (window.addEventListener) {window.addEventListener('load', _onload, false);}
        else {window.attachEvent('onload', _onload)}
    }());
</script>
<?php wp_footer(); ?>
</body>
</html>
