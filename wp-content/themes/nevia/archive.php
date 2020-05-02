<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nevia
 * @since Nevia 1.0
 */

$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }
?>

<?php get_template_part('loop'); ?>

<?php get_footer(); ?>
