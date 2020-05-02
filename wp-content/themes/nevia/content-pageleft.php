<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Nevia
 * @since Nevia 1.0
 */
?>

<!-- 960 Container -->
<div class="container floated">

    <div class="sixteen floated page-title">

        <h1><?php the_title(); ?> <?php $subtitle = get_post_meta($post->ID, 'pp_subtitle', true); if($subtitle)  echo "<span>".$subtitle."</span>";?>
             <?php edit_post_link( __( 'Edit', 'purepress' ), '<span class="edit-link">', '</span>' ); ?></h1>

        <?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>

    </div>

</div>
<!-- 960 Container / End -->

<?php
$ids = get_post_meta($post->ID, 'pp_gallery_slider', TRUE);
if($ids) {
        $args = array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'post_mime_type' => 'image',
        'post__in' => explode( ",", $ids),
        'posts_per_page' => '-1',
        'orderby' => 'post__in'
        );
        $images_array = get_posts( $args );
          if ( $images_array ) {
              $captions = ot_get_option('pp_portfolio_caption');
           ?>
            <section class="flexslider">
                <ul class="slides">
                 <?php foreach( $images_array as $images ) : setup_postdata($images); ?>
                 <!-- 960 Container -->
                    <?php
                        $attachment = wp_get_attachment_image_src($images->ID, 'full');
                        $thumb = wp_get_attachment_image_src($images->ID, 'portfolio-main');
                    ?>
                    <li>
                        <a href="<?php echo $attachment[0] ?>" rel="fancybox-gallery" title="<?php echo $images->post_title; ?>" >
                            <img src="<?php echo $thumb[0] ?>" alt="<?php echo $images->post_title; ?>" />
                             <?php if($captions == 'yes') { ?><div class="slide-caption"><h3><?php echo $images->post_title; ?></h3></div><?php } ?>
                        </a>
                    </li>
                <?php endforeach;  ?>
                </ul>
            </section>
            <!-- End 960 Container -->
            <?php
            } //eof if type
            wp_reset_query();
    } ?>

<!-- 960 Container -->
<div class="container floated">

    <!-- Sidebar -->
    <div class="four floated sidebar left">
        <?php  get_sidebar(); ?>
    </div>
    <!-- Sidebar / End -->

    <!-- Page Content -->
    <div class="eleven floated right">
        <!-- Page Content -->
        <div id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
            <?php the_content(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'purepress' ), 'after' => '</div>' ) ); ?>

        </div>
    </div>
    <!-- Page Content / End -->
</div>
<!-- 960 Container / End -->
