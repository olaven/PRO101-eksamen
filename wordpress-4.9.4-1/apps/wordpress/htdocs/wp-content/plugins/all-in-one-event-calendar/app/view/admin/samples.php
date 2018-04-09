<?php

/**
 * The Calendar Samples page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.1
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Samples extends Ai1ec_View_Admin_Abstract {
	/**
	 * Adds page to the menu.
	 *
	 * @wp_hook admin_menu
	 *
	 * @return void
	 */
	public function add_page() {
		// =======================
		// = Calendar Add Ons Page =
		// =======================
		add_submenu_page(
			AI1EC_ADMIN_BASE_URL,
			Ai1ec_I18n::__( 'Samples' ),
			Ai1ec_I18n::__( 'Samples' ),
			'manage_ai1ec_options',
			AI1EC_PLUGIN_NAME . '-samples',
			array( $this, 'display_page' )
		);
	}
	/**
	 * Display Add Ons list page.
	 *
	 * @return void
	 */
	public function display_page() {
		wp_enqueue_style(
			'ai1ec_samples.css',
			AI1EC_ADMIN_THEME_CSS_URL . 'samples.css',
			array(),
			AI1EC_VERSION
		);

		$this->_registry->get( 'theme.loader' )->get_file(
			'samples.twig',
			array(),
			true
		)->render();
	}

	public function add_meta_box() {
	}

	public function display_meta_box( $object, $box ) {
	}

	public function handle_post() {
	}

}
