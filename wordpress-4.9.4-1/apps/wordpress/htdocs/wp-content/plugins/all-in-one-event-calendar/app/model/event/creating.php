<?php

/**
 * Handles create/update operations.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Model
 */
class Ai1ec_Event_Creating extends Ai1ec_Base {

    protected function is_valid_event( $post ) {
            // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if (
            ! isset( $_POST[AI1EC_POST_TYPE] ) ||
            ! wp_verify_nonce( $_POST[AI1EC_POST_TYPE], 'ai1ec' )
        ) {
            return false;
        }

        if (
            isset( $post->post_status ) &&
            'auto-draft' === $post->post_status
        ) {
            return false;
        }

        // verify if this is not inline-editing
        if (
            isset( $_REQUEST['action'] ) &&
            'inline-save' === $_REQUEST['action']
        ) {
            return false;
        }

        // verify that the post_type is that of an event
        if ( $post->post_type !==  AI1EC_POST_TYPE ) {
            return false;
        }

        return true;
    }

    private function _parse_post_to_event( $post_id ) {

        /**
         * =====================================================================
         *
         * CHANGE CODE BELLOW TO HAVE FOLLOWING PROPERTIES:
         * - be initializiable from model;
         * - have sane defaults;
         * - avoid that cluster of isset and ternary operator.
         *
         * =====================================================================
         */

        $all_day          = isset( $_POST['ai1ec_all_day_event'] )    ? 1                                             : 0;
        $instant_event    = isset( $_POST['ai1ec_instant_event'] )    ? 1                                             : 0;
        $timezone_name    = isset( $_POST['ai1ec_timezone_name'] )    ? $_POST['ai1ec_timezone_name']                 : 'sys.default';
        $start_time       = isset( $_POST['ai1ec_start_time'] )       ? $_POST['ai1ec_start_time']                    : '';
        $end_time         = isset( $_POST['ai1ec_end_time'] )         ? $_POST['ai1ec_end_time']                      : '';
        $venue            = isset( $_POST['ai1ec_venue'] )            ? $_POST['ai1ec_venue']                         : '';
        $address          = isset( $_POST['ai1ec_address'] )          ? $_POST['ai1ec_address']                       : '';
        $city             = isset( $_POST['ai1ec_city'] )             ? $_POST['ai1ec_city']                          : '';
        $province         = isset( $_POST['ai1ec_province'] )         ? $_POST['ai1ec_province']                      : '';
        $postal_code      = isset( $_POST['ai1ec_postal_code'] )      ? $_POST['ai1ec_postal_code']                   : '';
        $country          = isset( $_POST['ai1ec_country'] )          ? $_POST['ai1ec_country']                       : '';
        $google_map       = isset( $_POST['ai1ec_google_map'] )       ? 1                                             : 0;
        $cost             = isset( $_POST['ai1ec_cost'] )             ? $_POST['ai1ec_cost']                          : '';
        $is_free          = isset( $_POST['ai1ec_is_free'] )          ? (bool)$_POST['ai1ec_is_free']                 : false;
        $ticket_url       = isset( $_POST['ai1ec_ticket_url'] )       ? $_POST['ai1ec_ticket_url']                    : '';
        $contact_name     = isset( $_POST['ai1ec_contact_name'] )     ? $_POST['ai1ec_contact_name']                  : '';
        $contact_phone    = isset( $_POST['ai1ec_contact_phone'] )    ? $_POST['ai1ec_contact_phone']                 : '';
        $contact_email    = isset( $_POST['ai1ec_contact_email'] )    ? $_POST['ai1ec_contact_email']                 : '';
        $contact_url      = isset( $_POST['ai1ec_contact_url'] )      ? $_POST['ai1ec_contact_url']                   : '';
        $show_coordinates = isset( $_POST['ai1ec_input_coordinates'] )? 1                                             : 0;
        $longitude        = isset( $_POST['ai1ec_longitude'] )        ? $_POST['ai1ec_longitude']                     : '';
        $latitude         = isset( $_POST['ai1ec_latitude'] )         ? $_POST['ai1ec_latitude']                      : '';
        $cost_type        = isset( $_POST['ai1ec_cost_type'] )        ? $_POST['ai1ec_cost_type']                     : '';
        $rrule  = null;
        $exrule = null;
        $exdate = null;
        $rdate  = null;

        if ( 'external' !== $cost_type ) {
            $ticket_url = '';
        }

        $this->_remap_recurrence_dates();
        // if rrule is set, convert it from local to UTC time
        if (
            isset( $_POST['ai1ec_repeat'] ) &&
            ! empty( $_POST['ai1ec_repeat'] )
        ) {
            $rrule = $_POST['ai1ec_rrule'];
        }

        // add manual dates
        if (
            isset( $_POST['ai1ec_exdate'] ) &&
            ! empty( $_POST['ai1ec_exdate'] )
        ) {
            $exdate = $_POST['ai1ec_exdate'];
        }
        if (
            isset( $_POST['ai1ec_rdate'] ) &&
            ! empty( $_POST['ai1ec_rdate'] )
        ) {
            $rdate = $_POST['ai1ec_rdate'];
        }

        // if exrule is set, convert it from local to UTC time
        if (
            isset( $_POST['ai1ec_exclude'] ) &&
            ! empty( $_POST['ai1ec_exclude'] ) &&
            ( null !== $rrule || null !== $rdate ) // no point for exclusion, if repetition is not set
        ) {
            $exrule = $this->_registry->get( 'recurrence.rule' )->merge_exrule(
                $_POST['ai1ec_exrule'],
                $rrule
            );
        }

        $is_new = false;
        try {
            $event =  $this->_registry->get(
                'model.event',
                $post_id ? $post_id : null
            );
        } catch ( Ai1ec_Event_Not_Found_Exception $excpt ) {
            // Post exists, but event data hasn't been saved yet. Create new event
            // object.
            $is_new = true;
            $event  =  $this->_registry->get( 'model.event' );
        }
        $formatted_timezone = $this->_registry->get( 'date.timezone' )
                ->get_name( $timezone_name );
        if ( empty( $timezone_name ) || ! $formatted_timezone ) {
            $timezone_name = 'sys.default';
        }

        unset( $formatted_timezone );
        $start_time_entry = $this->_registry
            ->get( 'date.time', $start_time, $timezone_name );
        $end_time_entry   = $this->_registry
            ->get( 'date.time', $end_time,   $timezone_name );

        $timezone_name = $start_time_entry->get_timezone();
        if ( null === $timezone_name ) {
            $timezone_name = $start_time_entry->get_default_format_timezone();
        }

        $event->set( 'post_id',          $post_id );
        $event->set( 'start',            $start_time_entry );
        if ( $instant_event ) {
            $event->set_no_end_time();
        } else {
            $event->set( 'end',           $end_time_entry );
            $event->set( 'instant_event', false );
        }
        $event->set( 'timezone_name',    $timezone_name );
        $event->set( 'allday',           $all_day );
        $event->set( 'venue',            $venue );
        $event->set( 'address',          $address );
        $event->set( 'city',             $city );
        $event->set( 'province',         $province );
        $event->set( 'postal_code',      $postal_code );
        $event->set( 'country',          $country );
        $event->set( 'show_map',         $google_map );
        $event->set( 'cost',             $cost );
        $event->set( 'is_free',          $is_free );
        $event->set( 'ticket_url',       $ticket_url );
        $event->set( 'contact_name',     $contact_name );
        $event->set( 'contact_phone',    $contact_phone );
        $event->set( 'contact_email',    $contact_email );
        $event->set( 'contact_url',      $contact_url );
        $event->set( 'recurrence_rules', $rrule );
        $event->set( 'exception_rules',  $exrule );
        $event->set( 'exception_dates',  $exdate );
        $event->set( 'recurrence_dates', $rdate );
        $event->set( 'show_coordinates', $show_coordinates );
        $event->set( 'longitude',        trim( $longitude ) );
        $event->set( 'latitude',         trim( $latitude ) );
        $event->set( 'ical_uid',         $event->get_uid() );

        return array(
            'event'        => $event,
            'is_new'       => $is_new
        );
    }

    /**
     * Saves meta post data.
     *
     * @wp_hook save_post
     *
     * @param  int    $post_id Post ID.
     * @param  object $post    Post object.
     * @param  update
     *
     * @return object|null Saved Ai1ec_Event object if successful or null.
     */
    public function save_post( $post_id, $post, $update ) {

        if ( false === $this->is_valid_event( $post ) ) {
            return null;
        }

        // LABEL:magicquotes
        // remove WordPress `magical` slashes - we work around it ourselves
        $_POST = stripslashes_deep( $_POST );

        $data = $this->_parse_post_to_event( $post_id );
        if ( ! $data ) {
            return null;
        }
        $event        = $data['event'];
        $is_new       = $data[ 'is_new'];

        $banner_image = isset( $_POST['ai1ec_banner_image'] )     ? $_POST['ai1ec_banner_image'] : '';
        $cost_type    = isset( $_POST['ai1ec_cost_type'] )        ? $_POST['ai1ec_cost_type'] : '';

        update_post_meta( $post_id, 'ai1ec_banner_image', $banner_image );
        if ( $cost_type ) {
            update_post_meta( $post_id, '_ai1ec_cost_type', $cost_type );
        }
        $api = $this->_registry->get( 'model.api.api-ticketing' );
        if ( $update === false ) {
            //this method just creates the API event, the update action
            //is treated by another hook (pre_update_event inside api )
            if ( 'tickets' === $cost_type ) {
                $result = $api->store_event( $event, $post, false );
                if ( true !== $result ) {
                    $_POST['_ticket_store_event_error'] = $result;
                } else {
                    update_post_meta(
                        $post_id,
                        '_ai1ec_timely_tickets_url',
                        $api->get_api_event_buy_ticket_url( $event->get( 'post_id' ) )
                    );
                }
            }
        }
        if ( 'tickets' === $cost_type ) {
            update_post_meta(
                $post_id,
                '_ai1ec_timely_tickets_url',
                $api->get_api_event_buy_ticket_url( $event->get( 'post_id' ) )
            );
        } else {
            delete_post_meta(
                $post_id,
                '_ai1ec_timely_tickets_url'
            );
        }

        // let other extensions save their fields.
        do_action( 'ai1ec_save_post', $event );

        $event->save( ! $is_new );

        // LABEL:magicquotes
        // restore `magic` WordPress quotes to maintain compatibility
        $_POST = add_magic_quotes( $_POST );

        $api = $this->_registry->get( 'model.api.api-registration' );
        $api->check_settings();

        return $event;
    }

    private function get_sendback_page( $post_id ) {
        $sendback  = wp_get_referer();
        $page_base = Ai1ec_Wp_Uri_Helper::get_pagebase( $sendback ); //$_SERVER['REQUEST_URI'] );
        if ( 'post.php' === $page_base ) {
            return get_edit_post_link( $post_id, 'url' );
        } else {
            return admin_url( 'edit.php?post_type=ai1ec_event' );
        }
    }

    /**
     * Handle PRE (ticket event) update.
     * Just handle the Ticket Events, other kind of post are ignored
     * @wp_hook pre_post_update
     *
     */
    public function pre_post_update ( $post_id, $new_post_data ) {

        // LABEL:magicquotes
        // remove WordPress `magical` slashes - we work around it ourselves
        $_POST = stripslashes_deep( $_POST );

        $api    = $this->_registry->get( 'model.api.api-ticketing' );
        $action = $this->current_action();
        switch( $action ) {
        case 'inline-save': //quick edit from edit page
            $fields = array();
            if ( false === ai1ec_is_blank( $_REQUEST['post_title'] ) ) {
                $fields['title'] = $_REQUEST['post_title'];
            }
            if ( false === ai1ec_is_blank( $_REQUEST['_status'] ) ) {
                $fields['status'] = $_REQUEST['_status'];
            }
            if ( isset( $_REQUEST['keep_private'] ) && 'private' === $_REQUEST['keep_private'] ) {
                $fields['visibility'] = 'private';
            } else if ( isset( $_REQUEST['post_password'] ) && false === ai1ec_is_blank( $_REQUEST['post_password'] ) ) {
                $fields['visibility'] = 'password';
            }
            if ( 0 < count( $fields ) ) {
                $post    = get_post( $post_id );
                $ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
                $message = $api->update_api_event_fields( $post, $fields, 'update', $ajax );
                if ( null !== $message )  {
                    if ( $ajax ) {
                        wp_die( $message );
                    } else {
                        wp_redirect( $this->get_sendback_page( $post_id ) );
                        exit();
                    }
                }
            }
            return;
        case 'edit': //bulk edition from edit page
            $fields          = array();
            if ( false === ai1ec_is_blank( $_REQUEST['_status'] ) ) {
                $fields['status'] = $_REQUEST['_status'];
            }
            if ( 0 < count( $fields ) ) {
                $post    = get_post( $post_id );
                $ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
                $message = $api->update_api_event_fields( $post, $fields, 'update', $ajax );
                if ( null !== $message )  {
                    if ( $ajax ) {
                        wp_die( $message );
                    } else {
                        wp_redirect( $this->get_sendback_page( $post_id ) );
                        exit();
                    }
                }
            }
            return;
        case 'editpost': //edition from post page
            $new_post_data['ID'] = $post_id;
            $post = new WP_Post( (object) $new_post_data );
            if ( false === $this->is_valid_event( $post ) ) {
                break;
            }
            $data  = $this->_parse_post_to_event( $post_id );
            if ( ! $data ) {
                break;
            }
            $event     = $data['event'];
            $cost_type = isset( $_REQUEST['ai1ec_cost_type'] ) ? $_REQUEST['ai1ec_cost_type'] : '';
            if ( 'tickets' === $cost_type ) {
                $result = $api->store_event( $event, $post, true );
                if ( true !== $result ) {
                    wp_redirect( $this->get_sendback_page( $post_id ) );
                    exit();
                }
            } else {
                $message = $api->delete_api_event( $post_id, 'update', false );
                if ( null !== $message )  {
                    wp_redirect( $this->get_sendback_page( $post_id ) );
                    exit();
                }
            }
            break;
        default:
            break;
        }

        // LABEL:magicquotes
        // restore `magic` WordPress quotes to maintain compatibility
        $_POST = add_magic_quotes( $_POST );
    }

    protected function current_action() {
        $action = '';
        if ( isset( $_REQUEST['delete_all'] ) || isset( $_REQUEST['delete_all2'] ) ) {
            $action = 'delete';
        } else {
            if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] ) {
                $action = $_REQUEST['action'];
            }
            if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] ) {
                $action = $_REQUEST['action2'];
            }
        }
        return $action;
    }

    /**
     * _create_duplicate_post method
     *
     * Create copy of event by calling {@uses wp_insert_post} function.
     * Using 'post_parent' to add hierarchy.
     *
     * @param array $data Event instance data to copy
     *
     * @return int|bool New post ID or false on failure
     **/
    public function create_duplicate_post() {
        if ( ! isset( $_POST['post_ID'] ) ) {
            return false;
        }
        $clean_fields = array(
            'ai1ec_repeat'      => NULL,
            'ai1ec_rrule'       => '',
            'ai1ec_exrule'      => '',
            'ai1ec_exdate'      => '',
            'post_ID'           => NULL,
            'post_name'         => NULL,
            'ai1ec_instance_id' => NULL,
        );
        $old_post_id = $_POST['post_ID'];
        $instance_id = $_POST['ai1ec_instance_id'];
        foreach ( $clean_fields as $field => $to_value ) {
            if ( NULL === $to_value ) {
                unset( $_POST[$field] );
            } else {
                $_POST[$field] = $to_value;
            }
        }
        $_POST   = _wp_translate_postdata( false, $_POST );
        $_POST['post_parent'] = $old_post_id;
        $post_id = wp_insert_post( $_POST );
        $this->_registry->get( 'model.event.parent' )->event_parent(
            $post_id,
            $old_post_id,
            $instance_id
        );
        return $post_id;
    }

    /**
     * Cleans calendar shortcodes from event content.
     *
     * @param array $data    An array of slashed post data.
     * @param array $postarr An array of sanitized, but otherwise unmodified post data.
     *
     * @return array An array of slashed post data.
     */
    public function wp_insert_post_data( $data ) {
        global $shortcode_tags;
        if (
            ! isset( $data['post_type'] ) ||
            ! isset( $data['post_content'] ) ||
            AI1EC_POST_TYPE !== $data['post_type'] ||
            empty( $shortcode_tags ) ||
            ! is_array( $shortcode_tags ) ||
            false === strpos( $data['post_content'], '[' )
        ) {
            return $data;
        }
        $pattern              = get_shortcode_regex();
        $data['post_content'] = preg_replace_callback(
            "/$pattern/s",
            array( $this, 'strip_shortcode_tag' ),
            $data['post_content']
        );
        return $data;
    }

    /**
     * Reutrns shortcode or stripped content for given shortcode.
     * Currently regex callback function passes as $tag argument 7-element long
     * array.
     * First element ($tag[0]) is not modified full shortcode text.
     * Third element ($tag[2]) is pure shortcode identifier.
     * Sixth element ($tag[5]) contains shortcode content if any
     * [ai1ec_test]content[/ai1ec].
     *
     * @param array $tag Incoming data.
     *
     * @return string Shortcode replace tag.
     */
    public function strip_shortcode_tag( $tag ) {
        if (
            count( $tag ) < 7 ||
            'ai1ec' !== substr( $tag[2], 0, 5 ) ||
            ! apply_filters( 'ai1ec_content_remove_shortcode_' . $tag[2], false )
        ) {
            return $tag[0];
        }
        return $tag[5];
    }

    protected function _remap_recurrence_dates() {
        if (
            isset( $_POST['ai1ec_exclude'] ) &&
            'EXDATE' === substr( $_POST['ai1ec_exrule'], 0, 6 )
        ) {
            $_POST['ai1ec_exdate'] = substr( $_POST['ai1ec_exrule'], 7 );
            unset( $_POST['ai1ec_exclude'],  $_POST['ai1ec_exrule'] );
        }
        if (
            isset( $_POST['ai1ec_repeat'] ) &&
            'RDATE' === substr( $_POST['ai1ec_rrule'], 0, 5 )
        ) {
            $_POST['ai1ec_rdate'] = substr( $_POST['ai1ec_rrule'], 6 );
            unset( $_POST['ai1ec_repeat'],  $_POST['ai1ec_rrule'] );
        }
    }

}
