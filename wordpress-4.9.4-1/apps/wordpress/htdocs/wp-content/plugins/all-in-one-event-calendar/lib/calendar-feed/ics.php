<?php

/**
 * The class which handles ics feeds tab.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Calendar-feed
 */
class Ai1ecIcsConnectorPlugin extends Ai1ec_Connector_Plugin {

    /**
     * @var string Name of cron hook.
     */
    const HOOK_NAME = 'ai1ec_cron';

    const ICS_OPTION_DB_VERSION = 'ai1ec_ics_db_version';

    const ICS_DB_VERSION        = 236;

    /**
     * @var array
     *   title: The title of the tab and the title of the configuration section
     *   id: The id used in the generation of the tab
     */
    protected $variables = array(
        'id' => 'ics',
    );

    /**
     * @var Ai1ec_Compatibility_Xguard Instance of execution guard.
     */
    protected $_xguard   = null;

    protected $_api_feed = null;

    public function get_tab_title() {
        return Ai1ec_I18n::__( 'My Feeds' );
    }

    public function __construct( Ai1ec_Registry_Object $registry ) {
        parent::__construct( $registry );
        // Handle schema changes.
        $this->_install_schema();
        // Install the CRON
        $this->install_cron();
        $this->_xguard = $registry->get( 'compatibility.xguard' );
        $this->_api_feed = $registry->get( 'model.api.api-feeds' );
    }

    /**
     * update_ics_feed function
     *
     * Imports the selected iCalendar feed
     *
     * @return void
     */
    public function update_ics_feed( $feed_id = false ) {
        $ajax = false;
        // if no feed is provided, we are using ajax
        if ( ! $feed_id ) {
            $ajax    = true;
            $feed_id = (int) $_REQUEST['ics_id'];
        }
        $cron_name = $this->_import_lock_name( $feed_id );
        $output    = array(
            'data' => array(
                'ics_id'  => $feed_id,
                'error'   => true,
                'message' => Ai1ec_I18n::__(
                    'Another import process in progress. Please try again later.'
                ),
            ),
        );
        // hold import lock for 8 minutes
        if ( $this->_xguard->acquire( $cron_name, 480 ) ) {
            $output = $this->process_ics_feed_update( $ajax, $feed_id );
        }
        $this->_xguard->release( $cron_name );
        if ( true === $ajax ) {
            $render_json = $this->_registry->get(
                'http.response.render.strategy.json'
            );
            return $render_json->render( $output );
        }
        return $output;
    }

    /**
     * Perform actual feed refresh.
     *
     * @param bool $ajax    True when handling AJAX feed.
     * @param int  $feed_id ID of feed to process.
     *
     * @return array Output to return to user.
     */
    public function process_ics_feed_update( $ajax, $feed_id ) {
        $db         = $this->_registry->get( 'dbi.dbi' );
        $table_name = $db->get_table_name( 'ai1ec_event_feeds' );
        $feed       = $db->get_row(
            $db->prepare(
                'SELECT * FROM ' . $table_name . ' WHERE feed_id = %d', $feed_id
            )
        );

        $message    = '';
        $output = array();

        if ( $feed ) {
            // Migrate manually imported feed URLs to API
            if ( ! is_numeric( $feed->feed_name ) ) {
                // Build array with feed options
                $entry = array(
                    'feed_url'             => $feed->feed_url,
                    'feed_category'        => $feed->feed_category,
                    'feed_tags'            => $feed->feed_tags,
                    'comments_enabled'     => $feed->comments_enabled,
                    'map_display_enabled'  => $feed->map_display_enabled,
                    'keep_tags_categories' => $feed->keep_tags_categories,
                    'keep_old_events'      => $feed->keep_old_events,
                    'import_timezone'      => $feed->import_timezone
                );

                // Import to API
                try {
                    $response = $this->_api_feed->import_feed( $entry );

                    $api_feed = $this->_api_feed;

                    $db->update(
                        $table_name,
                        array(
                            'feed_name' => $response->id
                        ),
                        array(
                            'feed_id' => $feed_id
                        )
                    );
                    // Set ID
                    $feed->feed_name = $response->id;
                } catch ( Exception $e ) {
                    $message = $e->getMessage();
                }
            }
            // Only process if we have the API feed ID
            if ( is_numeric( $feed->feed_name ) ) {
                $count = 0;

                try {
                    $response                   = $this->_api_feed->get_feed( $feed->feed_name );

                    $import_export              = $this->_registry->get( 'controller.import-export' );

                    $search                     = $this->_registry->get( 'model.search' );
                    $events_in_db               = $search->get_event_ids_for_feed( $feed->feed_url );
                    // flip the array. We will use keys to check events which are imported.
                    $events_in_db               = array_flip( $events_in_db );
                    $args                       = array();
                    $args['events_in_db']       = $events_in_db;
                    $args['feed']               = $feed;

                    $args['comment_status']     = 'open';
                    if ( isset( $feed->comments_enabled ) && $feed->comments_enabled < 1 ) {
                        $args['comment_status'] = 'closed';
                    }

                    $args['do_show_map']        = 0;
                    if ( isset( $feed->map_display_enabled ) && $feed->map_display_enabled > 0 ) {
                        $args['do_show_map']    = 1;
                    }
                    $args['source']             = $response;
                    do_action( 'ai1ec_ics_before_import', $args );

                    $result                     = $import_export->import_events( 'api-ics', $args );

                    do_action( 'ai1ec_ics_after_import' );
                    $count                      = $result['count'];
                    $feed_name                  = $result['name'];
                    // we must flip again the array to iterate over it
                    if ( 0 == $feed->keep_old_events ) {
                        $events_to_delete = array_flip( $result['events_to_delete'] );
                        foreach ( $events_to_delete as $event_id ) {
                            wp_delete_post( $event_id, true );
                        }
                    }
                } catch ( Exception $e ) {
                    $message = $e->getMessage();
                }
            }
            if ( $message ) {
                // If we already got an error message, display it.
                $output['data'] = array(
                        'error'   => true,
                        'message' => $message,
                );
            } else {
                $output['data'] = array(
                        'error'   => false,
                        'message' => sprintf( _n( 'Imported %s event', 'Imported %s events', $count, AI1EC_PLUGIN_NAME ), $count ),
                        'name'    => $feed_name,
                );
            }
        } else {
            $output['data'] = array(
                    'error'     => true,
                    'message'    => __( 'Invalid ICS feed ID', AI1EC_PLUGIN_NAME )
            );
        }

        $output['data']['ics_id'] = $feed_id;
        return $output;
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
     * This function sets up the cron job for updating the events, and upgrades it if it is out of date.
     *
     * @return void
     */
    private function install_cron() {
        $this->_registry->get( 'scheduling.utility' )->reschedule(
            self::HOOK_NAME,
            $this->_registry->get( 'model.settings' )->get( 'ics_cron_freq' ),
            AI1EC_CRON_VERSION
        );
    }

    /**
     * Handles all the required steps to install / update the schema
     */
    protected function _install_schema() {
        // If existing DB version is not consistent with current plugin's
        // version,
        // or does not exist, then create/update table structure using
        // dbDelta().
        $option             = $this->_registry->get( 'model.option' );
        $current_db_version = $option->get( self::ICS_OPTION_DB_VERSION );
        if ( $current_db_version != self::ICS_DB_VERSION ) {
            /** @var $db Ai1ec_Dbi */
            $db = $this->_registry->get( 'dbi.dbi' );
            // ======================
            // = Create table feeds =
            // ======================
            $table_name = $db->get_table_name( 'ai1ec_event_feeds' );
            $sql = "CREATE TABLE $table_name (
                    feed_id bigint(20) NOT NULL AUTO_INCREMENT,
                    feed_url varchar(255) NOT NULL,
                    feed_name varchar(255) NOT NULL,
                    feed_category varchar(255) NOT NULL,
                    feed_tags varchar(255) NOT NULL,
                    comments_enabled tinyint(1) NOT NULL DEFAULT '1',
                    map_display_enabled tinyint(1) NOT NULL DEFAULT '0',
                    keep_tags_categories tinyint(1) NOT NULL DEFAULT '0',
                    keep_old_events tinyint(1) NOT NULL DEFAULT '0',
                    import_timezone tinyint(1) NOT NULL DEFAULT '0',
                    PRIMARY KEY  (feed_id),
                    UNIQUE KEY feed (feed_url)
                    ) CHARACTER SET utf8;";
            if ( $this->_registry->get( 'database.helper' )->apply_delta( $sql ) ) {
                $option->set( self::ICS_OPTION_DB_VERSION,
                    self::ICS_DB_VERSION );
            } else {
                trigger_error( 'Failed to upgrade ICS DB schema',
                    E_USER_WARNING );
            }
        }
    }

    /**
     * Cron callback.
     *
     * (Re-)Import all ICS feeds.
     *
     * @wp_hook ai1ec_cron
     *
     * @return void
     */
    public function cron() {
        $this->_api_feed->check_settings();

        if ( false === $this->_api_feed->is_signed() ) {
            return;
        }

        $db = $this->_registry->get( 'dbi.dbi' );
        // Initializing custom post type and custom taxonomies
        $post_type = $this->_registry->get( 'post.custom-type' );
        $post_type->register();

        // =======================
        // = Select all feed IDs =
        // =======================
        $sql        = 'SELECT `feed_id` FROM ' .
            $db->get_table_name( 'ai1ec_event_feeds' );
        $feeds      = $db->get_col( $sql );

        // ===============================
        // = go over each iCalendar feed =
        // ===============================
        foreach ( $feeds as $feed_id ) {
            // update the feed
            $this->update_ics_feed( $feed_id );
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see Ai1ec_Connector_Plugin::handle_feeds_page_post()
     */
    public function handle_feeds_page_post() {
        $settings = $this->_registry->get( 'model.settings' );
        if ( isset( $_POST['cron_freq'] ) ) {
            $settings->set( 'ics_cron_freq', $_REQUEST['cron_freq'] );
        }
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
        $api_feed   = $this->_api_feed;
        $api_signed = $api_feed->is_signed();
        $settings   = $this->_registry->get( 'model.settings' );
        $factory    = $this->_registry->get(
            'factory.html'
        );
        $select2_cats = $factory->create_select2_multiselect(
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
            array( 'id' => 'ai1ec_feed_tags' )
        );
        $modal = $this->_registry->get(
            'html.element.legacy.bootstrap.modal',
            esc_html__(
                "Do you want to keep the events imported from the calendar or remove them?",
                AI1EC_PLUGIN_NAME
            )
        );
        $modal->set_header_text(
            esc_html__( 'Removing ICS Feed', AI1EC_PLUGIN_NAME )
        );
        $modal->set_keep_button_text(
            esc_html__( 'Keep Events', AI1EC_PLUGIN_NAME )
        );
        $modal->set_delete_button_text(
            esc_html__( 'Remove Events', AI1EC_PLUGIN_NAME )
        );
        $modal->set_id( 'ai1ec-ics-modal' );
        $loader    = $this->_registry->get( 'theme.loader' );
        $cron_freq = $loader->get_file(
            'cron_freq.php',
            array( 'cron_freq' => $settings->get( 'ics_cron_freq' ) ),
            true
        );

        $db          = $this->_registry->get( 'dbi.dbi' );
        $table_name  = $db->get_table_name( 'ai1ec_event_feeds' );
        $sql         = "SELECT COUNT(*) FROM $table_name WHERE $table_name.feed_name REGEXP '[a-zA-Z]+'";
        $local_feeds = $db->get_var( $sql );
        $args        = array(
            'cron_freq'        => $cron_freq->get_content(),
            'event_categories' => $select2_cats,
            'event_tags'       => $select2_tags,
            'feed_rows'        => $this->_get_feed_rows( $api_feed->getStaticVar('FEED_API_ALL_EVENTS_CODE') ),
            'single_feed_rows' => $this->_get_feed_rows( $api_feed->getStaticVar('FEED_API_SOME_EVENTS_CODE') ),
            'modal'            => $modal,
            'api_signed'       => $api_signed,
            'migration'        => $api_signed && 0 < $local_feeds
        );

        $display_feeds = $loader->get_file(
            'plugins/ics/display_feeds.php',
            $args,
            true
        );
        $display_feeds->render();
        $this->render_closing_div_of_tab();
    }

    /**
     * get_feed_rows function
     *
     * Creates feed rows to display on settings page
     *
     * @return String feed rows
     **/
    protected function _get_feed_rows( $feed_status ) {
        // Select all added feeds
        $rows = $this->_registry->get( 'dbi.dbi' )->select(
            'ai1ec_event_feeds',
            array(
                'feed_id',
                'feed_url',
                'feed_name',
                'feed_category',
                'feed_tags',
                'comments_enabled',
                'map_display_enabled',
                'keep_tags_categories',
                'keep_old_events',
                'import_timezone'
            )
        );

        $html              = '';
        $theme_loader      = $this->_registry->get( 'theme.loader' );
        $api_feed          = $this->_api_feed;
        $api_signed        = $api_feed->is_signed();
        // Get list of subscriptions
        $api_subscriptions = $api_feed->get_feed_subscriptions();

        foreach ( $rows as $row ) {
            $row_feed_status = $this->getFeedStatus( $row->feed_name );

            // If the status of the feed is different from requested, skip
            if ( $api_feed->getStaticVar('FEED_API_ALL_EVENTS_CODE') === $feed_status && $row_feed_status === $api_feed->getStaticVar('FEED_API_SOME_EVENTS_CODE') ) {
                continue;
            } else if ( $api_feed->getStaticVar('FEED_API_SOME_EVENTS_CODE') === $feed_status && $feed_status !== $row_feed_status ) {
                continue;
            }

            $feed_categories = explode( ',', $row->feed_category );
            $categories      = array();

            foreach ( $feed_categories as $cat_id ) {
                $feed_category = get_term(
                    $cat_id,
                    'events_categories'
                );
                if ( $feed_category && ! is_wp_error( $feed_category ) ) {
                    $categories[] = $feed_category->name;
                }
            }
            unset( $feed_categories );

            // Get event UIDs
            $feed_events_uids = array();
            if ( $api_feed->getStaticVar('FEED_API_SOME_EVENTS_CODE') === $feed_status ) {
                foreach ( $api_subscriptions as $api_subscription ) {
                    if ( $api_subscription->feed_id === $row->feed_name ) {
                        $feed_events_uids = (array) $api_subscription->feed_events_uids;
                        break;
                    }
                }
            }

            $args          = array(
                'feed_url'             => $row->feed_url,
                'feed_name'            => ! empty( $row->feed_name ) ? $row->feed_name : $row->feed_url,
                'feed_events_uids'     => $feed_events_uids,
                'event_category'       => implode( ', ', $categories ),
                'categories_ids'       => $row->feed_category,
                'tags'                 => stripslashes(
                    str_replace( ',', ', ', $row->feed_tags )
                ),
                'tags_ids'             => $row->feed_tags,
                'feed_id'              => $row->feed_id,
                'comments_enabled'     => (bool) intval(
                        $row->comments_enabled
                ),
                'map_display_enabled'  => (bool) intval(
                        $row->map_display_enabled
                ),
                'keep_tags_categories' => (bool) intval(
                        $row->keep_tags_categories
                ),
                'keep_old_events'      => (bool) intval(
                        $row->keep_old_events
                ),
                'feed_import_timezone' => (bool) intval(
                        $row->import_timezone
                ),
                'feed_status'          => $row_feed_status,
                'api_signed'           => $api_signed,
            );
            $html .= $theme_loader->get_file( 'feed_row.php', $args, true )
                ->get_content();
        }

        return $html;
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
        // Delete tables
        $dbi        = $this->_registry->get( 'dbi.dbi' );
        $table_name = $dbi->get_table_name( 'ai1ec_event_feeds' );
        $dbi->query( 'DROP TABLE IF EXISTS ' . $table_name );
        // Delete scheduled tasks
        $this->_registry->get( 'scheduling.utility' )
            ->delete( self::HOOK_NAME );
        // Delete options
        delete_option( self::ICS_DB_VERSION );
        delete_option( self::ICS_OPTION_DB_VERSION );
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
        check_ajax_referer( 'ai1ec_ics_feed_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_ai1ec_feeds' ) ) {
            wp_die( Ai1ec_I18n::__( 'Oh, submission was not accepted.' ) );
        }

        $api_feed   = $this->_api_feed;

        $db = $this->_registry->get( 'dbi.dbi' );
        $table_name = $db->get_table_name( 'ai1ec_event_feeds' );

        $feed_categories = empty( $_REQUEST['feed_category'] ) ? '' : implode(
            ',', $_REQUEST['feed_category'] );

        $json_strategy = $this->_registry->get(
            'http.response.render.strategy.json'
        );

        $entry = array(
            'feed_url'             => $_REQUEST['feed_url'],
            'feed_category'        => $feed_categories,
            'feed_tags'            => $_REQUEST['feed_tags'],
            'comments_enabled'     => Ai1ec_Primitive_Int::db_bool(
                $_REQUEST['comments_enabled']
            ),
            'map_display_enabled'  => Ai1ec_Primitive_Int::db_bool(
                $_REQUEST['map_display_enabled']
            ),
            'keep_tags_categories' => Ai1ec_Primitive_Int::db_bool(
                $_REQUEST['keep_tags_categories']
            ),
            'keep_old_events'      => Ai1ec_Primitive_Int::db_bool(
                $_REQUEST['keep_old_events']
            ),
            'import_timezone'      => Ai1ec_Primitive_Int::db_bool(
                $_REQUEST['feed_import_timezone']
            )
        );

        // Import to the API
        $api_signed               = $this->_api_feed->is_signed();
        try {
            $response             = $this->_api_feed->import_feed( $entry );
        } catch ( Exception $e ) {
            $output = array(
                'error'   => true,
                'message' => $e->getMessage()
            );
            return $json_strategy->render( array( 'data' => $output ) );
        }

        // Get API feed ID
        $entry['feed_name']       = $response->id;

        $entry                    = apply_filters( 'ai1ec_ics_feed_entry', $entry );

        if ( is_wp_error( $entry ) ) {
            $output = array(
                'error'   => true,
                'message' => $entry->get_error_message()
            );
            return $json_strategy->render( array( 'data' => $output ) );
        }

        $format  = array( '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%s' );

        if ( ! empty( $_REQUEST['feed_id'] ) ) {
            $feed_id = $_REQUEST['feed_id'];

            $db->update(
                $table_name,
                $entry,
                array( 'feed_id' => $feed_id )
            );
        } else {
            $res        = $db->insert( $table_name, $entry, $format );
            $feed_id    = $db->get_insert_id();
        }

        $categories = array();
        do_action( 'ai1ec_ics_feed_added', $feed_id, $entry );

        $update = $this->update_ics_feed( $feed_id );

        $feed_name = $update['data']['name'];

        $cat_ids = '';
        if ( ! empty( $_REQUEST['feed_category'] ) ) {
            foreach ( $_REQUEST['feed_category'] as $cat_id ) {
                $feed_category = get_term( $cat_id, 'events_categories' );
                $categories[]  = $feed_category->name;
            }
            $cat_ids = implode( ',', $_REQUEST['feed_category'] );
        }

        $args = array(
            'feed_url'             => $_REQUEST['feed_url'],
            'feed_name'            => $feed_name,
            'feed_events_uids'     => array(),
            'event_category'       => implode( ', ', $categories ),
            'categories_ids'       => $cat_ids,
            'tags'                 => str_replace(
                ',',
                ', ',
                $_REQUEST['feed_tags']
            ),
            'tags_ids'             => $_REQUEST['feed_tags'],
            'feed_id'              => $feed_id,
            'comments_enabled'     => (bool) intval(
                $_REQUEST['comments_enabled']
            ),
            'map_display_enabled'  => (bool) intval(
                $_REQUEST['map_display_enabled']
            ),
            'events'               => 0,
            'keep_tags_categories' => (bool) intval(
                $_REQUEST['keep_tags_categories']
            ),
            'keep_old_events'      => (bool) intval(
                $_REQUEST['keep_old_events']
            ),
            'feed_import_timezone' => (bool) intval(
                $_REQUEST['feed_import_timezone']
            ),
            'api_signed'           => $api_signed,
        );

        // Display added feed row.
        $loader = $this->_registry->get( 'theme.loader' );
        $file   = $loader->get_file( 'feed_row.php', $args, true );
        $output = $file->get_content();
        $output = array(
            'error'   => false,
            'message' => stripslashes( $output ),
            'update'  => $update,
        );
        return $json_strategy->render( array( 'data' => $output ) );
    }

    /**
     * Delete feeds and events
     */
    public function delete_feeds_and_events() {
        $remove_events = $_POST['remove_events'] === 'true' ? true : false;
        $ics_id = isset( $_POST['ics_id'] ) ? (int) $_REQUEST['ics_id'] : 0;
        if ( $remove_events ) {
            $output = $this->flush_ics_feed( true, false );
            if ( $output['error'] === false ) {
                $this->delete_ics_feed( false, $ics_id );
            }
            $json_strategy = $this->_registry->get(
                'http.response.render.strategy.json'
            );
            return $json_strategy->render( array( 'data' => $output ) );
        } else {
            $this->delete_ics_feed( true, $ics_id );
        }
        exit();
    }

    /**
     * Deletes all event posts that are from that selected feed
     *
     * @param bool        $ajax     When true data is output using json_response
     * @param bool|string $feed_url Feed URL
     *
     * @return void
     */
    public function flush_ics_feed( $ajax = true, $feed_url = false ) {
        $db         = $this->_registry->get( 'dbi.dbi' );
        $ics_id     = 0;
        if ( isset( $_REQUEST['ics_id'] ) ) {
            $ics_id = (int) $_REQUEST['ics_id'];
        }
        $table_name = $db->get_table_name( 'ai1ec_event_feeds' );
        if ( false === $feed_url ) {
            $feed_url = $db->get_var(
                $db->prepare(
                    'SELECT feed_url FROM ' . $table_name .
                        ' WHERE feed_id = %d',
                    $ics_id
                )
            );
        }
        if ( $feed_url ) {
            $table_name = $db->get_table_name( 'ai1ec_events' );
            $sql        = 'SELECT `post_id` FROM ' . $table_name .
                ' WHERE `ical_feed_url` = %s';
            $events     = $db->get_col( $db->prepare( $sql, $feed_url ) );
            $total      = count( $events );
            foreach ( $events as $event_id ) {
                // delete post (this will trigger deletion of cached events, and
                // remove the event from events table)
                wp_delete_post( $event_id, true );
            }
            $output = array(
                'error'   => false,
                'message' => sprintf(
                    Ai1ec_I18n::__( 'Deleted %d events' ),
                    $total
                ),
                'count'   => $total,
            );
        } else {
            $output = array(
                'error'   => true,
                'message' => Ai1ec_I18n::__( 'Invalid ICS feed ID' ),
            );
        }
        if ( $ajax ) {
            $output['ics_id'] = $ics_id;
            return $output;
        }
    }

    /**
     * delete_ics_feed function
     *
     * Deletes submitted ics feed id from the database
     *
     * @param bool $ajax When set to TRUE, the data is outputted using json_response
     * @param bool|string $ics_id Feed URL
     *
     * @return String JSON output
     **/
    public function delete_ics_feed( $ajax = TRUE, $ics_id = FALSE ) {
        $db = $this->_registry->get( 'dbi.dbi' );
        if ( $ics_id === FALSE ) {
            $ics_id = (int) $_REQUEST['ics_id'];
        }
        $table_name = $db->get_table_name( 'ai1ec_event_feeds' );
        // Get API feed ID
        $feed_id = $db->get_var(
                $db->prepare(
                    'SELECT feed_name FROM ' . $table_name .
                        ' WHERE feed_id = %d',
                    $ics_id
                )
            );

        // Unsubscribe in API
        try {
            $this->_api_feed->unsubscribe_feed( $feed_id );
        } catch ( Exception $e ) {
        }

        // Delete from database
        $db->query( $db->prepare( "DELETE FROM {$table_name} WHERE feed_id = %d", $ics_id ) );
        do_action( 'ai1ec_ics_feed_deleted', $ics_id );

        $output = array(
            'error'   => false,
            'message' => __( 'Feed deleted', AI1EC_PLUGIN_NAME ),
            'ics_id'  => $ics_id,
        );
        if ( $ajax ) {
            $json_strategy = $this->_registry->get(
                'http.response.render.strategy.json'
            );
            return $json_strategy->render( array( 'data' => $output ) );
        }
    }


    /**
     * Adds discover event feed to the database
     *
     * @return string JSON output
     *
     */
    public function add_discover_events_feed_subscription() {
        if ( ! current_user_can( 'manage_ai1ec_feeds' ) ) {
            wp_die( Ai1ec_I18n::__( 'Oh, submission was not accepted.' ) );
        }

        $feed_id       = $_POST['ai1ec_feed_id'];
        $event_id      = $_POST['ai1ec_event_id'];
        $feed_url      = $_POST['ai1ec_feed_url'];

        $api_feed      = $this->_api_feed;

        $db            = $this->_registry->get( 'dbi.dbi' );
        $table_name    = $db->get_table_name( 'ai1ec_event_feeds' );

        $json_strategy = $this->_registry->get(
            'http.response.render.strategy.json'
        );

        // Import to the API
        try {
            $response  = $this->_api_feed->subscribe_feed( $feed_id, $event_id );
        } catch ( Exception $e ) {
            $output = array(
                'error'   => true,
                'message' => $e->getMessage()
            );
            return $json_strategy->render( array( 'data' => $output ) );
        }

        $sql        = "SELECT COUNT(*) FROM $table_name WHERE feed_name = '" . $feed_id . "'";
        $feed_count = $db->get_var( $sql );

        // Not imported yet
        if ( '0' === $feed_count ) {
            $entry = array(
                'feed_url'             => $feed_url,
                'feed_name'            => $feed_id,
                'feed_category'        => '',
                'feed_tags'            => '',
                'comments_enabled'     => 0,
                'map_display_enabled'  => 1,
                'keep_tags_categories' => '',
                'keep_old_events'      => 0,
                'import_timezone'      => 0
            );

            $format                    = array( '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%d', '%d' );

            $res                       = $db->insert( $table_name, $entry, $format );
            $feed_id                   = $db->get_insert_id();
        }

        $update = $this->update_ics_feed( $feed_id );

        $output = array(
            'error'   => false,
            'message' => __( 'Event imported', AI1EC_PLUGIN_NAME ),
            'feed_id' => $feed_id,
        );

        return $json_strategy->render( array( 'data' => $output ) );
    }

    /**
     * delete_individual_event_subscription function
     *
     * Deletes submitted ics feed id from the database
     *
     * @param bool $ajax When set to TRUE, the data is outputted using json_response
     * @param bool|string $ics_id Feed URL
     *
     * @return String JSON output
     **/
    public function delete_individual_event_subscription() {
        $db             = $this->_registry->get( 'dbi.dbi' );

        $feed_id        = $_POST['ai1ec_feed_id'];
        $feed_event_uid = $_POST['ai1ec_event_id'];
        $delete         = $_POST['ai1ec_delete'];

        $table_name     = $db->get_table_name( 'ai1ec_event_feeds' );

        $ics_id         = $db->get_var(
            $db->prepare(
                'SELECT feed_id FROM ' . $table_name .
                ' WHERE feed_name = %s',
                $feed_id
            )
        );

        // Unsubscribe in API
        try {
            $this->_api_feed->unsubscribe_feed( $feed_id, $feed_event_uid );
        } catch ( Exception $e ) {
        }

        // Check if has more subscriptions
        $found_subscription = false;

        $feeds_subscriptions = $this->_api_feed->get_feed_subscriptions( true );
        foreach( $feeds_subscriptions as $api_feed ) {
            if ( $api_feed->feed_id === $feed_id ) {
                $found_subscription = true;
                break;
            }
        }

        // Delete from database if there are no more individual feeds imported
        if ( ! $found_subscription ) {
            $db->query( $db->prepare( 'DELETE FROM ' . $table_name . ' WHERE feed_id = %d', $ics_id ) );
            do_action( 'ai1ec_ics_feed_deleted', $ics_id );
        }

        // Delete event from database
        if ( $delete ) {
            $feed_url = $db->get_var(
                $db->prepare(
                    'SELECT feed_url FROM ' . $table_name .
                    ' WHERE feed_id = %d',
                    $ics_id
                    )
                );

            $table_name = $db->get_table_name( 'ai1ec_events' );
            $sql        = 'SELECT post_id FROM ' . $table_name .
                            ' WHERE ical_feed_url = %s AND ical_uid = %s';
            $events     = $db->get_col( $db->prepare( $sql, $feed_url, $feed_event_uid ) );
            $total      = count( $events );
            foreach ( $events as $event_id ) {
                // delete post (this will trigger deletion of cached events, and
                // remove the event from events table)
                wp_delete_post( $event_id, true );
            }
        }

        $output = array(
            'error'   => false,
            'message' => __( 'Feed deleted', AI1EC_PLUGIN_NAME ),
            'ics_id'  => $ics_id,
        );

        $json_strategy = $this->_registry->get(
            'http.response.render.strategy.json'
        );

        return $json_strategy->render( array( 'data' => $output ) );
    }


    /**
     * Get name to use for import locking via xguard.
     *
     * @param int $feed_id ID of feed being imported.
     *
     * @return string Name to use in xguard.
     */
    protected function _import_lock_name( $feed_id ) {
        return 'ics_import_' . (int)$feed_id;
    }

    /**
     * Check feed status
     *
     * @param int $feed_id ID of feed
     *
     * @return string Feed status
     */
    public function getFeedStatus( $feed_id ) {
        $api_feed          = $this->_api_feed;

        // Default status
        $feed_status       = $api_feed->getStaticVar('FEED_NOT_MIGRATED_CODE');

        // Get list of subscriptions
        $api_subscriptions = $api_feed->get_feed_subscriptions();

        foreach ( $api_subscriptions as $api_subscription ) {
            if ( $api_subscription->feed_id === $feed_id ) {
                if ( sizeof( $api_subscription->feed_events_uids ) > 0 ) {
                    $feed_status = $api_feed->getStaticVar('FEED_API_SOME_EVENTS_CODE');
                } else {
                    $feed_status = $api_feed->getStaticVar('FEED_API_ALL_EVENTS_CODE');
                }
                break;
            }
        }

        return $feed_status;
    }

}
