<?php $current_user_id = current_user_id(); ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	      <meta name="description" content="HouseAce is the eaiest way to improve your home.">
        <meta name="google-site-verification" content="3RSNQA-Pihx0maVBQqly2xjb1jzOJAuH2T8-fH33C-E" />

        <title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?> <?php if ( is_single() ) { ?> &raquo; <?php } ?> <?php wp_title(); ?></title>
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/assets/images/apple-touch-icon.png">
        <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/assets/images/favicon.ico">
        <!-- Stylesheets -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/animate.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-extend.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/site.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/skins/red.css">

        <!-- Plugins -->
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/animsition/animsition.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/asscrollable/asScrollable.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/intro-js/introjs.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/flag-icon-css/flag-icon.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/alertify-js/alertify.min.css?v2.1.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">
	      <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-touchspin/bootstrap-touchspin.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/multi-select/multi-select.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/dashboard/ecommerce.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/aspieprogress/asPieProgress.css">



        <!-- Fonts -->
	      <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/7-stroke/7-stroke.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/web-icons/web-icons.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/font-awesome/font-awesome.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fonts/brand-icons/brand-icons.min.css">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <?php // Dashboard styles ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/dashboard/ecommerce.css">

        <?php // Quotes list styles ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slidepanel/slidePanel.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/jquery-selective/jquery-selective.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/apps/work.css">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-select/bootstrap-select.min.css?v2.2.0">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/switchery/switchery.min.css?v2.2.0">


        <?php // add Invoice styles
        if(is_singular('invoice')) : ?>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/invoice.css">
<?php endif; ?>

<?php // add Account styles if we are on Account page
if(is_page('account') || is_page_template('page-subscription.php') || is_page_template('agent-profile-template.php')) : ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/profile.css">
<?php // add single-template styles if we are in single-template template
elseif( get_post_type() == 'template') : ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/pages/single-template.css">
<?php endif; ?>

<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/apps/message.min.css?v2.1.0">


<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/bootstrap-table/bootstrap-table.min.css?v2.1.0">


<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/project-templates/main_v2/manage_v2/js/dropzone.css">
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css">

<!--[if lt IE 9]>
<script src="<?php bloginfo('template_url'); ?>/vendor/html5shiv/html5shiv.min.js"></script>
<![endif]-->
<!--[if lt IE 10]>
        <script src="<?php bloginfo('template_url'); ?>/vendor/media-match/media.match.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/vendor/respond/respond.min.js"></script>
        <![endif]-->
        <!-- Scripts -->
        <script src="<?php bloginfo('template_url'); ?>/vendor/modernizr/modernizr.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/vendor/breakpoints/breakpoints.js"></script>
        <script>
        Breakpoints();
        </script>

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/magnific-popup/magnific-popup.min.css?v2.1.0">


        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/stylev2.css">


        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/project-templates/project.css">

        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/owl-carousel/owl.carousel.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/vendor/slick-carousel/slick.min.css?v2.2.0">
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/examples/css/uikit/carousel.min.css?v2.2.0">

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '417628235319148');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=417628235319148&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->



<!-- Global site tag (gtag.js) - Google AdWords: 799426903 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-799426903"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-799426903');
</script>


	<?php wp_head(); ?>
</head>
	
<?php
if(is_page('all_projects') || is_page('all_contacts') || is_page('payments')) { $body_class = 'app-work'; }
elseif(is_singular('project')) { $body_class = 'bg-white'; }
elseif(is_page('add_quote')) { $body_class = 'bg-white'; }
elseif(is_page('quote')) { $body_class = 'review-bg'; }
elseif(is_page('add_quote/step2')) { $body_class = 'painter-bg'; }
elseif(is_page('add_quote/step3')) { $body_class = 'painter-bg'; }
elseif(is_page('edit_scope')) { $body_class = 'painter-bg'; }
elseif(is_page('account') || is_page_template('page-subscription.php') || is_page_template('agent-profile-template.php')) { $body_class = 'page-profile'; }
elseif(is_singular('invoice')) { $body_class = 'page-invoice'; }
elseif(is_page('dash')) { $body_class = 'app-work ecommerce_dashboard bg-white'; }
?>
<body class="<?php echo $body_class; ?>">
	
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90952463-1', 'auto');
  ga('send', 'pageview');

</script>
	
	
<div class="quoteOverlay" <?php if(is_user_logged_in() && is_page('step3')) { echo 'style="display:block"'; } ?>>
  <div class="quoteLoader"><i class="fa fa-spin fa-refresh"></i></div>
</div>

        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                <![endif]-->
                <nav class="site-navbar navbar navbar-white navbar-fixed-top" role="navigation">
                
<div class="navbar-container container-fluid">
					<div class="navbar-brand">
          <a href="<?php bloginfo('url'); ?>">
            <img class="navbar-brand-logo" src="<?php bloginfo('template_url'); ?>/assets/images/paynt.png" title="Paynt">
         </a>
        </div>
    <ul class="nav navbar-toolbar">
         <li class="nav-item">
    <a class="nav-link dropdown-toggle blue-grey-800 font-weight-500" data-toggle="collapse" href="#" data-target="#site-navbar-search" role="button">FREE QUOTE <i class="icon pe-gleam"></i></a>  
          </li>
  </ul>
   
  <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form action="/add_quote" method="get" role="search">
          <div class="form-group">
            <div class="input-search">
              <div class="col-md-9 col-xs-12">
           <i class="input-search-icon wb-search inline" aria-hidden="true"></i>
        <select data-plugin="selectpicker" data-live-search="true"  data-style="btn-lg bg-white margin-top-10" title='Choose Project' class="show-tick form-control" name="templateId" id="templatId">
                    <optgroup label="Interior Painting">
                    <option value="10129">Paint House/Terrace Interior</option>
                    <option value="10129">Paint Apartment/unit Interior</option>
                    <option value="11704">Paint Office Interior</option>
                    <option value="10130">Paint a Single Room</option>
                    <option value="12249">Paint a Single Wall/Ceiling</option>
                    <option value="12250">Paint Doors or Windows</option>
                    </optgroup>
                    <optgroup label="Exterior Painting">
                    <option value="10131">Paint House Exterior</option>
                    <option value="10131">Paint Building Exterior</option>
                    <option value="8522">Paint House/Building Roof</option>
                    <option value="12249">Paint a Single Surface</option>
                     </optgroup> 
                    <optgroup label="TImber floors">
                    <option value="10309">Sand & Polish Floors</option>
                    <option value="10309">Stain Timber Floors</option>
                    <option value="10309">Lime/White Wash Timber Floors</option>
                     </optgroup>
                  </select>
              </div>
           <div class="col-md-3 col-xs-12 margin-top-10">
            <button type="submit" class="btn btn-lg btn-block btn-primary btn-raised"><b><i class="icon pe-gleam"></i>GO</b></button>
          </div>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
  
              <!-- Navbar Toolbar Right -->
                <ul class="nav navbar-toolbar navbar-right margin-right-0 navbar-toolbar-right">
            <li class="hidden-xs"><a class="blue-grey-800 font-weight-500" href="<?php bloginfo('url'); ?>/#how-it-works">HOW IT WORKS</a></li>
            <li><a class="red-700 font-weight-500" href="tel: 0284171038"><i class="icon pe-phone"></i> 02 8417 1038</a></li>
     <?php if(!is_user_logged_in()) : ?> 
	<li>
			 <form action="<?php bloginfo('url'); ?>/sign-in">
			<button class="btn btn-default bg-white btn-raised navbar-btn btn-sm" href="">My Account</button>
		</form>
	</li>
        <?php endif ; ?>		
      
									  <?php // show notifications for logged users
                        if(is_user_logged_in()) :
                                $notifications = get_field('notifications','user_' . $current_user_id);
                                if(is_array($notifications)) { $notifications_count = count($notifications); }
                                else { $notifications_count = 0; }
                                $notifications = array_reverse($notifications);
                                ?>
									
                       <li class="dropdown hidden-xs">
                                        <a data-toggle="dropdown" href="javascript:void(0)" title="Notifications" aria-expanded="false" data-animation="scale-up" role="button">
                                                <i class="icon wb-bell" aria-hidden="true"></i>
                                                <?php if($notifications_count > 0) : ?>
                                                        <span class="badge badge-default up"><?php echo $notifications_count; ?></span>
                                                <?php endif; ?>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                                                <li class="dropdown-menu-header" role="presentation">
                                                        <h5>NOTIFICATIONS</h5>
                                                        <?php if($notifications_count > 0) : ?>
                                                                <span class="label label-round label-danger">New <?php echo $notifications_count; ?></span>
                                                        <?php else : ?>
                                                                <p class="margin-top-20">There are no new notifications.</p>
                                                        <?php endif; ?>
                                                </li>
                                                <li class="list-group" role="presentation">
                                                        <div data-role="container">
                                                                <div data-role="content">
                                                                        <?php foreach($notifications as $n) : ?>
                                                                                <?php if($n['type'] == 'approved') {
                                                                                        $color = 'bg-green-600';
                                                                                        $icon = 'wb-check-mini';
                                                                                }
                                                                                elseif($n['type'] == 'cancelled') {
                                                                                        $color = 'bg-red-600';
                                                                                        $icon = 'wb-close-mini';
                                                                                }
                                                                                elseif($n['type'] == 'done') {
                                                                                        $color = 'bg-blue-600';
                                                                                        $icon = 'wb-pie-chart';
                                                                                }
                                                                                elseif($n['type'] == 'paid') {
                                                                                        $color = 'bg-yellow-700';
                                                                                        $icon = 'wb-order';
                                                                                }
                                                                                elseif($n['type'] == 'waiting') {
                                                                                        $color = 'bg-grey-600';
                                                                                        $icon = 'wb-time';
                                                                                }
                                                                                elseif($n['type'] == 'invoice') {
                                                                                        $color = 'bg-orange-600';
                                                                                        $icon = 'wb-file';
                                                                                }
                                                                                ?>
                                                                                <a class="list-group-item" href="<?php bloginfo('url'); ?>/?p=<?php echo $n['project_id']; ?>" role="menuitem">
                                                                                        <div class="media">
                                                                                                <div class="media-left padding-right-10">
                                                                                                        <i class="icon <?php echo $icon; ?> <?php echo $color; ?> white icon-circle" aria-hidden="true"></i>
                                                                                                </div>
                                                                                                <div class="media-body">
                                                                                                        <h6 class="media-heading"><?php echo $n['text']; ?></h6>
                                                                                                        <time class="media-meta" datetime=""><?php echo $n['date']; ?></time>
                                                                                                </div>
                                                                                        </div>
                                                                                </a>
                                                                        <?php endforeach; ?>
                                                                </div>
                                                        </div>
                                                </li>
                                        </ul>
                                </li>
                        <?php endif; ?>

                        <?php // show notifications for logged users
                        if(is_user_logged_in()) :
                                $messages = get_field('messages','user_' . $current_user_id);
                                if(is_array($messages)) { $messages_count = count($messages); }
                                else { $messages_count = 0; }
                                $messages = array_reverse($messages);
                                ?>
                                <li class="dropdown hidden-xs">
                                        <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false"
                                        data-animation="scale-up" role="button">
                                        <i class="icon wb-envelope" aria-hidden="true"></i>
                                        <?php if($messages_count > 0) : ?>
                                                <span class="badge badge-info up"><?php echo $messages_count; ?></span>
                                        <?php endif; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                                        <li class="dropdown-menu-header" role="presentation">
                                                <h5>MESSAGES</h5>
                                                <?php if($messages_count > 0) : ?>
                                                        <span class="label label-round label-info">New <?php echo $messages_count; ?></span>
                                                <?php else : ?>
                                                        <p class="margin-top-20">There are no new notifications.</p>
                                                <?php endif; ?>
                                        </li>
                                        <li class="list-group" role="presentation">
                                                <div data-role="container">
                                                        <div data-role="content">

                                                                <?php foreach($messages as $m ) : $from = $m['user_id']; $from_data = go_userdata($from); ?>

                                                                        <a class="list-group-item" href="<?php bloginfo('url'); ?>/?p=<?php echo $m['project_id']; ?>" role="menuitem">
                                                                                <div class="media">
                                                                                        <div class="media-left padding-right-10">
                                                                                                <span class="avatar avatar-sm ">
                                                                                                        <img src="<?php echo $from_data->avatar; ?>" alt="..." />
                                                                                                        <i></i>
                                                                                                </span>
                                                                                        </div>
                                                                                        <div class="media-body">
                                                                                                <h6 class="media-heading"><?php echo $from_data->first_name; ?> <?php echo $from_data->last_name; ?></h6>
                                                                                                <div class="media-meta">
                                                                                                        <time><?php echo $m['date']; ?></time>
                                                                                                </div>
                                                                                                <div class="media-detail"><?php echo $m['text']; ?></div>
                                                                                        </div>
                                                                                </div>
                                                                        </a>

                                                                <?php endforeach; ?>


                                                        </div>
                                                </div>
                                        </li>
                                </ul>
                        </li>
                <?php endif; ?>

                <li class="dropdown">
                        <?php if(is_user_logged_in()) : $current_user_id = current_user_id(); ?>
                                <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
                                        <span class="avatar avatar-online">
                                                <?php if(get_field('ava','user_' . $current_user_id)) : ?>
                                                        <?php $ava_id = get_field('ava','user_' . $current_user_id ); $size = "ava"; $ava = wp_get_attachment_image_src( $ava_id, $size ); ?>
                                                        <img src="<?php echo $ava[0]; ?>" alt="...">
                                                        <i></i>
                                                <?php else : ?>
                                                        <img src="<?php bloginfo('template_url'); ?>/assets/defaults/default-ava.png" alt="...">
                                                        <i></i>
                                                <?php endif; ?>
                                        </span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/account" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Account</a>
                                        </li>
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
																									<a href="<?php bloginfo('url'); ?>/dash" role="menuitem"><i class="icon wb-briefcase" aria-hidden="true"></i> Dashboard</a>
                                        </li><?php endif ;?>
                                        <li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_projects" role="menuitem"><i class="icon wb-align-justify" aria-hidden="true"></i> My Jobs</a>
                                        </li>
																	   <?php if(is_headcontractor() || is_agent()) : ?><li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/all_contacts" role="menuitem"><i class="icon wb-users" aria-hidden="true"></i> Contacts</a>
                                        </li><?php endif ;?>
																	<li role="presentation">
                                                <a href="<?php bloginfo('url'); ?>/payments" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Payments</a>
                                        </li>
                                        <li class="divider" role="presentation"></li>
                                        <li role="presentation">
                                                <a href="<?php echo wp_logout_url( home_url() ); ?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
                                        </li>
                                </ul>
                       
                </li>
   <?php endif; ?>   
        </ul>
					
					  
       
<!-- End Navbar Collapse -->
	
</div>
</nav>
	
	

