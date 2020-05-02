<?php
/**
 * Template Name: Home Page Template with Flex
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


$slides = ot_get_option( 'mainslider', array() );
if ( !empty( $slides )) {
    get_template_part('slider');
}
while ( have_posts() ) : the_post(); ?>
<!-- 960 Container -->
<div class="container">
    <?php the_content(); ?>
</div>
<?php endwhile; // end of the loop.

get_footer(); ?>