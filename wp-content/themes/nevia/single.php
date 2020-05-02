<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Nevia
 * @since Nevia 1.0
 */

$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }
 ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php get_template_part( 'content', 'single'); ?>

<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>