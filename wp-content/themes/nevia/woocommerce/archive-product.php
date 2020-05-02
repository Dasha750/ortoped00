<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 * @modified    purethemes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>
<?php $blog_layout = ot_get_option('pp_blog_layout','right-sidebar'); ?>
<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
		?>
		<div class="container floated">

			<div class="sixteen floated page-title">
				<h2><?php woocommerce_page_title(); ?></h2>

        <?php //
        woocommerce_breadcrumb(array(
        	'delimiter'  => ' ',
        	'wrap_before'  => '<nav id="breadcrumbs"><ul><li>You are here: </li>',
        	'wrap_after' => '</ul></nav>',
        	'before'   => '<li class="current_element">',
        	'after'   => '</li>',
        	'home'    => null
        	));
        // if(ot_get_option('pp_breadcrumbs') != 'no') echo dimox_breadcrumbs();
        	?>
        </div>
    </div>
    <!-- 960 Container / End -->

    <!-- 960 Container -->
    <div class="container floated">

        <?php if($blog_layout == 'left-sidebar') { ?>
            <!-- Sidebar -->
            <div class="four floated sidebar left">
                <?php do_action('woocommerce_sidebar'); ?>
            </div>
            <!-- Sidebar / End -->
        <?php } ?>
    	<!-- Page Content -->
    	<div class="eleven floated  <?php if($blog_layout == 'left-sidebar') { echo 'right'; } ?>">
    		<div class="shop-page page-content">
    			<?php do_action( 'woocommerce_archive_description' ); ?>
    			<!-- Isotope -->

    				<?php if ( have_posts() ) : ?>

    				<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
				?>

				<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

				    <?php  woocommerce_get_template_part( 'content', 'product' ); ?>

			     <?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>


			<?php else : ?>

    <?php if ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( true ) ) ) ) : ?>
    <div class="shop-wrapper">
       <?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>


    <?php endif; ?>

<?php endif; ?>
	<div class="clear"></div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
		?>
    <?php
            /**
             * woocommerce_after_shop_loop hook
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action( 'woocommerce_after_shop_loop' );
            ?>

	</div>
</div>
<!-- Page Content / End -->
<!-- Sidebar -->
<?php if($blog_layout == 'right-sidebar') { ?>
<!-- Sidebar -->
<div class="four floated sidebar right">
    <?php do_action('woocommerce_sidebar'); ?>
</div>
<!-- Sidebar / End -->
<?php } ?>

</div>
<!-- 960 Container / End -->

<?php get_footer('shop'); ?>
