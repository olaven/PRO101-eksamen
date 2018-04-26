<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThinkUpThemes
 */
?>

		<div id="sidebar">
		<div id="sidebar-core">

			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( thinkup_input_sidebars() ) ) : ?>

				<aside class="widget widget_text">
					<h3 class="widget-title"><?php _e( 'Please Add Widgets', 'melos' ); ?></h3>
					<div class="textwidget"><div class="error-icon">
						<p><?php _e( 'Remove this message by adding widgets to the Sidebar from the Widgets section of the Wordpress admin area.', 'melos' ); ?></p>
						<a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>" title="<?php _e( 'No Widgets Selected', 'melos' ); ?>"><?php _e( 'Click here to go to Widget area.', 'melos' ); ?></a>
					</div></div>
				</aside>

			<?php endif; ?>

		</div>
		</div><!-- #sidebar -->
				