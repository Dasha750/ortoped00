<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Nevia
 * @since Nevia 1.0
 */

if ( ! function_exists( 'nevia_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Nevia 1.0
 */
function nevia_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'nevia' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'purepress' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'purepress' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'purepress' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'purepress' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // nevia_content_nav

if ( ! function_exists( 'nevia_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Nevia 1.0
 */
function nevia_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'nevia' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'purepress' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="avatar"><?php echo get_avatar( $comment, 60 ); ?></div>
				<div class="comment-des"><div class="arrow-comment"></div>
				<div class="comment-by">
					<?php printf( '<strong>%s</strong>', get_comment_author_link() ); ?>
					<span class="reply"><span style="color:#ccc">/ </span><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
					<span class="date">	<?php printf( __( '%1$s at %2$s', 'purepress' ), get_comment_date(), get_comment_time() ); ?></span>
				</div>
				<?php comment_text(); ?>
				</div>
				<div class="clearfix"></div>
		</div><!-- #comment-## -->
	<?php
			break;
	endswitch;
}
endif; // ends check for nevia_comment()


add_filter('comment_form_defaults', 'pp_comment_defaults');
function pp_comment_defaults($defaults) {
    $req = get_option('require_name_email');
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->display_name;
    $defaults = array(
        'fields' => array(
            'author' => '<div><label for="author">' . __('Name','purepress') . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' . '<input id="author" name="author"  type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
            'url' => '<div><label for="url">' . __('Email','purepress') . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' . '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
            'email' => '<div><label for="email">' . __('Url','purepress') . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' . '<input id="url" name="url" type="text"   value="' . esc_attr($commenter['comment_author_url']) . '" size="30"' . $aria_req . ' /></div>'
            ),
        'comment_field' => '<div><label for="comment">' . __('Add Comment', 'purepress') . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>',
        'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p>',
        'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
        'comment_notes_before' => '<fieldset>',
        'comment_notes_after' => '</fieldset>',
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => __('Leave a Comment','purepress'),
        'title_reply_to' => __('Leave a Reply %s','purepress'),
        'cancel_reply_link' => __('Cancel reply','purepress'),
        'label_submit' => __('Add Comment','purepress'),
        );

return $defaults;
}




if ( ! function_exists( 'nevia_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Nevia 1.0
 */
function nevia_posted_on() {
if(is_single()) {
  $metas = ot_get_option('pp_meta_single',array());
  if (in_array("author", $metas)) {
    echo ' <span><i class="halflings user"></i>'.__('By','purepress').' <a class="author-link" href="'.get_author_posts_url(get_the_author_meta('ID' )).'">'; the_author_meta('display_name'); echo'</a></span>';
  }
  if (in_array("cat", $metas)) {
    if(has_category()) { echo '<span><i class="halflings tag"></i>'; the_category(', '); echo '</span>'; }
  }
  if (in_array("tags", $metas)) {
    if(has_tag()) { echo '<span><i class="halflings tags"></i>'; the_tags('',', '); echo '</span>'; }
  }
  if (in_array("com", $metas)) {
    echo '<span><i class="halflings comments"></i>'; comments_popup_link( __('With 0 comments','purepress'), __('With 1 comment','purepress'), __('With % comments','purepress'), 'comments-link', __('Comments are off','purepress')); echo '</span>';
  }
} else {
  $metas = ot_get_option('pp_meta_blog',array());
  if (in_array("author", $metas)) {
    echo ' <span><i class="halflings user"></i>'.__('By','purepress').' <a class="author-link" href="'.get_author_posts_url(get_the_author_meta('ID' )).'">'; the_author_meta('display_name'); echo'</a></span>';
  }
  if (in_array("cat", $metas)) {
    if(has_category()) { echo '<span><i class="halflings tag"></i>'; the_category(', '); echo '</span>'; }
  }
  if (in_array("tags", $metas)) {
    if(has_tag()) { echo '<span><i class="halflings tags"></i>'; the_tags('',', '); echo '</span>'; }
  }
  if (in_array("com", $metas)) {
    echo '<span><i class="halflings comments"></i>'; comments_popup_link( __('With 0 comments','purepress'), __('With 1 comment','purepress'), __('With % comments','purepress'), 'comments-link', __('Comments are off','purepress')); echo '</span>';
  }
  }
}
endif;





/**
 * Returns true if a blog has more than 1 category
 *
 * @since Nevia 1.0
 */
function nevia_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so nevia_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so nevia_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in nevia_categorized_blog
 *
 * @since Nevia 1.0
 */
function nevia_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'nevia_category_transient_flusher' );
add_action( 'save_post', 'nevia_category_transient_flusher' );

/**
 * Limits number of words from string
 *
 * @since Nevia 1.0
 */
function string_limit_words($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit) {
        array_pop($words);
        //add a ... at last article when more than limit word count
        return implode(' ', $words) ;
    } else {
        //otherwise
        return implode(' ', $words);
    }
}

function dimox_breadcrumbs() {
  $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
  $delimiter = ''; // delimiter between crumbs
  $home = __('Home','purepress'); // text for the 'Home' link
  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
  $before = '<li class="current_element">'; // tag before the current crumb
  $after = '</li>'; // tag after the current crumb

  global $post;
  $homeLink = home_url();
  $frontpageuri = nevia_get_posts_page('url');
  $frontpagetitle = ot_get_option('pp_blog_page');
  $output = '';
  if (is_home() || is_front_page()) {
    if ($showOnHome == 1)
      echo '<nav id="breadcrumbs"><ul><li>';
      _e('You are here:','purepress');
      echo '</li><li><a href="' . $homeLink . '"></i>' . $home . '</a></li>';
      echo '<li>' . $frontpagetitle . '</li>';
      echo '</ul></nav>';

  } else {

    $output .= '<nav id="breadcrumbs"><ul><li>'.__('You are here:','purepress').'</li><li><a href="' . $homeLink . '">' . $home . '</a>' . $delimiter . '</li> ';

    if ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) $output .= '<li>'.get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ').'<li>';
      $output .= $before . __('Archive by category "','purepress') . single_cat_title('', false) . '"' . $after;

    } elseif ( is_search() ) {
      $output .= $before . __('Search results for "','purepress') . get_search_query() . '"' . $after;

    } elseif ( is_day() ) {
      $output .= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
      $output .= '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li> ';
      $output .= $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      $output .= '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' </li>';
      $output .= $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      $output .= $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $output .= '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
        if ($showCurrent == 1) $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        $output .= '<li>'.$cats.'</li>';
        if ($showCurrent == 1) $output .= $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      $output .= $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      //$output .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      $output .= '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
      if ($showCurrent == 1) $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) $output .= $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        $output .= $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) $output .= ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) $output .= ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      $output .= $before . __('Posts tagged','purepress').' "' . single_tag_title('', false) . '"' . $after;

    } elseif ( is_author() ) {
     global $author;
     $userdata = get_userdata($author);
     $output .= $before . __('Articles posted by ','purepress') . $userdata->display_name . $after;

   } elseif ( is_404() ) {
    $output .= $before .  __('Error 404','purepress') . $after;
  }

  if ( get_query_var('paged') ) {
    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ' ';
      $output .= '<li>'.__('Page','purepress') . ' ' . get_query_var('paged').'</li>';
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $output .= ' ';
}

$output .= '</ul></nav>';
return $output;
}
} // end dimox_breadcrumbs()



function incr_number_to_width($width) {
    switch ($width) {
        case '1':
        return "one";
        break;
        case '2':
        return "two";
        break;
        case '3':
        return "three";
        break;
        case '4':
        return "four";
        break;
        case '5':
        return "five";
        break;
        case '6':
        return "six";
        break;
        case '7':
        return "seven";
        break;
        case '8':
        return "eight";
        break;
        case '9':
        return "nine";
        break;
        case '10':
        return "ten";
        break;
        case '11':
        return "eleven";
        break;
        case '12':
        return "twelve";
        break;

        default:
        return "four";
        break;
    }
}



function new_excerpt_more($more) {
    global $post;
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');


function pp_tag_cloud_filter($args = array()) {
   $args['smallest'] = 13;
   $args['largest'] = 13;
   $args['unit'] = 'px';
   return $args;
}
add_filter('widget_tag_cloud_args', 'pp_tag_cloud_filter', 90);



function num_posts_portfolio($query)
{
    if ($query->is_main_query() && $query->is_post_type_archive('portfolio') && !is_admin()) {
        $showpost = ot_get_option('pp_portfolio_showpost','9');
        $query->set('posts_per_page', $showpost);
        }
}

add_action('pre_get_posts', 'num_posts_portfolio');


function recent_porfolios() {
    global $post;
    $exclude = $post->ID;
    rewind_posts();

    // Create a new WP_Query() object
    $wpcust = new WP_Query(
        array(
            'post_type' => array('portfolio'),
            'post__not_in' => array($exclude),
            'showposts' => '4' ) // or 10 etc. however many you want
        );

        // the $wpcust-> variable is used to call the Loop methods. not sure if required
    if ( $wpcust->have_posts() ):
        while( $wpcust->have_posts() ) : $wpcust->the_post();
    ?>


    <div class="four columns ">
      <a href="<?php echo get_permalink(); ?>" class="portfolio-item isotope">
          <figure>
              <div class="picture"><?php echo  get_the_post_thumbnail($post->ID,'portfolio-thumb'); ?><div class="image-overlay-link"></div></div>
              <figcaption class="item-description">
                <h5><?php echo get_the_title(); ?></h5>
                <?php
                $terms = get_the_terms( $post->ID, 'filters' );
                  if ( $terms && ! is_wp_error( $terms ) ) : echo '<span>';
                    $filters = array();
                    $i = 0;
                    foreach ( $terms as $term ) {
                      $filters[] = $term->name;
                      if ($i++ > 2) break;
                    }
                    $outputfilters = join( ", ", $filters ); echo $outputfilters;
                  echo '</span>';
                  endif;
                ?>
              </figcaption>
            </figure>
          </a>
    </div>


    <?php
        endwhile;  // close the Loop
        endif;
        wp_reset_query(); // reset the Loop

} // end of list_all_posttypes() function


if ( ! function_exists( 'nevia_get_posts_page' ) ) :

function nevia_get_posts_page($info) {
  if( get_option('show_on_front') == 'page') {
    $posts_page_id = get_option( 'page_for_posts');
    $posts_page = get_page( $posts_page_id);
    $posts_page_title = $posts_page->post_title;
    $posts_page_url = get_page_uri($posts_page_id  );
  }
  else $posts_page_title = $posts_page_url = '';

  if ($info == 'url') {
    return $posts_page_url;
  } elseif ($info == 'title') {
    return $posts_page_title;
  } else {
    return false;
  }
}
endif;


function nevia_language_list(){
  if (function_exists('icl_get_languages')) {
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        echo '<div id="nevia_language_list"><ul>';
        foreach($languages as $l){
            echo '<li>';
            if($l['country_flag_url']){
                if(!$l['active']) echo '<a href="'.$l['url'].'">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['native_name'].'" width="18" />';
                if(!$l['active']) echo '</a>';
            }

            echo '</li>';
        }
        echo '</ul></div>';
    }
  }
}