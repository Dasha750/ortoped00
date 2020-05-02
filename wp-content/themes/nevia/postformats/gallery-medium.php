  <!-- Post -->
  <?php $format = get_post_format();
        if( false === $format )  $format = 'standard'; ?>
  <article <?php post_class('post medium '.$format); ?> id="post-<?php the_ID(); ?>" >
    <?php
    $ids = get_post_meta($post->ID, 'pp_gallery_slider', TRUE);
    $args = array(
      'post_type' => 'attachment',
      'post_status' => 'inherit',
      'post_mime_type' => 'image',
      'post__in' => explode( ",", $ids),
      'posts_per_page' => '-1',
      'orderby' => 'post__in'
      );


    $images_array = get_posts( $args );
    if ( $images_array ) { ?>
    <div class="medium-image">
      <section class="flexslider nonav">
      <ul class="slides post-img">
        <?php  foreach( $images_array as $images ) : setup_postdata($images);
          $attachment = wp_get_attachment_image_src($images->ID, 'large');
          $thumb = wp_get_attachment_image_src($images->ID, 'blog-medium');
          ?>
            <li><a href="<?php echo $attachment[0] ?>" rel="fancybox-gallery" title="<?php echo $images->post_title; ?>"><img src="<?php echo $thumb[0] ?>" alt="<?php echo $images->post_title; ?>" /></a></li>
          <?php  endforeach;  ?>
        </ul>
      </section></div>
      <?php } ?>

      <section class="date">
        <span class="day"><?php echo get_the_date('d'); ?></span>
        <span class="month"><?php echo get_the_date('M'); ?></span>
      </section>

      <section class="medium-content">

        <header class="meta">
          <h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark">
            <?php the_title(); ?>
          </a></h2>
          <?php nevia_posted_on(); ?>
        </header>

        <?php the_excerpt(); ?>

        <a href="<?php the_permalink(); ?>" class="button color"><?php  _e('Read More', 'purepress'); ?> </a>

      </section>

    </article>