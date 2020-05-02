<?php
/**
 * Initialize the meta boxes.
 */
add_action( 'admin_init', '_custom_meta_boxes' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types
 * in demo-theme-options.php.
 *
 * @return    void
 *
 * @access    private
 * @since     2.0
 */
function _custom_meta_boxes() {

  /**
   * Create a custom meta boxes array that we pass to
   * the OptionTree Meta Box API Class.
   */

  $sidebars = ot_get_option('incr_sidebars');
  $sidebars_array = array();
  $sidebars_array[0] = array (
   'label' => "Default sidebar",
   'value' => 'sidebar'
   );

  $sidebars_k = 1;
  if(!empty($sidebars)){
    foreach($sidebars as $sidebar){
      $sidebars_array[$sidebars_k++] = array(
        'label' => $sidebar['title'],
        'value' => $sidebar['id']
        );
    }
  }



  $meta_box_layout = array(
    'id'        => 'pp_metabox_sidebar',
    'title'     => 'Layout',
    'desc'      => 'If you choose the sidebar layout, please choose a sidebar from the list below. Sidebars can be created in the Theme Options and configured in the Theme Widgets.',
    'pages'     => array( 'post' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'pp_sidebar_layout',
        'label'       => 'Layout',
        'desc'        => '',
        'std'         => 'right-sidebar',
        'type'        => 'radio_image',
        'class'       => ''
        ),
      array(
        'id'          => 'pp_sidebar_set',
        'label'       => 'Sidebar',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'    => $sidebars_array
        )
      )
    );
    $meta_box_layout_page = array(
    'id'        => 'pp_metabox_sidebar',
    'title'     => 'Layout',
    'desc'      => 'If you choose the sidebar layout, please choose a sidebar from the list below. Sidebars can be created in the Theme Options and configured in the Theme Widgets.',
    'pages'     => array( 'page' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(
      array(
        'id'          => 'pp_sidebar_layout',
        'label'       => 'Layout',
        'desc'        => '',
        'std'         => 'full-width',
        'type'        => 'radio_image',
        'class'       => ''
        ),
      array(
        'id'          => 'pp_sidebar_set',
        'label'       => 'Sidebar',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'class'       => '',
        'choices'    => $sidebars_array
        )
      )
    );

  $post_options = array(
    'id'        => 'pp_metabox_featue',
    'title'     => 'Post options',
    'desc'      => 'Select post display options (Option depends on Post\'s Format, so be sure to select one.',
    'pages'     => array( 'post' ),
    'context'   => 'normal',
    'priority'  => 'high',
    'fields'    => array(

      array(
        'id'          => 'pp_feattype',
        'label'       => 'Show thumbnail on blog and archive page?',
        'desc'        => '',
        'std'         => 'show_thumb',
        'type'        => 'select',
        'class'       => '',
        'choices' => array(
          array(
            'label' => 'Show thumbnail',
            'value' => 'show_thumb'
            ),
          array(
            'label' => 'Hide thumbnail',
            'value' => 'hide_thumb'
            )
          )

        ),
      array(
        'id'          => 'pp_video_link',
        'label'       => 'Link to Video',
        'desc'        => 'Just link, not embed code, this field uses oEmbed.',
        'std'         => '',
        'type'        => 'text',
        'class'       => '',
        ),
      array(
        'id'          => 'pp_video_embed',
        'label'       => 'Embed code for Video',
        'desc'        => 'Place here embed code for videos services that do not support oEmbed',
        'std'         => '',
        'type'        => 'textarea',
        'class'       => '',
        ),
      array(
        'label' => 'Gallery slider (use when Post Type is set to Gallery)',
        'id' => 'pp_gallery_slider',
        'type' => 'puregallery',
        'desc' => 'Click Create Slider to create your gallery for slider.',
        'post_type' => 'post',
      ),
      )
    );

$subtitle = array(
  'id'        => 'pp_metabox_subtitle',
  'title'     => 'Subtitle',
  'desc'      => '',
  'pages'     => array( 'page', 'portfolio' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array(
    array(
      'id'          => 'pp_subtitle',
      'label'       => 'Subtitle',
      'desc'        => 'Set subtitle for page.',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      )
    )
  );


$layers = array();
global $wpdb;
// Table name
$table_name = $wpdb->prefix . "layerslider";
// Get sliders
$sliders = $wpdb->get_results( "SELECT * FROM $table_name WHERE flag_hidden = '0' AND flag_deleted = '0' ORDER BY date_c ASC LIMIT 100" );
// Iterate over the sliders
if($sliders) {
  foreach($sliders as $key => $item) {
    $layers[] = array(
      'label' => $item->name,
      'value' => $item->id
      );
         // echo '<option value="'.$item->id.'">'.$item->name.'</option>';
  }
} else {
  $layers[] = array(
      'label' => 'No Sliders Found',
      'value' => ''
      );
}

$slider = array(
  'id'        => 'pp_metabox_slider',
  'title'     => 'Slider settings',
  'desc'      => 'If you want to use Layer Slider on this page, select page template "LayerSlider Page" and choose slider you want to display',
  'pages'     => array( 'page' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array(
    array(
      'id'          => 'pp_page_layer',
      'label'       => 'Layer Slider',
      'desc'        => '',
      'std'         => '',
      'type'        => 'select',
      'choices'     => $layers,
      'class'       => '',
      )
    )
  );

$gallerypage = array(
  'id'        => 'pp_metabox_gallerypage',
  'title'     => 'Gallery slider',
  'desc'      => 'If you want to use flexslider gallery like on Portfolio item, just create gallery using button below',
  'pages'     => array( 'page' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array(
    array(
        'label' => 'Gallery slider ',
        'id' => 'pp_gallery_slider',
        'type' => 'puregallery',
        'desc' => 'Click Create Slider to create your gallery for slider.',
        'post_type' => 'post',
      )
    )
  );



$meta_box_filters = array(

  'id'        => 'pp_metabox_pf_tax',
  'title'     => 'Portfolio Template Options',
  'desc'      => '',
  'pages'     => array('page' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array(

    array(
      'label' => 'Select Filters to display',
      'id' => 'portfolio_filters',
      'type' => 'taxonomy-checkbox',
      'desc' => 'Select filters from which you want to display your portfolio items.',
      'std' => '',
      'rows' => '',
      'post_type' => '',
      'taxonomy' => 'filters',
      'class' => 'filters-checbox' ),
    array(
      'id'          => 'pp_filters_switch',
      'label'       => 'Filters buttons display',
      'desc'        => '',
      'std'         => '',
      'type'        => 'select',
      'class'       => '',
      'choices' => array(
        array(
          'label' => 'Yes',
          'value' => 'yes'
          ),
        array(
          'label' => 'No',
          'value' => 'no'
          )
        )
      ),
     array(
      'id'          => 'pp_portfolio_title',
      'label'       => 'Title of Portfolio Section',
      'desc'        => 'Overwrites setting from Theme Options.',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      ),

    )

  );

$meta_pf_fields = array();
$metafields = ot_get_option( 'pp_pf_meta', array() );
if (!empty( $metafields ) ) {
  $i = 0;
  foreach( $metafields as $metafield ) {
   if($metafield['type'] == "text") {
     $meta_pf_fields[$i]['id'] = "pp_pf_".sanitize_title($metafield['title']);
     $meta_pf_fields[$i]['label'] = $metafield['title'];
     $meta_pf_fields[$i]['type'] = "text";
     $i++;
   }
   if($metafield['type'] == "link") {
     $meta_pf_fields[$i]['id'] = "pp_pf_link";
     $meta_pf_fields[$i]['label'] = $metafield['title'];
     $meta_pf_fields[$i]['type'] = "text";
     $i++;
   }
 }
}


$meta_box_pffields = array(
 array(
      'id'          => 'pp_pf_type',
      'label'       => 'Portfolio type',
      'desc'        => '',
      'std'         => '',
      'type'        => 'select',
      'class'       => '',
      'choices' => array(
        array(
          'label' => 'Gallery',
          'value' => 'gallery'
          ),
        array(
          'label' => 'Video',
          'value' => 'video'
          )
        )

      ),
    array(
      'label' => 'Gallery slider',
      'id' => 'pp_gallery_slider',
      'type' => 'puregallery',
      'desc' => 'Click Create Slider to create your gallery for slider.',
      'post_type' => 'post',

      ),
    array(
      'id'          => 'pp_pfvideo_link',
      'label'       => 'Link to Video',
      'desc'        => 'Just link, not embed code, this field is used for oEmbed.',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      ),
     array(
        'id'          => 'pp_pfvideo_embed',
        'label'       => 'Embed code for Video',
        'desc'        => 'Place here embed code for videos services that do not support oEmbed',
        'std'         => '',
        'type'        => 'textarea',
        'class'       => '',
        ),

    array(
      'id'          => 'pp_pf_full',
      'label'       => 'Full width content ',
      'desc'        => 'If you don\'t want to show date, client and launch button fields, you can switch to full width content here',
      'std'         => 'none',
      'type'        => 'select',
      'class'       => '',
      'choices' => array(
        array(
          'label' => 'Full width',
          'value' => 'full'
          ),
        array(
          'label' => '12 columns',
          'value' => 'none'
          )
        )

      ),

  );

$my_meta_box_pf = array(
  'id'        => 'pp_metabox_pf',
  'title'     => 'Portfolio Options',
  'desc'      => '',
  'pages'     => array('portfolio' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array_merge($meta_box_pffields,$meta_pf_fields)
);


$testimonials = array(
  'id'        => 'pp_metabox_testimonials',
  'title'     => 'Testimonials info',
  'desc'      => 'Fill field below to use testimonials in slider',
  'pages'     => array( 'testimonial' ),
  'context'   => 'normal',
  'priority'  => 'high',
  'fields'    => array(
    array(
      'id'          => 'pp_author',
      'label'       => 'Author of testimonial',
      'desc'        => '',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      ),
     array(
      'id'          => 'pp_link',
      'label'       => 'Link to authors website (optional)',
      'desc'        => '',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      ),
     array(
      'id'          => 'pp_position',
      'label'       => 'Enter their position in their specific company.',
      'desc'        => '',
      'std'         => '',
      'type'        => 'text',
      'class'       => '',
      )
    )
  );


  /**
   * Register our meta boxes using the
   * ot_register_meta_box() function.
   */
  ot_register_meta_box( $meta_box_layout );
  ot_register_meta_box( $meta_box_layout_page );
  ot_register_meta_box( $post_options );
  ot_register_meta_box( $meta_box_filters );
  ot_register_meta_box( $subtitle );
  ot_register_meta_box( $gallerypage );
  ot_register_meta_box( $slider );
  ot_register_meta_box( $my_meta_box_pf );
  ot_register_meta_box( $testimonials );

}