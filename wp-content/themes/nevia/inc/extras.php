<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Nevia
 * @since Nevia 1.0
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since Nevia 1.0
 */
function nevia_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'nevia_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Nevia 1.0
 */
function nevia_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'nevia_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since Nevia 1.0
 */
function nevia_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'nevia_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Nevia 1.1
 */
function nevia_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'purepress' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'nevia_wp_title', 10, 2);




/*
Plugin Name: OptionTree Gallery Manager
author: purethemes.net
----------------------------------------------------- */

function ot_type_puregallery( $args = array() ) {
    /* turns arguments array into variables */
    extract( $args );
    global $post;

    $current_post_id = $post->ID;

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-post_attachments_checkbox type-checkbox ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';

    /* description */
    echo $has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . ' <br/><a href="#" class="delete-gallery">Delete gallery</a></div>' : '';

    /* format setting inner wrapper */
    echo '<div class="format-setting-inner">';

    /* setup the post types */
    $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
    global $pagenow;
    if($pagenow == 'themes.php' ) {
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'post_mime_type' => 'image',
            'post__in' => explode( ",", $field_value),
            'posts_per_page' => '-1',
            'orderby' => 'post__in'
            );
    } else {
        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'post__in' => explode( ",", $field_value),
            'post_mime_type' => 'image',
            'posts_per_page' => '-1',
            'orderby' => 'post__in'
            );
    }

    /* query posts array */
    $query = new WP_Query( $args  );

    /* has posts */ echo '<input type="hidden" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_id ) . '" value="' . esc_attr( $field_value ) . '" class="widefat option-tree-ui-input ' . esc_attr( $field_class ) . '" />';
    if ( $query->have_posts() ) {
        echo '<ul style="margin:0px" id="option-tree-gallery-list">';
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<li>';
                $thumbnail = wp_get_attachment_image_src( $query->post->ID, 'thumbnail');
                echo '<img  src="' . $thumbnail[0] . '" width="60" height="60" />';
                echo '</li>';

            }
        echo "</ul>";
        echo '<a title="Add images" class="option-tree-attachments-update option-tree-ui-button blue right hug-right addgallery" href="#">Edit Slider Gallery</a>';

    } else {
        echo '<ul style="margin:0px" id="option-tree-gallery-list"></ul><p>' . __( 'No Gallery', 'option-tree' ) . '</p>';
        echo '<a title="Add images" class="option-tree-attachments-update option-tree-ui-button blue right hug-right addgallery" href="#">Create Slider Gallery</a>';
    }

    echo '</div>';

    echo '</div>';
}
//fake and dirty shortcode for stupid media uploader
function media_view_settings($settings, $post ) {
    if (!is_object($post)) return $settings;
    $shortcode = '[gallery ';
    $ids = get_post_meta($post->ID, 'pp_gallery_slider', TRUE);
    $ids = explode(",", $ids);

    if (is_array($ids))
        $shortcode .= 'ids = "' . implode(',',$ids) . '"]';
    else
        $shortcode .= "id = \"{$post->ID}\"]";
    $settings['neviagallery'] = array('shortcode' => $shortcode);
    return $settings;

}
add_filter( 'media_view_settings','media_view_settings', 10, 2 );


function ot_type_attachments_ajax_update() {
    if ( !empty( $_POST['ids'] ) )  {
            $args = array(
                   'post_type' => 'attachment',
                    'post_status' => 'inherit',
                    'post__in' => $_POST['ids'],
                    'post_mime_type' => 'image',
                    'posts_per_page' => '-1',
                    'orderby' => 'post__in'
                );
            $return = '';
                /* query posts array */
    $query = new WP_Query( $args  );
    $post_type = isset( $field_post_type ) ? explode( ',', $field_post_type ) : array( 'post' );
    /* has posts */
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $return .= '<li>';
            $thumbnail = wp_get_attachment_image_src( $query->post->ID, 'thumbnail');
            $return .=  '<img  src="' . $thumbnail[0] . '" width="60" height="60" />';
            $return .=  '</li>';

        }

    } else {
        $return .=  '<p>' . __( 'No Posts Found', 'option-tree' ) . '</p>';
    }
            echo $return;
            exit();
    }
}

add_action( 'wp_ajax_attachments_update', 'ot_type_attachments_ajax_update' );



