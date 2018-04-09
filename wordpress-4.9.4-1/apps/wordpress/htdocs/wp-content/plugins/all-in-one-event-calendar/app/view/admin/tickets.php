<?php

/**
 * Tickets page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.4
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Tickets extends Ai1ec_View_Admin_Abstract {

    /**
     * @var string The nonce action
     */
    const NONCE_ACTION = 'ai1ec_api_ticketing_signup';

    /**
     * @var string The nonce name
     */
    const NONCE_NAME  = 'ai1ec_api_ticketing_nonce';

    /**
     * @var string The id/name of the submit button.
     */
    const SUBMIT_ID = 'ai1ec_api_ticketing_signup';

    /**
     * Adds the page to the correct menu.
     */
    public function add_page() {
        add_submenu_page(
            AI1EC_ADMIN_BASE_URL,
            __( 'Ticketing', AI1EC_PLUGIN_NAME ),
            __( 'Ticketing', AI1EC_PLUGIN_NAME ),
            'manage_ai1ec_feeds',
            AI1EC_PLUGIN_NAME . '-tickets',
            array( $this, 'display_page' )
        );
    }

    /**
     * Add meta box for page.
     *
     * @wp_hook admin_init
     *
     * @return void
     */
    public function add_meta_box() {}

    /**
     * Display the page html
     */
    public function display_page() {

        $signed_to_api       = $this->_api_registration->is_signed();
        $signup_available    = $this->_api_registration->is_api_sign_up_available();
        $ticketing_available = $this->_api_registration->is_ticket_available();
        $ticketing_enabled   = $this->_api_registration->has_subscription_active( Ai1ec_Api_Features::CODE_TICKETING );
        $ticketing_message   = $this->_api_registration->get_sign_message();
        $loader              = $this->_registry->get( 'theme.loader' );
         wp_enqueue_style(
            'ai1ec_samples.css',
            AI1EC_ADMIN_THEME_CSS_URL . 'samples.css',
            array(),
            AI1EC_VERSION
        );

        if ( ! $signed_to_api ) {

            if ( false === ai1ec_is_blank( $ticketing_message ) ) {
                $this->_api_registration->clear_sign_message();
            }

            $args = array(
                'title' => Ai1ec_I18n::__(
                    'Timely Ticketing'
                ),
                'sign_up_text' => 'Please, <a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings">Sign Up for a Timely Network account</a> to use Ticketing.',
                'signup_form'  => Ai1ec_I18n::__( 'You need to sign up for a Timely Network account in order to use Ticketing.<br /><br />' ) .
                    (
                        $signup_available
                        ? Ai1ec_I18n::__( '<a href="edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings" class="ai1ec-btn ai1ec-btn-primary ai1ec-btn-lg">Sign In to Timely Network</a>' )
                        : Ai1ec_I18n::__( '<b>Signing up for a Timely Network account is currently unavailable. Please, try again later.</b>' )
                    ),
                'show_info'    => true

            );
            $file = $loader->get_file( 'ticketing/signup.twig', $args, true );
        } elseif ( ! $ticketing_available ) {
            $args = array(
                'title' => Ai1ec_I18n::__(
                    'Timely Ticketing'
                ),
                'sign_up_text' => '',
                'signup_form'  => 'Ticketing is currently not available for this website. Please, try again later.',
                'show_info'    => true

            );
            $file = $loader->get_file( 'ticketing/signup.twig', $args, true );
        } elseif ( ! $ticketing_enabled ) {
            $args = array(
                    'title' => Ai1ec_I18n::__(
                            'Timely Ticketing'
                            ),
                    'sign_up_text' => '',
                    'signup_form'  => '',
                    'show_info'    => true
            );
            $file = $loader->get_file( 'ticketing/signup.twig', $args, true );
        } else {
            $response  = $this->_api_registration->get_payment_preferences();
            $purchases = $this->_api_registration->get_purchases();
            $args      = array(
                'title'                             => Ai1ec_I18n::__(
                    'Timely Ticketing'
                ),
                'settings_text'                     => Ai1ec_I18n::__( 'Settings' ),
                'sales_text'                        => Ai1ec_I18n::__( 'Sales' ),
                'select_payment_text'               => Ai1ec_I18n::__( 'Please provide your PayPal details.' ),
                'cheque_text'                       => Ai1ec_I18n::__( 'Cheque' ),
                'paypal_text'                       => Ai1ec_I18n::__( 'PayPal' ),
                'currency_text'                     => Ai1ec_I18n::__( 'Preferred currency for tickets:' ),
                'required_text'                     => Ai1ec_I18n::__( 'This field is required.' ),
                'save_changes_text'                 => Ai1ec_I18n::__( 'Save Changes' ),
                'date_text'                         => Ai1ec_I18n::__( 'Date' ),
                'event_text'                        => Ai1ec_I18n::__( 'Event' ),
                'purchaser_text'                    => Ai1ec_I18n::__( 'Purchaser' ),
                'tickets_text'                      => Ai1ec_I18n::__( 'Tickets' ),
                'email_text'                        => Ai1ec_I18n::__( 'Email' ),
                'status_text'                       => Ai1ec_I18n::__( 'Status' ),
                'total_text'                        => Ai1ec_I18n::__( 'Total' ),
                'sign_out_button_text'              => Ai1ec_I18n::__( 'Sign Out' ),
                'payment_method'                    => $response->payment_method,
                'paypal_email'                      => $response->paypal_email,
                'first_name'                        => $response->first_name,
                'last_name'                         => $response->last_name,
                'currency'                          => $response->currency,
                'nonce'                             => array(
                    'action'   => self::NONCE_ACTION,
                    'name'     => self::NONCE_NAME,
                    'referrer' => false,
                ),
                'action'                            =>
                    '?controller=front&action=ai1ec_api_ticketing_signup&plugin=' .
                    AI1EC_PLUGIN_NAME,
                'purchases'                         => $purchases,
                'paypal_currencies'                    => array (
                    array( 'description' => Ai1ec_I18n::__( 'United States Dollar' ), 'code' => 'USD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Canadian Dollar' ), 'code' => 'CAD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Australian Dollar' ), 'code' => 'AUD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Brazilian Real' ), 'code' => 'BRL', 'note' => Ai1ec_I18n::__( 'Note: This currency is supported as a payment currency and a currency balance for in-country PayPal accounts only.' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Czech Koruna' ), 'code' => 'CZK' ),
                    array( 'description' => Ai1ec_I18n::__( 'Danish Krone' ), 'code' => 'DKK' ),
                    array( 'description' => Ai1ec_I18n::__( 'Euro' ), 'code' => 'EUR' ),
                    array( 'description' => Ai1ec_I18n::__( 'Hong Kong Dollar' ), 'code' => 'HKD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Hungarian Forint' ), 'code' => 'HUF', 'note' => Ai1ec_I18n::__( 'Note: Decimal amounts are not supported for this currency. Passing a decimal amount will throw an error.' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Israeli New Sheqel' ), 'code' => 'ILS' ),
                    array( 'description' => Ai1ec_I18n::__( 'Japanese Yen' ), 'code' => 'JPY', 'note' => Ai1ec_I18n::__( 'Note: This currency does not support decimals. Passing a decimal amount will throw an error. 1,000,000' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Malaysian Ringgit' ), 'code' => 'MYR', 'note' => Ai1ec_I18n::__( 'Note: This currency is supported as a payment currency and a currency balance for in-country PayPal accounts only.' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Mexican Peso' ), 'code' => 'MXN' ),
                    array( 'description' => Ai1ec_I18n::__( 'Norwegian Krone' ), 'code' => 'NOK' ),
                    array( 'description' => Ai1ec_I18n::__( 'New Zealand Dollar' ), 'code' => 'NZD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Philippine Peso' ), 'code' => 'PHP' ),
                    array( 'description' => Ai1ec_I18n::__( 'Polish Zloty' ), 'code' => 'PLN' ),
                    array( 'description' => Ai1ec_I18n::__( 'Pound Sterling' ), 'code' => 'GBP' ),
                    array( 'description' => Ai1ec_I18n::__( 'Russian Ruble' ), 'code' => 'RUB', 'note' => Ai1ec_I18n::__( 'For in-border payments (payments made within Russia), the Russian Ruble is the only accepted currency. If you use another currency for in-border payments, the transaction will fail' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Singapore Dollar' ), 'code' => 'SGD' ),
                    array( 'description' => Ai1ec_I18n::__( 'Swedish Krona' ), 'code' => 'SEK' ),
                    array( 'description' => Ai1ec_I18n::__( 'Swiss Franc' ), 'code' => 'CHF' ),
                    array( 'description' => Ai1ec_I18n::__( 'Taiwan New Dollar' ), 'code' => 'TWD', 'note' => Ai1ec_I18n::__( 'Note: Decimal amounts are not supported for this currency. Passing a decimal amount will throw an error.' ) ),
                    array( 'description' => Ai1ec_I18n::__( 'Thai Baht' ), 'code' => 'THB' ),
                )
            );
            $file = $loader->get_file( 'ticketing/manage.twig', $args, true );
        }

        $this->_registry->get( 'css.admin' )->admin_enqueue_scripts(
            'ai1ec_event_page_all-in-one-event-calendar-settings'
        );
        $this->_registry->get( 'css.admin' )->process_enqueue(
            array(
                array( 'style', 'ticketing.css', ),
            )
        );
        if ( isset( $_POST['ai1ec_save_settings'] ) ) {
            $response = $this->_api_registration->save_payment_preferences();

            // this redirect makes sure that the error messages appear on the screen
            if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                header( "Location: " . $_SERVER['HTTP_REFERER'] );
            }
        }
        return $file->render();
    }

    /**
     * Handle post, likely to be deprecated to use commands.
     */
    public function handle_post(){}

}
