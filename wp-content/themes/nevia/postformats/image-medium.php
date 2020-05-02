  <!-- Post -->
  <?php $format = get_post_format();
        if( false === $format )  $format = 'standard'; ?>
  <article <?php post_class('post medium '.$format); ?> id="post-<?php the_ID(); ?>" >
    <?php if(has_post_thumbnail()) { ?>
    <div class="medium-image"><figure class="post-img">
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-medium'); ?></a>
    </figure></div>
    <?php } ?>

    <section class="date">
      <span class="day"><?php echo get_the_date('d'); ?></span>
      <span class="month"><?php echo get_the_date('M'); ?></span>
    </section>

    <div class="medium-content">

      <header class="meta">
        <h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'purepress'), the_title_attribute('echo=0')); ?>" rel="bookmark">
          <?php the_title(); ?>
        </a></h2>
        <?php nevia_posted_on(); ?>
      </header>

      <?php the_excerpt(); ?>

      <a href="<?php the_permalink(); ?>" class="button color"><?php  _e('Read More', 'purepress'); ?> </a>

   </div>
  </article>