<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 * @modified    purethemes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>
<?php $blog_layout = ot_get_option('pp_blog_layout','right-sidebar'); ?>
<!-- 960 Container -->
<div class="container floated">

	<div class="sixteen floated page-title">

		<h2><?php if ( is_search() ) : ?>
			<?php
			printf( __( 'Search Results: &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
			if ( get_query_var( 'paged' ) )
				printf( __( '&nbsp;&ndash; Page %s', 'woocommerce' ), get_query_var( 'paged' ) );
			?>
		<?php elseif ( is_tax() ) : ?>
		<?php echo single_term_title( "", false ); ?>
	<?php else : ?>
	<?php
	$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
	echo ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title ;
	?>
<?php endif; ?>

</h2>

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
    	<div class="eleven floated  <?php if($blog_layout == 'left-sidebar') { echo 'right'; } ?>">
    		<div class="shop-page page-content">
    			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action('woocommerce_before_main_content');
				?>

				<?php while ( have_posts() ) : the_post(); ?>

				<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action('woocommerce_after_main_content');
					?>
		</div>
	</div>
<!-- Page Content / End -->
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
