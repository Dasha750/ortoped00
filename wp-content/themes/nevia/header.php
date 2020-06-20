<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Nevia
 * @since Nevia 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name='yandex-verification' content='636ae94b2574b09c' />


	<title><?php wp_title( '|', true, 'right' ); ?></title>
	

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo ot_get_option('pp_favicon_upload', get_template_directory_uri().'/images/favicon.ico')?>" />
	<link rel="stylesheet" type="text/css" media="all" href='https://ortoped.kharkov.ua/wp-content/themes/style.css' />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

<!-- Fonts
	================================================== -->
	<?php
 	    if(ot_get_option('pp_logofonts_on') =="yes") {
	   	 	$logofont = ot_get_option('pp_logo_typo',array());
	   			if(ot_get_option('pp_fonts_on') == 'yes') { $fontl = '|'.$logofont['font-family']; } else { $fontl = $logofont['font-family']; }
	    } else { $fontl = ""; }
	    if(ot_get_option('pp_fonts_on') == 'yes')  {
	    	$fonts =  ot_get_option('pp_body_font').'|'.ot_get_option('pp_h_font').'';
	    } else { $fonts = ''; }

	if(ot_get_option('pp_fonts_on') == 'yes' || ot_get_option('pp_logofonts_on') =="yes" )  { ?>
		<link href='https://fonts.googleapis.com/css?family=<?php echo $fonts.$fontl;?>' rel='stylesheet' type='text/css'>
	<?php }
	?>
<?php wp_head(); ?>
	<meta name="google-site-verification" content="h8mlUYnhlQAQwRb3ack7FFJImMaeFNLT1_xOLgzCklo" />
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132791613-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-132791613-1');
</script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                          'gtm.start':
                              new Date().getTime(), event: 'gtm.js'
                      });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5R92GSB');</script>
    <!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5R92GSB"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Wrapper / Start -->
<div id="wrapper">

<!-- Header
================================================== -->
<div id="top-line"></div>

<!-- 960 Container -->
<div class="container">

	<?php do_action( 'before' ); ?>
	<!-- Header -->
	<header id="header">
	<?php
		$logo_area_width = ot_get_option('pp_logo_area_width',10);
		$menu_area_width = 16 - $logo_area_width;
	?>
	<!-- Logo -->
		<div class="<?php echo incr_number_to_width($logo_area_width); ?> columns">
			<div id="logo">
				<img id="logoImg" src="https://ortoped.kharkov.ua/wp-content/uploads/main_8.png"/>
				
				<?php  $logo = ot_get_option( 'pp_logo_upload' );
					if($logo) { ?>
						<?php if(is_front_page()){ ?>
							<h1><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>"/></a></h1>
						<?php } else { ?>
							<div class="title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>"/></a></div>
						<?php }
					} else { ?>
						<?php if(is_front_page()){ ?>
							<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php } else { ?>
							<div class="title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
						<?php } ?>
					<?php } ?>
				<?php if(get_theme_mod('nevia_tagline_switch','show') == 'show') { ?><div id="tagline"><?php bloginfo( 'description' ); ?></div><?php } ?>
				<div class="clearfix"></div>
				<p class="main-address">
					<strong>г. Харьков, <br>
						Клиника "Беатрис": ул. Пушкинская 44. 
					</strong>				
				</p>
				
			</div>
		</div>

		<!-- Social / Contact -->
		<?php $socialicons = ot_get_option( 'pp_headericons', array() ); ?>
		<div class="<?php echo incr_number_to_width($menu_area_width); ?> columns <?php if ( empty( $socialicons ) ) { echo "no-icons"; }?>">
			<?php if( ot_get_option('pp_language') == 'enable') { nevia_language_list(); } ?>
			<!-- Social Icons -->
        	<?php /* get the icons array */

				if ( !empty( $socialicons ) ) {
					echo '<ul class="social-icons">';
					foreach( $socialicons as $icon ) {
						echo '<li class="' . $icon['icons_service'] . '"><a title="' . $icon['title'] . '" href="' . $icon['icons_url'] . '">' . $icon['icons_service'] . '</a></li>';
					}
					echo '</ul>';
				}
			?>
			<div class="clearfix"></div>

			<!-- Contact Details -->
			<?php if(ot_get_option('pp_cdetails_phone')) { ?>
				<div class="contact-details"> <?php
				 if (function_exists('icl_register_string')) {
				 	icl_register_string('Contact details in header','cdetails', ot_get_option('pp_cdetails_phone'));
				 	echo icl_t('Contact details in header','cdetails', ot_get_option('pp_cdetails_phone')); }
				 else {
				 	echo  ot_get_option('pp_cdetails_phone');
				 } ?></div>
			<?php } ?>

			<div class="clearfix"></div>
			<?php if(ot_get_option('pp_search') != "disable") { ?>
			<!-- Search -->
			<nav class="top-search">
				<form action=" <?php echo home_url(); ?> " id="searchform" method="get">
					<button class="search-btn"></button>
					<input class="search-field" type="text" onblur="if(this.value=='')this.value='<?php _e('Search','purepress'); ?>';" onfocus="if(this.value=='<?php _e('Search','purepress'); ?>')this.value='';" value="<?php _e('Search','purepress'); ?>" name="s" />
				</form>
			</nav>
			<?php } ?>

		</div>
	</header>
	<!-- Header / End -->

	<div class="clearfix"></div>

</div>
<!-- 960 Container / End -->



<!-- Navigation
================================================== -->
<nav id="navigation" class="<?php echo get_theme_mod('nevia_layout_style','style-1') ?>">

<div class="left-corner"></div>
<div class="right-corner"></div>
<?php wp_nav_menu( array(
	'theme_location' => 'primary',
	'walker' => new my_footer_menu_walker
	)); ?>
<?php
wp_nav_menu(array(
	'theme_location' => 'primary',
	'walker'         => new Walker_Nav_Menu_Dropdown(),
	'items_wrap'     => '<select class="selectnav"><option value="/">'.__('Select Page','purepress').'</option>%3$s</select>',
	'container' => false,
	'menu_class' => 'selectnav',

	)); ?>
</nav>
<div class="clearfix"></div>


<!-- Content
================================================== -->
<div id="content">