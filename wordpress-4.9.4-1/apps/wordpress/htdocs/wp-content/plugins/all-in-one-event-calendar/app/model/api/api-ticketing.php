<?php

/**
 * Class for Timely API communication for Ticketing.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Ticketing extends Ai1ec_Api_Abstract {

    const API_EVENT_DATA            = '_ai1ec_api_event_id';

    const ATTR_EVENT_ID             = 'api_event_id';
    const ATTR_THUMBNAIL_ID         = 'thumbnail_id';
    const ATTR_ICS_CHECKOUT_URL     = 'ics_checkout_url';
    const ATTR_ICS_API_URL          = 'ics_api_url';
    const ATTR_ACCOUNT              = 'account';
    const ATTR_CALENDAR_ID          = 'calendar_id';
    const ATTR_CURRENCY             = 'currency';

    const MAX_TICKET_TO_BUY_DEFAULT = 25;

    /**
     * Post construction routine.
     *
     * Override this method to perform post-construction tasks.
     *
     * @return void Return from this method is ignored.
     */
    protected function _initialize() {
        parent::_initialize();
    }

    /**
     * Count the valid Tickets Types (not removed) included inside the Ticket Event
     */
    private function _count_valid_tickets( $post_ticket_types ) {
        if (false === isset( $post_ticket_types ) || 0 === count( $post_ticket_types ) ) {
            return 0;
        } else {
            $count = 0;
            foreach ( $post_ticket_types as $ticket_type_ite ) {
                if ( !isset( $ticket_type_ite['remove'] ) ) {
                    $count++;
                }
            }
            return $count;
        }
    }

    /**
     * Return an error if the Ticket Event is not owned by the Current account
     */
    private function _prevent_update_ticket_event( Ai1ec_Event $event, $ajax_action = false ) {
        if ( $this->is_ticket_event_imported( $event->get( 'post_id' ) ) )  {
            //prevent changes on Ticket Events that were imported
            $error        = __( 'This Event was replicated from another site. Changes are not allowed.', AI1EC_PLUGIN_NAME );
            if ( ! $ajax_action ) {
                $notification = $this->_registry->get( 'notification.admin' );
                $notification->store(
                    $error,
                    'error',
                    0,
                    array( Ai1ec_Notification_Admin::RCPT_ADMIN ),
                    false
                );
            }
            return $error;
        }
        if ( $this->is_ticket_event_from_another_account( $event->get( 'post_id' ) ) )  {
            //prevent changes on Ticket Events that were imported
            $error        = sprintf(
                        __( 'This Event was created using a different account %s. Changes are not allowed.', AI1EC_PLUGIN_NAME ),
                        $this->get_api_event_account( $event->get( 'post_id' ) )
                    );
            if ( ! $ajax_action ) {
                $notification = $this->_registry->get( 'notification.admin' );
                $notification->store(
                    $error,
                    'error',
                    0,
                    array( Ai1ec_Notification_Admin::RCPT_ADMIN ),
                    false
                );
            }
            return $error;
        }
        return null;
    }

    /**
     * Run some validations inside the _POST request to check if the Event
     * submmited is a valid event for Tickets
     * @return NULL in case of success or a Message in case of error
     */
    private function _is_valid_post( Ai1ec_Event $event, $updating ) {
        $message = null;
        if ( ( isset( $_POST['ai1ec_rdate'] ) && ! empty( $_POST['ai1ec_rdate'] ) ) ||
             ( isset( $_POST['ai1ec_repeat'] ) && ! empty( $_POST['ai1ec_repeat'] ) )
             ) {
            $message = __( 'The Repeat option was selected but recurrence is not supported by Event with Tickets.', AI1EC_PLUGIN_NAME );
        } else if ( isset( $_POST['ai1ec_tickets_loading_error'] ) ) {
            //do not update tickets because is unsafe. There was a problem to load the tickets,
            //the customer received the same message when the event was loaded.
            $message = $_POST['ai1ec_tickets_loading_error'];
        } else if ( false === ai1ec_is_blank( $event->get( 'ical_feed_url' ) ) ) {
            //prevent ticket creating inside Regular Events Imported events
            $message = __( 'This Event was replicated from another site. Any changes on Tickets were discarded.', AI1EC_PLUGIN_NAME );
        } else {
            $error = $this->_prevent_update_ticket_event( $event );
            if ( null !== $error ) {
                $message = $error;
            } else if ( ! isset( $_POST['ai1ec_tickets'] ) || 0 === $this->_count_valid_tickets( $_POST['ai1ec_tickets'] ) ) {
                $message      = __( 'The Event has the cost option Ticket selected but no ticket was included.', AI1EC_PLUGIN_NAME );
            } else if ( false === $this->has_payment_settings() ) {
                $message = __( 'You need to save the payments settings to create ticket events.', AI1EC_PLUGIN_NAME );
            } else if ( ! isset( $_POST['tax_options'] ) && ! $updating ) {
                $message =     __( 'Tax and Invoice options are required.', AI1EC_PLUGIN_NAME );
            }
        }
        if ( null !== $message ) {
            $notification = $this->_registry->get( 'notification.admin' );
            $notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
            return $message;
        }
        return null;
    }

    /**
    *  Create or update a Ticket Event on API server
     * @return object Response body in JSON.
     */
    public function store_event( Ai1ec_Event $event, WP_Post $post, $updating ) {

        $error = $this->_is_valid_post( $event, $updating );
        if ( null !== $error ) {
            return $error;
        }
        $api_event_id = $this->get_api_event_id( $event->get( 'post_id' ) );
        $is_new       = ! $api_event_id;
        $fields       = array( 'visibility' => $_POST['visibility'] );
        if ( isset( $_POST['tax_options'] ) ) {
            $fields['tax_options'] = $_POST['tax_options'];
        }
        $body_data    = $this->parse_event_fields_to_api_structure(
            $event,
            $post,
            $_POST['ai1ec_tickets'],
            $fields
        );
        $url = AI1EC_API_URL . 'events';
        if ( $api_event_id ) {
            $url = $url . '/' . $api_event_id;
        }

        //get the thumbnail id saved previously
        $api_data = $this->get_api_event_data( $event->get( 'post_id' ) );
        if ( isset( $api_data[self::ATTR_THUMBNAIL_ID] ) ) {
            $event_thumbnail_id = $api_data[self::ATTR_THUMBNAIL_ID];
        } else {
            $event_thumbnail_id = 0;
        }
        //get the current thumbnail id
        $post_thumbnail_id  = get_post_thumbnail_id( $event->get( 'post_id' ) );
        if ( false === isset( $post_thumbnail_id ) ) {
            $post_thumbnail_id = 0;
        }
        $update_image   = ( $event_thumbnail_id !== $post_thumbnail_id );
        $payload        = '';
        $custom_headers = null;

        if ( true === $update_image && 0 < $post_thumbnail_id ) {
            $boundary                       = wp_generate_password( 24 );
            $custom_headers['Content-Type'] = 'multipart/form-data; boundary=' . $boundary;
            $body_data['update_image']      = '1';
            foreach ($body_data as $key => $value) {
                if ( is_array( $value ) ) {
                    $index = 0;
                    foreach ( $value as $arr_key => $arr_value ) {
                        if ( is_array( $arr_value ) ) {
                            foreach ( $arr_value as $child_key => $child_value ) {
                                $payload .= '--' . $boundary;
                                $payload .= "\r\n";
                                $payload .= 'Content-Disposition: form-data; name="' . $key . '[' . $index . '][' . $child_key . ']"' . "\r\n";
                                $payload .= "\r\n";
                                $payload .= $child_value;
                                $payload .= "\r\n";
                            }
                        } else {
                            $payload .= '--' . $boundary;
                            $payload .= "\r\n";
                            $payload .= 'Content-Disposition: form-data; name="tax_options[' . $arr_key . ']"' . "\r\n";
                            $payload .= "\r\n";
                            $payload .= $arr_value;
                            $payload .= "\r\n";
                        }
                        $index++;
                    }
                } else {
                    $payload .= '--' . $boundary;
                    $payload .= "\r\n";
                    $payload .= 'Content-Disposition: form-data; name="' . $key . '"' . "\r\n";
                    $payload .= "\r\n";
                    $payload .= $value;
                    $payload .= "\r\n";
                }
            }
            $file_path = get_attached_file ( $post_thumbnail_id );
            $file_type = wp_check_filetype ( $file_path );
            $payload  .= '--' . $boundary;
            $payload  .= "\r\n";
            $payload  .= 'Content-Disposition: form-data; name="image_id"; filename="' . basename( $file_path ) . '"' . "\r\n";
            $payload  .= 'Content-Type: ' . $file_type['type'] . "\r\n";
            $payload  .= "\r\n";
            $payload  .= file_get_contents( $file_path );
            $payload  .= "\r\n";
            $payload  .= '--' . $boundary . '--';
        } else {
            $body_data['update_image'] = (true === $update_image) ? '1' : '0';
            $payload                   = $body_data;
        }
        $response = $this->request_api( 'POST', $url, $payload,
            true, //true to decode response body
            $custom_headers
            );
        if ( $this->is_response_success( $response ) ) {
            $api_event_id = $response->body->id;
            if ( isset( $response->body->currency ) ) {
                $currency = $response->body->currency;
            } else {
                $currency = 'USD';
            }
            $currency     = $response->body->currency;
            if ( $post_thumbnail_id <= 0 ) {
                $post_thumbnail_id = null;
            }
            $this->save_api_event_data( $event->get( 'post_id') , $api_event_id,  null, null, $currency, $post_thumbnail_id );
            return true;
        } else {
            $error_message = '';
            if ( $is_new ) {
                $error_message = __( 'We were unable to create the Event on Time.ly Ticketing', AI1EC_PLUGIN_NAME );
            } else {
                $error_message = __( 'We were unable to update the Event on Time.ly Ticketing', AI1EC_PLUGIN_NAME );
            }
            return $this->save_error_notification( $response, $error_message );
        }
    }

    /**
     * Parse the fields of an Event to the structure used by API
     */
    public function parse_event_fields_to_api_structure( Ai1ec_Event $event , WP_Post $post, $post_ticket_types, $api_fields_values  ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( $calendar_id <= 0 ) {
            return null;
        }

        //fields of ai1ec events table used by API
        $body['latitude']         = $event->get( 'latitude' );
        $body['longitude']        = $event->get( 'longitude' );
        $body['post_id']          = $event->get( 'post_id' );
        $body['calendar_id']      = $calendar_id;
        $body['dtstart']          = $event->get( 'start' )->format_to_javascript();
        $body['dtend']            = $event->getenddate()->format_to_javascript();
        $body['timezone']         = $event->get( 'timezone_name' );
        $body['venue_name']       = $event->get( 'venue' );
        $body['address']          = $event->get( 'address' );
        $body['city']             = $event->get( 'city' );
        $body['province']         = $event->get( 'province' );
        $body['postal_code']      = $event->get( 'postal_code' );
        $body['country']          = $event->get( 'country' );
        $body['contact_name']     = $event->get( 'contact_name' );
        $body['contact_phone']    = $event->get( 'contact_phone' );
        $body['contact_email']    = $event->get( 'contact_email' );
        $body['contact_website']  = $event->get( 'contact_url' );
        $body['uid']              = $event->get_uid();
        $body['title']            = $post->post_title;
        $body['description']      = $post->post_content;
        $body['url']              = get_permalink( $post->ID );
        $body['status']           = $post->post_status;

        $utc_current_time         = $this->_registry->get( 'date.time')->format_to_javascript();
        $body['created_at']       = $utc_current_time;
        $body['updated_at']       = $utc_current_time;

        //removing blank values
        foreach ($body as $key => $value) {
            if ( ai1ec_is_blank( $value ) ) {
                unset( $body[ $key ] );
            }
        }

        if ( is_null( $api_fields_values ) || 0 == count( $api_fields_values ) ) {
            $api_fields_values = array( 'status' => 'closed', 'ai1ec_version' => AI1EC_VERSION );
        } else {
            if ( ! isset( $api_fields_values['ai1ec_version'] ) ) {
                $api_fields_values['ai1ec_version'] = AI1EC_VERSION;
            }
            foreach ( $api_fields_values as $key => $value ) {
                $body[$key] = $api_fields_values[$key];
                if ( 'visibility' === $key ) {
                    if ( 0 === strcasecmp( 'private', $value ) ) {
                        $body['status'] = 'private';
                    } else if ( 0 === strcasecmp( 'password', $value ) ) {
                        $body['status'] = 'password';
                    }
                }
            }
        }

        $tickets_types = array();
        if ( ! is_null( $post_ticket_types ) ) {
            $index         = 0;
            foreach ( $post_ticket_types as $ticket_type_ite ) {
                if ( false === isset( $ticket_type_ite['id'] ) &&
                     isset( $ticket_type_ite['remove'] ) ) {
                    //ignoring new tickets that didn't go to api yet
                    continue;
                }
                $tickets_types[$index++] = $this->_parse_tickets_type_post_to_api_structure(
                    $ticket_type_ite,
                    $event
                );
            }
        }
        $body['ticket_types'] = $tickets_types;

        return $body;
    }

    /**
     * Parse the fields of a Ticket Type to the structure used by API
     */
    protected function _parse_tickets_type_post_to_api_structure( $ticket_type_ite, $event ) {
        $utc_current_time = $this->_registry->get( 'date.time' )->format_to_javascript();
        if ( isset( $ticket_type_ite['id'] ) ) {
            $ticket_type['id']          = $ticket_type_ite['id'];
            $ticket_type['created_at']     = $ticket_type_ite['created_at'];
        } else {
            $ticket_type['created_at']     = $utc_current_time;
        }
        if ( isset( $ticket_type_ite['remove'] ) ) {
            $ticket_type['deleted_at']     = $utc_current_time;
        }
        $ticket_type['name']        = $ticket_type_ite['ticket_name'];
        $ticket_type['description'] = $ticket_type_ite['description'];
        $ticket_type['price']       = $ticket_type_ite['ticket_price'];
        if ( 0 === strcasecmp( 'on',  $ticket_type_ite['unlimited'] ) ) {
            $ticket_type['quantity'] = null;
        } else {
            $ticket_type['quantity'] = $ticket_type_ite['quantity'];
        }
        $ticket_type['buy_min_qty']   = $ticket_type_ite['buy_min_limit'];
        if ( ai1ec_is_blank( $ticket_type_ite['buy_max_limit'] ) ) {
            $ticket_type['buy_max_qty'] = null;
        } else {
            $ticket_type['buy_max_qty'] = $ticket_type_ite['buy_max_limit'];
        }
        if ( 0 === strcasecmp( 'on',  $ticket_type_ite['availibility'] ) ) {
            //immediate availability
            $timezone_start_time            = $this->_registry->get( 'date.time' );
            $timezone_start_time->set_timezone( $event->get('timezone_name') );
            $ticket_type['immediately']     = true;
            $ticket_type['sale_start_date'] = $timezone_start_time->format_to_javascript( $event->get('timezone_name') );
            $ticket_type['sale_end_date']   = $event->get( 'end' )->format_to_javascript();
        } else {
            $ticket_type['immediately']     = false;
            $ticket_type['sale_start_date'] =  $ticket_type_ite['ticket_sale_start_date'];
            $ticket_type['sale_end_date']   =  $ticket_type_ite['ticket_sale_end_date'];
        }
        $ticket_type['updated_at'] = $utc_current_time;
        $ticket_type['status']     = $ticket_type_ite['ticket_status'];
        return $ticket_type;
    }

    /**
     * Unparse the fields of API structure to the Ticket Type
     */
    protected function _unparse_tickets_type_from_api_structure( $ticket_type_api ) {
        $ticket_type                         = $ticket_type_api;
        $ticket_type->ticket_name            = $ticket_type_api->name;
        $ticket_type->ticket_price           = $ticket_type_api->price;
        $ticket_type->buy_min_limit          = $ticket_type_api->buy_min_qty;
        if ( null === $ticket_type_api->buy_max_qty ) {
            $ticket_type->buy_max_limit = self::MAX_TICKET_TO_BUY_DEFAULT;
        } else {
            $ticket_type->buy_max_limit = $ticket_type_api->buy_max_qty;
        }
        if ( true === ( ( bool ) $ticket_type_api->immediately ) ) {
            $ticket_type->availibility = 'on';
        } else {
            $ticket_type->availibility = 'off';
        }
        $ticket_type->ticket_sale_start_date = $ticket_type_api->sale_start_date; //YYYY-MM-YY HH:NN:SS
        $ticket_type->ticket_sale_end_date   = $ticket_type_api->sale_end_date; //YYYY-MM-YY HH:NN:SS
        $ticket_type->ticket_status          = $ticket_type_api->status;
        if ( 'open' === $ticket_type_api->status ) {
            $ticket_type->ticket_status_label = __( 'Open for sale', AI1EC_PLUGIN_NAME );
        } else if ( 'closed' === $ticket_type_api->status )  {
            $ticket_type->ticket_status_label = __( 'Sale ended', AI1EC_PLUGIN_NAME );
        } else if ( 'canceled' === $ticket_type_api->status ) {
            $ticket_type->ticket_status_label = __( 'Canceled', AI1EC_PLUGIN_NAME );
        } else {
            $ticket_type->ticket_status_label = $ticket_type_api->status;
        }
        if ( false === isset( $ticket_type_api->quantity ) ||
            null === $ticket_type_api->quantity ) {
             $ticket_type->unlimited          = 'on';
        } else {
             $ticket_type->unlimited          = 'off';
        }
        $ticket_type->ticket_type_id = $ticket_type_api->id;
        $ticket_type->available      = $ticket_type_api->available;
        $ticket_type->availability   = $this->_parse_availability_message( $ticket_type_api->availability );

        //derived property to set the max quantity of dropdown
        if ( $ticket_type->available !== null ) {
            if ( $ticket_type->available > $ticket_type->buy_max_limit ) {
                $ticket_type->buy_max_available = $ticket_type->buy_max_limit;
            } else {
                $ticket_type->buy_max_available = $ticket_type->available;
            }
        } else {
            $ticket_type->buy_max_available = $ticket_type->buy_max_limit;
        }
        return $ticket_type;
    }

    public function _parse_availability_message( $availability ){
        if ( ai1ec_is_blank ( $availability ) ) {
            return null;
        } else {
            switch ($availability) {
                case 'past_event':
                    return __( 'Past Event' );
                case 'event_closed':
                    return __( 'Event closed' );
                case 'not_available_yet':
                    return __( 'Not available yet' );
                case 'sale_closed':
                    return __( 'Sale closed' );
                case 'sold_out':
                    return __( 'Sold out' );
                default:
                    return __( 'Not available' );
            }
        }
    }

    public function get_event( $post_id ) {
        $api_event_id = $this->get_api_event_id( $post_id );
        if ( ! $api_event_id ) {
            return (object) array( 'data' => array() );
        }
        $response = $this->request_api( 'GET', $this->get_api_event_url( $post_id ) . 'events/' . $api_event_id . '/edit' );
        if ( $this->is_response_success( $response ) ) {
            if ( isset( $response->body->ticket_types ) ) {
                 foreach ( $response->body->ticket_types as $ticket_api ) {
                     $this->_unparse_tickets_type_from_api_structure( $ticket_api );
                }
            }
            return (object) array( 'data' => $response->body );
        } else {
            $error_message = $this->_transform_error_message(
                __( 'We were unable to get the Event Details from Time.ly Ticketing', AI1EC_PLUGIN_NAME ),
                $response->raw, $response->url,
                true
            );
            return (object) array( 'data' => array(), 'error' => $error_message );
        }
    }

    /**
     * @return string JSON.
     */
    public function get_ticket_types( $post_id, $get_canceled = true ) {
        $api_event_id = $this->get_api_event_id( $post_id );
        if ( ! $api_event_id ) {
            return json_encode( array( 'data' => array() ) );
        }
        $response = $this->request_api( 'GET', $this->get_api_event_url( $post_id ) . 'events/' . $api_event_id . '/ticket_types',
            array( 'get_canceled' => ( true === $get_canceled ? 1 : 0 ) )
        );
        if ( $this->is_response_success( $response ) ) {
            if ( isset( $response->body->ticket_types ) ) {
                 foreach ( $response->body->ticket_types as $ticket_api ) {
                     $this->_unparse_tickets_type_from_api_structure( $ticket_api );
                }
                return json_encode( array( 'data' => $response->body->ticket_types ) );
            } else {
                return json_encode( array( 'data' => array() ) );
            }
        } else {
            $error_message = $this->_transform_error_message(
                __( 'We were unable to get the Tickets Details from Time.ly Ticketing', AI1EC_PLUGIN_NAME ),
                $response->raw, $response->url,
                true
            );
            return json_encode( array( 'data' => array(), 'error' => $error_message ) );
        }
    }

    /**
     * @return object Response body in JSON.
     */
    public function get_tickets( $post_id ) {
        $api_event_id = $this->get_api_event_id( $post_id );
        if ( ! $api_event_id ) {
            return json_encode( array( 'data' => array() ) );
        }
        $request  = array(
            'headers' => $this->_get_headers(),
            'timeout' => parent::DEFAULT_TIMEOUT
            );
        $url           = $this->get_api_event_url( $post_id ) . 'events/' . $api_event_id . '/tickets';
        $response      = wp_remote_get( $url, $request );
        $response_code = wp_remote_retrieve_response_code( $response );
        if ( 200 === $response_code ) {
            return $response['body'];
        } else {
            $error_message = $this->_transform_error_message(
                __( 'We were unable to get the Tickets Attendees from Time.ly Ticketing', AI1EC_PLUGIN_NAME ),
                $response, $url,
                true
            );
            return json_encode( array( 'data' => array(), 'error' => $error_message ) );
        }
    }

    /**
     * Check if a Ticket Event was imported from an ICS Feed
     */
    public function is_ticket_event_imported( $post_id ) {
        $data    = $this->get_api_event_data( $post_id );
        if (  isset( $data[self::ATTR_EVENT_ID] ) && isset( $data[self::ATTR_ICS_API_URL] ) ) {
            return ( ! ai1ec_is_blank ( $data[self::ATTR_ICS_API_URL] ) );
        } else {
            return false;
        }

    }

    /**
     * Check if the Ticket Event was created using a different account
     * The user probably created the event from one account, signed out and
     * is currently signed in with a new account
     */
    public function is_ticket_event_from_another_account( $post_id ) {
        $data    = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            if ( isset( $data[self::ATTR_ACCOUNT] ) ) {
                return ( $this->get_current_account() != $data[self::ATTR_ACCOUNT] );
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the API account where the event was created
     * @param int $post_id Post ID
     * @param bool $default_null True to return NULL if the value does not exist, false to return the configured API URL
     */
    public function get_api_event_account( $post_id ) {
        $data    = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            if ( isset( $data[self::ATTR_ACCOUNT] ) ) {
                return $data[self::ATTR_ACCOUNT];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Check if the response that came from the API is the event not found
     */
    private function _is_event_notfound_error( $response ) {
        if ( isset( $response->response_code ) && 404 === $response->response_code ) {
            if ( isset( $response->body ) ) {
                if ( is_array( $response->body ) &&
                    isset( $response->body['message'] ) ) {
                    if ( false !== stripos( $response->body['message'], 'event not found') ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @return NULL in case of success or an error string in case of error
     */
    public function update_api_event_fields( WP_Post $post, $api_fields_values, $post_action = 'trash', $ajax_action = false ) {
        $post_id      = $post->ID;
           $api_event_id = $this->get_api_event_id( $post_id );
        if ( ! $api_event_id ) {
            return null;
        }
        try {
            $event =  $this->_registry->get( 'model.event', $post_id );
        } catch ( Ai1ec_Event_Not_Found_Exception $excpt ) {
            $message      = __( 'Event not found inside the database.', AI1EC_PLUGIN_NAME );
            $notification = $this->_registry->get( 'notification.admin' );
            $notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
            return $message;
        }
        if ( 'update' === $post_action ) {
            $error = $this->_prevent_update_ticket_event( $event, $ajax_action );
            if ( null !== $error ) {
                return $error;
            }
        } else {
            if ( $this->is_ticket_event_imported( $post_id ) )  {
                return null;
            }
            if ( $this->is_ticket_event_from_another_account( $post_id ) )  {
                return null;
            }
        }
        $headers   = $this->_get_headers();
        $body_data = $this->parse_event_fields_to_api_structure(
            $event,
            $post,
            null, //does not update ticket types, just chaging the api fields specified
            $api_fields_values
        );
        $response = $this->request_api( 'POST',
            AI1EC_API_URL . 'events/' . $api_event_id,
            $body_data,
            true //true to decode response body
            );
        if ( ! $this->is_response_success( $response ) ) {
            if ( $this->_is_event_notfound_error( $response ) ) {
                if ( isset( $api_fields_values['status'] ) &&
                    'trash' === $api_fields_values['status'] ) {
                    //this is an exception, the event was deleted on API server, but for some reason
                    //the metada was not unset, in this case leave the event be
                    //move to trash
                    return null;
                }
            }
            $message = $this->save_error_notification( $response, __( 'We were unable to Update the Event on Time.ly Network', AI1EC_PLUGIN_NAME ) );
            return $message;
        } else {
            return null;
        }
    }

    /**
     * Deletes the API event
     * @return NULL in case of success or an error string in case of error
     */
    public function delete_api_event( $post_id, $post_action = 'delete', $ajax_action = false ) {
        $api_event_id = $this->get_api_event_id( $post_id );
        if ( ! $api_event_id ) {
            return null;
        }
        if ( 'update' === $post_action ) {
            try {
                $event =  $this->_registry->get( 'model.event', $post_id );
            } catch ( Ai1ec_Event_Not_Found_Exception $excpt ) {
                $message      = __( 'Event not found inside the database.', AI1EC_PLUGIN_NAME );
                $notification = $this->_registry->get( 'notification.admin' );
                $notification->store( $message, 'error', 0, array( Ai1ec_Notification_Admin::RCPT_ADMIN ), false );
                return $message;
            }
            $error = $this->_prevent_update_ticket_event( $event, $ajax_action );
            if ( null !== $error ) {
                return $error;
            }
        } else {
            if ( $this->is_ticket_event_imported( $post_id ) )  {
                $this->clear_event_metadata( $post_id );
                return null;
            }
            if ( $this->is_ticket_event_from_another_account( $post_id ) )  {
                $this->clear_event_metadata( $post_id );
                return null;
            }
        }
        $response = $this->request_api( 'DELETE',
            AI1EC_API_URL . 'events/' . $api_event_id,
            true //true to decode response body
            );
        if ( $this->is_response_success( $response ) ) {
            $this->clear_event_metadata( $post_id );
            return null;
        } else {
            if ( $this->_is_event_notfound_error( $response ) ) {
                $this->clear_event_metadata( $post_id );
                return null;
            }
            $message = $this->save_error_notification( $response, __( 'We were unable to remove the Event on Time.ly Network', AI1EC_PLUGIN_NAME ) );
            return $message;
        }
    }

    /**
     * Clear the event metadata used by Event from the post id
     * @param int $post_id Post ID
     */
    public function clear_event_metadata( $post_id ) {
        delete_post_meta( $post_id, self::API_EVENT_DATA );
    }

    public function get_api_event_data( $post_id ) {
        $data = get_post_meta(
            $post_id,
            self::API_EVENT_DATA,
            true
        );
        if ( ai1ec_is_blank ( $data ) ) {
            return null;
        } else if ( is_numeric( $data ) ) {
            //migrate the old metadata into one
            $new_data[self::ATTR_EVENT_ID] = $data;
            $value = get_post_meta( $post_id, '_ai1ec_thumbnail_id', true );
            if ( false === ai1ec_is_blank( $value ) ) {
                $new_data[self::ATTR_THUMBNAIL_ID] = $value;
            }
            $value = get_post_meta( $post_id, '_ai1ec_ics_checkout_url', true );
            if ( false === ai1ec_is_blank( $value ) ) {
                $new_data[self::ATTR_ICS_CHECKOUT_URL] = $value;
            }
            $value = get_post_meta( $post_id, '_ai1ec_ics_api_url'     , true );
            if ( ai1ec_is_blank( $value ) ) {
                //not imported ticket event
                $new_data[self::ATTR_ACCOUNT]          = $this->get_current_account();
                $new_data[self::ATTR_CALENDAR_ID]      = $this->get_current_calendar();
            } else {
                $new_data[self::ATTR_ICS_API_URL] = $value;
            }
            $new_data[self::ATTR_CURRENCY] = 'USD';
            update_post_meta( $post_id, self::API_EVENT_DATA, $new_data );
            return $new_data;
        } else if ( is_array( $data ) ) {
            return $data;
        } else {
            wp_die( 'Error geting the api data' );
        }
    }

    /**
     * Get the id of the event on the API
     * @param int $post_id Post ID
     */
    public function get_api_event_id( $post_id ) {
        $data = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            return $data[self::ATTR_EVENT_ID];
        } else {
            return null;
        }
    }

    /**
     * Get the API URL of the event
     * @param int $post_id Post ID
     * @param bool $default_null True to return NULL if the value does not exist, false to return the configured API URL
     */
    public function get_api_event_url ( $post_id ) {
        $data    = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            if ( isset( $data[self::ATTR_ICS_API_URL] ) ) {
                return $data[self::ATTR_ICS_API_URL];
            } else {
                return AI1EC_API_URL;
            }
        } else {
            return null;
        }
    }

    /**
     * Get the Currency of the event
     * @param int $post_id Post ID
     */
    public function get_api_event_currency ( $post_id ) {
        $data    = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            if ( isset( $data[self::ATTR_CURRENCY] ) ) {
                return $data[self::ATTR_CURRENCY];
            } else {
                return 'USD';
            }
        } else {
            return null;
        }
    }

    /**
     * Get the Checkout url of the event
     * @param int $post_id Post ID
     */
    public function get_api_event_checkout_url ( $post_id ) {
        $data = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            if ( isset( $data[self::ATTR_ICS_CHECKOUT_URL] ) ) {
                return $data[self::ATTR_ICS_CHECKOUT_URL];
            } else {
                return AI1EC_TICKETS_CHECKOUT_URL;
            }
        } else {
            return null;
        }
    }

    /**
     * Get the Buy Ticket URL of the event
     * @param int $post_id Post ID
     */
    public function get_api_event_buy_ticket_url ( $post_id ) {
        $data = $this->get_api_event_data( $post_id );
        if ( isset( $data[self::ATTR_EVENT_ID] ) ) {
            $api_event_id = $data[self::ATTR_EVENT_ID];
            if ( isset( $data[self::ATTR_ICS_CHECKOUT_URL] ) ) {
                $checkout_url = $data[self::ATTR_ICS_CHECKOUT_URL];
            } else {
                $checkout_url = AI1EC_TICKETS_CHECKOUT_URL;
            }
            return str_replace( '{event_id}', $api_event_id, $checkout_url );
        } else {
            return null;
        }
    }

     /**
     * Get tax options modal
     * @param int $event_id Event ID (optional)
     */
     public function get_tax_options_modal( $post_id = null ) {
         $calendar_id = $this->_get_ticket_calendar();
         $event_id    = $this->get_api_event_id( $post_id );
         $response    = $this->request_api( 'GET',
            AI1EC_API_URL . 'calendars/' . $calendar_id . '/tax_options' .
            ( is_null( $event_id ) ? '' : '?event_id=' . $event_id )
         );
         return (object) array( 'data' => $response->raw, 'error' => false );
    }

     /**
     * Get tax options modal
     * @param int $event_id Event ID (optional)
     */
     public function get_tax_options_modal_ep() {
         $calendar_id = $this->_get_ticket_calendar();
         $response    = $this->request_api( 'GET',
            AI1EC_API_URL . 'eventpromote/' . $calendar_id . '/tax_options'
         );
         return (object) array( 'data' => $response->raw, 'error' => false );
    }

     /**
      * Save the API event data
      * @param int $post_id Post ID
      * @param int $api_event_id (optional) Id of the event on the API
      * @param string $ics_api_url (optional) API URL of the event on the API (used when importing an ICS feed)
      * @param string $ics_checkout_url (optional) API CHECKOUT URL of the event on the API (used when importing an ICS feed)
     * @param string $currency (optional) Currency code of the event
     * @param string $thumbnail_id (optional) Id of the Thumbnail (Featured Image id)
      */
    public function save_api_event_data( $post_id, $api_event_id, $ics_api_url = null, $ics_checkout_url = null, $currency = null, $thumbnail_id = null ) {
        if ( ai1ec_is_blank( $api_event_id ) ) {
            throw new Error( 'Api event id should never be null' );
        }
        $api_data[self::ATTR_EVENT_ID]         = $api_event_id;
        $api_data[self::ATTR_ICS_API_URL]      = $ics_api_url;
        $api_data[self::ATTR_ICS_CHECKOUT_URL] = $ics_checkout_url;
        $api_data[self::ATTR_CURRENCY]         = $currency;
        $api_data[self::ATTR_THUMBNAIL_ID]     = $thumbnail_id;
        if ( ai1ec_is_blank( $ics_api_url ) ) {
            $api_data[self::ATTR_ACCOUNT]          = $this->get_current_account();
            $api_data[self::ATTR_CALENDAR_ID]      = $this->get_current_calendar();
        }
        $previous_data = $this->get_api_event_data( $post_id );
        $new_data      = array();
        if ( is_array( $previous_data ) ) {
            foreach ( $previous_data as $key => $value) {
                $new_data[$key] = $value;
            }
        }
        foreach ( $api_data as $key => $value ) {
            if ( ai1ec_is_blank( $value ) ) {
                unset( $new_data[$key] );
            } else {
                $new_data[$key] = $api_data[$key];
            }
        }
        return update_post_meta( $post_id, self::API_EVENT_DATA, $new_data, $previous_data );
    }

}