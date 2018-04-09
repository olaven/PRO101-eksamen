<?php
/**
 * Controller that handles javascript related functions.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Controller
 */
class Ai1ec_Javascript_Controller {

    // The js handle used when enqueueing
    const JS_HANDLE = 'ai1ec_requirejs';

    // The namespace for require.js functions
    const REQUIRE_NAMESPACE = 'timely';

    // the name of the configuration module for the frontend
    const FRONTEND_CONFIG_MODULE = 'ai1ec_calendar';

    //the name of the get parameter we use for loading js
    const LOAD_JS_PARAMETER = 'ai1ec_render_js';

    // just load backend scripts
    const LOAD_ONLY_BACKEND_SCRIPTS = 'common_backend';

    // just load backend scripts
    const LOAD_ONLY_FRONTEND_SCRIPTS = 'common_frontend';

    // Are we in the backend
    const IS_BACKEND_PARAMETER = 'is_backend';

    // Are we on the calendar page
    const IS_CALENDAR_PAGE = 'is_calendar_page';

    // this is the value of IS_BACKEND_PARAMETER which triggers loading of backend script
    const TRUE_PARAM = 'true';

    // the javascript file for event page
    const EVENT_PAGE_JS = 'event.js';

    // the javascript file for calendar page
    const CALENDAR_PAGE_JS = 'calendar.js';

    // the file for the calendar feedsa page
    const CALENDAR_FEEDS_PAGE = 'calendar_feeds.js';

    // add new event page js
    const ADD_NEW_EVENT_PAGE = 'add_new_event.js';

    // event category page js
    const EVENT_CATEGORY_PAGE = 'event_category.js';

    // less variable editing page
    const LESS_VARIBALES_PAGE = 'less_variables_editing.js';

    // settings page
    const SETTINGS_PAGE = 'admin_settings.js';

    //widget creator page
    const WIDGET_CREATOR = 'widget-creator.js';

    //ticketing page
    const TICKETING = 'ticketing.js';

    //cache file
    const CALENDAR_JS_CACHE_FILE = '/public/js_cache/calendar.js';

    /**
     * @var Ai1ec_Registry_Object
     */
    private $_registry;

    /**
     * The core js pages to load.
     * Used to avoid errors when extensions add pages.
     *
     * @var array
     */
    private $_core_pages = array(
        self::CALENDAR_FEEDS_PAGE => true,
        self::ADD_NEW_EVENT_PAGE  => true,
        self::EVENT_CATEGORY_PAGE => true,
        self::LESS_VARIBALES_PAGE => true,
        self::SETTINGS_PAGE       => true,
        self::EVENT_PAGE_JS       => true,
        self::CALENDAR_PAGE_JS    => true,
        self::WIDGET_CREATOR      => true,
        self::TICKETING           => true,
    );

    /**
     * Holds an instance of the settings object
     *
     * @var Ai1ec_Settings
     */
    private $_settings;

    /**
     * @var Ai1ec_Locale
     */
    private $_locale;

    /**
     * @var Ai1ec_Scripts
     */
    private $_scripts_helper;

    /**
     * @var Ai1ec_Acl_Aco
     */
    private $_aco;

    /**
     * @var Ai1ec_Template_Link_Helper
     */
    private $_template_link_helper;

    /**
     * @var bool
     */
    protected $_frontend_scripts_loaded = false;

    /**
     * Public constructor.
     *
     * @param Ai1ec_Registry_Object $registry
     *
     * @return void
     */
    public function __construct( Ai1ec_Registry_Object $registry ) {
        $this->_registry             = $registry;
        $this->_settings             = $registry->get( 'model.settings' );
        $this->_locale               = $registry->get( 'p28n.wpml' );
        $this->_aco                  = $registry->get( 'acl.aco' );
        $this->_template_link_helper = $registry->get( 'template.link.helper' );
        // this will need to be modified
        $this->_scripts_helper       = $registry->get( 'script.helper' );
    }

    /**
     * Load javascript files for frontend pages.
     *
     * @wp-hook ai1ec_load_frontend_js
     *
     * @param $is_calendar_page boolean Whether we are displaying the main
     *                                  calendar page or not
     *
     * @return void
     */
    public function load_frontend_js( $is_calendar_page, $is_shortcode = false ) {
        $page = null;

        // ======
        // = JS =
        // ======
        if( $this->_are_we_accessing_the_single_event_page() === true ) {
            $page = self::EVENT_PAGE_JS;
        }
        if( $is_calendar_page === true ) {
            $page = self::CALENDAR_PAGE_JS;
        }
        if( null !== $page ) {
            $this->add_link_to_render_js( $page, false );
        }
    }

    /**
     * Render the javascript for the appropriate page.
     *
     * @return void
     */
    public function render_js() {
        $js_path   = AI1EC_ADMIN_THEME_JS_PATH . DIRECTORY_SEPARATOR;
        $common_js = '';
        $js_cache  = $this->_settings->get( 'cache_dynamic_js' );

        if ( ! isset( $_GET[self::LOAD_JS_PARAMETER] ) ) {
            return null;
        }
        $page_to_load = $_GET[self::LOAD_JS_PARAMETER];
        $scripts_updated = $this->_registry->get( 'model.option' )->get( 'calendarjsupdated' );

        if (
            $js_cache &&
            $page_to_load === self::CALENDAR_PAGE_JS &&
            '1' === $scripts_updated &&
            $this->_registry->get( 'filesystem.checker' )->check_file_exists(
                AI1EC_PATH . self::CALENDAR_JS_CACHE_FILE,
                true
            )
        ) {
            Ai1ec_Http_Response_Helper::stop( 0 );
            return;
        }

        if (
            isset( $_GET[self::IS_BACKEND_PARAMETER] ) &&
            $_GET[self::IS_BACKEND_PARAMETER] === self::TRUE_PARAM
        ) {
            $common_js = file_get_contents( $js_path . 'pages/common_backend.js' );
        } else if (
            $page_to_load === self::EVENT_PAGE_JS ||
            $page_to_load === self::CALENDAR_PAGE_JS ||
            $page_to_load === self::LOAD_ONLY_FRONTEND_SCRIPTS
        ) {
            if (
                $page_to_load === self::LOAD_ONLY_FRONTEND_SCRIPTS &&
                true === $this->_frontend_scripts_loaded
            ) {
                return;
            }
            if ( false === $this->_frontend_scripts_loaded ) {
                $common_js = file_get_contents(
                    $js_path . 'pages/common_frontend.js'
                );
                $this->_frontend_scripts_loaded = true;
            }
        }

        // Create the config object for Require.js.
        $require_config = $this->create_require_js_config_object();

        // Load Require.js script.
        $require = file_get_contents( $js_path . 'require.js' );

        // Load appropriate jQuery script based on browser.
        $jquery = $this->get_jquery_version_based_on_browser(
            isset( $_SERVER['HTTP_USER_AGENT'] )
                ? $_SERVER['HTTP_USER_AGENT']
                : ''
        );

        // Load the main script for the page.
        $page_js = '';
        if ( isset( $this->_core_pages[$page_to_load] ) ) {
            $page_js = file_get_contents( $js_path . 'pages/' . $page_to_load );
        }

        // Load translation module.
        $translation    = $this->get_frontend_translation_data();
        $permalink      = $this->_template_link_helper
            ->get_permalink( $this->_settings->get( 'calendar_page_id' ) );
        $full_permalink = $this->_template_link_helper
            ->get_full_permalink( $this->_settings->get( 'calendar_page_id' ) );
        $translation['calendar_url']      = $permalink;
        $translation['full_calendar_url'] = $full_permalink;
        $translation_module = $this->create_require_js_module(
            self::FRONTEND_CONFIG_MODULE,
            $translation
        );

        // Load Ai1ec config script.
        $config = $this->create_require_js_module(
            'ai1ec_config',
            $this->get_translation_data()
        );

        // Let extensions add their scripts.
        $extension_files = array();
        $extension_files = apply_filters(
            'ai1ec_render_js',
            $extension_files,
            $page_to_load
        );
        $ext_js = '';

        foreach ( $extension_files as $file ) {
            $ext_js .= file_get_contents( $file );
        }

        // Finally, load the page_ready script to execute code that must run after
        // all scripts have been loaded.
        $page_ready = file_get_contents(
            $js_path . 'scripts/common_scripts/page_ready.js'
        );

        $javascript = $require . $require_config . $translation_module .
            $config . $jquery . $common_js . $ext_js . $page_js . $page_ready;
        // add to blank spaces to fix issues with js
        // being truncated onn some installs
        $javascript .= '  ';

        if (
            $js_cache &&
            $page_to_load === self::CALENDAR_PAGE_JS &&
            (
                '0' === $scripts_updated ||
                ! $this->_registry->get( 'filesystem.checker' )->check_file_exists(
                    AI1EC_PATH . self::CALENDAR_JS_CACHE_FILE,
                    true
                )
            )
        ) {
            $js_saved = false;
            try {
                $js_saved = file_put_contents(
                    $js_path . '../js_cache/' . self::CALENDAR_PAGE_JS,
                    $javascript
                );
                if ( $js_saved ) {
                    $this->_registry->get( 'model.option' )->set( 'calendarjsupdated', '1' );
                }
            } catch ( Exception $e ) {
                $this->_settings->set( 'cache_dynamic_js', false );
            }
        }

        $this->_echo_javascript( $javascript );
    }


    /**
     * Sets the flag to revalidate cached js files on next render.
     */
    public function revalidate_cache() {
        $this->_registry->get( 'model.option' )->set( 'calendarjsupdated', '0' );
    }

    /**
     * Get a compiled javascript file ( used by extensions )
     *
     * @param string $name
     *
     * @return string
     */
    public function get_module( $name ) {
        $js_path = AI1EC_ADMIN_THEME_JS_PATH . DIRECTORY_SEPARATOR;
        return file_get_contents( $js_path . $name );
    }

    /**
     * Check what file needs to be loaded and add the correct link.
     *
     * @wp-hook init
     *
     * @return void
     */
    public function load_admin_js() {
        // Initialize dashboard view

        $script_to_load = FALSE;
        if ( $this->are_we_on_calendar_feeds_page() === TRUE ) {
            // Load script for the importer plugins
            $script_to_load[] = self::CALENDAR_FEEDS_PAGE;
        }
        // Start the scripts for the event category page
        if ( $this->_are_we_editing_event_categories() === TRUE ) {
            // Load script required when editing categories
            $script_to_load[] = self::EVENT_CATEGORY_PAGE;
        }
        if ( $this->_are_we_editing_less_variables() === TRUE ) {
            // Load script required when editing categories
            $script_to_load[] = self::LESS_VARIBALES_PAGE;
        }
        // Load the js needed when you edit an event / add a new event
        if (
            true === $this->_are_we_creating_a_new_event() ||
            true === $this->_are_we_editing_an_event()
        ) {
            // Load script for adding / modifying events
            $script_to_load[] = self::ADD_NEW_EVENT_PAGE;
        }
        if ( true === $this->_are_we_accessing_the_calendar_settings_page() ) {
            $script_to_load[] = self::SETTINGS_PAGE;
        }
        if ( true === $this->_are_we_creating_widgets() ) {
            $script_to_load[] = self::WIDGET_CREATOR;
        }
        if (
            true === $this->_are_we_managing_tickets() ||
            true === $this->_are_we_managing_events_list()
        ) {
            $script_to_load[] = self::TICKETING;
        }
        if ( false === $script_to_load ) {
            $script_to_load[] = apply_filters( 'ai1ec_backend_js', self::LOAD_ONLY_BACKEND_SCRIPTS );
        }
        foreach ($script_to_load as $value) {
            $this->add_link_to_render_js( $value, true );
        }
    }

    /**
     * Loads version 1.9 or 2.0 of jQuery based on user agent.
     * If $user_agent is null (due to lack of HTTP header) we always serve
     * jQuery 2.0.
     *
     * @param string $user_agent
     *
     * @return string
     */
    public function get_jquery_version_based_on_browser( $user_agent ) {
        $js_path = AI1EC_ADMIN_THEME_JS_PATH . DIRECTORY_SEPARATOR;
        $jquery  = 'jquery_timely20.js';

        preg_match( '/MSIE (.*?);/', $user_agent, $matches );
        if ( count( $matches ) > 1 ) {
            //Then we're using IE
            $version = (int) $matches[1];
            if ( $version <= 8 ) {
                //IE 8 or under!
                $jquery = 'jquery_timely19.js';
            }
        }
        return file_get_contents( $js_path . $jquery );
    }

    /**
     * Creates a requirejs module that can be used for translations
     *
     * @param string $object_name
     * @param array $data
     *
     * @return string
     */
    public function create_require_js_module( $object_name, array $data ) {
        foreach ( (array) $data as $key => $value ) {
            if ( ! is_scalar( $value ) )
                continue;
            $data[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
        }
        $json_data = json_encode( $data );
        $prefix = self::REQUIRE_NAMESPACE;
        $script = "$prefix.define( '$object_name', $json_data );";

        return $script;
    }

    /**
     * Create the array needed for translation and passing other settings to JS.
     *
     * @return $data array the dynamic data array
     */
    public function get_translation_data() {

        $force_ssl_admin = force_ssl_admin();
        if ( $force_ssl_admin && ! is_ssl() ) {
            force_ssl_admin( false );
        }
        $ajax_url        = ai1ec_admin_url( 'admin-ajax.php' );
        force_ssl_admin( $force_ssl_admin );
        $settings        = $this->_registry->get( 'model.settings' );
        $locale          = $this->_registry->get( 'p28n.wpml' );
        $blog_timezone   = $this->_registry->get( 'model.option' )
            ->get( 'gmt_offset' );
        $application = $this->_registry->get( 'bootstrap.registry.application' );
        $data            = array(
            'calendar_feeds_nonce'           => wp_create_nonce( 'ai1ec_ics_feed_nonce'),
            // ICS feed error messages
            'duplicate_feed_message'         => esc_html(
                Ai1ec_I18n::__( 'This feed is already being imported.' )
            ),
            'invalid_url_message'            => esc_html(
                Ai1ec_I18n::__( 'Please enter a valid iCalendar URL.' )
            ),
            'invalid_website_message'        => esc_html(
                Ai1ec_I18n::__( 'Please enter a valid Website URL.' )
            ),
            'invalid_registration_message'   => esc_html(
                Ai1ec_I18n::__( 'Please enter a valid Registration URL, starting with https:// or http://.' )
            ),
            'invalid_email_message'          => esc_html(
                Ai1ec_I18n::__( 'Please enter a valid email address.' )
            ),
            'choose_image_message'           => Ai1ec_I18n::__( 'Choose Image' ),
            'now'                            => $this->_registry->get( 'date.system' )
                ->current_time(),
            'size_less_variable_not_ok'      => Ai1ec_I18n::__(
                'The value you have entered is not a valid CSS length.'
            ),
            'confirm_reset_theme'            => Ai1ec_I18n::__(
                'Are you sure you want to reset your theme options to their default values?'
            ),
            'error_message_not_valid_lat'    => Ai1ec_I18n::__(
                'Please enter a valid latitude. A valid latitude is comprised between +90 and -90.'
            ),
            'error_message_not_valid_long'   => Ai1ec_I18n::__(
                'Please enter a valid longitude. A valid longitude is comprised between +180 and -180.'
            ),
            'error_message_not_entered_lat'  => Ai1ec_I18n::__(
                'When the "Input coordinates" checkbox is checked, "Latitude" is a required field.'
            ),
            'error_message_not_entered_long' => Ai1ec_I18n::__(
                'When the "Input coordinates" checkbox is checked, "Longitude" is a required field.'
            ),
            'ai1ec_contact_url_not_valid'         => Ai1ec_I18n::__(
                'The URL you have entered in the <b>Organizer Contact Info</b> &gt; <b>Website URL</b> seems to be invalid.'
            ),
            'ai1ec_ticket_ext_url_not_valid'           => Ai1ec_I18n::__(
                'The URL you have entered in the <b>Event Cost and Tickets</b> &gt; <b>Tickets or Registration URL</b> seems to be invalid.'
            ),
            'ai1ec_contact_email_not_valid'         => Ai1ec_I18n::__(
                'The Email you have entered in the <b>Organizer Contact Info</b> &gt; <b>E-mail</b> seems to be invalid.'
            ),
            'general_url_not_valid'          => Ai1ec_I18n::__(
                'Please remember that URLs must start with either "http://" or "https://".'
            ),
            'calendar_loading'               => Ai1ec_I18n::__(
                'Loading&hellip;'
            ),
            'ticketing_required_fields'      => Ai1ec_I18n::__(
                '<b>Required or incorrect fields for Ticketing are outlined red.</b>'
            ),
            'ticketing_repeat_not_supported' => Ai1ec_I18n::__( '<b>The Repeat option was selected but recurrence is not supported by Event with Tickets.</b>'
            ),
            'ticketing_no_tickets_included'  => Ai1ec_I18n::__( '<b>
                The Event has the cost option Tickets selected but no ticket was included.</b>'
            ),
            'discovery_event_success'         => Ai1ec_I18n::__(
                'Event was imported successfully.'
            ),
            'discovery_event_error'          => Ai1ec_I18n::__(
                'An error occurred when importing event. Please, try later.'
            ),
            'language'                       => $this->_registry->get( 'p28n.wpml' )->get_lang(),
            'ajax_url'                       => $ajax_url,
            // 24h time format for time pickers
            'twentyfour_hour'                => $settings->get( 'input_24h_time' ),
            // Date format for date pickers
            'date_format'                    => $settings->get( 'input_date_format' ),
            // Names for months in date picker header (escaping is done in wp_localize_script)
            'month_names'                    => $locale->get_localized_month_names(),
            // Names for days in date picker header (escaping is done in wp_localize_script)
            'day_names'                      => $locale->get_localized_week_names(),
            // Start the week on this day in the date picker
            'week_start_day'                 => $settings->get( 'week_start_day' ),
            'week_view_starts_at'            => $settings->get( 'week_view_starts_at' ),
            'week_view_ends_at'              => $settings->get( 'week_view_ends_at' ),
            'google_maps_api_key'            => $settings->get( 'google_maps_api_key' ),
            'blog_timezone'                  => $blog_timezone,
            'affix_filter_menu'              => $settings->get( 'affix_filter_menu' ),
            'affix_vertical_offset_md'       => $settings->get( 'affix_vertical_offset_md' ),
            'affix_vertical_offset_lg'       => $settings->get( 'affix_vertical_offset_lg' ),
            'affix_vertical_offset_sm'       => $settings->get( 'affix_vertical_offset_sm' ),
            'affix_vertical_offset_xs'       => $settings->get( 'affix_vertical_offset_xs' ),
            'calendar_page_id'               => $settings->get( 'calendar_page_id' ),
            'region'                         => ( $settings->get( 'geo_region_biasing' ) ) ? $locale->get_region() : '',
            'site_url'                       => trailingslashit(
                ai1ec_get_site_url()
            ),
            'javascript_widgets'             => array(),
            'widget_creator'                 => array(
                'preview'         => Ai1ec_I18n::__( 'Preview:' ),
                'preview_loading' => Ai1ec_I18n::__(
                    'Loading preview&nbsp;<i class="ai1ec-fa ai1ec-fa-spin ai1ec-fa-spinner"></i>'
                )
            ),
            'ticketing'                       => array(
                'details'         => Ai1ec_I18n::__( 'Ticketing Details' ),
                'hide_details'    => Ai1ec_I18n::__( 'Hide Ticketing Details' ),
                'loading_details' => Ai1ec_I18n::__( 'Loading tickets details...' ),
                'type_and_price'  => Ai1ec_I18n::__( 'Type and price' ),
                'info'            => Ai1ec_I18n::__( 'Info' ),
                'information'     => Ai1ec_I18n::__( 'Information' ),
                'report'          => Ai1ec_I18n::__( 'Report' ),
                'sale_dates'      => Ai1ec_I18n::__( 'Sale dates' ),
                'limits'          => Ai1ec_I18n::__( 'Limits' ),
                'actions'         => Ai1ec_I18n::__( 'Actions' ),
                'sold'            => Ai1ec_I18n::__( 'Sold:' ),
                'left'            => Ai1ec_I18n::__( 'Left:' ),
                'start'           => Ai1ec_I18n::__( 'Start:' ),
                'end'             => Ai1ec_I18n::__( 'End:' ),
                'min'             => Ai1ec_I18n::__( 'Min:' ),
                'max'             => Ai1ec_I18n::__( 'Max:' ),
                'attendees'       => Ai1ec_I18n::__( 'Attendees' ),
                'hide_attendees'  => Ai1ec_I18n::__( 'Hide Attendees' ),
                'attendees_list'  => Ai1ec_I18n::__( 'Attendees List' ),
                'guest_name'      => Ai1ec_I18n::__( 'Guest Name' ),
                'status'          => Ai1ec_I18n::__( 'Status' ),
                'email'           => Ai1ec_I18n::__( 'Email' ),
                'no_attendees'    => Ai1ec_I18n::__( 'No attendees for this ticket type.' ),
                'edit'            => Ai1ec_I18n::__( 'Edit' ),
                'code'            => Ai1ec_I18n::__( 'Code' ),
                'unlimited'       => Ai1ec_I18n::__( 'Unlimited' ),
                'open_for_sale'   => Ai1ec_I18n::__( 'Open for sale' ),
                'no_delete_text'  => Ai1ec_I18n::__( 'You have sold tickets for this ticket type. Please change it\'s status to "Canceled" and make refunds to all users that purchased tickets.' ),
                'cancel_message'  => Ai1ec_I18n::__( 'You have sold tickets for this ticket type. Please make refunds to all users that purchased tickets' )
            ),
            'review'                         => array(
                'message_sent'  => Ai1ec_I18n::__( 'Your message has been sent. Thank you for your feedback.' ),
                'message_error' => Ai1ec_I18n::__( 'Your message has not been sent. Please try again or contact us.' )
            ),
            'load_views_error'                 => Ai1ec_I18n::__(
                'Something went wrong while fetching events.<br>The request status is: %STATUS% <br>The error thrown was: %ERROR%'
            ),
            'load_views_error_popup_title'   => Ai1ec_I18n::__( 'Response text received from server' ),
            'load_views_error_link_popup'    => Ai1ec_I18n::__( 'Click here for technical details' ),
            'cookie_path'                    => $this->_registry->get(
                'cookie.utility'
            )->get_path_for_cookie(),
            'disable_autocompletion'         => $settings->get( 'disable_autocompletion' ),
            'end_must_be_after_start'        => __( 'The end date can\'t be earlier than the start date.', AI1EC_PLUGIN_NAME ),
            'show_at_least_six_hours'        => __( 'For week and day view, you must select an interval of at least 6 hours.', AI1EC_PLUGIN_NAME ),
            'ai1ec_permalinks_enabled'       => $application->get( 'permalinks_enabled' ),
        );
        return apply_filters( 'ai1ec_js_translations', $data );
    }

    /**
     * Get the array with translated data for the frontend
     *
     * @return array
     */
    public function get_frontend_translation_data() {
        $data = array(
            'export_url' => AI1EC_EXPORT_URL,
        );

        // Replace desired CSS selector with calendar, if selector has been set
        $calendar_selector = $this->_settings->get( 'calendar_css_selector' );
        if( $calendar_selector ) {
            $page             = get_post(
                $this->_settings->get( 'calendar_page_id' )
            );
            $data['selector'] = $calendar_selector;
            $data['title']    = $page->post_title;
        }

        // DEPRECATED: Only still here for backwards compatibility with Ai1ec 1.x.
        $data['fonts'] = array();
        $fonts_dir = AI1EC_DEFAULT_THEME_URL . 'font_css/';
        $data['fonts'][] = array(
            'name' => 'League Gothic',
            'url'  => $fonts_dir . 'font-league-gothic.css',
        );
        $data['fonts'][] = array(
            'name' => 'fontawesome',
            'url'  => $fonts_dir . 'font-awesome.css',
        );
        return $data;
    }

    /**
     * Echoes the Javascript if not cached.
     *
     * Echoes the javascript with the correct content.
     * Since the content is dinamic, i use the hash function.
     *
     * @param string $javascript
     *
     * @return void
     */
    private function _echo_javascript( $javascript ) {
        $conditional_get = new HTTP_ConditionalGet( array(
            'contentHash' => md5( $javascript )
            )
        );
        $conditional_get->sendHeaders();
        if ( ! $conditional_get->cacheIsValid ) {
            $http_encoder = $this->_registry->get(
                'http.encoder',
                array(
                    'content' => $javascript,
                    'type' => 'text/javascript'
                )
            );
            $compression_level = null;
            if ( $this->_registry->get( 'model.settings' )->get( 'disable_gzip_compression' ) ) {
                // set the compression level to 0 to disable it.
                $compression_level = 0;
            }
            $http_encoder->encode( $compression_level );
            $http_encoder->sendAll();
        }
        Ai1ec_Http_Response_Helper::stop( 0 );
    }

    /**
     * Create the config object for requirejs.
     *
     * @return string
     */
    public function create_require_js_config_object() {
        $js_url    = AI1EC_ADMIN_THEME_JS_URL;
        $version   = AI1EC_VERSION;
        $namespace = self::REQUIRE_NAMESPACE;
        $config    = <<<JSC
        $namespace.require.config( {
            waitSeconds : 15,
            urlArgs     : 'ver=$version',
            baseUrl     : '$js_url'
        } );
JSC;
        return $config;
    }

    /**
     *    Check if we are in the calendar feeds page
     *
     * @return boolean TRUE if we are in the calendar feeds page FALSE otherwise
     */
    public function are_we_on_calendar_feeds_page() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : FALSE;
        $page = isset( $_GET['page'] ) ? $_GET['page'] : FALSE;
        if( $post_type === FALSE || $page === FALSE ) {
            return FALSE;
        }
        $is_calendar_feed_page = $path_details['basename'] === 'edit.php' &&
                                 $post_type                === 'ai1ec_event' &&
                                 $page                     === 'all-in-one-event-calendar-feeds';
        return $is_calendar_feed_page;
    }

    /**
     * Add the link to render the javascript
     *
     * @param string $page
     * @param boolean $backend
     *
     * @return void
     */
    public function add_link_to_render_js( $page, $backend ) {
        $load_backend_script = 'false';
        if ( true === $backend ) {
            $load_backend_script = self::TRUE_PARAM;
        }
        $is_calendar_page = false;
        if(
            true === is_page( $this->_settings->get( 'calendar_page_id' ) ) ||
            self::CALENDAR_PAGE_JS === $page
        ) {
            $is_calendar_page = self::TRUE_PARAM;
        }

        $url = add_query_arg(
            array(
                // Add the page to load
                self::LOAD_JS_PARAMETER    => $page,
                // If we are in the backend, we must load the common scripts
                self::IS_BACKEND_PARAMETER => $load_backend_script,
                // If we are on the calendar page we must load the correct option
                self::IS_CALENDAR_PAGE     => $is_calendar_page,
            ),
            trailingslashit( ai1ec_get_site_url() )
        );
        if (
            $this->_settings->get( 'cache_dynamic_js' ) &&
            $is_calendar_page &&
            '1' === $this->_registry->get( 'model.option' )->get( 'calendarjsupdated' ) &&
            $this->_registry->get( 'filesystem.checker' )->check_file_exists(
                AI1EC_PATH . self::CALENDAR_JS_CACHE_FILE,
                true
            )
        ) {
            $url = plugin_dir_url( 'all-in-one-event-calendar/public/js_cache/.' ) . $page;
        }

        if ( true === $backend ) {
            $this->_scripts_helper->enqueue_script(
                    self::JS_HANDLE,
                    $url,
                    array( 'postbox' ),
                    true
            );
        } else {
            $this->_scripts_helper->enqueue_script(
                    self::JS_HANDLE,
                    $url,
                    array(),
                    false
            );
        }
    }

    /**
     * check if we are editing an event
     *
     * @return boolean TRUE if we are editing an event FALSE otherwise
     */
    private function _are_we_editing_an_event() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $post_id = isset( $_GET['post'] ) ? $_GET['post'] : FALSE;
        $action = isset( $_GET['action'] ) ? $_GET['action'] : FALSE;
        if( $post_id === FALSE || $action === FALSE ) {
            return FALSE;
        }

        $editing = (
            'post.php' === $path_details['basename'] &&
            'edit'     === $action &&
            $this->_aco->is_our_post_type( $post_id )
        );
        return $editing;
    }

    /**
     * check if we are viewing events list
     *
     * @return boolean TRUE if we are on the events list FALSE otherwise
     */
    private function _are_we_managing_events_list() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $post_type    = isset( $_GET['post_type'] ) ? $_GET['post_type'] : FALSE;
        if ( FALSE === $post_type ) {
            return FALSE;
        }
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        $events_list = (
            'edit.php'    === $path_details['basename'] &&
            'ai1ec_event' === $post_type &&
            ai1ec_is_blank( $page )
        );
        return $events_list;
    }

    /**
     * check if we are creating a new event
     *
     * @return boolean TRUE if we are creating a new event FALSE otherwise
     */
    private function _are_we_creating_a_new_event() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
        return $path_details['basename'] === 'post-new.php' &&
                $post_type === AI1EC_POST_TYPE;
    }

    /**
     * Check if we are accessing the settings page
     *
     * @return boolean TRUE if we are accessing the settings page FALSE otherwise
     */
    private function _are_we_accessing_the_calendar_settings_page() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        return $path_details['basename'] === 'edit.php' &&
                $page === AI1EC_PLUGIN_NAME . '-settings';
    }

    protected function _are_we_creating_widgets() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        return $path_details['basename'] === 'edit.php' &&
            $page === AI1EC_PLUGIN_NAME . '-widget-creator';
    }

    protected function _are_we_managing_tickets() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        return $path_details['basename'] === 'edit.php' &&
            $page === AI1EC_PLUGIN_NAME . '-tickets';
    }

    /**
     * Check if we are editing less variables
     *
     * @return boolean TRUE if we are accessing a single event page FALSE otherwise
     */
    private function _are_we_editing_less_variables() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $page = isset( $_GET['page'] ) ? $_GET['page'] : '';
        return $path_details['basename'] === 'edit.php' && $page === AI1EC_PLUGIN_NAME . '-edit-css';
    }

    /**
     * Check if we are accessing the events category page
     *
     * @return boolean TRUE if we are accessing the events category page FALSE otherwise
     */
    private function _are_we_editing_event_categories() {
        if ( !isset( $_SERVER['SCRIPT_NAME'] ) ) {
            return FALSE;
        }

        $path_details = pathinfo( $_SERVER['SCRIPT_NAME'] );
        $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
        return (
            $path_details['basename'] === 'edit-tags.php' ||
            $path_details['basename'] === 'term.php'
        )  && $post_type === AI1EC_POST_TYPE;
    }

    /**
     * Check if we are accessing a single event page
     *
     * @return boolean TRUE if we are accessing a single event page FALSE otherwise
     */
    private function _are_we_accessing_the_single_event_page() {
        return $this->_aco->is_our_post_type();
    }

}
