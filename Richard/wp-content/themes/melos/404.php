<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

	<div class="entry-content title-404">
		<h2><i class="fa fa-ban"></i>404</h2>
		<p><?php _e( 'Sorry, we could not find the page you are looking for.', 'høyskolen kristiana' ); ?><br/><?php _e( 'Please try using the search function.', 'høyskolen kristiana' ) ?></p>
		<?php echo get_search_form(); ?>
	</div>

<?php get_footer(); ?>