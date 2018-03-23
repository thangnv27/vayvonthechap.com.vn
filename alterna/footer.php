<?php

/**

 * The Footer for our theme.

 *

 * @since alterna 7.0

 */

?>

            </div><!-- end content-wrap -->



            <div class="footer-wrap">

                <footer class="footer-content">

                    <?php get_template_part( 'template/footer/widgets' );?>

                    <div class="footer-bottom-content">

                        <?php get_template_part( 'template/footer/copyrights' );?>

                    </div>

                </footer>

                <?php get_template_part( 'template/footer/banner' );?>

            </div><!-- end footer-wrap -->

        </div><!-- end wrapper -->

        <?php wp_footer() ?>

	<a href="tel:0938603822" class="goi-ngay call-now"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/goi_ngay.png"></a>
    </body>

</html>