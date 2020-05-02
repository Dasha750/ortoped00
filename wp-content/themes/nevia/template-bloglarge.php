<?php
/**
 * Template Name: Blog Template - Large thumbs
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */

$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }

wp_reset_query();

?>
     <!-- 960 Container -->
     <div class="container floated">

        <div class="sixteen floated page-title">

            <h2><?php
            if ( is_category() ) {
                printf( __( 'Category Archives: %s', 'purepress' ), '<span>' . single_cat_title( '', false ) . '</span>' );

            } elseif ( is_tag() ) {
                printf( __( 'Tag Archives: %s', 'purepress' ), '<span>' . single_tag_title( '', false ) . '</span>' );

            } elseif ( is_author() ) {
                /* Queue the first post, that way we know
                 * what author we're dealing with (if that is the case).
                */
                the_post();
                printf( __( 'Author Archives: %s', 'purepress' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
                /* Since we called the_post() above, we need to
                 * rewind the loop back to the beginning that way
                 * we can run the loop properly, in full.
                 */
                rewind_posts();

            } elseif ( is_day() ) {
                printf( __( 'Daily Archives: %s', 'purepress' ), '<span>' . get_the_date() . '</span>' );

            } elseif ( is_month() ) {
                printf( __( 'Monthly Archives: %s', 'purepress' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

            } elseif ( is_year() ) {
                printf( __( 'Yearly Archives: %s', 'purepress' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

            } else {
               $pp_blog_page = ot_get_option('pp_blog_page');
                if (function_exists('icl_register_string')) {
                    icl_register_string('Blog page title','pp_blog_page', $pp_blog_page);
                    echo icl_t('Blog page title','pp_blog_page', $pp_blog_page); }
                else {
                    echo $pp_blog_page;
                }

            }
            ?></h2>

            <?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>

        </div>

    </div>
    <!-- 960 Container / End -->
    <?php $blog_layout = ot_get_option('pp_blog_layout','right-sidebar'); ?>
    <!-- 960 Container -->
    <div class="container floated main">
        <?php if($blog_layout == 'left-sidebar') { ?>
                <!-- Sidebar -->
                <div class="four floated sidebar left">
                    <?php  get_sidebar(); ?>
                </div>
                <!-- Sidebar / End -->
        <?php } ?>
        <!-- Page Content -->
        <div class="eleven floated  <?php if($blog_layout == 'left-sidebar') { echo 'right'; } ?>">

            <?php if ( have_posts() ) : ?>

            <?php /* Start the Loop */ ?>
            <?php while (have_posts()) : the_post();
                    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
                    $args = array('
                        offset'=> 0,
                        'paged'=>$paged,
                        'posts_per_page' => get_option('posts_per_page'),
                        'post_type' => 'post'
                        );
                    $all_posts = new WP_Query($args);
                    while($all_posts->have_posts()) : $all_posts->the_post(); ?>

                    <?php
                    /* Include the Post-Format-specific template for the content.
                     * If you want to overload this in a child theme then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    $format = get_post_format();
                    if( false === $format )  $format = 'standard';
                    get_template_part( 'postformats/'.$format );

                    ?>
                    <!-- Divider -->
                    <div class="line"></div>

                    <?php endwhile; ?>
                <?php endwhile; ?>

                <?php else : ?>

                <?php get_template_part( 'no-results', 'index' ); ?>

            <?php endif; ?>
            <?php if(function_exists('wp_pagenavi')) {
                wp_pagenavi( array( 'query' => $all_posts ) );
            } else { ?>
                <?php if ( get_next_posts_link() ||  get_previous_posts_link() ) : ?>
                <nav class="pagination">
                    <ul>
                    <?php if ( get_next_posts_link() ) : ?>
                    <li class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'purepress' ) ); ?></li>
                    <?php endif; ?>

                    <?php if ( get_previous_posts_link() ) : ?>
                    <li class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'purepress' ) ); ?></li>
                    <?php endif; ?>
                    </ul>
                    <div class="clearfix"></div>
                </nav>
                <?php endif; ?>
            <?php } ?>

        </div>
        <!-- Content / End -->
        <?php if($blog_layout == 'right-sidebar') { ?>
            <!-- Sidebar -->
            <div class="four floated sidebar right">
                <?php  get_sidebar(); ?>
            </div>
            <!-- Sidebar / End -->
        <?php } ?>
    </div>
    <!-- 960 Container / End -->

<?php
wp_reset_query();
get_footer(); ?>