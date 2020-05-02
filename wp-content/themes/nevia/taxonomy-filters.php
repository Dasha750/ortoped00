<?php
/**
 * The main template file.
 * @package WordPress
 */
$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }
 ?>

<!-- 960 Container -->
<div class="container floated">

    <div class="sixteen floated page-title">

        <h1><?php $pf_title = get_post_meta($post->ID, 'pp_portfolio_title', true); if($pf_title) { echo $pf_title;} else { $pp_portfolio_page = ot_get_option('pp_portfolio_page');
                if (function_exists('icl_register_string')) {
                    icl_register_string('Portfolio page title','pp_portfolio_page', $pp_portfolio_page);
                    echo icl_t('Portfolio page title','pp_portfolio_page', $pp_portfolio_page); }
                else {
                    echo $pp_portfolio_page;
                } } ?> <?php if(is_tax()) { $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );  if($term) echo '<span>/ '.$term->name.'</span>'; } ?></h1>

        <?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>

    </div>

</div>
<!-- 960 Container / End -->
<?php


$layout = ot_get_option('pp_portfolio_layout');
if ($layout == '4') {
    get_template_part('pftpl4col');
} else if ($layout == '2') {
    get_template_part('pftpl');
} else {
    get_template_part('pftpl3col');
}

get_footer();

?>