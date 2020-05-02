<?php
/**
 * Single Product Image
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.3
* @modified    purethemes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce;

?>
<div class="six columns">
    <div class="images shop-item">
       <?php
       if ( has_post_thumbnail() ) {
            $image              = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
            $image_title        = esc_attr( get_the_title( get_post_thumbnail_id() ) );
            $image_link         = wp_get_attachment_url( get_post_thumbnail_id() );
            $attachment_count   = count( get_children( array( 'post_parent' => $post->ID, 'post_mime_type' => 'image', 'post_type' => 'attachment' ) ) );

            if ( $attachment_count != 1 ) {
                $gallery = '-gallery';
            } else {
                $gallery = '';
            }
            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="fancybox' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
        } else {
            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );
        }
        do_action('woocommerce_product_thumbnails'); ?>
    </div>
</div>