<?php

/**
 * The class which handles manual Feeds import.
 *
 * @author     Time.ly Network Inc.
 * @since      2.4
 *
 * @package    AI1EC
 * @subpackage AI1EC.Calendar-feed
 */
class Ai1ecImportConnectorPlugin extends Ai1ec_Connector_Plugin {

    /**
     * @var array
     *   title: The title of the tab and the title of the configuration section
     *   id: The id used in the generation of the tab
     */
    protected $variables = array(
        'id' => 'import',
    );

    public function get_tab_title() {
        return Ai1ec_I18n::__( 'Import Feeds' );
    }

    public function __construct( Ai1ec_Registry_Object $registry ) {
        parent::__construct( $registry );
    }

    /**
     * Returns the translations array
     *
     * @return array
     */
    private function get_translations() {
        $categories = isset( $_POST['ai1ec_categories'] ) ? $_POST['ai1ec_categories'] : array();
        foreach ( $categories as &$cat ) {
            $term = get_term( $cat, 'events_categories' );
            $cat = $term->name;
        }
        $translations = array(
            '[feed_url]'   => $_POST['ai1ec_calendar_url'],
            '[categories]' => implode( ', ', $categories ),
            '[user_email]' => $_POST['ai1ec_submitter_email'],
            '[site_title]' => get_bloginfo( 'name' ),
            '[site_url]'   => ai1ec_site_url(),
            '[feeds_url]'  => ai1ec_admin_url(
                AI1EC_FEED_SETTINGS_BASE_URL . '#ics'
            ),
        );
        return $translations;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Ai1ec_Connector_Plugin::render_tab_content()
     */
    public function render_tab_content() {
        // Render the opening div
        $this->render_opening_div_of_tab();
        // Render the body of the tab
        $api           = $this->_registry->get( 'model.api.api-feeds' );
        $api_signed    = $api->is_signed();
        $settings      = $this->_registry->get( 'model.settings' );
        $factory       = $this->_registry->get(
            'factory.html'
        );
        $has_feature = $api->has_subscription_active(
            Ai1ec_Api_Features::CODE_IMPORT_FEEDS
            );
        $reached_limit = $api->subscription_has_reached_limit(
            Ai1ec_Api_Features::CODE_IMPORT_FEEDS
        );
        $select2_cats  = $factory->create_select2_multiselect(
            array(
                'name' => 'ai1ec_feed_category[]',
                'id' => 'ai1ec_feed_category',
                'use_id' => true,
                'type' => 'category',
                'placeholder' => __(
                    'Categories (optional)',
                    AI1EC_PLUGIN_NAME
                )
            ),
            get_terms(
                'events_categories',
                array(
                    'hide_empty' => false
                )
            )
        );
        $select2_tags = $factory->create_select2_input(
            array( 'id' => 'ai1ec_feed_tags')
        );
        $loader    = $this->_registry->get( 'theme.loader' );

        $args = array(
            'event_categories' => $select2_cats,
            'event_tags'       => $select2_tags,
            'api_signed'       => $api->is_signed(),
            'has_feature'      => $has_feature,
            'reached_limit'    => $reached_limit,
        );

        $import_feed = $loader->get_file(
            'plugins/ics/import_feed.php',
            $args,
            true
        );
        $import_feed->render();
        $this->render_closing_div_of_tab();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Ai1ec_Connector_Plugin::display_admin_notices()
     */
    public function display_admin_notices() {
        return;
    }
    /**
     * (non-PHPdoc)
     *
     * @see Ai1ec_Connector_Plugin::run_uninstall_procedures()
     */
    public function run_uninstall_procedures() {
    }

    /**
     * add_ics_feed function
     *
     * Adds submitted ics feed to the database
     *
     * @return string JSON output
     *
     */
    public function add_ics_feed() {
    }

    public function handle_feeds_page_post() {
    }

}
