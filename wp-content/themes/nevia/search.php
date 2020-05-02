<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Nevia
 * @since Nevia 1.0
 */

$headertype = ot_get_option('pp_headertype');
if($headertype == 'full') { get_header('full'); } else { get_header(); }
 ?>

<!-- 960 Container -->
<div class="container floated">

	<div class="sixteen floated page-title">

		<h1><?php printf( __( 'Search Results for: %s', 'purepress' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

		<?php if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs(); ?>

	</div>

</div>
<!-- 960 Container / End -->
<!-- 960 Container -->
<div class="container floated">

	<!-- Page Content -->
	<div class="eleven floated">

		<?php if ( have_posts() ) : ?>

		<?php // nevia_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

	       <?php
                    /* Include the Post-Format-specific template for the content.
                     * If you want to overload this in a child theme then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    $format = get_post_format();
                    $formatslist = array('status','aside','quote','audio','chat','link');
                    if( false === $format  )  $format = 'standard';

                    if (in_array($format, $formatslist))  $format = 'standard';
                    $thumbstyle = ot_get_option('pp_blog_thumbs');
                    if($thumbstyle == 'small') {
                           get_template_part( 'postformats/'.$format , 'medium' );
                    } else {
                        get_template_part( 'postformats/'.$format );
                    }
                    ?>
                    <!-- Divider -->
                    <div class="line"></div>



                <?php endwhile; ?>

            <?php else : ?>

            <?php get_template_part( 'no-results', 'index' ); ?>

        <?php endif; ?>
        <?php if(function_exists('wp_pagenavi')) {
        	wp_pagenavi();
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

<!-- Sidebar -->
<div class="four floated sidebar right">
	<?php  get_sidebar(); ?>
</div>
<!-- Sidebar / End -->

</div>
<!-- 960 Container / End -->

<?php get_footer(); ?>