<?php
/**
 * Custom widgets for Nevia theme
 *
 *
 * @package Nevia
 * @since Nevia 1.0
 */


add_action('widgets_init', 'purepress_load_widgets');
// Loads widgets here
function purepress_load_widgets() {
    register_widget('purepress_flickr');
    register_widget('purepress_contact');
    register_widget('purepress_text');
    register_widget('purepress_twitter_widget');
}

// flickr functions
function ppimage_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}

function ppselect_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);
    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the        $size variable to selct one.
    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
        );
    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}


// Flickr widget
class purepress_flickr extends WP_Widget {

    function purepress_flickr() {
        $widget_ops = array('classname' => 'purepress-flickr', 'description' => 'Widget for Flickr photos');
        $control_ops = array('width' => 300);
        $this->WP_Widget('purepress_flickr', 'Nevia Flickr', $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args, EXTR_SKIP);
        echo $before_widget;
        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $count = $instance['count'];

        if (!empty($title)) {
            echo '<div class="headline no-margin"><h4>'.$title.'</h4></div>' ;
        };

        if ($instance['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $instance['id'] . '&tags=&format=rss_200'; }
        elseif ($instance['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $instance['id'] . '&format=rss_200'; }
        elseif ($instance['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $instance['set'] . '&nsid=' . $instance['id'] . '&format=rss_200'; }
        elseif ($instance['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $instance['id'] . '&format=rss_200'; }
        elseif ($instance['type'] == "public" || $instance['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags=' . $instance['tags'] . '&format=rss_200'; }
        else {
            print '<strong>No "type" parameter has been setup. Check your flickr widget settings.</strong>';

        }
        // Check if another plugin is using RSS, may not work
        include_once (ABSPATH . WPINC . '/class-simplepie.php');
        error_reporting(E_ERROR);
        $feed = new SimplePie($rss_url);
        $feed->handle_content_type();

        //$items = array_slice($rss->items, 0, $instance['count']);

        $print_flickr = '<div class="flickr-widget"><ul>';

        $i = 0;
        foreach ($feed->get_items() as $item):

            if(++$i > $count)
                break;

            if ($enclosure = $item->get_enclosure()) {
                $img = ppimage_from_description($item->get_description());
                $thumb_url = ppselect_image($img, 0);
                $full_url = ppselect_image($img, 4);
                $print_flickr .= '<li><a  href="' .$item->get_link() . '" title="'. $enclosure->get_title(). '"><img alt="'. $enclosure->get_title().'" id="photo_' . $i . '" src="' . $thumb_url . '" /></a></li>'."\n";
            }
            endforeach;



            echo $print_flickr.'</ul></div><div class="clearfix"></div>';
            echo $after_widget;
        }

        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['count'] = $new_instance['count'];
            $instance['type'] = $new_instance['type'];
            $instance['id'] = $new_instance['id'];
            $instance['set'] = $new_instance['set'];
            $instance['tas'] = $new_instance['tags'];
            return $instance;
        }

        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = strip_tags($instance['title']);
            $count = $instance['count'];
            $type = $instance['type'];
            $id = $instance['id'];
            $set = $instance['set'];
            $tags = $instance['tags'];
            ?>


            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('type'); ?>">Display photos from</label>
                <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" id="type">
                    <option <?php if($instance['type'] == 'user') { echo 'selected'; } ?> value="user">user</option>
                    <option <?php if($instance['type'] == 'set') { echo 'selected'; } ?> value="set">set</option>
                    <option <?php if($instance['type'] == 'favorite') { echo 'selected'; } ?> value="favorite">favorite</option>
                    <option <?php if($instance['type'] == 'group') { echo 'selected'; } ?> value="group">group</option>
                    <option <?php if($instance['type'] == 'public') { echo 'selected'; } ?> value="public">community</option>
                </select>
            </p>


            <p>
                <label for="<?php echo $this->get_field_id('id'); ?>">User or Group ID (<a href="http://idgettr.com/">find ID</a>)</label>
                <input  id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" size="20" />

            </p>

            <p>
                <label for="<?php echo $this->get_field_id('set'); ?>">Set ID (<a href="http://idgettr.com/">find your ID</a> )</label>
                <input  id="<?php echo $this->get_field_id('set'); ?>" name="<?php echo $this->get_field_name('set'); ?>"  type="text"  value="<?php echo $set; ?>" size="40" />

            </p>

            <p>
                <label for="<?php echo $this->get_field_id('tags'); ?>">Tags (optional) <small>Comma separated, no spaces</small> </label>
                <input  id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>"  type="text" value="<?php echo $tags; ?>" size="40" />

            </p>

            <p>
                <label for="<?php echo $this->get_field_id('count'); ?>">How many photos?
                    <select class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" >
                        <?php for ($i=1; $i<=20; $i++) { ?>
                        <option <?php if ($count == $i) { echo 'selected'; } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </label>
            </p>

            <?php
        }

    } // eof Flickr widget


// Contact info widget
    class purepress_contact extends WP_Widget {

        function purepress_contact() {
            $widget_ops = array('classname' => 'purepress-contact', 'description' => 'Nicely styled contact info widget');
            $control_ops = array('width' => 300, 'height' => 350);
            $this->WP_Widget('purepress_contact', 'Nevia Contact Info', $widget_ops, $control_ops);
        }

        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $address = $instance['address'];
            $phone = $instance['phone'];
            $email = $instance['email'];
            echo $before_widget;
            echo $before_title . $title . $after_title;
                ?>
            <ul class="contact-details-alt">
                <?php
                if($address) { ?>
                <li><i class="halflings white map-marker"></i> <p><strong><?php _e('Address', 'purepress'); ?>:</strong> <?php echo $address; ?></p></li>
                <?php }
                if($phone) { ?>
                <li><i class="halflings white user"></i> <p><strong><?php _e('Phone', 'purepress'); ?>:</strong> <?php echo $phone; ?></p></li>
                <?php }
                if($email) { ?>
                <li><i class="halflings white envelope"></i> <p><strong><?php _e('Email', 'purepress'); ?>:</strong> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p></li>
                <?php } ?>
            </ul>
            <?php
            echo $after_widget;
        }


        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['address'] = $new_instance['address'];
            $instance['phone'] = $new_instance['phone'];
            $instance['email'] = $new_instance['email'];

            return $instance;
        }

        function form($instance) {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = strip_tags($instance['title']);
            $address = strip_tags($instance['address']);
            $phone = strip_tags($instance['phone']);
            $email = strip_tags($instance['email']);
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address', 'purepress'); ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" size="20" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone', 'purepress'); ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" size="20" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email', 'purepress'); ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" size="20" />
                </label>
            </p>


            <?php
        }
    }



/**
 * Text widget Nevia
 *
 * @since 1.0
 */
class purepress_text extends WP_Widget {
    function purepress_text() {
        $widget_ops = array('classname' => 'purepress-text', 'description' => 'Text widget without title');
        $control_ops = array('width' => 300, 'height' => 350);
        $this->WP_Widget('purepress_text', 'Nevia Text', $widget_ops, $control_ops);
    }
    function widget( $args, $instance ) {
        extract($args);
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        echo $before_widget;
        ?>
            <div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        if ( current_user_can('unfiltered_html') )
            $instance['text'] =  $new_instance['text'];
        else
            $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
        $instance['filter'] = isset($new_instance['filter']);
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );

        $text = esc_textarea($instance['text']);
?>

        <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

        <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
<?php
    }
} //eof text widget Nevia


/**
 * Twitter widget Nevia
 *
 * @since 1.0
 * TODO: update for API 1.1
 */
class purepress_twitter_widget extends WP_Widget {

//  class pu_tweet_widget extends WP_Widget {
    private $twitter_title = "Twitter";
    private $twitter_username = "purethemes";
    private $twitter_postcount = "1";
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'purepress_twitter_widget',      // Base ID
            'Nevia Twitter Widget',       // Name
            array(
                'classname'     =>  'purepress_twitter_widget',
                'description'   =>  __('A widget that displays your latest tweets.', 'framework')
            )
        );
        // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();
    } // end constructor
    /**
     * Registers and enqueues stylesheets for the administration panel and the
     * public facing site.
     */
    public function register_scripts_and_styles() {
    } // end register_scripts_and_styles
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        /* Our variables from the widget settings. */
        $this->twitter_title = apply_filters('widget_title', $instance['title'] );
        $this->twitter_username = $instance['username'];
        $this->twitter_postcount = $instance['postcount'];
        //$this->twitter_follow_text = $instance['tweettext'];
        $transName = 'list_tweets';
        $cacheTime = 20;
        if(false === ($twitterData = get_transient($transName) ) ){
            require_once 'twitter/twitteroauth.php';
            $twitterConnection = new TwitterOAuth(
                                ot_get_option('pp_twitter_ck'),
                                ot_get_option('pp_twitter_cs'),
                                ot_get_option('pp_twitter_at'),
                                ot_get_option('pp_twitter_ts')
                                );
            $twitterData = $twitterConnection->get(
                      'statuses/user_timeline',
                      array(
                        'screen_name'     => $this->twitter_username,
                        'count'           => $this->twitter_post_count,
                        'exclude_replies' => false
                      )
                    );
            if($twitterConnection->http_code != 200)
            {
                $twitterData = get_transient($transName);
            }
            // Save our new transient.
            set_transient($transName, $twitterData, 60 * $cacheTime);
        }
        /* Before widget (defined by themes). */
        echo $before_widget;
        ?>
        <div class="twitter_box"><?php
        /* Display the widget title if one was input (before and after defined by themes). */
        if ( $this->twitter_title )
            echo $before_title . $this->twitter_title . $after_title;
        /* Display Latest Tweets */
         ?>

            <?php
                if(!empty($twitterData) || !isset($twitterData['error'])){
                    $i=0;
                    $hyperlinks = true;
                    $encode_utf8 = true;
                    $twitter_users = true;
                    $update = true;
                    echo '
<ul id="twitter">';
                    foreach($twitterData as $item){
                            $msg = $item->text;
                            $permalink = 'http://twitter.com/#!/'. $this->twitter_username .'/status/'. $item->id_str;
                            if($encode_utf8) $msg = utf8_encode($msg);
                                    $msg = $this->encode_tweet($msg);
                            $link = $permalink;
                             echo '
<li class="twitter-item"><span>';
                              if ($hyperlinks) {    $msg = $this->hyperlinks($msg); }
                              if ($twitter_users)  { $msg = $this->twitter_users($msg); }
                              echo $msg;
                            if($update) {
                              $time = strtotime($item->created_at);
                              if ( ( abs( time() - $time) ) < 86400 )
                                $h_time = sprintf( __('%s ago', 'purepress'), human_time_diff( $time ) );
                              else
                                $h_time = date(__('Y/m/d'), $time);
                              echo sprintf( __('%s', 'purepress'),'</span><br/> <b class="twitter-timestamp"><a href="'.$link.'">' . $h_time . '</a></b>' );
                             }
                            echo '</li>';
                            $i++;
                            if ( $i >= $this->twitter_postcount ) break;
                    }
                    echo '</ul><div class="clearfix"></div>';
                }
            ?>
            </div>
        <?php
        /* After widget (defined by themes). */
        echo $after_widget;
    }
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        // Strip tags to remove HTML (important for text inputs)
        foreach($new_instance as $k => $v){
            $instance[$k] = strip_tags($v);
        }
        return $instance;
    }
    /**
     * Create the form for the Widget admin
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    function form( $instance ) {
        /* Set up some default widget settings. */
        $defaults = array(
        'title' => $this->twitter_title,
        'username' => $this->twitter_username,
        'postcount' => $this->twitter_postcount,
        //'tweettext' => $this->twitter_follow_text,
        );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <!-- Widget Title: Text Input -->

            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'framework') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />

        <!-- Username: Text Input -->

            <label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username e.g. purethemes', 'purepress') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />

        <!-- Postcount: Text Input -->

            <label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of tweets (max 20)', 'purepress') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />

        <!-- Tweettext: Text Input -->


    <?php
    }
    /**
     * Find links and create the hyperlinks
     */
    private function hyperlinks($text) {
        $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
        $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
        // match name@address
        $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
            //mach #trendingtopics. Props to Michael Voigt
        $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
        return $text;
    }
    /**
     * Find twitter usernames and link to them
     */
    private function twitter_users($text) {
           $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
           return $text;
    }
        /**
         * Encode single quotes in your tweets
         */
        private function encode_tweet($text) {
                $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
                return $text;
        }
 }
