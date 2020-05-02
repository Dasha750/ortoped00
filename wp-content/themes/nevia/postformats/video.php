  <!-- Post -->
  <?php $format = get_post_format();
        if( false === $format )  $format = 'standard'; ?>
  <article <?php post_class('post '.$format); ?> id="post-<?php the_ID(); ?>" >
    <?php
    if (( function_exists( 'get_post_format' ) && 'video' == get_post_format( $post->ID ) )  ) {
      global $wp_embed;
     $videoembed = get_post_meta($post->ID, 'pp_video_embed', true);
      if($videoembed) {
        echo '<section class="video" style="margin-bottom:20px">'.$videoembed.'</section>';
      } else {
        $videolink = get_post_meta($post->ID, 'pp_video_link', true);
        $post_embed = $wp_embed->run_shortcode('[embed  width="640" ]'.$videolink.'[/embed]') ;
        echo '<section class="video" style="margin-bottom:20px">'.$post_embed.'</section>';
      }
    } ?>
    <section class="date">
      <span class="day"><?php echo get_the_date('d'); ?></span>
      <span class="month"><?php echo get_the_date('M'); ?></span>
    </section>

    <section class="post-content">

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