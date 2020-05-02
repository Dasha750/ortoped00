<?php
/**
проверка
 * The template for displaying 404 pages (Not Found).
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

		<h2><?php _e("404 Page Not Found", 'purepress' ); ?></h2>

	</div>

</div>
<!-- 960 Container / End -->


<!-- Page Content -->
<div class="page-content">

	<!-- 960 Container -->
	<div class="container">

		<!-- Sixteen Columns -->
		<div class="sixteen columns">

			<section id="not-found">
				<h2>404 <i class="icon-file"></i></h2>
				<p><?php _e("We're sorry, but the page you were looking for doesn't exist.", 'purepress' ); ?></p>
			</section>

		</div>

	</div>
	<!-- 960 Container / End -->

</div>
<!-- Page Content / End -->


<?php // get_sidebar(); ?>
<?php get_footer(); ?>


