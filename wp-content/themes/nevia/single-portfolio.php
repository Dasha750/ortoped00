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

        <h1><?php the_title(); ?> <?php $subtitle  = get_post_meta($post->ID, 'pp_subtitle', true);
        if ( $subtitle) {
            echo ' <span>  '.$subtitle.'</span>';
        } ?></h1>

        <!-- Portfolio Navi -->
        <div id="portfolio-navi">
            <ul>
                <?php
                    $prev = get_adjacent_post(false, '', false);
                    $next = get_adjacent_post(false, '', true);
                ?>
                <?php if ($prev) { ?> <li><a class="prev" href="<?php echo get_permalink($prev->ID)?>"><b>←</b> <?php _e('Previous','purepress'); ?></a></li><?php } ?>
                <?php if (empty($prev)) { ?> <li><a class="prev disabled" href="#"><b>←</b> <?php _e('Previous','purepress'); ?></a></li><?php } ?>
                <?php if ($next) { ?><li><a class="next" href="<?php echo get_permalink($next->ID)?>"><?php _e('Next','purepress'); ?> <b>→</b></a></li><?php } ?>
                <?php if (empty($next)) { ?><li><a class="next disabled" href="#"><?php _e('Next','purepress'); ?> <b>→</b></a></li><?php } ?>
            </ul>
        </div>
        <div class="clearfix"></div>

    </div>

</div>
<!-- 960 Container / End -->



<!-- Page Content -->
<div class="page-content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="container">
        <div class="sixteen columns">
            <?php

            $type  = get_post_meta($post->ID, 'pp_pf_type', true);

            if($type == 'video') {
                $videoembed = get_post_meta($post->ID, 'pp_pfvideo_embed', true);
                if($videoembed) {
                    echo '<div class="container"><div class="sixteen columns video-cont">'.$videoembed.'</div></div>';
                } else {
                    global $wp_embed;
                    $videolink = get_post_meta($post->ID, 'pp_pfvideo_link', true);
                    $post_embed = $wp_embed->run_shortcode('[embed width="940" height="530"]'.$videolink.'[/embed]') ;
                    echo '<div class="container"><div class="sixteen columns video-cont">'.$post_embed.'</div></div>';
                }
            } else {
            // Check what to display above post title (image,vide, slideshow)
                $ids = get_post_meta($post->ID, 'pp_gallery_slider', TRUE);
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
                } //eof if type ?>
            </div>
        </div>


        <!-- 960 Container -->
        <div class="container" style="margin-top: 30px;">
            <?php
              $width  = get_post_meta($post->ID, 'pp_pf_full', true);
            ?>
            <div class="<?php if ($width == 'full') { echo "sixteen"; } else { echo "twelve"; } ?> columns">
                <?php the_content() ?>
            </div>
            <?php if ($width == 'none' || empty($width)) { ?>
            <div class="four columns">
                <div class="project-info-container">
                    <?php
                    $metafields = ot_get_option( 'pp_pf_meta', array() );
                    if (!empty( $metafields ) ) {
                        echo '<ul class="project-info">';
                        $i = 0;
                        foreach( $metafields as $metafield ) {
                          $i++;
                          //wpml fix
                          if (function_exists('icl_register_string')) {
                            icl_register_string('Portfolio meta title '.$i, 'pfmetatitle'.$i, $metafield['title']);
                          }
                          if (function_exists('icl_register_string')) {
                               $title = icl_t('Portfolio meta title '.$i, 'pfmetatitle'.$i, $metafield['title']);

                          } else {
                              $title = $metafield['title'];
                           }
                          if($metafield['type'] == "text") {
                           $field_id = "pp_pf_".sanitize_title($metafield['title']);
                           $value = get_post_meta($post->ID, $field_id, true);
                             if($value){
                               echo "<li><strong>".$title.":</strong>";
                               echo " ".$value."</li>";
                             }
                          }
                          if($metafield['type'] == "filters") {
                            $terms = get_the_terms( $post->ID , 'filters' );
                            if($terms) {

                              echo "<li><strong>".$title.":</strong> ";

                              foreach ( $terms as $term ) {
                                echo '<a href="'.get_term_link($term->slug, 'filters').'">'.$term->name."</a> ";
                              }
                              echo "</li>";
                            }
                          }
                          if($metafield['type'] == "dateofp") {

                            echo "<li><strong>Date:</strong> ";
                            echo  get_the_date();
                            echo "</li>";
                          }

                          if($metafield['type'] == "link") {
                            $text= $metafield['title'];
                            $link = get_post_meta($post->ID, 'pp_pf_link', true);
                            echo '<li><a href="'.$link.'" class="button color launch">'.$text.'</a></li>';
                          }
                      }
                    echo '</ul>';
                }
                    ?>
            </div>
        </div>
        <?php } ?>
</div>
<!-- End 960 Container -->
<?php endwhile; // End the loop. Whew.  ?>

<div class="line" style="margin: 20px 0 37px 0;"></div>


<div class="related-works">

    <!-- 960 Container -->
    <div class="container" style="margin-bottom: -10px;margin-top: -36px;padding-top: 25px;">

        <div class="sixteen columns">
            <h3 class="margin"><?php _e('Recent Works','purepress'); ?></h3>
        </div>

        <?php recent_porfolios(); ?>
    </div>
    <!-- End 960 Container -->

</div>
<!-- Related Works / End -->

</div>
<!-- Page Content / End -->


<?php
get_footer();
?>