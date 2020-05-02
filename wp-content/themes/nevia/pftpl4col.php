<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage purepress
 * @since purepress 1.0
 */
?>
<style type="text/css">
	@media only screen and (max-width: 767px) and (min-width: 480px) { #portfolio-wrapper iframe {min-width: 358px; min-height: 210px} #portfolio-wrapper img {min-width: 359px;}}
	@media only screen and (max-width: 479px)  { #portfolio-wrapper iframe {min-width: 358px; min-height: 210px} #portfolio-wrapper img {min-width: 259px;}}
</style>
<!-- Page Content -->
<div class="page-content portfolio">

	<!-- 960 Container -->
	<div class="container">
		<div class="sixteen columns">

			<!-- Filters -->
			<?php
			$filterswitcher = get_post_meta($post->ID, 'pp_filters_switch', true);
			if($filterswitcher != 'no') {
				$filters = get_post_meta($post->ID, 'portfolio_filters', true);
				if(!empty($filters)) { ?>
				<div id="filters" class="filters-dropdown"><span><?php  _e('All', 'purepress'); ?></span>
					<ul class="option-set" data-option-key="filter">
						<li><a href="#filter" class="selected" data-option-value="*"><?php  _e('All', 'purepress'); ?></a></li>
						<?php
						foreach ( $filters as $id ) {
							$term = get_term( $id, 'filters' );
							echo '<li><a href="#filter" data-option-value=".'.$term->slug.'">'. $term->name .'</a></li>';

						} ?>
					</ul>
				</div>
				<?php } }
				if(!is_tax()) {

					$terms = get_terms("filters");
					$count = count($terms);
					if ( $count > 0 ){ ?>
					<div id="filters" class="filters-dropdown"><span><?php  _e('All', 'purepress'); ?></span>
						<ul class="option-set" data-option-key="filter">
							<li><a href="#filter" class="selected" data-option-value="*"><?php  _e('All', 'purepress'); ?></a></li>
							<?php
							foreach ( $terms as $term ) {
								echo '<li><a href="#filter" data-option-value=".'.$term->slug.'">'. $term->name .'</a></li>';

							} ?>
						</ul>
					</div>
					<?php }
				} ?>
			</div>
		</div>
		<!-- 960 Container / End -->


		<!-- 960 Container -->
		<div class="container">

			<!-- Portfolio Content -->
			<div id="portfolio-wrapper">


				<!-- Post -->
				<?php
				while (have_posts()) : the_post(); ?>
				<!-- Portfolio Item -->
				<div <?php post_class('four columns isotope-item'); ?> id="post-<?php the_ID(); ?>" >
					<a href="<?php the_permalink(); ?>" class="portfolio-item isotope">
						<figure>
							<?php
							$type  = get_post_meta($post->ID, 'pp_pf_type', true);
							$videothumbtype = ot_get_option('pp_portfolio_videothumb');
							if($type == 'video' && $videothumbtype == 'video') {
								$videoembed = get_post_meta($post->ID, 'pp_pfvideo_embed', true);
								if($videoembed) {
									echo '<div class="video">'.$videoembed.'</div>';
								} else {
									global $wp_embed;
									$videolink = get_post_meta($post->ID, 'pp_pfvideo_link', true);
									$post_embed = $wp_embed->run_shortcode('[embed  width="220" height="160"]'.$videolink.'[/embed]') ;
									echo '<div class="video">'.$post_embed.'</div>';
								}
							} else {
									the_post_thumbnail("portfolio-small");
							} ?>
							<figcaption class="item-description">
								<h5><?php the_title(); ?></h5>
								<?php $terms = get_the_terms( $post->ID, 'filters' );
									if ( $terms && ! is_wp_error( $terms ) ) : echo '<span>';
										$filters = array();
										$i = 1;
										foreach ( $terms as $term ) {
											if ($i++ > 2) break;
											$filters[] = $term->name;

										}
										$outputfilters = join( ", ", $filters ); echo $outputfilters;
									echo '</span>';
									endif; ?>
							</figcaption>
						</figure>
					</a>
				</div>
				<!-- eof Portfolio Item -->

			<?php endwhile; // End the loop. Whew.  ?>
		</div>
		<!-- 960 Container -->
		<div class="container">
			<div class="columns sixteen">
			<?php if(function_exists('wp_pagenavi')) {
                wp_pagenavi();
            } else { ?>
			<?php if ( get_next_posts_link() ||  get_previous_posts_link() ) : ?>
                <nav class="pagination">
                    <ul>
                    <?php if ( get_next_posts_link() ) : ?>
                    <li class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous page', 'purepress' ) ); ?></li>
                    <?php endif; ?>

                    <?php if ( get_previous_posts_link() ) : ?>
                    <li class="nav-next"><?php previous_posts_link( __( 'Next page <span class="meta-nav">&rarr;</span>', 'purepress' ) ); ?></li>
                    <?php endif; ?>
                    </ul>
                    <div class="clearfix"></div>
                </nav>
            <?php endif; ?>
            <?php } ?>
            </div>
		</div>