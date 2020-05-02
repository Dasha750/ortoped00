<?php
/**
 * Template Name: Portfolio page 4 colums with LayerSlider
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

 ?>

<!-- 960 Container -->
<div class="container floated">

    <div class="sixteen floated page-title">

        <h1>
        	<?php $pf_title = get_post_meta($post->ID, 'pp_portfolio_title', true);
        	$pp_subtitle = get_post_meta($post->ID, 'pp_subtitle', true);
        	if($pf_title) { echo $pf_title;} else {  $pp_portfolio_page = ot_get_option('pp_portfolio_page');
                if (function_exists('icl_register_string')) {
                    icl_register_string('Portfolio page title','pp_portfolio_page', $pp_portfolio_page);
                    echo icl_t('Portfolio page title','pp_portfolio_page', $pp_portfolio_page); }
                else {
                    echo $pp_portfolio_page;
                } } ?>
        	<?php if(!is_tax() && $pp_subtitle) { echo '<span>'.$pp_subtitle.'</span>'; } ?>
        	<?php if(is_tax()) { $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );  if($term) echo '<span>/ '.$term->name.'</span>'; } ?></h1>

       <?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>

    </div>

</div>
<!-- 960 Container / End -->
<?php

$showpost = ot_get_option('pp_portfolio_showpost','6');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$filters = get_post_meta($post->ID, 'portfolio_filters', true);
if(empty($filters)) {
	query_posts(array (
		'post_type' => 'portfolio',
		'paged' => $paged,
		'posts_per_page' => $showpost
	));
} else {
	query_posts(array (
		'post_type' => 'portfolio',
		'paged' => $paged,
		'posts_per_page' => $showpost,
		'tax_query' => array(
			array(
				'taxonomy' => 'filters',
				'field' => 'id',
				'terms' => $filters,
				'operator' => 'IN',
				'include_children' => false
			)
		)
	));
}


get_template_part('pftpl4col');


get_footer();

?>