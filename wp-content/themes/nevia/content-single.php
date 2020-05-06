<?php
/**
 * @package Nevia
 * @since Nevia 1.0
 */
?>
<!-- 960 Container -->
<div class="container floated">

    <div class="sixteen floated page-title">

        <h2><?php echo ot_get_option('pp_blog_page'); ?></h2>

        <?php if (ot_get_option('pp_breadcrumbs') != 'no') {
            echo dimox_breadcrumbs();
        } ?>

    </div>

</div>
<!-- 960 Container / End -->
<?php $layout = get_post_meta($post->ID, 'pp_sidebar_layout', true);
if (empty($layout)) {
    $layout = 'right-sidebar';
} ?>

<!-- 960 Container -->
<div class="container <?php if ($layout != 'full-width') {
    echo 'floated';
} ?> main">
    <?php if ($layout == 'left-sidebar') { ?>
        <!-- Sidebar -->
        <div class="four floated sidebar left">
            <?php get_sidebar(); ?>
        </div>
        <!-- Sidebar / End -->
    <?php } ?>
    <!-- Page Content -->
    <div class="<?php if ($layout != 'full-width') {
        echo 'floated eleven';
        if ($layout == "left-sidebar") {
            echo ' right';
        }
    } else {
        echo 'columns sixteen';
    } ?>">
        <?php
        /* Include the Post-Format-specific template for the content.
         * If you want to overload this in a child theme then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        $format = get_post_format();
        if (false === $format) {
            $format = 'standard';
        } ?>
        <article <?php post_class('post ' . $format); ?> id="post-<?php the_ID(); ?>">

            <?php
            if ($format == 'image') {
                if (has_post_thumbnail()) {
                    $thumbbig = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full') ?>
                    <figure class="post-img">
                        <a rel="fancybox" href="<?php echo $thumbbig[0]; ?>"><?php the_post_thumbnail(); ?></a>
                    </figure>
                    <?php
                }
            }
            if ($format == 'gallery') {
                $ids = get_post_meta($post->ID, 'pp_gallery_slider', true);
                $args = array(
                    'post_type' => 'attachment',
                    'post_status' => 'inherit',
                    'post_mime_type' => 'image',
                    'post__in' => explode(",", $ids),
                    'posts_per_page' => '-1',
                    'orderby' => 'post__in'
                );
                $sliderquery = new WP_Query($args);
                if ($sliderquery->have_posts()) { ?>
                    <section class="flexslider">
                        <ul class="slides post-img">
                            <?php while ($sliderquery->have_posts()) {
                                $sliderquery->the_post(); ?>
                                <!-- 960 Container -->
                                <?php
                                $attachment = wp_get_attachment_image_src($sliderquery->post->ID, 'full');
                                $thumb = wp_get_attachment_image_src($sliderquery->post->ID, 'portfolio-main');
                                ?>
                                <li>
                                    <a href="<?php echo $attachment[0] ?>" rel="fancybox-gallery"
                                       title="<?php echo $image->post_title; ?>">
                                        <img src="<?php echo $thumb[0] ?>" alt="<?php echo $image->post_title; ?>"/>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </section>
                    <!-- End 960 Container -->
                    <?php
                }
                wp_reset_query(); //eof if type
            }
            if ($format == 'video') {
                if ((function_exists('get_post_format') && 'video' == get_post_format($post->ID))) {
                    global $wp_embed;
                    $videoembed = get_post_meta($post->ID, 'pp_video_embed', true);
                    if ($videoembed) {
                        echo '<section class="video" style="margin-bottom:20px">' . $videoembed . '</section>';
                    } else {
                        $videolink = get_post_meta($post->ID, 'pp_video_link', true);
                        if ($layout == 'full-width') {
                            $post_embed = $wp_embed->run_shortcode('[embed  width="940" ]' . $videolink . '[/embed]');
                        } else {
                            $post_embed = $wp_embed->run_shortcode('[embed  width="640" ]' . $videolink . '[/embed]');
                        }
                        echo '<section class="video" style="margin-bottom:20px">' . $post_embed . '</section>';
                    }
                }
            } ?>


            <section class="date">
                <span class="day"><?php echo get_the_date('d'); ?></span>
                <span class="month"><?php echo get_the_date('M'); ?></span>
            </section>

            <section class="post-content">
                <header class="meta">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                    <?php nevia_posted_on(); ?>
                </header>

                <?php the_content();
                wp_link_pages(); ?>

            </section>
        </article>

        <?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries  ?>
            <!-- About Author -->
            <section class="about-author">
                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('purepress_author_bio_avatar_size', 80)); ?>
                <div class="about-description">
                    <h4><?php printf(esc_attr__('About %s', 'purepress'), get_the_author()); ?></h4>
                    <?php the_author_meta('description'); ?>
                </div>
            </section>
        <?php endif; ?>
        <!-- Divider -->
        <div class="line"></div>
        <nav class="pagination">
            <ul>
                <li><?php previous_post_link('<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x('&larr;', 'Previous post link', 'purepress') . '</span> %title'); ?></li>
                <li><?php next_post_link('<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x('&rarr;', 'Next post link', 'purepress') . '</span>'); ?></li>
            </ul>
            <div class="clearfix"></div>
        </nav>
        <div class="line"></div>
        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (comments_open() || '0' != get_comments_number()) {
            comments_template('', true);
        }
        ?>
    </div>
    <!-- Content / End -->


    <?php if ($layout == 'right-sidebar') { ?>
        <!-- Sidebar -->
        <div class="four floated sidebar right">
            <?php get_sidebar(); ?>
        </div>
        <!-- Sidebar / End -->
    <?php } ?>


</div>
<!-- 960 Container / End -->