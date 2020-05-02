<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Nevia
 * @since Nevia 1.0
 */
?>

</div>
<!-- Content / End -->

</div>
<!-- Wrapper / End -->


<!-- Footer
================================================== -->

<!-- Footer / Start -->
<footer id="footer">
    <!-- 960 Container -->
    <div class="container">

        <div class="four columns">
             <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1st Column')) : endif; ?>
        </div>

        <div class="four columns">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2nd Column')) : endif; ?>
        </div>


        <div class="four columns">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3rd Column')) : endif; ?>
        </div>

        <div class="four columns">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 4th Column')) : endif; ?>
        </div>



    </div>
    <!-- 960 Container / End -->

</footer>
<!-- Footer / End -->


<!-- Footer Bottom / Start  -->
<footer id="footer-bottom">

    <!-- 960 Container -->
    <div class="container">

        <!-- Copyrights -->
        <div class="eight columns">
            <?php do_action( 'nevia_credits' ); ?>
            <div class="copyright">
               <?php $copyrights = ot_get_option('pp_copyrights' );
                if (function_exists('icl_register_string')) {
                    icl_register_string('Copyrights in footer','copyfooter', $copyrights);
                    echo icl_t('Copyrights in footer','copyfooter', $copyrights);
                } else {
                  echo $copyrights;
                } ?>
            </div>
        </div>

        <!-- Menu -->
        <div class="eight columns">
            <nav id="sub-menu">
                <?php wp_nav_menu( array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'depth' => '1',
                    'menu_class'      => '',
                )); ?>
            </nav>
        </div>

    </div>
    <!-- 960 Container / End -->

</footer>
<!-- Footer Bottom / End -->

<?php wp_footer(); ?>

</body>
</html>