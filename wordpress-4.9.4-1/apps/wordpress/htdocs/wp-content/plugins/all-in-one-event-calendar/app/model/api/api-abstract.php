<?php

/**
 * Common class for Timely API communication.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
abstract class Ai1ec_Api_Abstract extends Ai1ec_App {

    const WP_OPTION_KEY   = 'ai1ec_api_settings';
    const DEFAULT_TIMEOUT = 30;

    protected $_settings;

    /**
     * Post construction routine.
     *
     * Override this method to perform post-construction tasks.
     *
     * @return void Return from this method is ignored.
     */
    protected function _initialize() {
        $this->_settings = $this->_registry->get( 'model.settings' );
    }

    protected function get_ticketing_settings( $find_attribute = null, $default_value_attribute = null ) {
        $api_settings = get_option( self::WP_OPTION_KEY, null );
        if ( ! is_array( $api_settings ) ) {
            $api_settings = array(
                'enabled'              => $this->_settings->get( 'ticketing_enabled' ),
                'message'              => $this->_settings->get( 'ticketing_message' ),
                'token'                => $this->_settings->get( 'ticketing_token' ),
                'calendar_id'          => $this->_settings->get( 'ticketing_calendar_id' )
            );
            update_option( self::WP_OPTION_KEY, $api_settings );
            $this->_settings->set( 'ticketing_message'    , '' );
            $this->_settings->set( 'ticketing_enabled'    , false );
            $this->_settings->set( 'ticketing_token'      , '' );
            $this->_settings->set( 'ticketing_calendar_id', null );
        }
        if ( is_null( $find_attribute ) ) {
            return $api_settings;
        } else {
            if ( isset( $api_settings[$find_attribute] ) ) {
                return $api_settings[$find_attribute];
            } else {
                return $default_value_attribute;
            }
        }
    }

    /**
     * @param String $message last message received from the Sign up or Sign in process
     * @param bool $enabled true or false is ticket is enabled
     * @param string $token autenthication token
     * @param int @calendar_id remote id of the calendar
     * @param string $account Email used to create the account
     */
    protected function save_ticketing_settings( $message, $enabled, $token, $calendar_id, $account ) {
        $api_settings = $this->get_ticketing_settings();
        $api_settings['message']     = $message;
        $api_settings['enabled']     = $enabled;
        $api_settings['token']       = $token;
        $api_settings['calendar_id'] = $calendar_id;
        $api_settings['account']     = $account;
        return update_option( self::WP_OPTION_KEY, $api_settings );
    }

    protected function clear_ticketing_settings() {
        delete_option( self::WP_OPTION_KEY );

        // Clear transient API data
        delete_transient( 'ai1ec_api_feeds_subscriptions' );
        delete_transient( 'ai1ec_api_subscriptions' );
        delete_transient( 'ai1ec_api_features' );
        delete_transient( 'ai1ec_api_checked' );

        $this->check_settings();
    }

    /**
     * Save the Payment settings localy (same saved on the API)
     * @param array Preferences to save
     */
    public function save_payment_settings( array $values ) {
        $api_settings = $this->get_ticketing_settings();
        if ( null !== $values ) {
            $api_settings['payment_settings'] = $values;
        } else {
            unset( $api_settings['payment_settings'] );
        }
        return update_option( self::WP_OPTION_KEY, $api_settings );
    }

    /**
     * Get the saved payments settings (the same saved on the API)
     */
    public function get_payment_settings() {
        return $this->get_ticketing_settings( 'payment_settings' );
    }

    /**
     * Check if the current WP instance has payments settings configured
     */
    public function has_payment_settings() {
        $payment_settings = $this->get_payment_settings();
        if ( null === $payment_settings ) {
            //code to migrate the settings save on ticketing api and
            //bring them to the core side
            $payment_settings = $this->get_payment_preferences();
            if ( is_object( $payment_settings ) ) {
                $payment_settings = (array) $payment_settings;
            }
            $this->save_payment_settings( (array) $payment_settings );
        }
        return ( null !== $payment_settings &&
            'paypal' === $payment_settings['payment_method'] &&
            false === ai1ec_is_blank( $payment_settings['paypal_email'] ) ) ;
    }


    /**
     * @return object Response from API, or empty defaults
     */
    public function get_payment_preferences() {
        $calendar_id = $this->_get_ticket_calendar();
        $settings    = null;
        if ( 0 < $calendar_id ) {
            $response = $this->request_api( 'GET', AI1EC_API_URL . "calendars/$calendar_id/payment",
                null, //no body
                true //decode response body
            );
            if ( $this->is_response_success( $response ) ) {
                $settings = $response->body;
            }
        }
        if ( is_null( $settings ) ) {
            return (object) array( 'payment_method'=>'paypal', 'paypal_email'=> '', 'first_name'=>'',  'last_name'=>'', 'currency'=> 'USD' );
        } else {
            if ( ! isset( $settings->currency ) ) {
                $settings->currency = 'USD';
            }
            return $settings;
        }
    }


    public function get_timely_token() {
        return $this->get_ticketing_settings( 'token' );
    }

    protected function save_calendar_id ( $calendar_id ) {
        $api_settings = $this->get_ticketing_settings();
        $api_settings['calendar_id'] = $calendar_id;
        return update_option( self::WP_OPTION_KEY, $api_settings );
    }

    /**
     * Get the header array with authorization token
     */
    protected function _get_headers( $custom_headers = null ) {
        $headers  = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );
        $headers['Authorization'] = 'Basic ' . $this->get_ticketing_settings( 'token', '' );
        if ( null !== $custom_headers ) {
            foreach ( $custom_headers as $key => $value ) {
                if ( null === $value ) {
                    unset( $headers[$key] );
                } else {
                    $headers[$key] = $value;
                }
            }
        }
        return $headers;
    }

    /**
     * Create a standarized message to return
     * 1) If the API respond with http code 400 and with a JSON body, so, we will consider the API message to append in the base message.
     * 2) If the API does not responde with http code 400 or does not have a valid a JSON body, we will show the API URL and the http message error.
     */
    protected function _transform_error_message( $base_message, $response, $url, $ask_for_reload = false ) {
        $api_error = $this->get_api_error_msg( $response );
        $result    = null;
        if ( false === ai1ec_is_blank( $api_error ) ) {
            $result = sprintf(
                __( '%s.<br/>Detail: %s.', AI1EC_PLUGIN_NAME ),
                $base_message, $api_error
            );
        } else {
            if ( is_wp_error( $response ) ) {
                $error_message = sprintf(
                    __( 'API URL: %s.<br/>Detail: %s', AI1EC_PLUGIN_NAME ),
                    $url,
                    $response->get_error_message()
                );
            } else {
                $error_message = sprintf(
                    __( 'API URL: %s.<br/>Detail: %s - %s', AI1EC_PLUGIN_NAME ),
                    $url,
                    wp_remote_retrieve_response_code( $response ),
                    wp_remote_retrieve_response_message( $response )
                );
                $mailto = '<a href="mailto:labs@time.ly" target="_top">labs@time.ly</a>';
                if ( true === $ask_for_reload ) {
                    $result = sprintf(
                        __( '%s. Please reload this page to try again. If this error persists, please contact us at %s. In your report please include the information below.<br/>%s.', AI1EC_PLUGIN_NAME ),
                        $base_message,
                        $mailto,
                        $error_message
                    );
                } else {
                    $result = sprintf(
                        __( '%s. Please try again. If this error persists, please contact us at %s. In your report please include the information below.<br/>%s.', AI1EC_PLUGIN_NAME ),
                        $base_message,
                        $mailto,
                        $error_message
                    );
                }
            }
        }
        $result = trim( $result );
        $result = str_replace( '..', '.', $result );
        $result = str_replace( '.,', '.', $result );
        return $result;
    }


    /**
     * Search for the API message error
     */
    public function get_api_error_msg( $response ) {
        if ( isset( $response ) && false === is_wp_error( $response ) ) {
            $response_body = json_decode( $response['body'], true );
            if ( is_array( $response_body ) &&
                isset( $response_body['errors'] ) ) {
                $errors = $response_body['errors'];
                if ( false === is_array( $errors )) {
                    $errors = array( $errors );
                }
                $messages = null;
                foreach ($errors as $key => $value) {
                    if ( false === ai1ec_is_blank( $value ) ) {
                        if ( is_array( $value ) ) {
                            $value = implode ( ', ', $value );
                        }
                        $messages[] = $value;
                    }
                }
                if ( null !== $messages && false === empty( $messages ) ) {
                    return implode ( ', ', $messages);
                }
            }
        }
        return null;
    }

    /**
     * Get the ticket calendar from settings, if the calendar does not exists in
     * settings, then we will try to find on the API
     * @return string JSON.
     */
    protected function _get_ticket_calendar( $createIfNotExists = true ) {
        $ticketing_calendar_id = $this->get_ticketing_settings( 'calendar_id', 0 );
        if ( 0 < $ticketing_calendar_id ) {
            return $ticketing_calendar_id;
        } else {
            if ( ! $createIfNotExists ) {
                return 0;
            }
            // Try to find the calendar in the API
            $ticketing_calendar_id = $this->_find_user_calendar();
            if ( 0 < $ticketing_calendar_id  ) {
                $this->save_calendar_id( $ticketing_calendar_id );

                return $ticketing_calendar_id;
            } else {
                // If the calendar doesn't exist in the API, create a new one
                $ticketing_calendar_id = $this->_create_calendar();
                if ( 0 < $ticketing_calendar_id ) {
                    $this->save_calendar_id( $ticketing_calendar_id );

                    return $ticketing_calendar_id;
                } else {
                    return 0;
                }
            }
        }
    }

    /**
     * Find the existent calendar when the user is signing in
     */
    protected function _find_user_calendar() {
        $body = array(
            'title' => get_bloginfo( 'name' ),
            'url'   => ai1ec_site_url()
        );
        $response = $this->request_api( 'GET', AI1EC_API_URL . 'calendars', $body );
        if ( $this->is_response_success( $response ) ) {
            if ( is_array( $response->body ) ) {
                return $response->body[0]->id;
            } else {
                return $response->body->id;
            }
        } else {
            return 0;
        }
    }

    /**
     * Create a calendar when the user is signup
     */
    protected function _create_calendar() {
        $body = array(
            'title'    => get_bloginfo( 'name' ),
            'url'      => ai1ec_site_url(),
            'timezone' => $this->_settings->get( 'timezone_string' )
            );
        $response = $this->request_api( 'POST', AI1EC_API_URL . 'calendars', $body );
        if ( $this->is_response_success( $response ) ) {
            return $response->body->id;
        } else {
            $this->log_error( $response, 'Created calendar' );
            return 0;
        }
    }

    /**
     * Check if the current WP instance is signed into the API
     */
    public function is_signed() {
        return ( true === $this->get_ticketing_settings( 'enabled', false ) );
    }

    public function check_settings( $force = false ) {
        $checked = get_transient( 'ai1ec_api_checked' );

        if ( false === $checked || $force ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

            $failList = array();
            foreach ( Ai1ec_Api_Features::$features as $key => $value ) {
                if ( empty( $value ) ) {
                    continue;
                }
                if ( ( ! $this->is_signed() || ! $this->has_subscription_active( $key ) ) && call_user_func( 'is'.'_'.'pl'.'ug'.'in'.'_'.'ac'.'ti'.'ve', $value ) ) {
                    $failList[] = $value;
                }
            }

            if ( count( $failList ) > 0 ) {
                call_user_func( 'de'.'act'.'iv'.'ate'.'_'.'pl'.'ug'.'ins', $failList );

                $message = 'Your ' .
                            'All-in-One Event Calendar ' .
                            'has the ' .
                            'following ' .
                            'plugins ' .
                            'installed ' .
                            'but they are ' .
                            'disabled. '.
                            'To keep ' .
                            'them ' .
                            'enabled'.
                            ', simply '.
                            'keep ' .
                            'your calendar ' .
                            'logged in ' .
                            'to your '.
                            'Timely account.' .
                            '<br /><br />';

                foreach ( $failList as $failed ) {
                    $pieces = explode( '/', $failed );
                    $message .= '- ' . $pieces[0] . '<br />';
                }

                $this->show_error( $message );
            }

            set_transient( 'ai1ec_api_checked', true, 5 * 60 );
        }
    }

    /**
     * Get the current email account
     */
    public function get_current_account() {
        return $this->get_ticketing_settings( 'account', '' );
    }

    /**
     * Get the current calendar id
     */
    public function get_current_calendar() {
        return $this->get_ticketing_settings( 'calendar_id', 0 );
    }

    /**
     * Get the last message return by Signup or Signup process
     */
    public function get_sign_message() {
        return $this->get_ticketing_settings( 'message', '' );
    }

    /**
     * Clear the last message return by Signup or Signup process
     */
    public function clear_sign_message() {
        $api_settings            = $this->get_ticketing_settings();
        $api_settings['message'] = '';
        return update_option( self::WP_OPTION_KEY, $api_settings );
    }

    /**
     * @return array List of subscriptions and limits
     */
    protected function get_subscriptions( $force_refresh = false ) {
        $subscriptions = get_transient( 'ai1ec_api_subscriptions' );

        if ( false === $subscriptions || $force_refresh || ( defined( 'AI1EC_DEBUG' ) && AI1EC_DEBUG ) ) {
            $response = $this->request_api( 'GET', AI1EC_API_URL . 'calendars/' . $this->_get_ticket_calendar() . '/subscriptions',
                null,
                true
                );
            if ( $this->is_response_success( $response ) ) {
                $subscriptions = (array) $response->body;
            } else {
                $subscriptions = array();
            }

            // Save for 5 minutes
            $minutes = 5;
            set_transient( 'ai1ec_api_subscriptions', $subscriptions, $minutes * 60 );
        }

        return $subscriptions;
    }

    /**
     * Check if calendar should have a specific feature enabled
     */
    public function has_subscription_active( $feature ) {
        $subscriptions = $this->get_subscriptions();

        return array_key_exists( $feature, $subscriptions );
    }

    /**
     * Check if feature has reached its limit
     */
    public function subscription_has_reached_limit( $feature ) {
        $has_reached_limit = true;

        $provided = $this->subscription_get_quantity_limit( $feature );
        $used     = $this->subscription_get_used_quantity( $feature );

        if ( $provided - $used > 0 ) {
            $has_reached_limit = false;
        }

        return $has_reached_limit;
    }

    /**
     * Get feature quantity limit
     */
    public function subscription_get_quantity_limit( $feature ) {
        $provided = 0;

        $subscriptions = $this->get_subscriptions();

        if ( array_key_exists( $feature, $subscriptions ) ) {
            $quantity = (array) $subscriptions[$feature];

            $provided = $quantity['provided'];
        }

        return $provided;
    }

    /**
     * Get feature used quantity
     */
    public function subscription_get_used_quantity( $feature ) {
        $used = 0;

        $subscriptions = $this->get_subscriptions();

        if ( array_key_exists( $feature, $subscriptions ) ) {
            $quantity = (array) $subscriptions[$feature];

            $used = $quantity['used'];
        }

        return $used;
    }

    /**
     * Make the request to the API endpons
     * @param $url The end part of the url to make the request.
     *        $body The body to send the message
     *        $method POST | GET | PUT, etc
     *        or send a customized message to be showed in case of error
     *        $decode_response_body TRUE (default) to decode the body response
     * @return stdClass with the the fields:
     *         is_error TRUE or FALSE
     *         error in case of is_error be true
     *         body in case of is_error be false
     */
    protected function request_api(  $method, $url, $body = null, $decode_response_body = true, $custom_headers = null ) {
        $request = array(
            'method'  => $method,
            'accept'  => 'application/json',
            'headers' => $this->_get_headers( $custom_headers ),
            'timeout' => self::DEFAULT_TIMEOUT
        );
        if ( ! is_null( $body ) ) {
            $request['body'] = $body;
        }
        $response    = wp_remote_request( $url, $request );
        $result      = new stdClass();
        $result->url = $url;
        $result->raw = $response;
        if ( is_wp_error( $response ) ) {
            $result->is_error = true;
            $result->error    = $response->get_error_message();
        } else {
            $result->response_code = wp_remote_retrieve_response_code( $response );
            if ( 200 === $result->response_code ) {
                if ( true === $decode_response_body ) {
                    $result->body     = json_decode( $response['body'] );
                    if ( false === is_null( $result->body ) ) {
                        $result->is_error = false;
                    } else {
                        $result->is_error = true;
                        $result->error    = __( 'Error decoding the response', AI1EC_PLUGIN_NAME );
                        unset( $result->body );
                    }
                } else {
                    $result->is_error = false;
                    $result->body     = $response['body'];
                }
            } else {
                $result->is_error = true;
                $result->error    = wp_remote_retrieve_response_message( $response );
            }
        }
        return $result;
    }

    /**
     * Make a post request to the api
     * @param rest_endpoint Partial URL that can include {calendar_id} that will be replaced by the current calendar signed
     */
    public function call_api( $method, $endpoint, $body = null, $decode_response_body = true, $custom_headers = null  ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            return false;
        }
        $url  = AI1EC_API_URL . str_replace( '{calendar_id}', $calendar_id, $endpoint );
        return $this->request_api( $method, $url, $body, $decode_response_body, $custom_headers );
    }

    /**
     * Save an error notification to be showed to the user on WP header of the page
     * @param $response The response got from request_api method.
     *        $custom_error_message The custom message to show before the detailed message
     * @return full error message
     */
    protected function save_error_notification( $response, $custom_error_response ) {
        $error_message = $this->_transform_error_message(
            $custom_error_response,
            $response->raw,
            $response->url,
            true
        );
        $response->error_message = $error_message;
        $notification            = $this->_registry->get( 'notification.admin' );
        $notification->store( $error_message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
        error_log( $custom_error_response . ': ' . $error_message . ' - raw error: ' . print_r( $response->raw, true ) );
        return $error_message;
    }

    /**
     * Save an error notification to be showed to the user on WP header of the page
     * @param $response The response got from request_api method.
     *        $custom_error_message The custom message to show before the detailed message
     * @return full error message
     */
    protected function log_error( $response, $custom_error_response ) {
        $error_message = $this->_transform_error_message(
            $custom_error_response,
            $response->raw,
            $response->url,
            true
        );
        error_log( $custom_error_response . ': ' . $error_message . ' - raw error: ' . print_r( $response->raw, true ) );
        return $error_message;
    }

    protected function show_error( $error_message ) {
        $notification            = $this->_registry->get( 'notification.admin' );
        $notification->store( $error_message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
        error_log( $error_message);
        return $error_message;
    }

    /**
     * Useful method to check if the response of request_api is a successful message
     */
    public function is_response_success( $response ) {
        return $response != null &&
            ( !isset( $response->is_error ) || ( isset( $response->is_error ) && false === $response->is_error ) );
    }

}
