<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arctic Black
 */

if ( ! is_active_sidebar( 'sidebar-4' ) ) {
	return;
}
?>

<aside id="quaternary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-4' ); ?>
</aside><!-- #secondary -->
