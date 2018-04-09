<?php

/**
 * The Calendar Feeds page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Calendar_Feeds extends Ai1ec_View_Admin_Abstract {

    /**
     * Adds page to the menu.
     *
     * @wp_hook admin_menu
     *
     * @return void
     */
    public function add_page() {
        // =======================
        // = Calendar Feeds Page =
        // =======================
        $calendar_feeds = add_submenu_page(
            AI1EC_ADMIN_BASE_URL,
            Ai1ec_I18n::__( 'Import Feeds' ),
            Ai1ec_I18n::__( 'Import Feeds' ),
            'manage_ai1ec_feeds',
            AI1EC_PLUGIN_NAME . '-feeds',
            array( $this, 'display_page' )
        );
        $this->_registry->get( 'model.settings' )
            ->set( 'feeds_page', $calendar_feeds );
    }

    /**
     * Adds metabox to the page.
     *
     * @wp_hook admin_init
     *
     * @return void
     */
    public function add_meta_box() {
        // Add the 'ICS Import Settings' meta box.
        add_meta_box(
            'ai1ec-feeds',
            Ai1ec_I18n::_x( 'Feed Subscriptions', 'meta box' ),
            array( $this, 'display_meta_box' ),
            $this->_registry->get( 'model.settings' )->get( 'feeds_page' ),
            'left',
            'default'
        );
    }

    /**
     * Display this plugin's feeds page in the admin.
     *
     * @return void
     */
    public function display_page() {
        $settings = $this->_registry->get( 'model.settings' );
        $loader   = $this->_registry->get( 'theme.loader' );
        $args     = array(
            'title'             => __(
                'All-in-One Event Calendar: Import Feeds',
                AI1EC_PLUGIN_NAME
            ),
            'settings_page'     => $settings->get( 'feeds_page' ),
            'calendar_settings' => false,
        );
        $file     = $loader->get_file( 'feeds_settings.php', $args, true );
        wp_enqueue_style(
            'ai1ec_samples.css',
            AI1EC_ADMIN_THEME_CSS_URL . 'samples.css',
            array(),
            AI1EC_VERSION
        );
        $file->render();
    }

    /**
     * Renders the contents of the Calendar Feeds meta box.
     *
     * @return void
     */
    public function display_meta_box( $object, $box ) {
        // register the calendar feeds page.
        $calendar_feeds = $this->_registry->get( 'controller.calendar-feeds' );
        $feeds          = array();

        array_push( $feeds, $this->_registry->get( 'calendar-feed.import' ) );
        // Check for user subscription - Discover events
        if ($this->_api_registration->has_subscription_active( 'discover-events' ) ) {
            array_push( $feeds, $this->_registry->get( 'calendar-feed.suggested' ) );
        }

        // Add ICS
        array_push( $feeds, $this->_registry->get( 'calendar-feed.ics' ) );

        $feeds          = apply_filters( 'ai1ec_calendar_feeds', $feeds );
        foreach ( $feeds as $feed ) {
            $calendar_feeds->add_plugin( $feed );
        }
        $calendar_feeds->handle_feeds_page_post();
        $loader = $this->_registry->get( 'theme.loader' );
        $file   = $loader->get_file(
            'box_feeds.php',
            array( 'calendar_feeds' => $calendar_feeds ),
            true
        );
        $file->render();
    }

    public function handle_post() {
    }

}