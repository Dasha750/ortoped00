<?php
/**
 * Nevia functions and definitions
 *
 * @package Nevia
 * @since Nevia 1.0
 */


/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );

/**
 * Required: include OptionTree.
 */
include_once( 'option-tree/ot-loader.php' );

/**
 * Theme Options
 */
include_once( 'theme-options.php' );
include_once( 'meta-boxes.php' );

require_once("inc/class-pixelentity-theme-update.php");

$apikey = ot_get_option('pp_api_key');
if($apikey) {
    $username = ot_get_option('pp_username');
    PixelentityThemeUpdate::init($username,$apikey,'purethemes');
}

/**************************/
/* Include LayerSlider WP */
/**************************/

// Path for LayerSlider WP main PHP file
$layerslider = get_stylesheet_directory() . '/plugins/LayerSlider/layerslider.php';

// Check if the file is available to prevent warnings
if(file_exists($layerslider)) {

    // Include the file
    include $layerslider;

    // Activate the plugin if necessary
    if(get_option('nevia_layerslider_activated', '0') == '0') {

        // Run activation script
        layerslider_activation_scripts();

        // Save a flag that it is activated, so this won't run again
        update_option('nevia_layerslider_activated', '1');
    }
}

    $bgargs = array(
    'default-color' => 'ffffff',
    'default-image' => get_template_directory_uri() . '/images/bg/noise.png',
    );
    add_theme_support( 'custom-background', $bgargs );

    add_filter('widget_text', 'do_shortcode');
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Nevia 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'nevia_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Nevia 1.0
 */
function nevia_setup() {


	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

    /**
     * Shortcodes
     */
    require( get_template_directory() . '/inc/shortcodes.php' );

    /**
     * Shortcodes
     */
    require( get_template_directory() . '/inc/tinymce.php' );

    /**
     * Megamenu
     */
    require( get_template_directory() . '/inc/megamenu.php' );

   /**
	 * Widgets
	 */
	require( get_template_directory() . '/inc/widgets.php' );

    /**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Nevia, use a find and replace
	 * to change 'purepress' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'purepress', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
    add_theme_support( 'post-thumbnails' );


    set_post_thumbnail_size(640, 0, true); //size of thumbs
    add_image_size('blog-medium', 179, 179, true);  //4col

    //set to 472
    add_image_size('portfolio-main', 940, 0, true);     //slider
    add_image_size('portfolio-medium', 460, 334, true); //2col
    add_image_size('portfolio-thumb', 300, 218, true);  //3col
    add_image_size('portfolio-small', 220, 160, true);  //4col
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'purepress' ),
        'footer' => __( 'Footer Menu', 'purepress' )
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'image', 'video', 'gallery' ) );

    /**
     * Enable support for WooCommerce
     */
    add_theme_support( 'woocommerce' );
}
endif; // nevia_setup
add_action( 'after_setup_theme', 'nevia_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Nevia 1.0
 */
function nevia_widgets_init() {
	  register_sidebar(array(
        'id' => 'sidebar',
        'name' => 'Sidebar',
        'before_widget' => '<div id="%1$s" class="widget  %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="headline no-margin"><p class = "title">',
        'after_title' => '</p></div>',
        ));
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
     register_sidebar(array(
        'id' => 'shop',
        'name' => 'Shop',
        'before_widget' => '<div id="%1$s" class="widget  %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="headline no-margin"><h4>',
        'after_title' => '</h4></div>',
        ));
    }
    register_sidebar(array(
        'id' => 'footer1st',
        'name' => 'Footer 1st Column',
        'description' => '1st column for widgets in Footer.',
        'before_widget' => '<div id="%1$s" class="footer- %2$s">',
        'after_widget' => '</div>',
         'before_title' => '<p class="title">',
        'after_title' => '</p>',
        ));
     register_sidebar(array(
        'id' => 'footer2nd',
        'name' => 'Footer 2nd Column',
        'description' => '2nd column for widgets in Footer.',
        'before_widget' => '<div id="%1$s" class="footer- %2$s">',
        'after_widget' => '</div>',
         'before_title' => '<p class="title">',
        'after_title' => '</p>',
        ));
     register_sidebar(array(
        'id' => 'footer3rd',
        'name' => 'Footer 3rd Column',
        'description' => '3rd column for widgets in Footer.',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
         'before_title' => '<p class="title">',
        'after_title' => '</p>',
        ));
     register_sidebar(array(
        'id' => 'footer4th',
        'name' => 'Footer 4th Column',
        'description' => '4th column for widgets in Footer.',
        'before_widget' => '<div id="%1$s" class="footer- %2$s">',
        'after_widget' => '</div>',
         'before_title' => '<p class="title">',
        'after_title' => '</p>',
        ));

     //custom sidebars:
     if (ot_get_option('incr_sidebars')):
        $pp_sidebars = ot_get_option('incr_sidebars');
        foreach ($pp_sidebars as $pp_sidebar) {
        register_sidebar(array(
            'name' => $pp_sidebar["title"],
            'id' => $pp_sidebar["id"],
            'before_widget' => '<div id="%1$s" class="widget  %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="headline no-margin"><h4>',
            'after_title' => '</h4></div>',
            ));
        }
       endif;

}
add_action( 'widgets_init', 'nevia_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function nevia_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    $color = get_theme_mod('nevia_main_color','#169fe6');  //E.g. #FF0000
    $custom_css = "a, a:visited{ color: {$color}; }";
    wp_add_inline_style( 'style', $custom_css );
    wp_enqueue_style( 'pp-woocommerce', get_template_directory_uri().'/css/woocommerce.css' );
	if(ot_get_option('pp_mediaqueries') != 'no') wp_enqueue_style( 'pp-responsive', get_template_directory_uri().'/css/mediaqueries.css' );


    wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'twitter', get_template_directory_uri() . '/js/jquery.twitter.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/jquery.modernizr.js', array( 'jquery' ), '' );
    wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/jquery.nevia.plugins.js', array( 'jquery' ), '', true );


    //use isotope only if portfolio
    if(ot_get_option('pp_layerisotop') == 'on') {
        if (    is_post_type_archive( 'portfolio' ) ||
            is_page_template( 'template-portfolio2col.php' ) ||
            is_page_template( 'template-portfolio2col-flex.php' ) ||
            is_page_template( 'template-portfolio2col-layer.php' ) ||
            is_page_template( 'template-portfolio3col.php' ) ||
            is_page_template( 'template-portfolio3col-flex.php' ) ||
            is_page_template( 'template-portfolio3col-layer.php' ) ||
            is_page_template( 'template-portfolio4col.php' ) ||
            is_page_template( 'template-portfolio4col-flex.php' ) ||
            is_page_template( 'template-portfolio4col-layer.php' ) ) {
            wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );
            wp_enqueue_script( 'isotopenevia', get_template_directory_uri() . '/js/jquery.isotope.nevia.js', array( 'jquery','isotope' ), '', true );
        }

        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            if ( is_shop() || is_product_category() || is_product_tag() ) {
             wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );
             wp_enqueue_script( 'isotopenevia', get_template_directory_uri() . '/js/jquery.isotope.nevia.js', array( 'jquery','isotope' ), '', true );
         }
     }
    } else {
         wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), '', true );
         wp_enqueue_script( 'isotopenevia', get_template_directory_uri() . '/js/jquery.isotope.nevia.js', array( 'jquery','isotope' ), '', true );

    }

    wp_enqueue_script( 'jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

     wp_localize_script( 'custom', 'nevia',
            array(
                'ajaxurl'=>admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce'),
                'flexslidespeed' => ot_get_option('pp_flex_slideshowspeed',7000),
                'flexanimspeed' => ot_get_option('pp_flex_animationspeed',600),
                'flexanimationtype' => ot_get_option('pp_flex_animationtype','fade'),
                'jcautoscroll' => ot_get_option('pp_jcarousel_auto','no')
                )
            );
}
add_action( 'wp_enqueue_scripts', 'nevia_scripts' );


function load_my_script() {
    global $pagenow;
    if (is_admin() && $pagenow == 'post-new.php' OR $pagenow == 'post.php') {
        if ( ! did_action( 'wp_enqueue_media' ) )
        wp_enqueue_media();

        wp_register_style('centum-css', get_template_directory_uri() . '/css/centum.admin.css');
        wp_register_script('centum-scripts', get_template_directory_uri() . '/inc/script.js');
        wp_enqueue_style('centum-css');
        wp_enqueue_script('centum-scripts');
    }
}
add_action('admin_enqueue_scripts', 'load_my_script');


define( 'WOOCOMMERCE_USE_CSS', false );

/* ----------------------------------------------------- */
/* Portfolio Custom Post Type */
/* ----------------------------------------------------- */


add_action( 'init', 'register_cpt_portfolio' );

function register_cpt_portfolio() {

    $labels = array(
        'name' => __( 'Portfolio','purepress'),
        'singular_name' => __( 'Portfolio','purepress'),
        'add_new' => __( 'Add New','purepress' ),
        'add_new_item' => __( 'Add New Work','purepress' ),
        'edit_item' => __( 'Edit Work','purepress'),
        'new_item' => __( 'New Work','purepress'),
        'view_item' => __( 'View Work','purepress'),
        'search_items' => __( 'Search Portfolio','purepress'),
        'not_found' => __( 'No portfolio found','purepress'),
        'not_found_in_trash' => __( 'No works found in Trash','purepress'),
        'parent_item_colon' => __( 'Parent work:','purepress'),
        'menu_name' => __( 'Portfolio','purepress'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Display your works by filters','purepress'),
        'supports' => array( 'title', 'editor', 'excerpt', 'revisions', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        //'menu_icon' => TEMPLATE_URL . 'work.png',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'portfolio'),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}


/* ----------------------------------------------------- */
/* Testimonials Custom Post Type */
/* ----------------------------------------------------- */


add_action( 'init', 'register_cpt_testimonials' );

function register_cpt_testimonials() {

    $labels = array(
        'name' => __( 'Testimonials','purepress'),
        'singular_name' => __( 'testimonial','purepress'),
        'add_new' => __( 'Add New','purepress' ),
        'add_new_item' => __( 'Add New Testimonial','purepress' ),
        'edit_item' => __( 'Edit Testimonial','purepress'),
        'new_item' => __( 'New Testimonial','purepress'),
        'view_item' => __( 'View Testimonial','purepress'),
        'search_items' => __( 'Search Testimonials','purepress'),
        'not_found' => __( 'No testimonials found','purepress'),
        'not_found_in_trash' => __( 'No testimonials found in Trash','purepress'),
        'parent_item_colon' => __( 'Parent testimonial:','purepress'),
        'menu_name' => __( 'Testimonials','purepress'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Display your works by filters','purepress'),
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,

        //'menu_icon' => TEMPLATE_URL . 'work.png',
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'testimonial'),
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}
/* ----------------------------------------------------- */
/* Filter Taxonomy */
/* ----------------------------------------------------- */

add_action( 'init', 'register_taxonomy_filters' );

function register_taxonomy_filters() {

    $labels = array(
        'name' => __( 'Filters', 'purepress' ),
        'singular_name' => __( 'Filter', 'purepress' ),
        'search_items' => __( 'Search Filters', 'purepress' ),
        'popular_items' => __( 'Popular Filters', 'purepress' ),
        'all_items' => __( 'All Filters', 'purepress' ),
        'parent_item' => __( 'Parent Filter', 'purepress' ),
        'parent_item_colon' => __( 'Parent Filter:', 'purepress' ),
        'edit_item' => __( 'Edit Filter', 'purepress' ),
        'update_item' => __( 'Update Filter', 'purepress' ),
        'add_new_item' => __( 'Add New Filter', 'purepress' ),
        'new_item_name' => __( 'New Filter', 'purepress' ),
        'separate_items_with_commas' => __( 'Separate Filters with commas', 'purepress' ),
        'add_or_remove_items' => __( 'Add or remove Filters', 'purepress' ),
        'choose_from_most_used' => __( 'Choose from the most used Filters', 'purepress' ),
        'menu_name' => __( 'Filters', 'purepress' ),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,
        'rewrite' => true,
        'query_var' => true
    );
    register_taxonomy( 'filters', array('portfolio'), $args );
}


/*
 * Adds terms from a custom taxonomy to post_class
 */
add_filter( 'post_class', 'theme_t_wp_taxonomy_post_class', 10, 3 );

function theme_t_wp_taxonomy_post_class( $classes, $class, $ID ) {
    $taxonomy = 'filters';
    $terms = get_the_terms( (int) $ID, $taxonomy );
    if( !empty( $terms ) ) {
        foreach( (array) $terms as $order => $term ) {
            if( !in_array( $term->slug, $classes ) ) {
                $classes[] = $term->slug;
            }
        }
    }
    return $classes;
}


/*
** WOOCOMMERCE
*/

remove_action( 'woocommerce_before_main_content',    'woocommerce_breadcrumb', 20, 0);

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
 * WooCommerce Loop Product Thumbs
 **/

 if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
    function woocommerce_template_loop_product_thumbnail() {
        echo woocommerce_get_product_thumbnail();
    }
 }


/**
 * WooCommerce Product Thumbnail
 **/
 if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
    function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
        global $post, $woocommerce;
        $output = '';
        if ( ! $placeholder_width )
            $placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
        if ( ! $placeholder_height )
            $placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );
            $output .= '<a href="'.get_permalink().'">';
            if ( has_post_thumbnail() ) {
                $output .= get_the_post_thumbnail( $post->ID, 'portfolio-thumb' );
            } else {
                $output .= '<img src="'. woocommerce_placeholder_img_src() .'" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';
            }
            $output .= '</a>';
            return $output;
    }
 }

/**
 * Replace WooCommerce Default Pagination with WP-PageNavi Pagination
 *
 * @author WPSnacks.com
 * @link http://www.wpsnacks.com
 */
if(function_exists('wp_pagenavi')) {
    remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
    function woocommerce_pagination() {
        wp_pagenavi();
    }
    add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);
}
remove_action('woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );


/**
 * Custom Add To Cart Messages
 *
 **/
add_filter( 'woocommerce_add_to_cart_message', 'custom_add_to_cart_message' );
function custom_add_to_cart_message() {
    global $woocommerce;

    // Output success messages
    if (get_option('woocommerce_cart_redirect_after_add')=='yes') :

        $return_to  = get_permalink(woocommerce_get_page_id('shop'));

        $message    = sprintf('<p id="added_cart_info">%s</p> <a href="%s" style="float:right; margin-right: -15px;" class="button color">%s</a>', __('Product successfully added to your cart.', 'woocommerce'), $return_to, __('Continue Shopping &rarr;', 'woocommerce') );

    else :

        $message    = sprintf('<p id="added_cart_info">%s</p> <a href="%s" style="float:right; margin-right: -15px;" class="button color">%s</a> ', __('Product successfully added to your cart.', 'woocommerce'), get_permalink(woocommerce_get_page_id('cart')), __('View Cart &rarr;', 'woocommerce') );

    endif;

        return $message;
}


/* Change number of items */
$wooitems = ot_get_option('pp_wooitems','9');
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$wooitems.';' ), 20 );


/* remove comments if you want to get rid of sorting and results counter
remove_filter( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',30 );
remove_filter( 'woocommerce_before_shop_loop', 'woocommerce_result_count',20 );
*/

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

$catalogmode = ot_get_option('pp_woo_catalog');
if ($catalogmode == "yes") {
    remove_filter( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
}

//change default image

add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {
     $src = get_template_directory_uri(). '/images/shop-01.jpg';
     return $src;
}

remove_action('wp_head', 'wp_generator');

add_filter('login_errors', create_function('$a', "return null;"));

function at_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter('style_loader_src', 'at_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'at_remove_wp_ver_css_js', 9999);

function my_login_logo(){
    echo '<style type="text/css">#login h1 a { background: url('. get_bloginfo('template_directory') .'/images/logo-login.png) no-repeat top center !important; height: 96px; width: 96px; }</style>';
}
add_action('login_head', 'my_login_logo');
add_filter( 'login_headerurl', create_function('', 'return get_home_url();') );
add_filter( 'login_headertitle', create_function('', 'return get_bloginfo();') );
?>