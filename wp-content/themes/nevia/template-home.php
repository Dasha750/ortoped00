<?php
/**
 * Template Name: Home Page Template
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

$sliderstatus = ot_get_option( 'pp_slider_on' );
if($sliderstatus == 'yes') {

    $slidertype = ot_get_option( 'pp_slider_home' );
    if($slidertype=='flex') {
        get_template_part('slider');
    } else {
        $layerid = ot_get_option( 'pp_layerid', array() );
        echo do_shortcode( '[layerslider id="'.$layerid.'"]' );
    }
}
while ( have_posts() ) : the_post(); ?>
<!-- 960 Container -->
<div class="container">
	<?php the_content(); ?>
</div>
<?php endwhile; // end of the loop.

get_footer(); ?>