<?php
/**
 * The main template file.
 * @package MaryAnne
 * @since MaryAnne 1.0.0
*/
get_header(); ?>  
  <div id="main-content">    
    <div id="content"<?php if ($maryanne_options_db['maryanne_post_entry_format'] != 'Standard') { ?> class="content-grid"<?php } ?>>    
      <section class="home-latest-posts<?php if ($maryanne_options_db['maryanne_post_entry_format'] != 'Standard') { ?> js-masonry<?php } ?>">      
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if ($maryanne_options_db['maryanne_post_entry_format'] != 'Standard') {
get_template_part( 'content', 'grid' ); } else {
get_template_part( 'content', 'archives' ); } ?>
<?php endwhile; endif; ?>
      </section>
<?php maryanne_content_nav( 'nav-below' ); ?>  
    </div> <!-- end of content -->
<?php if ($maryanne_options_db['maryanne_post_entry_format'] == 'Standard') { ?>
<?php get_sidebar(); ?>
<?php } ?>
  </div> <!-- end of main-content -->
<?php get_footer(); ?>