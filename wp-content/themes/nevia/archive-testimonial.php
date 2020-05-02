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

<!-- 960 Container -->
<div class="container floated">

    <div class="sixteen floated page-title">
        <h1><?php _e('Testimonials', 'purepress'); ?></h1>
        <?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>
    </div>

</div>

<!-- 960 Container / End -->
<?php $blog_layout = ot_get_option('pp_blog_layout','right-sidebar'); ?>
<!-- 960 Container -->
<div class="container floated main">
    <?php if($blog_layout == 'left-sidebar') { ?>
    <!-- Sidebar -->
    <div class="four floated sidebar left">
        <?php  get_sidebar(); ?>
    </div>
    <!-- Sidebar / End -->
    <?php } ?>
    <!-- Page Content -->
    <div class="eleven floated  <?php if($blog_layout == 'left-sidebar') { echo 'right'; } ?>">

        <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post();
        $author = get_post_meta($post->ID, 'pp_author', true);
        $link = get_post_meta($post->ID, 'pp_link', true);
        $position = get_post_meta($post->ID, 'pp_position', true);
        ?>

        <div class="testimonials" style="margin-top: 20px;"><?php the_content(); ?></div>
        <div class="testimonials-bg"></div>
        <div class="testimonials-author"><?php echo $author; ?>, <span><?php echo $position; ?></span></div>
        <!-- Divider -->
        <div class="line" style="margin-top: 20px;"></div>



    <?php endwhile; ?>

<?php else : ?>

    <?php get_template_part( 'no-results', 'index' ); ?>

<?php endif; ?>
<?php if(function_exists('wp_pagenavi')) {
    wp_pagenavi();
} else { ?>
<?php if ( get_next_posts_link() ||  get_previous_posts_link() ) : ?>
    <nav class="pagination">
        <ul>
            <?php if ( get_next_posts_link() ) : ?>
            <li class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'purepress' ) ); ?></li>
        <?php endif; ?>

        <?php if ( get_previous_posts_link() ) : ?>
        <li class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'purepress' ) ); ?></li>
    <?php endif; ?>
</ul>
<div class="clearfix"></div>
</nav>
<?php endif; ?>
<?php } ?>

</div>
<!-- Content / End -->
<?php if($blog_layout == 'right-sidebar') { ?>
<!-- Sidebar -->
<div class="four floated sidebar right">
    <?php  get_sidebar(); ?>
</div>
<!-- Sidebar / End -->
<?php } ?>
</div>
<!-- 960 Container / End -->


<?php get_footer(); ?>
