<?php
global $standart_fonts;
$standart_fonts = array(
	'Arial, Helvetica, sans-serif'                     => 'Arial, Helvetica, sans-serif',
	'Arial Black, Gadget, sans-serif'                  => 'Arial Black, Gadget, sans-serif',
	'Bookman Old Style, serif'                         => 'Bookman Old Style, serif',
	'Comic Sans MS, cursive'                           => 'Comic Sans MS, cursive',
	'Courier, monospace'                               => 'Courier, monospace',
	'Garamond, serif'                                  => 'Garamond, serif',
	'Georgia, serif'                                   => 'Georgia, serif',
	'Impact, Charcoal, sans-serif'                     => 'Impact, Charcoal, sans-serif',
	'Lucida Console, Monaco, monospace'                => 'Lucida Console, Monaco, monospace',
	'Lucida Sans Unicode, Lucida Grande, sans-serif'   => 'Lucida Sans Unicode, Lucida Grande, sans-serif',
	'MS Sans Serif, Geneva, sans-serif'                => 'MS Sans Serif, Geneva, sans-serif',
	'MS Serif, New York, sans-serif'                   => 'MS Serif, New York, sans-serif',
	'Palatino Linotype, Book Antiqua, Palatino, serif' => 'Palatino Linotype, Book Antiqua, Palatino, serif',
	'Tahoma,Geneva, sans-serif'                        => 'Tahoma, Geneva, sans-serif',
	'Times New Roman, Times,serif'                     => 'Times New Roman, Times, serif',
	'Trebuchet MS, Helvetica, sans-serif'              => 'Trebuchet MS, Helvetica, sans-serif',
	'Verdana, Geneva, sans-serif'                      => 'Verdana, Geneva, sans-serif',
);

function mtnc_get_plugin_options( $is_current = false ) {
	$saved = (array) get_option( 'maintenance_options' );

	if ( ! $is_current ) {
		$options = wp_parse_args( get_option( 'maintenance_options', array() ), mtnc_get_default_array() );
	} else {
		$options = $saved;
	}
	return $options;
}

function mtnc_generate_input_filed( $title, $id, $name, $value, $placeholder = '' ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<input type="text" id="' . esc_attr( $id ) . '" name="lib_options[' . $name . ']" value="' . esc_attr( stripslashes( $value ) ) . '" placeholder="' . esc_attr( $placeholder ) . '"/>';
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_generate_number_filed( $title, $id, $name, $value, $placeholder = '' ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<input type="number" min="0" step="1" pattern="[0-9]{10}" id="' . esc_attr( $id ) . '" name="lib_options[' . $name . ']" value="' . esc_attr( stripslashes( $value ) ) . '" placeholder="' . esc_attr( $placeholder ) . '"/>';
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_generate_textarea_filed( $title, $id, $name, $value ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<textarea name="lib_options[' . $name . ']" id="' . esc_attr( $id ) . '" cols="30" rows="10">' . esc_textarea( $value ) . '</textarea>';
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}


function mtnc_generate_tinymce_filed( $title, $id, $name, $value ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	ob_start();
	wp_editor(
		$value,
		$id,
		array(
			'textarea_name' => 'lib_options[' . $name . ']',
			'teeny'         => 1,
			'media_buttons' => 0,
		)
	);
	$out_filed .= ob_get_contents();
	ob_clean();
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}


function mtnc_generate_check_filed( $title, $label, $id, $name, $value ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<label for=' . esc_attr( $id ) . '>';
	$out_filed .= '<input type="checkbox"  id="' . esc_attr( $id ) . '" name="lib_options[' . $name . ']" value="1" ' . checked( true, $value, false ) . '/>';
	$out_filed .= $label;
	$out_filed .= '</label>';
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_generate_image_filed( $title, $id, $name, $value, $class, $name_btn, $class_btn ) {
	$out_filed = '';

	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<input type="hidden" id="' . esc_attr( $id ) . '" name="lib_options[' . $name . ']" value="' . esc_attr( $value ) . '" />';
	$out_filed .= '<div class="img-container">';
	$url        = '';
	if ( $value !== '' ) {
		$image = wp_get_attachment_image_src( $value, 'full' );
		$url   = esc_url( $image[0] );
	}

	$out_filed .= '<div class="' . esc_attr( $class ) . '" style="background-image:url(' . $url . ')">';
	if ( $value ) {
		$out_filed .= '<input class="button button-primary delete-img remove" type="button" value="x" />';
	}
	$out_filed .= '</div>';
	$out_filed .= '<input type="button" class="' . esc_attr( $class_btn ) . '" value="' . esc_attr( $name_btn ) . '"/>';

	$out_filed .= '</div>';
	$out_filed .= '</fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_get_color_field( $title, $id, $name, $value, $default_color ) {
	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	$out_filed .= '<input type="text" id="' . esc_attr( $id ) . '" name="lib_options[' . $name . ']" data-default-color="' . esc_attr( $default_color ) . '" value="' . wp_kses_post( stripslashes( $value ) ) . '" />';
	$out_filed .= '<fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_get_google_font( $font = null ) {
	$font_params = $full_link = $gg_fonts = '';

	$gg_fonts = json_decode( mtnc_get_google_fonts() );

	if ( property_exists( $gg_fonts, $font ) ) {
		$curr_font = $gg_fonts->{$font};
		if ( ! empty( $curr_font ) ) {
			foreach ( $curr_font->variants as $values ) {
				if ( ! empty( $values->id ) ) {
					$font_params .= $values->id . ',';
				} elseif ( ! empty( $values ) ) {
					$font_params .= $values . ',';
				}
			}

			$font_params = trim( $font_params, ',' );
			$full_link   = $font . ':' . $font_params;
		}
	}

	return $full_link;
}

/*
 * Function get_fonts_field is backward compatibility with Maintenance PRO Version 3.6.2 and below */
function get_fonts_field( $title, $id, $name, $value ) {
	return mtnc_get_fonts_field( $title, $id, $name, $value );
}

function mtnc_get_fonts_field( $title, $id, $name, $value ) {
	global $standart_fonts;
	$out_items = $gg_fonts = '';

	$gg_fonts = json_decode( mtnc_get_google_fonts() );

	$out_filed  = '';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
	$out_filed .= '<td>';
	$out_filed .= '<fieldset>';
	if ( ! empty( $standart_fonts ) ) {
		$out_items .= '<optgroup label="' . __( 'Standard Fonts', 'maintenance' ) . '">';
		foreach ( $standart_fonts as $key => $options ) {
			$out_items .= '<option value="' . $key . '" ' . selected( $value, $key, false ) . '>' . $options . '</option>';
		}
	}

	if ( ! empty( $gg_fonts ) ) {
		$out_items .= '<optgroup label="' . __( 'Google Web Fonts', 'maintenance' ) . '">';
		foreach ( $gg_fonts as $key => $options ) {
			$out_items .= '<option value="' . $key . '" ' . selected( $value, $key, false ) . '>' . $key . '</option>';
		}
	}

	if ( ! empty( $out_items ) ) {
		$out_filed .= '<select class="select2_customize" name="lib_options[' . $name . ']" id="' . esc_attr( $id ) . '">';
		$out_filed .= $out_items;
		$out_filed .= '</select>';
	}
	$out_filed .= '<fieldset>';
	$out_filed .= '</td>';
	$out_filed .= '</tr>';
	return $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_get_fonts_subsets( $title, $id, $name, $value ) {
	global $standart_fonts;
	$out_items = $gg_fonts = $curr_font = $mt_option = '';
	$mt_option = mtnc_get_plugin_options( true );
	$curr_font = esc_attr( $mt_option['body_font_family'] );
	$vars      = 'subsets';

	$gg_fonts = json_decode( mtnc_get_google_fonts(), true );

	if ( ! empty( $gg_fonts ) ) {

		$out_filed  = '';
		$out_filed .= '<tr valign="top">';
		$out_filed .= '<th scope="row">' . esc_attr( $title ) . '</th>';
		$out_filed .= '<td>';
		$out_filed .= '<fieldset>';
		$out_filed .= '<select class="select2_customize" name="lib_options[' . $name . ']" id="' . esc_attr( $id ) . '">';
		if ( ! empty( $gg_fonts[ $curr_font ] ) ) {
			foreach ( $gg_fonts[ $curr_font ]['variants'] as $key => $v ) {
				$out_filed .= '<option value="' . $v . '" ' . selected( $value, $v, false ) . '>' . $v . '</option>';
			}
		}
		$out_filed .= '</select>';

		$out_filed .= '<fieldset>';
		$out_filed .= '</td>';
		$out_filed .= '</tr>';
	}
	return $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_page_create_meta_boxes() {
	global $mtnc_variable;
	add_meta_box( 'mtnc-general', __( 'General Settings', 'maintenance' ), 'mtnc_add_data_fields', $mtnc_variable->options_page, 'normal', 'default' );
	add_meta_box( 'mtnc-css', __( 'Custom CSS', 'maintenance' ), 'mtnc_add_css_fields', $mtnc_variable->options_page, 'normal', 'default' );
	add_meta_box( 'mtnc-excludepages', __( 'Exclude pages from maintenance mode', 'maintenance' ), 'mtnc_add_exclude_pages_fields', $mtnc_variable->options_page, 'normal', 'default' );
}
add_action( 'add_mt_meta_boxes', 'mtnc_page_create_meta_boxes', 10 );

function mtnc_page_create_meta_boxes_widget_pro() {
	global $mtnc_variable;
	add_meta_box( 'promo-extended', __( 'Pro version', 'maintenance' ), 'mtnc_extended_version', $mtnc_variable->options_page, 'side', 'default' );
}
add_action( 'add_mt_meta_boxes', 'mtnc_page_create_meta_boxes_widget_pro', 11 );


function mtnc_page_create_meta_boxes_our_themes() {
	global $mtnc_variable;
	add_meta_box( 'promo-our-themes', __( 'Fruitful Code projects', 'maintenance' ), 'mtnc_our_themes', $mtnc_variable->options_page, 'side', 'default' );
}
add_action( 'add_mt_meta_boxes', 'mtnc_page_create_meta_boxes_our_themes', 12 );

function mtnc_page_create_meta_boxes_widget_support() {
	global $mtnc_variable;
	add_meta_box( 'promo-content', __( 'Support', 'maintenance' ), 'mtnc_contact_support', $mtnc_variable->options_page, 'side', 'default' );
}
add_action( 'add_mt_meta_boxes', 'mtnc_page_create_meta_boxes_widget_support', 13 );

function mtnc_page_create_meta_boxes_improve_translate() {
	global $mtnc_variable;
	add_meta_box( 'promo-translate', __( 'Translation', 'maintenance' ), 'mtnc_improve_translate', $mtnc_variable->options_page, 'side', 'default' );
}
add_action( 'add_mt_meta_boxes', 'mtnc_page_create_meta_boxes_improve_translate', 14 );

function mtnc_add_data_fields( $object, $box ) {
	$mt_option = mtnc_get_plugin_options( true );
	$is_blur   = false;

	/*Deafult Variable*/
	$page_title = $heading = $description = $logo_width = $logo_height = '';

	$allowed_tags = wp_kses_allowed_html( 'post' );
	if ( isset( $mt_option['page_title'] ) ) {
		$page_title = wp_kses( stripslashes( $mt_option['page_title'] ), $allowed_tags );
	}
	if ( isset( $mt_option['heading'] ) ) {
		$heading = wp_kses_post( $mt_option['heading'] );
	}
	if ( isset( $mt_option['description'] ) ) {
		$description = wp_kses( stripslashes( $mt_option['description'] ), $allowed_tags );
	}
	if ( isset( $mt_option['footer_text'] ) ) {
		$footer_text = wp_kses_post( $mt_option['footer_text'] );
	}
	if ( isset( $mt_option['logo_width'] ) ) {
		$logo_width = wp_kses_post( $mt_option['logo_width'] );
	}
	if ( isset( $mt_option['logo_height'] ) ) {
		$logo_height = wp_kses_post( $mt_option['logo_height'] );
	}

	?>
	<table class="form-table">
		<tbody>
		<?php
		mtnc_generate_input_filed( __( 'Page title', 'maintenance' ), 'page_title', 'page_title', $page_title );
		mtnc_generate_input_filed( __( 'Headline', 'maintenance' ), 'heading', 'heading', $heading );
		mtnc_generate_tinymce_filed( __( 'Description', 'maintenance' ), 'description', 'description', $description );
		mtnc_generate_input_filed( __( 'Footer Text', 'maintenance' ), 'footer_text', 'footer_text', $footer_text );
		mtnc_generate_number_filed( __( 'Set Logo width', 'maintenance' ), 'logo_width', 'logo_width', $logo_width );
		mtnc_generate_number_filed( __( 'Set Logo height', 'maintenance' ), 'logo_height', 'logo_height', $logo_height );
		mtnc_generate_image_filed( __( 'Logo', 'maintenance' ), 'logo', 'logo', (int) $mt_option['logo'], 'boxes box-logo', __( 'Upload Logo', 'maintenance' ), 'upload_logo upload_btn button' );
		mtnc_generate_image_filed( __( 'Retina logo', 'maintenance' ), 'retina_logo', 'retina_logo', (int) $mt_option['retina_logo'], 'boxes box-logo', __( 'Upload Retina Logo', 'maintenance' ), 'upload_logo upload_btn button' );
		do_action( 'mtnc_background_field' );
		mtnc_generate_image_filed( __( 'Background image (portrait mode)', 'maintenance' ), 'bg_image_portrait', 'bg_image_portrait', isset( $mt_option['bg_image_portrait'] ) ? (int) $mt_option[ 'bg_image_portrait' ] : '', 'boxes box-logo', __( 'Upload image for portrait device orientation', 'maintenance' ), 'upload_logo upload_btn button' );
		mtnc_generate_image_filed( __( 'Page preloader image', 'maintenance' ), 'preloader_img', 'preloader_img', isset( $mt_option['preloader_img'] ) ? (int) $mt_option['preloader_img'] : '', 'boxes box-logo', __( 'Upload preloader', 'maintenance' ), 'upload_logo upload_btn button' );

		do_action( 'mtnc_color_fields' );
		do_action( 'mtnc_font_fields' );
		mtnc_generate_check_filed( __( '503', 'maintenance' ), __( 'Service temporarily unavailable, Google analytics will be disable.', 'maintenance' ), '503_enabled', '503_enabled', ! empty( $mt_option['503_enabled'] ) );

		$gg_analytics_id = '';
		if ( ! empty( $mt_option['gg_analytics_id'] ) ) {
			$gg_analytics_id = esc_js( $mt_option['gg_analytics_id'] );
		}

		mtnc_generate_input_filed( __( 'Google Analytics ID', 'maintenance' ), 'gg_analytics_id', 'gg_analytics_id', $gg_analytics_id, __( 'UA-XXXXX-X', 'maintenance' ) );
		mtnc_generate_input_filed( __( 'Set blur intensity', 'maintenance' ), 'blur_intensity', 'blur_intensity', (int) $mt_option['blur_intensity'] );

		if ( isset( $mt_option['is_blur'] ) ) {
			if ( $mt_option['is_blur'] ) {
				$is_blur = true;
			}
		}

		mtnc_generate_check_filed( __( 'Apply background blur', 'maintenance' ), '', 'is_blur', 'is_blur', $is_blur );
		mtnc_generate_check_filed( __( 'Enable frontend login', 'maintenance' ), '', 'is_login', 'is_login', isset( $mt_option['is_login'] ) );

		?>
		</tbody>
	</table>
	<?php
}


function mtnc_add_css_fields() {
	$mt_option = mtnc_get_plugin_options( true );
	echo '<table class="form-table">';
	echo '<tbody>';
	mtnc_generate_textarea_filed( __( 'CSS Code', 'maintenance' ), 'custom_css', 'custom_css', wp_kses_stripslashes( $mt_option['custom_css'] ) );
	echo '</tbody>';
	echo '</table>';
}

function mtnc_add_exclude_pages_fields() {
	$mt_option = mtnc_get_plugin_options( true );
	$out_filed = '';

	$post_types = get_post_types(
		array(
			'show_ui' => true,
			'public'  => true,
		),
		'objects'
	);

	$out_filed .= '<table class="form-table">';
	$out_filed .= '<tbody>';
	$out_filed .= '<tr valign="top">';
	$out_filed .= '<th colspan="2" scope="row">' . __( 'Select the page to be displayed:', 'maintenance' ) . '</th>';
	$out_filed .= '</tr>';

	foreach ( $post_types as $post_slug => $type ) {

		if ( ( $post_slug === 'attachment' ) ||
			( $post_slug === 'revision' ) ||
			( $post_slug === 'nav_menu_item' )
		) {
			continue;
		}

		$args = array(
			'posts_per_page' => -1,
			'orderby'        => 'NAME',
			'order'          => 'ASC',
			'post_type'      => $post_slug,
			'post_status'    => 'publish',
		);

		$posts_array = get_posts( $args );
		$db_pages_ex = array();

		if ( ! empty( $posts_array ) ) {

			/*Exclude pages from maintenance mode*/
			if ( ! empty( $mt_option['exclude_pages'] ) && isset( $mt_option['exclude_pages'][ $post_slug ] ) ) {
				$db_pages_ex = $mt_option['exclude_pages'][ $post_slug ];
			}

			$out_filed .= '<tr valign="top">';
			$out_filed .= '<th scope="row">' . $type->labels->name . '</th>';

			$out_filed .= '<fieldset>';
			$out_filed .= '<td>';

			$out_filed .= '<select id="exclude-pages-' . $post_slug . '" name="lib_options[exclude_pages][' . $post_slug . '][]" style="width:100%;" class="exclude-pages multiple-select-mt" multiple="multiple">';

			foreach ( $posts_array as $post_values ) {
				$current = null;
				if ( ! empty( $db_pages_ex ) && in_array( $post_values->ID, $db_pages_ex, false ) ) {
					$current = $post_values->ID;
				}
				$selected   = selected( $current, $post_values->ID, false );
				$out_filed .= '<option value="' . $post_values->ID . '" ' . $selected . '>' . $post_values->post_title . '</option>';
			}

			$out_filed .= '</select>';

			$out_filed .= '</fieldset>';
			$out_filed .= '</td>';
			$out_filed .= '</tr>';
		}
	}

	$out_filed .= '</tbody>';
	$out_filed .= '</table>';

	echo $out_filed; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_get_background_fileds_action() {
	$mt_option = mtnc_get_plugin_options( true );
	mtnc_generate_image_filed( __( 'Background image', 'maintenance' ), 'body_bg', 'body_bg', esc_attr( $mt_option['body_bg'] ), 'boxes box-bg', __( 'Upload Background', 'maintenance' ), 'upload_background upload_btn button' );
}
add_action( 'mtnc_background_field', 'mtnc_get_background_fileds_action', 10 );

function mtnc_get_color_fileds_action() {
	$mt_option = mtnc_get_plugin_options( true );
	mtnc_get_color_field( __( 'Background color', 'maintenance' ), 'body_bg_color', 'body_bg_color', esc_attr( $mt_option['body_bg_color'] ), '#111111' );
	mtnc_get_color_field( __( 'Font color', 'maintenance' ), 'font_color', 'font_color', esc_attr( $mt_option['font_color'] ), '#ffffff' );
	mtnc_get_color_field( __( 'Login block background color', 'maintenance' ), 'controls_bg_color', 'controls_bg_color', isset( $mt_option['controls_bg_color'] ) ? esc_attr( $mt_option['controls_bg_color'] ) : '', '#000000' );
}
add_action( 'mtnc_color_fields', 'mtnc_get_color_fileds_action', 10 );


function mtnc_get_font_fileds_action() {
	$mt_option = mtnc_get_plugin_options( true );
	echo mtnc_get_fonts_field( __( 'Font family', 'maintenance' ), 'body_font_family', 'body_font_family', esc_attr( $mt_option['body_font_family'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput
	$subset = '';

	if ( ! empty( $mt_option['body_font_subset'] ) ) {
		$subset = $mt_option['body_font_subset'];
	}
	echo mtnc_get_fonts_subsets( __( 'Subsets', 'maintenance' ), 'body_font_subset', 'body_font_subset', esc_attr( $subset ) ); // phpcs:ignore WordPress.Security.EscapeOutput
}
add_action( 'mtnc_font_fields', 'mtnc_get_font_fileds_action', 10 );


function mtnc_contact_support() {
	$promo_text  = '';
	$promo_text .= '<div class="sidebar-promo" id="sidebar-promo">';
	$promo_text .= '<h4 class="support">' . __( 'Have any questions?', 'maintenance' ) . '</h3>';
	$promo_text .= '<p>' . sprintf(
		__( 'You may find answers to your questions at <a target="_blank" href="http://support.fruitfulcode.com/hc/en-us/sections/200406386">support forum</a><br>You may  <a target="_blank" href="http://support.fruitfulcode.com/hc/en-us/requests/new">contact us</a> with customization requests and suggestions.<br> Please visit our website to learn about us and our services <a href="%1$s" title="%2$s">%2$s</a>', 'maintenance' ),
		'http://fruitfulcode.com',
		'fruitfulcode.com'
	) . '</p>';
	$promo_text .= '</div>';
	echo $promo_text; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_improve_translate() {
	$promo_text  = '';
	$promo_text .= '<div class="sidebar-promo" id="sidebar-translate">';
	$promo_text .= '<h4 class="translate">' . __( 'This plugin is translation friendly', 'maintenance' ) . '</h3>';
	$promo_text .= '<p>' . sprintf(
		__( 'Want to improve translation or make one for your native language? <a href="%1$s" title="%2$s">%2$s</a>', 'maintenance' ),
		'http://support.fruitfulcode.com/hc/en-us/articles/204268628',
		__( 'Follow this tutorial', 'maintenance' )
	) . '</p>';
	$promo_text .= '</div>';
	echo $promo_text; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_our_themes() {
	$promo_text  = '';
	$promo_text .= '<div class="sidebar-promo" id="sidebar-themes">';
	$promo_text .= '<h4 class="themes">' . __( 'Premium WordPress themes', 'maintenance' ) . '</h3>';

	$rand_banner = wp_rand( 0, 2 );

	$class = 'anaglyph-theme';
	$link  = 'http://themeforest.net/item/anaglyph-one-page-multi-page-wordpress-theme/7874320?ref=fruitfulcode';
	$title = __( 'ANAGLYPH - One page / Multi Page WordPress Theme', 'maintenance' );

	if ( $rand_banner === 1 ) {
		$class = 'lovely-theme';
		$link  = 'http://themeforest.net/item/lovely-simple-elegant-wordpress-theme/8428221?ref=fruitfulcode';
		$title = __( 'Love.ly - Simple & Elegant WordPress theme', 'maintenance' );
	}

	if ( $rand_banner === 2 ) {
		$class = 'zoner-theme';
		$link  = 'http://themeforest.net/item/zoner-real-estate-wordpress-theme/9099226?ref=fruitfulcode';
		$title = __( 'Zoner - Real Estate WordPress theme', 'maintenance' );
	}

	$promo_text .= '<p>' . sprintf( '<a target="_blank" class="%1s" href="%2s" title="%3s"></a>', $class, $link, $title ) . '</p>';

	$promo_text .= '</div>';
	echo $promo_text; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_extended_version() {
	$promo_text  = '';
	$promo_text .= '<div class="sidebar-promo worker" id="sidebar-promo">';
	$promo_text .= '<h4 class="star">' . __( 'Extended functionality', 'maintenance' ) . '</h3>';
	$promo_text .= '<p>' . sprintf(
		__( 'Purchase <a href="http://codecanyon.net/item/maintenance-wordpress-plugin/2781350?ref=fruitfulcode" target="_blank">PRO</a> version  with extended functionality. %1$s If you like our plugin please <a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/maintenance?filter=5">rate it</a>, <a title="leave feedbacks" href="%2$s" target="_blank">leave feedbacks</a>.', 'maintenance' ),
		'<br />',
		'http://wordpress.org/support/view/plugin-reviews/maintenance'
	) . '</p>';
	$promo_text .= sprintf(
		'<a class="button button-primary" title="%1$s" href="%2$s" target="_blank">%1$s</a>',
		__( 'Demo website', 'maintenance' ),
		'http://plugins.fruitfulcode.com/maintenance/'
	);
	$promo_text .= '</div>';
	echo $promo_text; // phpcs:ignore WordPress.Security.EscapeOutput
}

function mtnc_cur_page_url() {
	$page_url = 'http';
	if ( isset( $_SERVER['HTTPS'] ) ) {
		$page_url .= 's';}
	$page_url .= '://';
	if ( isset( $_SERVER['SERVER_PORT'] ) && $_SERVER['SERVER_PORT'] !== '80' ) {
		$page_url .= wp_unslash( $_SERVER['SERVER_NAME'] ) . ':' . wp_unslash( $_SERVER['SERVER_PORT'] ) . wp_unslash( $_SERVER['REQUEST_URI'] );
	} else {
		$page_url .= wp_unslash( $_SERVER['SERVER_NAME'] ) . wp_unslash( $_SERVER['REQUEST_URI'] );
	}
	return $page_url;
}

function mtnc_check_exclude() {
	global $mt_options, $post;
	$mt_options = mtnc_get_plugin_options( true );
	$is_skip    = false;
	$cur_url    = mtnc_cur_page_url();
	if ( is_page() || is_single() ) {
		$curr_id = $post->ID;
	} else {
		if ( is_home() ) {
			$blog_id = get_option( 'page_for_posts' );
			if ( $blog_id ) {
				$curr_id = $blog_id;
			}
		}

		if ( is_front_page() ) {
			$front_page_id = get_option( 'show_on_front' );
			if ( $front_page_id ) {
				$curr_id = $front_page_id;
			}
		}
	}

	if ( isset( $mt_options['exclude_pages'] ) && ! empty( $mt_options['exclude_pages'] ) ) {
		$exlude_objs = $mt_options['exclude_pages'];
		foreach ( $exlude_objs as $objs_id ) {
			foreach ( $objs_id as $obj_id ) {
				if ( $curr_id === (int) $obj_id ) {
					$is_skip = true;
					break;
				}
			}
		}
	}

	return $is_skip;
}


function mtnc_load_maintenance_page( $original_template ) {
	global $mt_options;

	$v_curr_date_start = $v_curr_date_end = $v_curr_time = '';
	$vdate_start       = $vdate_end = date_i18n( 'Y-m-d', strtotime( current_time( 'mysql', 0 ) ) );
	$vtime_start       = date_i18n( 'h:i:s A', strtotime( '01:00:00 am' ) );
	$vtime_end         = date_i18n( 'h:i:s A', strtotime( '12:59:59 pm' ) );

	if ( ! is_user_logged_in() ) {
		if ( ! empty( $mt_options['state'] ) ) {

			if ( ! empty( $mt_options['expiry_date_start'] ) ) {
				$vdate_start = $mt_options['expiry_date_start'];
			}
			if ( ! empty( $mt_options['expiry_date_end'] ) ) {
				$vdate_end = $mt_options['expiry_date_end'];
			}
			if ( ! empty( $mt_options['expiry_time_start'] ) ) {
				$vtime_start = $mt_options['expiry_time_start'];
			}
			if ( ! empty( $mt_options['expiry_time_end'] ) ) {
				$vtime_end = $mt_options['expiry_time_end'];
			}

			$v_curr_time = strtotime( current_time( 'mysql', 0 ) );

			$v_curr_date_start = strtotime( $vdate_start . ' ' . $vtime_start );
			$v_curr_date_end   = strtotime( $vdate_end . ' ' . $vtime_end );

			if ( mtnc_check_exclude() ) {
				return $original_template;
			}

			if ( ( $v_curr_time < $v_curr_date_start ) || ( $v_curr_time > $v_curr_date_end ) ) {
				if ( ! empty( $mt_options['is_down'] ) ) { // is down - is flag for "Open website after countdown expired"
					return $original_template;
				}
			}
		} else {
			return $original_template;
		}

		if ( file_exists( MTNC_LOAD . 'index.php' ) ) {
			add_filter( 'script_loader_tag', 'mtnc_defer_scripts', 10, 2 );
			return MTNC_LOAD . 'index.php';
		} else {
			return $original_template;
		}
	} else {
		return $original_template;
	}
}

function mtnc_defer_scripts( $tag, $handle ) {
	if ( strpos( $handle, '_ie' ) !== 0 ) {
		return $tag;
	}
	return str_replace( ' src', ' defer="defer" src', $tag );
}

function mtnc_metaboxes_scripts() {
	global $mtnc_variable;
	?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function() {
			jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			postboxes.add_postbox_toggles( '<?php echo esc_js( $mtnc_variable->options_page ); ?>' );
		});
		//]]>
	</script>
	<?php
}

function mtnc_add_toolbar_items() {
	global $wp_admin_bar, $wpdb;
	$mt_options = mtnc_get_plugin_options( true );
	$check      = '';
	if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
		return;
	}
	$url_to = admin_url( 'admin.php?page=maintenance' );

	if ( $mt_options['state'] ) {
		$check = 'On';
	} else {
		$check = 'Off';
	}
	$wp_admin_bar->add_menu(
		array(
			'id'    => 'maintenance_options',
			'title' => __( 'Maintenance', 'maintenance' ) . __( ' is ', 'maintenance' ) . $check,
			'href'  => $url_to,
			'meta'  => array(
				'title' => __(
					'Maintenance',
					'maintenance'
				) . __(
					' is ',
					'maintenance'
				) . $check,
			),
		)
	);
}


function mtnc_hex2rgb( $hex ) {
	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) === 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
	return implode( ',', $rgb );
}


function mtnc_insert_attach_sample_files() {
	global $wpdb;

	$title            = '';
	$attach_id        = 0;
	$is_attach_exists = $wpdb->get_results( "SELECT p.ID FROM $wpdb->posts p WHERE  p.post_title LIKE '%mt-sample-background%'", OBJECT );

	if ( ! empty( $is_attach_exists ) ) {
		$attach_id = current( $is_attach_exists )->ID;
	} else {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$upload_dir   = wp_upload_dir();
		$image_url    = MTNC_URI . 'images/mt-sample-background.jpg';
		$file_name    = basename( $image_url );
		$file_content = wp_remote_get( $image_url );
		$upload       = wp_upload_bits( $file_name, null, $file_content['body'], current_time( 'mysql', 0 ) );

		if ( ! $upload['error'] ) {
			$title = preg_replace( '/\.[^.]+$/', '', $file_name );

			$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );
			$attachment  = array(
				'guid'           => $upload['url'],
				'post_mime_type' => $wp_filetype['type'],
				'post_title'     => $title,
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			$attach_id   = wp_insert_attachment( $attachment, $upload['file'] );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
			wp_update_attachment_metadata( $attach_id, $attach_data );

		}
	}

	if ( ! empty( $attach_id ) ) {
		return $attach_id;
	} else {
		return '';
	}
}

function mtnc_get_default_array() {

	$defaults = array(
		'state'             => true,
		'page_title'        => __( 'Website is under construction', 'maintenance' ),
		'heading'           => __( 'Maintenance mode is on', 'maintenance' ),
		'description'       => __( 'Website will be available soon', 'maintenance' ),
		'footer_text'       => '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ),
		'logo_width'        => 220,
		'logo_height'       => '',
		'logo'              => '',
		'retina_logo'       => '',
		'body_bg'           => mtnc_insert_attach_sample_files(),
		'bg_image_portrait' => '',
		'preloader_img'     => '',
		'body_bg_color'     => '#111111',
		'controls_bg_color' => '#111111',
		'font_color'        => '#ffffff',
		'body_font_family'  => 'Open Sans',
		'body_font_subset'  => 'Latin',
		'is_blur'           => false,
		'blur_intensity'    => 5,
		'503_enabled'       => false,
		'gg_analytics_id'   => '',
		'is_login'          => true,
		'custom_css'        => '',
		'exclude_pages'     => '',
	);
	return apply_filters( 'mtnc_get_default_array', $defaults );
}

if ( ! function_exists( 'mtnc_get_google_fonts' ) ) {
	function mtnc_get_google_fonts() {
		$gg_fonts = wp_remote_get( MTNC_URI . 'includes/fonts/googlefonts.json' );
		return $gg_fonts['body'];
	}
}
