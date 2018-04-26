<?php
/**
 * Arctic vendor configuration.
 *
 * @package Arctic Black
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/vendor/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 */
function arctic_black_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			/* Recommended plugin name */
			'name'      => __( 'WP Term Images', 'arctic-black' ),
			'slug'      => 'wp-term-images',
			'required'  => false,
		),

		array(
			/* Recommended plugin name */
			'name'      => __( 'WP Instagram Widget', 'arctic-black' ),
			'slug'      => 'wp-instagram-widget',
			'required'  => false,
		)

	);

	/*
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'arctic-black',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'arctic_black_register_required_plugins' );
