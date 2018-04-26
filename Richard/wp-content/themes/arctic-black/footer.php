<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arctic Black
 */

$setting = arctic_black_setting_default();
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php if ( get_theme_mod( 'footer-image', $setting['footer_image'] ) !== '' ) :?>
			<div class="footer-image"></div>
		<?php endif;?>

		<?php get_sidebar( 'footer' );?>

		<?php get_template_part( 'template-parts/footer', 'social' );?>

		<?php arctic_black_do_footer_copyright();?>

	</footer><!-- #colophon -->

	<?php get_sidebar( 'instagram' );?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
