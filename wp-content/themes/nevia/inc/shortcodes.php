<?php
/**
 * Custom shortcodes for Nevia theme
 *
 *
 * @package Nevia
 * @since Nevia 1.0
 */


/**
* Clear shortcode
* Usage: [clear]
*/
function pp_clear() {
     return '<div class="clear"></div>';

}
add_shortcode( 'clear', 'pp_clear' );

/**
* Line shortcode
* Usage: [line]
*/
function pp_line() {
     return '<div class="line" style="margin-top: 25px; margin-bottom: 40px;"></div>';

}
add_shortcode( 'line', 'pp_line' );

/**
* Headline shortcode
* Usage: [headline margin="margin-reset" type="h3"] [/headline] // margin-down margin-both
*/
function pp_headline( $atts, $content ) {
    extract(shortcode_atts(array(
        'margin' => 'margin-reset','htype' => 'h3'), $atts));
    return '<'.$htype.' class="'.$margin.'">'.do_shortcode( $content ).'</'.$htype.'>';
}

add_shortcode( 'headline', 'pp_headline' );


/**
* Dropcap shortcode
* Usage: [dropcap color="gray"] [/dropcap]// margin-down margin-both
*/
function pp_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
        'color'=>''), $atts));
    return '<span class="dropcap '.$color.'">'.$content.'</span>';
}
add_shortcode('dropcap', 'pp_dropcap');

/**
* Highlight shortcode
* Usage: [highlight style="gray"] [/highlight] // color, gray, light
*/
function pp_highlight($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => 'gray'
        ), $atts));
    return '<span class="highlight '.$style.'">'.$content.'</span>';
}
add_shortcode('highlight', 'pp_highlight');


/**
* Tooltip shortcode
* Usage: [tooltip title="" url=""] [/tooltip] // color, gray, light
*/
function pp_tooltip($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'url' => ''
        ), $atts));
    return '<a href="'.$url.'" class="tooltip" title="'.$title.'">'.$content.'</a>';
}
add_shortcode('tooltip', 'pp_tooltip');


/**
* List style shortcode
* Usage: [list type="check"] [/list] // check, star, plus, sign
*/
function pp_liststyle($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => 'check'  // check, star, plus, sign
        ), $atts));
    return '<div class="'.$type.'-list">'.$content.'</div>';
}
add_shortcode('list', 'pp_liststyle');


/**
* Icon box shortcode
* Usage: [iconbox column="one-third" title="" link="" icon=""] [/iconbox]
*/
function pp_iconbox( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => '',
        'link' => '',
        'icon' => '',
        'column' => 'one-third'
        ), $atts));
    $output = '<div class="columns '.$column.'"><article class="icon-box">';
    $output .= '<i class="'.$icon.'"></i>';
    if($link)
        { $output .= '<h3><a href="'.$link.'">'.$title.'</a></h3>'; }
    else
        { $output .= '<h3>'.$title.'</h3>'; }
    $output .= '<p>'.do_shortcode( $content ).'</p></article></div>';
    return $output;

}
add_shortcode( 'iconbox', 'pp_iconbox' );
/**
*  Usage: [iconwrapper] [/iconwrapper]
*/
function pp_iconbox_wrapper( $atts, $content ) {
     $output = '<section class="icon-box-container">'.do_shortcode( $content ).'</section>';
     return $output;
}
add_shortcode( 'iconwrapper', 'pp_iconbox_wrapper' );


/**
* Recent work shortcode
* Usage: [recent_work limit="4" title="Recent Work" orderby="date" order="DESC" filters="" carousel="yes"] [/recent_work]
*/
function pp_recent_work($atts, $content ) {
 extract(shortcode_atts(array(
    'limit'=>'4',
    'title' => 'Recent Work',
    'orderby'=> 'date',
    'order'=> 'DESC',
    'filters' => '',
    'carousel' => 'yes'
    ), $atts));
    $output = '';
    if($filters){
        $filterstemparray = explode(',', $filters);
        if (count($filterstemparray)>1) {
            $filtersarray = $filterstemparray;

        } else {
            $filtersarray = $filterstemparray[0];
        }
    };
    if($filters=="all" || empty($filters)) {
         $wp_query = new WP_Query(
            array(
                'post_type' => array('portfolio'),
                'showposts' => $limit,
                'orderby' => $orderby,
                'order' => $order
                ));
    } else {
       $wp_query = new WP_Query(
        array(
            'post_type' => array('portfolio'),
            'showposts' => $limit,
            'orderby' => $orderby,
            'order' => $order,
            'tax_query' => array(
                array(
                    'taxonomy' => 'filters',
                    'field' => 'slug',
                    'terms' => $filtersarray
                    )
                ),
            )
            );
    }
    if($carousel == 'yes') {
    $output .= '<div class="blank floated">
        <div class="four columns carousel-intro">
            <section class="entire">
                <h3>'.$title.'</h3>
                <p>'.do_shortcode( $content ).'</p>
            </section>
            <div class="carousel-navi">
                <div id="work-prev" class="arl jcarousel-prev"><i class="icon-chevron-left"></i></div>
                <div id="work-next" class="arr jcarousel-next"><i class="icon-chevron-right"></i></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <section class="jcarousel recent-work-jc"><ul>';
    } // if carousel

    if ( $wp_query->have_posts() ):
    while( $wp_query->have_posts() ) : $wp_query->the_post();

        $id = $wp_query->post->ID;
        $type = get_post_meta($id, 'pp_pf_type', true);
        if($carousel == 'yes') { $output .= '<li class="four columns">'; } else { $output .= '<div class="four columns">';}
        $output .= '<a href="'.get_permalink().'" class="portfolio-item"><figure>';

        $videothumbtype = ot_get_option('portfolio_videothumb');
            if($type == 'video' && $videothumbtype == 'video') {
            global $wp_embed;
            $videolink = get_post_meta($id, 'incr_pfvideo_link', true);
            $post_embed = $wp_embed->run_shortcode('[embed  width="220" height="147"]'.$videolink.'[/embed]') ;
            $output .= '<div class="picture recent_video">'.$post_embed.'</div>';
        } else {
            if ( has_post_thumbnail()) {
                $output .= get_the_post_thumbnail($wp_query->post->ID,'portfolio-thumb');
            }
        }
        $output .= '<figcaption class="item-description"><h5>'.get_the_title().'</h5>';
            $terms = get_the_terms( $wp_query->post->ID, 'filters' );
            if ( $terms && ! is_wp_error( $terms ) ) : $output .= '<span>';
                $filters = array();
                $i = 0;
                foreach ( $terms as $term ) {
                    $filters[] = $term->name;
                    if ($i++ > 0) break;
                }
                $outputfilters = join( ", ", $filters ); $output .= $outputfilters;
            $output .= '</span>';
            endif;

         if($carousel == 'yes') { $output .= '</figcaption></figure></a></li>'; } else {  $output .= '</figcaption></figure></a></div>'; }
        endwhile;  // close the Loop
    endif;
    if($carousel == 'yes') { $output .='</ul></section></div>'; }
    return $output;
}
add_shortcode('recent_work', 'pp_recent_work');

/**
* Recent work shortcode
* Usage: [recent_blog_carousel limit="4" title="Recent Work" orderby="date" order="DESC" filters="" carousel="yes"] [/recent_work]
*/
function pp_recent_blog_carousel($atts, $content ) {
 extract(shortcode_atts(array(
    'limit'=>'4',
    'title' => 'Recent Blog',
    'orderby'=> 'date',
    'order'=> 'DESC',
    ), $atts));
    $output = '';
   $wp_query = new WP_Query(
    array(
        'post_type' => array('post'),
        'showposts' => $limit,
        'orderby' => $orderby,
        'order' => $order
        )
    );
    $output .= '<div class="blank floated">
        <div class="four columns carousel-intro">
            <section class="entire">
                <h3>'.$title.'</h3>
                <p>'.do_shortcode( $content ).'</p>
            </section>
            <div class="carousel-navi">
                <div id="work-prev" class="arl jcarousel-prev"><i class="icon-chevron-left"></i></div>
                <div id="work-next" class="arr jcarousel-next"><i class="icon-chevron-right"></i></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <section class="jcarousel recent-blog-jc"><ul>';


    if ( $wp_query->have_posts() ):
    while( $wp_query->have_posts() ) : $wp_query->the_post();

        $id = $wp_query->post->ID;
        $type = get_post_meta($id, 'pp_pf_type', true);
        $output .= '<li class="four columns">';
        $output .= '<a href="'.get_permalink().'" class="portfolio-item"><figure>';

        if ( has_post_thumbnail()) {
            $output .= get_the_post_thumbnail($wp_query->post->ID,'portfolio-thumb');
        }

        $output .= '<figcaption class="item-description"><h5 style="padding:0px 5px 5px">'.get_the_title().'</h5>';
            $terms = get_the_terms( $wp_query->post->ID, 'category' );
            if ( $terms && ! is_wp_error( $terms ) ) : $output .= '<span>';
                $filters = array();
                $i = 0;
                foreach ( $terms as $term ) {
                    $filters[] = $term->name;
                    if ($i++ > 0) break;
                }
                $outputfilters = join( ", ", $filters ); $output .= $outputfilters;
            $output .= '</span>';
            endif;
        $output .= '</figcaption></figure></a></li>';
        endwhile;  // close the Loop
    endif;
    $output .='</ul></section></div>';
    return $output;
}
add_shortcode('recent_blog_carousel', 'pp_recent_blog_carousel');



/**
* Recent blog shortcode
* Usage: [recent_blog limit="4" title="Recent Work" subtitle="/ Stuff From Our Blog" words="15"] [/recent_blog]
*/
function recent_blog($atts) {
   extract(shortcode_atts(array(
    'limit' => '2',
    'title' => 'Recent News',
    'subtitle' => '/ Stuff From Our Blog',
    'words' => 15
    ), $atts));

    $counter = 0;
    $wp_query = new WP_Query(
    array(
        'post_type' => array('post'),
        'showposts' => $limit
        /*'category__in' => $cats*/
        ));

    if ( $wp_query->have_posts() ):

    $output = '';
    if ($title != 'hide') {
       $output .= '<h3 class="margin-1">'.$title.'<span> '.$subtitle.'</span></h3>';
    }
        while( $wp_query->have_posts() ) : $wp_query->the_post();
            $counter++;

                switch ($counter) {
                    case '1':
                    $class = 'alpha';
                    break;
                    case $counter % 4 === 0:
                    $class = 'omega';
                    break;
                    case $counter % 5 === 0:
                    $class = 'alpha';
                    break;
                    case $limit:
                    $class = 'omega';
                    break;
                    default:
                    $class = ' ';
                    break;
                }

            $excerpt = get_the_excerpt();
            $short_excerpt = string_limit_words($excerpt,$words);

            $output .= '<div class="four columns '.$class.'"><article class="recent-blog"> <section class="date">
                    <span class="day">'.get_the_date('d').'</span>
                    <span class="month">'.get_the_date('M').'</span>
                </section>';
            $output .='<h4><a href="'. get_permalink().'">'.get_the_title().'</a></h4><p>'.$short_excerpt.'</p></article></div>';
        endwhile;  // close the Loop
    endif;
    wp_reset_query();
    return $output;

}
add_shortcode('recent_blog', 'recent_blog');


/**
* Tesimonials shortcode
* Usage: [testimonials limit="4" title="Testimonials" subtitle=" / What Our Clients Say"]
*/

function pp_testimonials($atts, $content ) {
 extract(shortcode_atts(array(
    'limit'=>'4',
    'title' => 'Testimonials',
    'subtitle' => ' / What Our Clients Say'
    ), $atts));

 $wp_query = new WP_Query(
    array(
        'post_type' => array('testimonial'),
        'showposts' => $limit,
        )
    );
  $output = '<h3 class="margin-1">'.$title.'<span>'.$subtitle.'</span></h3><section class="flexslider testimonial-slider"><ul class="slides">';

  if ( $wp_query->have_posts() ):
    while( $wp_query->have_posts() ) : $wp_query->the_post();

        $id = $wp_query->post->ID;
        $author = get_post_meta($id, 'pp_author', true);
        $link = get_post_meta($id, 'pp_link', true);
        $position = get_post_meta($id, 'pp_position', true);

        $output .= '<li class="testimonial">';
        $output .= '<div class="testimonials">'.get_the_content().'</div><div class="testimonials-bg"></div>';
        if($link) {
            $output .= ' <div class="testimonials-author"><a href="'.$link.'">'.$author.'</a>';
        } else {
            $output .= ' <div class="testimonials-author">'.$author;
        }
        if($position) { $output .= ', <span>'.$position.'</span>'; }
        $output .= '</div></li>';

        endwhile;  // close the Loop
    endif;
    $output .='</ul></section>';
    return $output;
}

add_shortcode('testimonials', 'pp_testimonials');


/**
* Columns shortcode
* Usage: [column width="eight" place="" custom_class=""] [/column]
*/

function pp_column($atts, $content = null) {
    extract( shortcode_atts( array(
        'width' => 'eight',
        'place' => '',
        'custom_class' => ''
        ), $atts ) );

    switch ( $width ) {
        case "1/3" :
        $w = "columns one-third";
        break;

        case "2/3" :
        $w = "columns two-thirds";
        break;

        case "one" : $w = "one columns"; break;
        case "two" : $w = "two columns"; break;
        case "three" : $w = "three columns"; break;
        case "four" : $w = "four columns"; break;
        case "five" : $w = "five columns"; break;
        case "six" : $w = "six columns"; break;
        case "seven" : $w = "seven columns"; break;
        case "eight" : $w = "eight columns"; break;
        case "nine" : $w = "nine columns"; break;
        case "ten" : $w = "ten columns"; break;
        case "eleven" : $w = "eleven columns"; break;
        case "twelve" : $w = "twelve columns"; break;
        case "thirteen" : $w = "thirteen columns"; break;
        case "fourteen" : $w = "fourteen columns"; break;
        case "fifteen" : $w = "fifteen columns"; break;
        case "sixteen" : $w = "sixteen columns"; break;

        default :
        $w = 'columns eight';
    }
    switch ( $place ) {
        case "last" :
        $p = "omega";
        break;

        case "center" :
        $p = "alpha omega";
        break;

        case "none" :
        $p = " ";
        break;

        case "first" :
        $p = "alpha";
        break;
        default :
        $p = ' ';
    }

    $column ='<div class="'.$w.' '.$custom_class.' '.$p.'">'.do_shortcode( $content ).'</div>';
    if($place=='last') $column .= '<br class="clear" />';
    return $column;
}
add_shortcode('column', 'pp_column');

/**
* Notice shortcode
* Usage: [notice title="Notice" buttonlink="" buttontext=""] [/notice]
*/
function pp_notice( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => 'Notice',
        'buttonlink' => '',
        'buttontext' => ''
        ), $atts));
    $output = '<div class="large-notice"><h2>'.$title.'</h2><p>'.do_shortcode( $content ).'</p>';
    if($buttonlink) $output .= '<a href="'.$buttonlink.'" class="button medium color">'.$buttontext.'</a>';
    $output .= '</div>';
    return $output;
}

add_shortcode( 'notice', 'pp_notice' );

/**
* Accordion shortcode
* Usage: [accordion title="Tab"] [/accordion]
*/
function pp_accordion( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => 'Tab'
        ), $atts));
    return '<h3><span class="ui-accordion-header-icon ui-icon ui-accordion-icon"></span>'.$title.'</h3><div><p>'.do_shortcode( $content ).'</p></div>';
}
add_shortcode( 'accordion', 'pp_accordion' );

function pp_accordion_wrap( $atts, $content ) {
    extract(shortcode_atts(array(), $atts));
    return '<div class="accordion">'.do_shortcode( $content ).'</div>';
}
add_shortcode( 'accordionwrap', 'pp_accordion_wrap' );

/**
* Skillbars shortcode
* Usage: [skillbars] [/skillbars]
*/

function pp_skillbars( $atts, $content ) {
    extract(shortcode_atts(array(), $atts));
    return '<div id="skill-bars">'.do_shortcode( $content ).'</div>';
}
add_shortcode( 'skillbars', 'pp_skillbars' );

/**
* Usage: [skillbar title="Web Design 80%" value="80"]
*/
function pp_skillbar( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => 'Web Design 80%',
        'value' => '80'
        ), $atts));
    return '<div class="skill-bar"><div class="skill-bar-content" data-percentage="'.$value.'"></div><span class="skill-title">'.$title.'</span></div>';
}
add_shortcode( 'skillbar', 'pp_skillbar' );

/**
* Team shortcode
* Usage: [team photo="" link="" name="" job=""] [/team]
*/

function pp_team($atts, $content ) {
   extract(shortcode_atts(array(
    'photo'=>"",
    'link' => "",
    'name'=>"",
    'job' =>''), $atts));
   $output = '';
    if($photo) {
        if($link) {
            $output .= '<a href="'.$link.'"><img src="'.$photo.'" alt="'.$name.'"/></a>';
        } else {
         $output .= '<img src="'.$photo.'" alt="'.$name.'"/>';
        }
    }
    $output .= '<div class="team-name"><h5>'.$name.'</h5><span>'.$job.'</span></div>';
    $output .= '<div class="team-about"><p>'.do_shortcode( $content ).'</p></div>';

   return $output;
}
add_shortcode('team', 'pp_team');


/**
* Pricing table shortcode
* Usage: [pricing_table featured="no" color="" header="" price="" per=""] [/pricing_table]
*/


function pp_pricing_table($atts, $content) {
    extract(shortcode_atts(array(
        "featured" => 'no',
        "color" => '',
        "header" => '',
        "price" => '',
        "per" => ''
        ), $atts));

    $output ='';
    if($featured != "no") {
        $output .= '<div class="pricing-table featured">';
    } else {
        $output .= '<div class="pricing-table">';
    }
    $output .= '<div class="color-'.$color.'">';

    $output .= '<h3>'.$header.'</h3>';
    $output .= '<h4><span class="price">'.$price.'</span>';
    if($per) $output .= '<span class="time">'.$per.'</span>';
    $output .= '</h4>';
    $output .= do_shortcode( $content );
    $output .= '</div></div>​';
    return $output;
}
add_shortcode('pricing_table', 'pp_pricing_table');

/**
* Usage: [pricing_wrapper number="4"] [/pricing_table]
*/
function pp_pricing_wrapper($atts, $content) {
    extract(shortcode_atts(array(
        "number" => '4',

        ), $atts));

    switch ($number) {
        case '2':
        $tables = 'two';
        break;
        case '3':
        $tables = 'three';
        break;
        case '4':
        $tables = 'four';
        break;
        case '5':
        $tables = 'five';
        break;

        default:
        $tables = 'four';
        break;
    }
    $output = '<div class="'.$tables.'-tables">';
    $output .= do_shortcode( $content );
    $output .= '</div>​';
    return $output;
}
add_shortcode('pricing_wrapper', 'pp_pricing_wrapper');


function pp_pricing_check($atts) {
    extract(shortcode_atts(array(
        "check" => 'yes',
        ), $atts));
    $output = '<span class="pricing_check '.$check.'"></span>​';
    return $output;
}
add_shortcode('pricing_check', 'pp_pricing_check');




/**
* Button shortcodes
* Usage: [button url="" color="" customcolor="" size="small" iconcolor="white" icon="" "halflings=""]  [/button]
*/
function pp_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => '',
        "color" => 'color',  //gray color light
        "customcolor" => '',
        "size" => 'medium',  // medium small
        "iconcolor" => 'white',
        "icon" => '',
        "halflings" => 'yes',
        "target" => '',
        "customclass" => '',


        ), $atts));
    $output = '<a class="button '.$size.' '.$color.' '.$customclass.'" href="'.$url.'" ';
    if(!empty($target)) { $output .= 'target="'.$target.'"'; }
    if(!empty($customcolor)) { $output .= 'style="background-color:'.$customcolor.'"'; }
    $output .= '>';
    if($halflings != "no") { $halclass = "halflings"; } else { $halclass = ""; }
    if(!empty($icon)) { $output .= '<i class="'.$icon.' '.$halclass.' '.$iconcolor.'"></i> '; }
    $output .= $content.'</a>';

    return $output;
}
add_shortcode('button', 'pp_button');


/**
* Tabs shortcodes
* Usage: [tab url="" color="" customcolor="" size="small" iconcolor="white" icon="" "halflings=""]  [/tab]
*/

function etdc_tab_group( $atts, $content ) {
    $GLOBALS['pptab_count'] = 0;
    do_shortcode( $content );
    $count = 0;
    if( is_array( $GLOBALS['tabs'] ) ) {
        foreach( $GLOBALS['tabs'] as $tab ) {
            $count++;
            if($tab['icon']) { $tabs[] = '<li><a href="#tab'.$count.'"><i class="'.$tab['icon'].'"></i> '.$tab['title'].'</a></li>'; }
            else { $tabs[] = '<li><a href="#tab'.$count.'">'.$tab['title'].'</a></li>'; }
            $panes[] = '<div class="tab-content" id="tab'.$count.'">'.$tab['content'].'</div>';
        }
        $return = "\n".'<ul class="tabs-nav">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="tabs-container">'.implode( "\n", $panes ).'</div>'."\n";
    }
    return $return;
}

/**
* Usage: [tab title="" icon=""] [/tab]
*/

function etdc_tab( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => 'Tab %d',
        'icon' => ''
        ), $atts));

    $x = $GLOBALS['pptab_count'];
    $GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['pptab_count'] ), 'icon' => $icon, 'content' =>  do_shortcode( $content ) );
    $GLOBALS['pptab_count']++;
}
add_shortcode( 'tabgroup', 'etdc_tab_group' );
add_shortcode( 'tab', 'etdc_tab' );

/**
* Box shortcodes
* Usage: [box type=""] [/box]
*/

function pp_box($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => ''
        ), $atts));
    return '<div class="notification closeable '.$type.'"><p>'.do_shortcode( $content ).'</p><a class="close" href="#"><i class="icon-remove"></i></a></div>';
}
add_shortcode('box', 'pp_box');

/**
* Clients shortcodes
* Usage: [clients] [/clients]
*/

function pp_clients( $atts, $content ) {
    extract(shortcode_atts(array(), $atts));
    return '<div class="client-list">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'clients', 'pp_clients' );

/**
* Toggle shortcodes
* Usage: [toggle title="" open="no"] [/toggle]
*/

function pp_toggle( $atts, $content ) {
    extract(shortcode_atts(array(
        'title' => '',
        'open' => 'no'
        ), $atts));
    if($open != 'no') { $opclass = "opened"; } else { $opclass = ''; }
    return ' <div class="toggle-wrap"><span class="trigger '.$opclass.'"><a href="#"><i class="toggle-icon"></i> '.$title.'</a></span><div class="toggle-container"><p>'.do_shortcode( $content ).'</p></div></div>';
}
add_shortcode( 'toggle', 'pp_toggle' );

/**
* Google map shortcodes
* Usage: [googlemap width="100%" height="250px" address="New York, United States"]
*/

function fn_googleMaps($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '100%',
      "height" => '250px',
      "address" => 'New York, United States'
      ), $atts));
   $output ='<section class="google-map-container"><div id="googlemaps" class="google-map google-map-full" style="height:'.$height.'; width:'.$width.'"></div>
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="'.get_template_directory_uri().'/js/jquery.gmap.min.js"></script>
        <script type="text/javascript">
           jQuery("#googlemaps").gMap({
            maptype: "ROADMAP",
            scrollwheel: false,
            zoom: 13,
            markers: [
            {
                address: \''.$address.'\',
                html: "",
                popup: false,
            }
            ],
        });
        </script></section>';
return $output;
}
add_shortcode("googlemap", "fn_googleMaps");



/**
* Recent work shortcode
* Usage: [recent_blog_carousel limit="4" title="Recent Work" orderby="date" order="DESC" filters="" carousel="yes"] [/recent_work]
*/
function pp_clients_carousel($atts, $content ) {
 extract(shortcode_atts(array(
    'title' => 'Clients',
    'subtitle' => 'Check for who we worked!'
    ), $atts));
    $output = '';

    $output .= '<div class="blank ">
        <div class="four columns carousel-intro">
            <section class="entire">
                <h3>'.$title.'</h3>
                <p>'.$subtitle.'</p>
            </section>
            <div class="carousel-navi">
                <div id="work-prev" class="arl jcarousel-prev"><i class="icon-chevron-left"></i></div>
                <div id="work-next" class="arr jcarousel-next"><i class="icon-chevron-right"></i></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <section class="jcarousel clients-jc">';
        $output .= do_shortcode( $content );
        $output .='</section></div>';
        return $output;
}
add_shortcode('clients_carousel', 'pp_clients_carousel');





//woocommerce custom shortcodes


/**
 * Recent Products shortcode
 *
 * @access public
 * @param array $atts
 * @return string
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    function nevia_woocommerce_recent_products( $atts, $content ) {
        extract(shortcode_atts(array(
            'limit'=>'4',
            'title' => 'Recent Products',
            'orderby'=> 'date',
            'order'=> 'DESC',
            'carousel' => 'yes',
            'per_page'  => '12'
            ), $atts));

        $args = array(
            'suppress_filters' => false,
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page' => $per_page,
            'orderby' => $orderby,
            'order' => $order,
            'meta_query' => array(
                array(
                    'key' => '_visibility',
                    'value' => array('catalog', 'visible'),
                    'compare' => 'IN'
                    )
                )
            );
        $output = '';
        if($carousel == 'yes') {
            $output .= '
            <div class="blank floated">
            <div class="four columns carousel-intro">
            <section class="entire">
            <h3>'.$title.'</h3>
            <p>'.do_shortcode( $content ).'</p>
            </section>
            <div class="carousel-navi">
            <div id="work-prev" class="arl jcarousel-prev"><i class="icon-chevron-left"></i></div>
            <div id="work-next" class="arr jcarousel-next"><i class="icon-chevron-right"></i></div>
            </div>
            <div class="clearfix"></div>
            </div>
            <section class="jcarousel recent-products-jc"><ul>';
        } // if carousel

    $products = get_posts( $args );

    if ( $products ) :
      foreach( $products as $productshop ) : setup_postdata($productshop);
                if($carousel == 'yes') {
                    $output .= '<li class="four columns">';
                } else {
                    $output .= '<div class="four columns">';
                }
            $output .= '<div class="shop-item ">';
            $output .= '<figure>';
            if ( has_post_thumbnail($productshop->ID)) {
                    $output .=  '<a href="'.get_permalink($productshop->ID).'" >';
                    $output .= get_the_post_thumbnail($productshop->ID,'portfolio-thumb');
                    $output .=  '</a>';
            }
            $output .= '<figcaption class="item-description"><a href="'.get_permalink($productshop->ID).'" ><h5>'.get_the_title($productshop->ID).'</h5></a>';
            $product = get_product( $productshop->ID );
            $output .=  $product->get_price_html();
                if($carousel == 'yes') {
                    $output .= '</figcaption></figure></div></li>';
                 } else {
                    $output .= '</figcaption></figure></div></div>';
                }
            endforeach; // end of the loop.
            endif;

        if($carousel == 'yes') { $output .='</ul></section></div>'; }
            return $output;
        }
        add_shortcode('nevia_recent_products', 'nevia_woocommerce_recent_products');

    } ?>