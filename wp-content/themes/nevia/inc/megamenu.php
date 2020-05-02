<?php

global $haflings;

 $haflings = array(
    'glass',
    'music',
    'search',
    'envelope',
    'heart',
    'star',
    'star-empty',
    'user',
    'film',
    'th-large',
    'th',
    'th-list',
    'ok',
    'remove',
    'zoom-in',
    'zoom-out',
    'off',
    'signal',
    'cog',
    'trash',
    'home',
    'file',
    'time',
    'road',
    'download-alt',
    'download',
    'upload',
    'inbox',
    'play-circle',
    'repeat',
    'refresh',
    'list-alt',
    'lock',
    'flag',
    'headphones',
    'volume-off',
    'volume-down',
    'volume-up',
    'qrcode',
    'barcode',
    'tag',
    'tags',
    'book',
    'bookmark',
    'print',
    'camera',
    'font',
    'bold',
    'italic',
    'text-height',
    'text-width',
    'align-left',
    'align-center',
    'align-right',
    'align-justify',
    'list',
    'indent-left',
    'indent-right',
    'facetime-video',
    'picture',
    'pencil',
    'map-marker',
    'adjust',
    'tint',
    'edit',
    'share',
    'check',
    'move',
    'step-backward',
    'fast-backward',
    'backward',
    'play',
    'pause',
    'stop',
    'forward',
    'fast-forward',
    'step-forward',
    'eject',
    'chevron-left',
    'chevron-right',
    'plus-sign',
    'minus-sign',
    'remove-sign',
    'ok-sign',
    'question-sign',
    'info-sign',
    'screenshot',
    'remove-circle',
    'ok-circle',
    'ban-circle',
    'arrow-left',
    'arrow-right',
    'arrow-up',
    'arrow-down',
    'share-alt',
    'resize-full',
    'resize-small',
    'plus',
    'minus',
    'asterisk',
    'exclamation-sign',
    'gift',
    'leaf',
    'fire',
    'eye-open',
    'eye-close',
    'warning-sign',
    'plane',
    'calendar',
    'comments',
    'magnet',
    'chevron-up',
    'chevron-down',
    'retweet',
    'shopping-cart',
    'folder-close',
    'folder-open',
    'resize-vertical',
    'resize-horizontal',
    'hdd',
    'bullhorn',
    'bell',
    'certificate',
    'thumbs-up',
    'thumbs-down',
    'hand-right',
    'hand-left',
    'hand-top',
    'hand-down',
    'circle-arrow-right',
    'circle-arrow-left',
    'circle-arrow-top',
    'circle-arrow-down',
    'globe',
    'wrench',
    'tasks',
    'filter',
    'briefcase',
    'fullscreen',
    'dashboard',
    'paperclip',
    'heart-empty',
    'link',
    'phone',
    'pushpin',
    'euro',
    'usd',
    'gbp',
    'sort',
    'sort-by-alphabet',
    'sort-by-alphabet-alt',
    'sort-by-order',
    'sort-by-order-alt',
    'sort-by-attributes',
    'sort-by-attributes-alt',
    'unchecked',
    'expand',
    'collapse',
    'collapse-top'
    );
# Custom walker class for the wp_nav_menu
class my_footer_menu_walker extends Walker
{
    var $item_count = 0;
    /**
    * @see Walker::$tree_type
    * @since 3.0.0
    * @var string
    */
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );


    var $colmenu = 0;

    private $curItem;
    /**
    * @see Walker::$db_fields
    * @since 3.0.0
    * @todo Decouple this.
    * @var array
    */
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    /**
    * @see Walker::start_lvl()
    * @since 3.0.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param int $depth Depth of page. Used for padding.
    */
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $id = $this->curItem->ID;
        $colnr = get_post_meta( $id, '_menu-item-columnscont', true);

        if($depth == 1 && $this->colmenu != '') {
            $output .= "\n$indent<ol>\n";
        } else {
            if($this->colmenu != '') {
                $output .= "\n$indent<ul class=\"cols$colnr\">\n";
            } else {
               $output .= "\n$indent<ul class=\"sub-menu\">\n";
            }
        }
    }

    /**
    * @see Walker::end_lvl()
    * @since 3.0.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param int $depth Depth of page. Used for padding.
    */
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        if($depth == 1 && $this->colmenu != '') {
            $output .= "\n$indent</ol>\n";
        } else {
            $output .= "$indent</ul>\n";
        }

    }

    /**
    * @see Walker::start_el()
    * @since 3.0.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param object $item Menu item data object.
    * @param int $depth Depth of menu item. Used for padding.
    * @param int $current_page Menu item ID.
    * @param object $args
    */
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query, $item_count;
        $this->curItem = $item;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        if($depth === 0) {
            $this->colmenu = get_post_meta( $item->ID, '_menu-item-colmenu', true);
        }
        if($depth === 1 && $this->colmenu != '') {
            $classes[] = 'col'.get_post_meta( $item->ID, '_menu-item-columns', true);
        }
        # END adding column classes

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

        # A little hack to disable clicking on links
        $is_clickable = get_post_meta($item->object_id, 'link_disabled', true);
        $jsarg = ($is_clickable == '1') ? 'onclick="return false;"' : '';
        $args = (object) $args;
        $item_output = $args->before;
        $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
        $icon = get_post_meta( $item->ID, '_menu-item-pureicon', true);
        if($depth === 1 && $this->colmenu != '' ) {
            if($linkrole == 'titleh5' ) {
                $item_output .= '<h5>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</h5>';
            } else if($linkrole == 'titleh4') {
                $item_output .= '<h4>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</h4>';
            } else if($linkrole == 'paragraph') {
                $content = get_post_meta( $item->ID, '_menu-item-html', true);
                //$item_output .= '<p>';
                $item_output .= do_shortcode($content);
                //$item_output .= '</p>';
            } else {
                $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
            }
        } elseif( $depth === 0 ) {
            if( !empty($icon) && $icon != 'none') {
                    $item_output .= '<a'. $attributes .' '.$jsarg.'><i class="halflings white '.$icon.'"></i> ';
                    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                    $item_output .= '</a>';
                } else {
                    $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                    $item_output .= '</a>';
                }
        } else {
                $item_output .= '<a'. $attributes .' '.$jsarg.'>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
        }
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

        $item_count ++;
    }

    /**
    * @see Walker::end_el()
    * @since 3.0.0
    *
    * @param string $output Passed by reference. Used to append additional content.
    * @param object $item Page data object. Not used.
    * @param int $depth Depth of page. Not Used.
    */
    function end_el(&$output, $item, $depth) {
        $output .= "</li>\n";
    }
}




/**
 * Walker_Nav_Menu class copied from
 */

class purethemes_walker_nav_edit extends Walker_Nav_Menu {
    /**
     * @see Walker_Nav_Menu::start_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function start_lvl(&$output) {}

    /**
     * @see Walker_Nav_Menu::end_lvl()
     * @since 3.0.0
     *
     * @param string $output Passed by reference.
     */
    function end_lvl(&$output) {
    }

    /**
     * @see Walker::start_el()
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param object $args
     */
    function start_el(&$output, $item, $depth, $args) {
        global $_wp_nav_menu_max_depth;
        $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        ob_start();
        $item_id = esc_attr( $item->ID );
        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        $original_title = '';
        if ( 'taxonomy' == $item->type ) {
            $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            if ( is_wp_error( $original_title ) )
                $original_title = false;
        } elseif ( 'post_type' == $item->type ) {
            $original_object = get_post( $item->object_id );
            $original_title = $original_object->post_title;
        }

        $classes = array(
            'menu-item menu-item-depth-' . $depth,
            'menu-item-' . esc_attr( $item->object ),
            'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
        );

        $title = $item->title;

        if ( ! empty( $item->_invalid ) ) {
            $classes[] = 'menu-item-invalid';
            /* translators: %s: title of menu item which is invalid */
            $title = sprintf( __( '%s (Invalid)' ), $item->title );
        } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
            $classes[] = 'pending';
            /* translators: %s: title of menu item in draft status */
            $title = sprintf( __('%s (Pending)'), $item->title );
        }

        $title = empty( $item->label ) ? $title : $item->label;

        ?>
        <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
            <dl class="menu-item-bar">
                <dt class="menu-item-handle">
                    <span class="item-title"><?php echo esc_html( $title ); ?></span>
                    <span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-up-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                            |
                            <a href="<?php
                                echo wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'action' => 'move-down-menu-item',
                                            'menu-item' => $item_id,
                                        ),
                                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                    ),
                                    'move-menu_item'
                                );
                            ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                            echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"><?php _e( 'Edit Menu Item' ); ?></a>
                    </span>
                </dt>
            </dl>

            <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                <?php if( 'custom' == $item->type ) : ?>
                    <p class="field-url description description-wide">
                        <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                            <?php _e( 'URL' ); ?><br />
                            <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                        </label>
                    </p>
                <?php endif; ?>
                <p class="description description-thin">
                    <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <?php _e( 'Navigation Label' ); ?><br />
                        <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                    </label>
                </p>
                <p class="description description-thin">
                    <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                        <?php _e( 'Title Attribute' ); ?><br />
                        <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                    </label>
                </p>
                <p class="field-link-target description">
                    <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                        <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                        <?php _e( 'Open link in a new window/tab' ); ?>
                    </label>
                </p>
                <p class="field-css-classes description description-thin">
                    <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                        <?php _e( 'CSS Classes (optional)' ); ?><br />
                        <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                    </label>
                </p>
                <p class="field-xfn description description-thin">
                    <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                        <?php _e( 'Link Relationship (XFN)' ); ?><br />
                        <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                    </label>
                </p>
                <p class="field-description description description-wide">
                    <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                        <?php _e( 'Description' ); ?><br />
                        <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                        <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
                    </label>
                </p>

                <!-- custom element for columns number -->

                <?php if($depth === 0) { ?>
                 <p class="field-menu-columnscont description description-thin">
                    <label for="edit-menu-item-columnscont-<?php echo $item_id; ?>"><?php _e( 'Width of container for submenu','purepress' ); ?>
                        <select id="edit-menu-item-columnscont-<?php echo $item_id; ?>" class="widefat edit-menu-item-columnscont" name="menu-item-columnscont[<?php echo $item_id; ?>]">
                            <?php  $col = get_post_meta( $item->ID, '_menu-item-columnscont', true); ?>
                            <option value="1" <?php if($col == '1') { echo 'selected'; } ?>><?php _e('1 column','purepress'); ?></option>
                            <option value="2" <?php if($col == '2') { echo 'selected'; } ?>><?php _e('2 columns','purepress'); ?></option>
                            <option value="3" <?php if($col == '3') { echo 'selected'; } ?>><?php _e('3 columns','purepress'); ?></option>
                            <option value="4" <?php if($col == '4') { echo 'selected'; } ?>><?php _e('4 columns','purepress'); ?></option>
                            <option value="5" <?php if($col == '5') { echo 'selected'; } ?>><?php _e('5 columns','purepress'); ?></option>
                        </select>
                    </label>
                </p>
                <p class="field-colmenu description">
                    <label for="edit-menu-item-colmenu-<?php echo $item_id; ?>">
                        <?php $statuscheckbox=''; $colmenu = get_post_meta( $item->ID, '_menu-item-colmenu', true); if($colmenu != "") $statuscheckbox = "checked='checked'";?>
                        <input type="checkbox" id="edit-menu-item-colmenu-<?php echo $item_id; ?>" value="_blank" name="menu-item-colmenu[<?php echo $item_id; ?>]"<?php echo $statuscheckbox; ?> />
                        <?php _e( 'Enable megamenu','purepress' ); ?>
                    </label>
                </p>
                <p class="field-menu-pureicon description description-thin">
                    <label for="edit-menu-item-pureicon-<?php echo $item_id; ?>"><?php _e( 'Menu icon','purepress' ); ?>
                        <select id="edit-menu-item-pureicon-<?php echo $item_id; ?>" class="widefat edit-menu-item-pureicon" name="menu-item-pureicon[<?php echo $item_id; ?>]">
                            <option value="none" <?php if(empty($iconsel) || $iconsel == 'none') { echo 'selected'; } ?>>Disable icon</option>
                            <?php
                            global $haflings;
                            $iconsel = get_post_meta( $item->ID, '_menu-item-pureicon', true);
                            foreach ($haflings as $icon ) { ?>
                                <option value="<?php echo $icon; ?>" <?php if($iconsel == $icon) { echo 'selected'; } ?>><?php echo $icon; ?></option>
                             <?php } ?>
                        </select>
                    </label>
                </p>
                <?php } ?>
                <?php if($depth === 1) { ?>
                <p class="field-menu-columns description description-thin">
                    <label for="edit-menu-item-columns-<?php echo $item_id; ?>"><?php _e( 'Element width','purepress' ); ?>
                        <select id="edit-menu-item-columns-<?php echo $item_id; ?>" class="widefat edit-menu-item-columns" name="menu-item-columns[<?php echo $item_id; ?>]">
                            <?php  $col = get_post_meta( $item->ID, '_menu-item-columns', true); ?>
                            <option value="1" <?php if($col == '1') { echo 'selected'; } ?>><?php _e('1 column','purepress'); ?></option>
                            <option value="2" <?php if($col == '2') { echo 'selected'; } ?>><?php _e('2 columns','purepress'); ?></option>
                            <option value="3" <?php if($col == '3') { echo 'selected'; } ?>><?php _e('3 columns','purepress'); ?></option>
                            <option value="4" <?php if($col == '4') { echo 'selected'; } ?>><?php _e('4 columns','purepress'); ?></option>
                            <option value="5" <?php if($col == '5') { echo 'selected'; } ?>><?php _e('5 columns','purepress'); ?></option>
                        </select>
                    </label>
                </p>
                <p class="field-menu-linkrole description description-thin">
                    <label for="edit-menu-item-linkrole-<?php echo $item_id; ?>"><?php _e( 'Act as link or title','purepress' ); ?>
                        <select id="edit-menu-item-linkrole-<?php echo $item_id; ?>" class="widefat edit-menu-item-linkrole" name="menu-item-linkrole[<?php echo $item_id; ?>]">
                            <?php  $val = get_post_meta( $item->ID, '_menu-item-linkrole', true); ?>
                            <option value="link" <?php if($val == 'link') { echo 'selected'; } ?>><?php _e('Link'); ?></option>
                            <option value="titleh4" <?php if($val == 'titleh4') { echo 'selected'; } ?>><?php _e('Title (h4)','purepress'); ?></option>
                            <option value="titleh5" <?php if($val == 'titleh5') { echo 'selected'; } ?>><?php _e('Title (h5)','purepress'); ?></option>
                            <option value="paragraph" <?php if($val == 'paragraph') { echo 'selected'; } ?>><?php _e('Paragraph','purepress'); ?></option>
                        </select>
                    </label>
                </p>
                <p class="field-menu-linkrole description description-wide">
                    <label for="edit-menu-item-html-<?php echo $item_id; ?>"><?php _e( 'Custom html text','purepress' ); ?>
                         <?php $content = get_post_meta( $item->ID, '_menu-item-html', true); ?>
                         <textarea id="edit-menu-item-html-<?php echo $item_id; ?>" class="widefat edit-menu-item-html" rows="3" cols="20" name="menu-item-html[<?php echo $item_id; ?>]"><?php echo $content; // textarea_escaped ?></textarea>
                    </label>
                </p>
                <?php } ?>
                <!-- eof custom element for columns number -->
                <div class="menu-item-actions description-wide submitbox">
                    <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                        <p class="link-to-original">
                            <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                        </p>
                    <?php endif; ?>
                    <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                    echo wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'delete-menu-item',
                                'menu-item' => $item_id,
                            ),
                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                        ),
                        'delete-menu_item_' . $item_id
                    ); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                        ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
                </div>

                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
            </div><!-- .menu-item-settings-->
            <ul class="menu-item-transport"></ul>
        <?php
        $output .= ob_get_clean();
    }
}

        function modify_backend_walker($name)
        {
            return 'purethemes_walker_nav_edit';
        }

        /*
         * Save and Update the Custom Navigation Menu Item Properties by checking all $_POST vars with the name of $check
         * @param int $menu_id
         * @param int $menu_item_db
         */
        function update_menu($menu_id, $menu_item_db)
        {
            $check = array('columns','linkrole','colmenu', 'columnscont','pureicon','html' );

            foreach ( $check as $key )
            {
                if(!isset($_POST['menu-item-'.$key][$menu_item_db]))
                {
                    $_POST['menu-item-'.$key][$menu_item_db] = "";
                }

                $value = $_POST['menu-item-'.$key][$menu_item_db];
                update_post_meta( $menu_item_db, '_menu-item-'.$key, $value );
            }
        }

add_action( 'wp_update_nav_menu_item', 'update_menu', 100, 3);
add_filter( 'wp_edit_nav_menu_walker', 'modify_backend_walker' , 100);



//responsive walker

class Walker_Nav_Menu_Dropdown extends Walker_Nav_Menu{
    var $to_depth = -1;
    private $curItem;
    function start_lvl(&$output, $depth){
             $id = $this->curItem->ID;
             $linkrole = get_post_meta( $id, '_menu-item-linkrole', true);
             $types  = array( 'paragraph', 'titleh4', 'titleh5' );
             if(!in_array( $linkrole, $types )) {

              $output .= '</option>';
          }
     }

  function end_lvl(&$output, $depth){
      $indent = str_repeat("\t", $depth); // don't output children closing tag
  }

  function start_el(&$output, $item, $depth, $args){
      $this->curItem = $item;
      $indent = ( $depth ) ? str_repeat( "&nbsp;", $depth * 4 ) : '';
      $class_names = $value = '';
      $classes = empty( $item->classes ) ? array() : (array) $item->classes;
      $classes[] = 'menu-item-' . $item->ID;
      $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
      $class_names = ' class="' . esc_attr( $class_names ) . '"';
      $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
      $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
      $value = ' value="'. $item->url .'"';
      $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
      $types  = array( 'paragraph', 'titleh4', 'titleh5' );
      $args = (object) $args;
      if(!in_array( $linkrole, $types )) {
          $output .= '<option'.$id.$value.$class_names.'>';
          $item_output = $args->before;
          $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
          $output .= $indent.$item_output;
      }
  }

  function end_el(&$output, $item, $depth){
     $linkrole = get_post_meta( $item->ID, '_menu-item-linkrole', true);
     if($linkrole != 'paragraph' || $linkrole != 'titleh4' || $linkrole != 'titleh5') {
      if(substr($output, -9) != '</option>') {
            $output .= "</option>"; // replace closing </li> with the option tag

        }
        }
    }
}

?>