<?php
/**
 * Nevia Theme Customizer
 *
 * @package Nevia
 * @since Nevia 1.2
 */


add_action ('admin_menu', 'themedemo_admin');
function themedemo_admin() {
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}



/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}


add_action( 'customize_register', 'nevia_customize_register' );


function nevia_customize_register($wp_customize) {


    // color section
  $wp_customize->add_section( 'centum_color_settings', array(
    'title'          => __('Main color','purethemes'),
    'priority'       => 35,
    ) );

  $wp_customize->add_setting( 'nevia_main_color', array(
    'default'        => '#169fe6',
    'transport' =>'postMessage'
    ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nevia_main_color', array(
    'label'   => __('Color Setting','purethemes'),
    'section' => 'colors',
    'settings'   => 'nevia_main_color',
    )));



    // eof color section

    // bof layout section
  $wp_customize->add_section( 'nevia_layout_settings', array(
      'title'          => __('Menu type','purethemes'),
      'priority'       => 36,
    ));

  $wp_customize->add_setting( 'nevia_layout_style', array(
    'default'  => 'style-1',
    'transport' => 'postMessage'
    ));
  $wp_customize->add_control( 'nevia_layout_choose', array(
    'label'    => __('Select menut type','purethemes'),
    'section'  => 'nevia_layout_settings',
    'settings' => 'nevia_layout_style',
    'type'     => 'select',
    'choices'    => array(
        'style-1' => 'Style 1',
        'style-2' => 'Style 2',
        )
    ));


   // eof layout section

  $wp_customize->add_setting( 'nevia_tagline_switch', array(
    'default'  => 'show',
    'transport' => 'refresh'
    ));
  $wp_customize->add_control( 'nevia_tagline_switcher', array(
   'settings' => 'nevia_tagline_switch',
   'label'    => __( 'Display Tagline','purepress' ),
   'section'  => 'title_tagline',
   'type'     => 'select',
   'choices'    => array(
    'show' => 'Show',
    'hide' => 'Hide',
    )
   ));


  if ( $wp_customize->is_preview() && !is_admin() )
    add_action( 'wp_footer', 'centum_customize_preview', 21);
}


function centum_customize_preview() {
    ?>
    <script type="text/javascript">
    ( function( $ ){
        function hex2rgb(hex) {
            if (hex[0]=="#") hex=hex.substr(1);
            if (hex.length==3) {
                var temp=hex; hex='';
                temp = /^([a-f0-9])([a-f0-9])([a-f0-9])$/i.exec(temp).slice(1);
                for (var i=0;i<3;i++) hex+=temp[i]+temp[i];
            }
        var triplets = /^([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})$/i.exec(hex).slice(1);
        return {
            red: parseInt(triplets[0],16),
            green: parseInt(triplets[1],16),
            blue: parseInt(triplets[2],16)
        }
    }


    wp.customize('nevia_main_color',function( value ) {
        value.bind(function(to) {

         $('.wp-pagenavi .current,.pagination .current, .caption-color,#top-line,.highlight.color,.skill-bar-content,.button.color,span.onsale,.price_slider_wrapper .ui-widget-header,.increase-value, input[type="button"],input[type="submit"]').css('background', to);
         $('.filters-dropdown.active,.search-btn-widget,.trigger.active .toggle-icon,.pricing-table .color-3 h4,.color-3 .sign-up .button,.ui-accordion-icon-active').css('background-color',to);
         $(' .widget_layered_nav ul li.chosen a, ul.menu > li.current-menu-parent > a, ul.menu > li.current-menu-item > a, #current ').css('background-color',to).css('border-color',to);
         $('.selected,.dropcap, #breadcrumbs ul li:last-child a, #breadcrumbs ul li a, .trigger.active a,.testimonials-author, .widget #twitter b a, .tabs-nav li.active a, .sidebar .widget #twitter li a').css('color',to);

         $('.price_slider_wrapper .button, .tags a, .tagcloud a, .button.gray,.button.light,.ls-fullwidth .ls-nav-next,.ls-fullwidth .ls-nav-prev,.flexslider .flex-next,.flexslider .flex-prev,.arl.active,.arr.active,#portfolio-navi a,.ls-nevia .ls-nav-prev,.ls-nevia .ls-nav-next').hover(
          function(){
            var attr = $(this).attr('orgbackground');
            if (typeof attr == 'undefined' || attr == false) {
              var orgbg = $(this).css('background-color');
            }
            $(this).attr('orgbackground', orgbg).css('background-color', to);
          }, function(){
            var bg = $(this).attr('orgbackground');
            $(this).css('background-color', bg);
          } );

          $('.portfolio-item').hover(
          function(){
            var attr = $(this).find('figure .item-description').attr('orgbordertopcolor');
            if (typeof attr == 'undefined' || attr == false) {
              var orgbg = $(this).find('figure .item-description').css('borderTopColor');
            }
            $(this).find('figure .item-description').attr('orgbordertopcolor', orgbg).css('borderTopColor', to);
          }, function(){
            var bg = $(this).find('figure .item-description').attr('orgbordertopcolor');
            $(this).find('figure .item-description').css('borderTopColor', bg);
          } );



     });
});


wp.customize('nevia_layout_style',function( value ) {
    value.bind(function(to) {
            $('nav#navigation').removeClass('style-1').removeClass('style-2').addClass(to);
        });
});


//.image-overlay-link, .image-overlay-zoom
} )( jQuery )
</script>
<?php
}

add_action('wp_head', 'custom_stylesheet_content');

function custom_stylesheet_content() {
 $ltopmar = ot_get_option( 'pp_logo_top_margin' );
 $lbotmar = ot_get_option( 'pp_logo_bottom_margin' );
 $taglinemar = ot_get_option( 'pp_tagline_margin' );
 $logofont = ot_get_option('pp_logo_typo',array());

 global $post;
 global $google_array;

 ?>
 <style type="text/css">
 <?php if(ot_get_option('pp_fonts_on') == 'yes')  {  ?>
    body { font-family: '<?php echo str_replace("+", " ", ot_get_option( 'pp_body_font')); ?>', Helvetica, Arial, sans-serif; } #content h1, h2, h3, h4, h5, h6 { font-family: '<?php echo str_replace("+", " ", ot_get_option( 'pp_h_font')); ?>'; }
  <?php $bodysize = ot_get_option('pp_body_size');
    if ($bodysize) {  ?>
body { font-size: <?php echo $bodysize[0].$bodysize[1]; ?> }
  <?php }
  } ?>
  #logo {<?php if ( isset( $ltopmar[0] ) && $ltopmar[1] ) { echo 'margin-top:'.$ltopmar[0].$ltopmar[1].';'; } ?> <?php if ( isset( $lbotmar[0] ) && $lbotmar[1] ) { echo 'margin-bottom:'.$lbotmar[0].$lbotmar[1].';'; } ?> } #tagline { <?php if ( isset( $taglinemar[0] ) && $taglinemar[1] ) { echo 'margin-top:'.$taglinemar[0].$taglinemar[1].';'; } ?> }
  <?php  if(ot_get_option('pp_logofonts_on') =="yes") { ?>
    #logo h2 a, #logo h1 a { font-family: <?php echo str_replace("+", " ",  $logofont['font-family']); ?>; }
    #logo h2 a, #logo h1 a { color: <?php echo $logofont['font-color']; ?>; font-family: <?php  echo str_replace("+", " ",  $logofont['font-family']); ?>; font-style: <?php echo $logofont['font-style']; ?>; font-variant: <?php echo $logofont['font-variant']; ?>; font-weight: <?php echo $logofont['font-weight']; ?>; font-size: <?php echo $logofont['font-size']; ?>; }
    <?php }
$custom_main_color = get_theme_mod('nevia_main_color','#169fe6'); ?>
.caption-color, #top-line, .highlight.color, .skill-bar-content, .button.color, span.onsale, .price_slider_wrapper .ui-widget-header, .increase-value, input[type="button"], input[type="submit"], input[type="button"]:focus, input[type="submit"]:focus, .price_slider_wrapper .button:hover, .tags a:hover, .tagcloud a:hover, .button.gray:hover, .button.light:hover { background:<?php echo $custom_main_color;?>; }
.wp-pagenavi .current, .pagination .current { background: <?php echo $custom_main_color;?> !important; }

.filters-dropdown.active, #searchsubmit, .search-btn-widget, .trigger.active .toggle-icon, .pricing-table .color-3 h4, .color-3 .sign-up .button, .ui-accordion-icon-active, .ls-fullwidth .ls-nav-next:hover, .ls-fullwidth .ls-nav-prev:hover, .flexslider .flex-next:hover, .flexslider .flex-prev:hover, .arl.active:hover, .arr.active:hover, .ls-nevia .ls-nav-next:hover, .ls-nevia .ls-nav-prev:hover, #portfolio-navi a:hover { background-color: <?php echo $custom_main_color;?>; }
ul.menu > li.current-menu-parent > a, ul.menu > li.current-menu-item > a, #current { background-color: <?php echo $custom_main_color;?>; border-right: 1px solid <?php echo $custom_main_color;?>; }
.recent-products-jc .shop-item:hover > figure > .item-description,
.portfolio-item:hover > figure > .item-description { border-top: 5px solid <?php echo $custom_main_color;?>; }
.widget_recent_products ul.product_list_widget li img:hover, .widget_recent_reviews ul.product_list_widget li img:hover, .widget_recently_viewed_products ul.product_list_widget li img:hover, .widget_random_products ul.product_list_widget li img:hover, .widget_best_sellers ul.product_list_widget li img:hover, .widget_onsale ul.product_list_widget li img:hover, .widget_featured_products ul.product_list_widget li img:hover, .latest-post-blog img:hover { background: <?php echo $custom_main_color;?>; border: 1px solid <?php echo $custom_main_color;?>; }
.flickr-widget-blog a:hover { border: 5px solid <?php echo $custom_main_color;?>; }
.selected { color: <?php echo $custom_main_color;?> !important; } .tabs-nav li.active a { border-top: 1px solid <?php echo $custom_main_color;?>; }
.dropcap, #breadcrumbs ul li:last-child a, #breadcrumbs ul li a, .trigger.active a, .testimonials-author, .tabs-nav li.active a, .sidebar .widget #twitter li span a, .widget #twitter b a:hover, .ui-accordion .ui-accordion-header-active:hover, .ui-accordion .ui-accordion-header-active { color: <?php echo $custom_main_color;?>; }
#footer .flickr-widget a:hover, .sidebar .flickr-widget a:hover  { border-color: <?php echo $custom_main_color;?>; }
.widget_layered_nav ul li.chosen a { background-color: <?php echo $custom_main_color;?>; border: 1px solid <?php echo $custom_main_color;?>; }
<?php echo ot_get_option( 'pp_custom_css' );  ?>
</style>
<?php

}   //eof custom_stylesheet_content
