<?php
/**
 * Template Name: Page with LayerSlider
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */

$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }

$slider = get_post_meta($post->ID, 'pp_page_layer', true);
if($slider) {
        echo do_shortcode( '[layerslider id="'.$slider.'"]' );
}
while ( have_posts() ) : the_post();
$layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);
switch ($layout) {
    case 'full-width':
        get_template_part( 'content', 'page' );
        break;
    case 'left-sidebar':
        get_template_part( 'content', 'pageleft' );
        break;
    case 'right-sidebar':
        get_template_part( 'content', 'pageright' );
        break;
    default:
        get_template_part( 'content', 'page' );
        break;
}


endwhile; // end of the loop.


get_footer(); ?>