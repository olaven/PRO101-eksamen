<?php

/**
 * The ics import/export engine.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Import-export
 */
class Ai1ec_Ics_Import_Export_Engine
    extends Ai1ec_Base
    implements Ai1ec_Import_Export_Engine {

    /**
     * @var Ai1ec_Taxonomy
     */
    protected $_taxonomy_model = null;

    /**
     * Recurrence rule class. Contains filter method.
     *
     * @var Ai1ec_Recurrence_Rule
     */
    protected $_rule_filter = null;

    /* (non-PHPdoc)
     * @see Ai1ec_Import_Export_Engine::import()
     */
    public function import( array $arguments ) {
        throw new Exception( 'Import not supported' );
    }

    /* (non-PHPdoc)
     * @see Ai1ec_Import_Export_Engine::export()
     */
    public function export( array $arguments, array $params = array() ) {
        $vparams = array();
        if ( isset( $params['xml'] ) && true === $params['xml'] ) {
            $vparams['format'] = 'xcal';
        }
        $c = new vcalendar( $vparams );
        $c->setProperty( 'calscale', 'GREGORIAN' );
        $c->setProperty( 'method', 'PUBLISH' );
        // if no post id are specified do not export those properties
        // as they would create a new calendar in outlook.
        // a user reported this in AIOEC-982 and said this would fix it
        if( true === $arguments['do_not_export_as_calendar'] ) {
            $c->setProperty( 'X-WR-CALNAME', get_bloginfo( 'name' ) );
            $c->setProperty( 'X-WR-CALDESC', get_bloginfo( 'description' ) );
        }
        $c->setProperty( 'X-FROM-URL', home_url() );
        // Timezone setup
        $tz = $this->_registry->get( 'date.timezone' )->get_default_timezone();
        if ( $tz ) {
            $c->setProperty( 'X-WR-TIMEZONE', $tz );
            $tz_xprops = array( 'X-LIC-LOCATION' => $tz );
            iCalUtilityFunctions::createTimezone( $c, $tz, $tz_xprops );
        }

        $this->_taxonomy_model = $this->_registry->get( 'model.taxonomy' );
        $post_ids = array();
        foreach ( $arguments['events'] as $event ) {
            $post_ids[] = $event->get( 'post_id' );
        }
        $this->_taxonomy_model->prepare_meta_for_ics( $post_ids );
        $this->_registry->get( 'controller.content-filter' )
            ->clear_the_content_filters();
        foreach ( $arguments['events'] as $event ) {
            $c = $this->_insert_event_in_calendar(
                $event,
                $c,
                true,
                $params
            );
        }
        $this->_registry->get( 'controller.content-filter' )
            ->restore_the_content_filters();
        $str = ltrim( $c->createCalendar() );
        return $str;
    }

    /**
     * Check if date-time specification has no (empty) time component.
     *
     * @param array $datetime Datetime array returned by iCalcreator.
     *
     * @return bool Timelessness.
     */
    protected function _is_timeless( array $datetime ) {
        $timeless = true;
        foreach ( array( 'hour', 'min', 'sec' ) as $field ) {
            $timeless &= (
                    isset( $datetime[$field] ) &&
                    0 != $datetime[$field]
            )
            ? false
            : true;
        }
        return $timeless;
    }

    /**
     * Process vcalendar instance - add events to database.
     *
     * @param vcalendar $v    Calendar to retrieve data from.
     * @param array     $args Arbitrary arguments map.
     *
     * @throws Ai1ec_Parse_Exception
     *
     * @internal param stdClass $feed           Instance of feed (see Ai1ecIcs plugin).
     * @internal param string   $comment_status WP comment status: 'open' or 'closed'.
     * @internal param int      $do_show_map    Map display status (DB boolean: 0 or 1).
     *
     * @return int Count of events added to database.
     */
    public function add_vcalendar_events_to_db(
        vcalendar $v,
        array $args
    ) {
        $forced_timezone = null;
        $feed            = isset( $args['feed'] ) ? $args['feed'] : null;
        $comment_status  = isset( $args['comment_status'] ) ? $args['comment_status'] : 'open';
        $do_show_map     = isset( $args['do_show_map'] ) ? $args['do_show_map'] : 0;
        $count           = 0;
        $events_in_db    = isset( $args['events_in_db'] ) ? $args['events_in_db'] : 0;

        //sort by event date function _cmpfcn of iCalcreator.class.php
        $v->sort();

        // Reverse the sort order, so that RECURRENCE-IDs are listed before the
        // defining recurrence events, and therefore take precedence during
        // caching.
        $v->components = array_reverse( $v->components );

        // TODO: select only VEVENT components that occur after, say, 1 month ago.
        // Maybe use $v->selectComponents(), which takes into account recurrence

        // Fetch default timezone in case individual properties don't define it
        $tz             = $v->getComponent( 'vtimezone' );
        $local_timezone = $this->_registry->get( 'date.timezone' )->get_default_timezone();
        $timezone       = $local_timezone;
        if ( ! empty( $tz ) ) {
            $timezone = $tz->getProperty( 'TZID' );
        }

        $feed_name     = $v->getProperty( 'X-WR-CALNAME' );
        $x_wr_timezone = $v->getProperty( 'X-WR-TIMEZONE' );
        if (
            isset( $x_wr_timezone[1] ) &&
            is_array( $x_wr_timezone )
        ) {
            $forced_timezone = (string)$x_wr_timezone[1];
            $timezone        = $forced_timezone;
        }

        $messages        = array();
        if ( empty( $forced_timezone ) ) {
            $forced_timezone = $local_timezone;
        }
        $current_timestamp = $this->_registry->get( 'date.time' )->format_to_gmt();
        // initialize empty custom exclusions structure
        $exclusions        = array();
        // go over each event
        while ( $e = $v->getComponent( 'vevent' ) ) {

            // Event data array.
            $data = array();
            // =====================
            // = Start & end times =
            // =====================
            $start = $e->getProperty( 'dtstart', 1, true );
            $end   = $e->getProperty( 'dtend',   1, true );
            // For cases where a "VEVENT" calendar component
            // specifies a "DTSTART" property with a DATE value type but none
            // of "DTEND" nor "DURATION" property, the event duration is taken to
            // be one day.  For cases where a "VEVENT" calendar component
            // specifies a "DTSTART" property with a DATE-TIME value type but no
            // "DTEND" property, the event ends on the same calendar date and
            // time of day specified by the "DTSTART" property.
            if ( empty( $end ) )  {
                // #1 if duration is present, assign it to end time
                $end = $e->getProperty( 'duration', 1, true, true );
                if ( empty( $end ) ) {
                    // #2 if only DATE value is set for start, set duration to 1 day
                    if ( ! isset( $start['value']['hour'] ) ) {
                        $end = array(
                            'value' => array(
                                'year'  => $start['value']['year'],
                                'month' => $start['value']['month'],
                                'day'   => $start['value']['day'] + 1,
                                'hour'  => 0,
                                'min'   => 0,
                                'sec'   => 0,
                            ),
                        );
                        if ( isset( $start['value']['tz'] ) ) {
                            $end['value']['tz'] = $start['value']['tz'];
                        }
                    } else {
                        // #3 set end date to start time
                        $end = $start;
                    }
                }
            }
            $categories = $e->getProperty( "CATEGORIES", false, true );
            $imported_cat = array( Ai1ec_Event_Taxonomy::CATEGORIES => array() );
            // If the user chose to preserve taxonomies during import, add categories.
            if( $categories && $feed->keep_tags_categories ) {
                $imported_cat = $this->add_categories_and_tags(
                        $categories['value'],
                        $imported_cat,
                        false,
                        true
                );
            }
            $feed_categories = $feed->feed_category;
            if( ! empty( $feed_categories ) ) {
                $imported_cat = $this->add_categories_and_tags(
                        $feed_categories,
                        $imported_cat,
                        false,
                        false
                );
            }
            $tags = $e->getProperty( "X-TAGS", false, true );
            $imported_tags = array( Ai1ec_Event_Taxonomy::TAGS => array() );
            // If the user chose to preserve taxonomies during import, add tags.
            if( $tags && $feed->keep_tags_categories ) {
                $imported_tags = $this->add_categories_and_tags(
                        $tags[1]['value'],
                        $imported_tags,
                        true,
                        true
                );
            }
            $feed_tags = $feed->feed_tags;
            if( ! empty( $feed_tags ) ) {
                $imported_tags = $this->add_categories_and_tags(
                        $feed_tags,
                        $imported_tags,
                        true,
                        true
                );
            }
            // Event is all-day if no time components are defined
            $allday = $this->_is_timeless( $start['value'] ) &&
                $this->_is_timeless( $end['value'] );
            // Also check the proprietary MS all-day field.
            $ms_allday = $e->getProperty( 'X-MICROSOFT-CDO-ALLDAYEVENT' );
            if ( ! empty( $ms_allday ) && $ms_allday[1] == 'TRUE' ) {
                $allday = true;
            }
            $event_timezone = $timezone;

            // Check if the timezone is a recognized TZ in PHP
            // Note: the TZ may be perfectly valid, but it may not be an accepted value in the PHP version the plugin is running on
            $tztest = @timezone_open( $event_timezone );

            if ( ! $tztest || $allday || preg_match( "/GMT[+|-][0-9]{4}.*/", $event_timezone ) ) {
                $event_timezone = $local_timezone;
            }
            $start = $this->_time_array_to_datetime(
                $start,
                $event_timezone,
                $feed->import_timezone ? $forced_timezone : null
            );
            $end   = $this->_time_array_to_datetime(
                $end,
                $event_timezone,
                $feed->import_timezone ? $forced_timezone : null
            );
            if ( false === $start || false === $end ) {
                array_push ( $messages, $e->getProperty( 'summary' )." -  Failed to parse one or more dates to timezone: ".var_export( $event_timezone, true ) );
                continue;
            }

            // If all-day, and start and end times are equal, then this event has
            // invalid end time (happens sometimes with poorly implemented iCalendar
            // exports, such as in The Event Calendar), so set end time to 1 day
            // after start time.
            if ( $allday && $start->format() === $end->format() ) {
                $end->adjust_day( +1 );
            }

            $data += compact( 'start', 'end', 'allday' );

            // =======================================
            // = Recurrence rules & recurrence dates =
            // =======================================
            if ( $rrule = $e->createRrule() ) {
                $rrule = explode( ':', $rrule );
                $rrule = trim( end( $rrule ) );
            }

            if ( $exrule = $e->createExrule() ) {
                $exrule = explode( ':', $exrule );
                $exrule = trim( end( $exrule ) );
            }

            if ( $rdate = $e->createRdate() ) {
                $arr     = explode( 'RDATE', $rdate );
                $matches = null;
                foreach ( $arr as $value ) {
                    $arr2 = explode( ':', $value );
                    if ( 2 === count( $arr2 ) ) {
                        $matches[] = $arr2[1];
                    }
                }
                if ( null !== $matches ) {
                    $rdate = implode( ',', $matches );
                    unset( $matches );
                    unset( $arr );
                } else {
                    $rdate = null;
                }
            }

            // ===================
            // = Exception dates =
            // ===================
            $exdate = '';
            if ( $exdates = $e->createExdate() ){
                // We may have two formats:
                // one exdate with many dates ot more EXDATE rules
                $exdates      = explode( 'EXDATE', $exdates );
                $def_timezone = $this->_get_import_timezone( $event_timezone );
                foreach ( $exdates as $exd ) {
                    if ( empty( $exd ) ) {
                        continue;
                    }
                    $exploded       = explode( ':', $exd );
                    $excpt_timezone = $def_timezone;
                    $excpt_date     = null;
                    foreach ( $exploded as $particle ) {
                        if ( ';TZID=' === substr( $particle, 0, 6 ) ) {
                            $excpt_timezone = substr( $particle, 6 );
                        } else {
                            $excpt_date = trim( $particle );
                        }
                    }
                    $exploded       = explode( ',', $excpt_date );
                    foreach ( $exploded as $particle ) {
                        // Google sends YYYYMMDD for all-day excluded events
                        if (
                            $allday &&
                            8 === strlen( $particle )
                        ) {
                            $particle    .= 'T000000Z';
                            $excpt_timezone = 'UTC';
                        }
                        $ex_dt = $this->_registry->get(
                            'date.time',
                            $particle,
                            $excpt_timezone
                        );
                        if ( $ex_dt ) {
                            if ( isset( $exdate{0} ) ) {
                                $exdate .= ',';
                            }
                            $exdate .= $ex_dt->format( 'Ymd\THis', $excpt_timezone );
                        }
                    }
                }
            }
            // Add custom exclusions if there any
            $recurrence_id = $e->getProperty( 'recurrence-id' );
            if (
                false === $recurrence_id &&
                ! empty( $exclusions[$e->getProperty( 'uid' )] )
            ) {
                if ( isset( $exdate{0} ) ) {
                    $exdate .= ',';
                }
                $exdate .= implode( ',', $exclusions[$e->getProperty( 'uid' )] );
            }
            // ========================
            // = Latitude & longitude =
            // ========================
            $latitude = $longitude = NULL;
            $geo_tag  = $e->getProperty( 'geo' );
            if ( is_array( $geo_tag ) ) {
                if (
                    isset( $geo_tag['latitude'] ) &&
                    isset( $geo_tag['longitude'] )
                ) {
                    $latitude  = (float)$geo_tag['latitude'];
                    $longitude = (float)$geo_tag['longitude'];
                }
            } else if ( ! empty( $geo_tag ) && false !== strpos( $geo_tag, ';' ) ) {
                list( $latitude, $longitude ) = explode( ';', $geo_tag, 2 );
                $latitude  = (float)$latitude;
                $longitude = (float)$longitude;
            }
            unset( $geo_tag );
            if ( NULL !== $latitude ) {
                $data += compact( 'latitude', 'longitude' );
                // Check the input coordinates checkbox, otherwise lat/long data
                // is not present on the edit event page
                $data['show_coordinates'] = 1;
            }
            // ===================
            // = Venue & address =
            // ===================
            $address = $venue = '';
            $location = $e->getProperty( 'location' );
            $matches = array();
            // This regexp matches a venue / address in the format
            // "venue @ address" or "venue - address".
            preg_match( '/\s*(.*\S)\s+[\-@]\s+(.*)\s*/', $location, $matches );
            // if there is no match, it's not a combined venue + address
            if ( empty( $matches ) ) {
                // temporary fix for Mac ICS import. Se AIOEC-2187
                // and https://github.com/iCalcreator/iCalcreator/issues/13
                $location = str_replace( '\n', "\n", $location );
                // if there is a comma, probably it's an address
                if ( false === strpos( $location, ',' ) ) {
                    $venue = $location;
                } else {
                    $address = $location;
                }
            } else {
                $venue = isset( $matches[1] ) ? $matches[1] : '';
                $address = isset( $matches[2] ) ? $matches[2] : '';
            }

            // =====================================================
            // = Set show map status based on presence of location =
            // =====================================================
            $event_do_show_map = $do_show_map;
            if (
                1 === $do_show_map &&
                NULL === $latitude &&
                empty( $address )
            ) {
                $event_do_show_map = 0;
            }

            // ==================
            // = Cost & tickets =
            // ==================
            $cost       = $e->getProperty( 'X-COST' );
            $cost       = $cost ? $cost[1] : '';
            $ticket_url = $e->getProperty( 'X-TICKETS-URL' );
            $ticket_url = $ticket_url ? $ticket_url[1] : '';

            // ===============================
            // = Contact name, phone, e-mail =
            // ===============================
            $organizer = $e->getProperty( 'organizer' );
            if (
                'MAILTO:' === substr( $organizer, 0, 7 ) &&
                false === strpos( $organizer, '@' )
            ) {
                $organizer = substr( $organizer, 7 );
            }
            $contact = $e->getProperty( 'contact' );
            $elements = explode( ';', $contact, 4 );

            foreach ( $elements as $el ) {
                $el = trim( $el );
                // Detect e-mail address.
                if ( false !== strpos( $el, '@' ) ) {
                    $data['contact_email'] = $el;
                }
                // Detect URL.
                elseif ( false !== strpos( $el, '://' ) ) {
                    $data['contact_url']   = $el;
                }
                // Detect phone number.
                elseif ( preg_match( '/^[\+0-9\-\(\)\s]*$/', $el ) && strlen( $el ) <= 32 ) {
                    $data['contact_phone'] = $el;
                }
                // Default to name.
                else {
                    $data['contact_name']  = $el;
                }
            }
            if ( ! isset( $data['contact_name'] ) || ! $data['contact_name'] ) {
                // If no contact name, default to organizer property.
                $data['contact_name']    = $organizer;
            }

            $description = stripslashes(
                            str_replace(
                                '\n',
                                "\n",
                                $e->getProperty( 'description' )
                            ));

            $description = $this->_remove_ticket_url( $description );

            // Store yet-unsaved values to the $data array.
            $data += array(
                'recurrence_rules'  => $rrule,
                'exception_rules'   => $exrule,
                'recurrence_dates'  => $rdate,
                'exception_dates'   => $exdate,
                'venue'             => $venue,
                'address'           => $address,
                'cost'              => $cost,
                'ticket_url'        => $ticket_url,
                'show_map'          => $event_do_show_map,
                'ical_feed_url'     => $feed->feed_url,
                'ical_source_url'   => $e->getProperty( 'url' ),
                'ical_organizer'    => $organizer,
                'ical_contact'      => $contact,
                'ical_uid'          => $this->_get_ical_uid( $e ),
                'categories'        => array_keys( $imported_cat[Ai1ec_Event_Taxonomy::CATEGORIES] ),
                'tags'              => array_keys( $imported_tags[Ai1ec_Event_Taxonomy::TAGS] ),
                'feed'              => $feed,
                'post'              => array(
                    'post_status'       => 'publish',
                    'comment_status'    => $comment_status,
                    'post_type'         => AI1EC_POST_TYPE,
                    'post_author'       => 1,
                    'post_title'        => $e->getProperty( 'summary' ),
                    'post_content'      => $description
                )
            );
            // register any custom exclusions for given event
            $exclusions = $this->_add_recurring_events_exclusions(
                $e,
                $exclusions,
                $start
            );

            // Create event object.
            $data  = apply_filters(
                'ai1ec_pre_init_event_from_feed',
                $data,
                $e,
                $feed
            );

            $event = $this->_registry->get( 'model.event', $data );

            // Instant Event
            $is_instant = $e->getProperty( 'X-INSTANT-EVENT' );
            if ( $is_instant ) {
                $event->set_no_end_time();
            }

            $recurrence = $event->get( 'recurrence_rules' );
            $search = $this->_registry->get( 'model.search' );
            // first let's check by UID
            $matching_event_id = $search
                ->get_matching_event_by_uid_and_url(
                    $event->get( 'ical_uid' ),
                    $event->get( 'ical_feed_url' )
                );
            // if no result, perform the legacy check.
            if ( null === $matching_event_id ) {
                $matching_event_id = $search
                    ->get_matching_event_id(
                        $event->get( 'ical_uid' ),
                        $event->get( 'ical_feed_url' ),
                        $event->get( 'start' ),
                        ! empty( $recurrence )
                    );
            }
            if ( null === $matching_event_id ) {

                // =================================================
                // = Event was not found, so store it and the post =
                // =================================================
                $event->save();
                $count++;
            } else {
                // ======================================================
                // = Event was found, let's store the new event details =
                // ======================================================
                $uid_cal = $e->getProperty( 'uid' );
                if ( ! ai1ec_is_blank( $uid_cal ) ) {
                    $uid_cal_original = sprintf( $event->get_uid_pattern(), $matching_event_id );
                    if ( $uid_cal_original === $uid_cal ) {
                        //avoiding cycle import
                        //ignore the event, it belongs to site
                        unset( $events_in_db[$matching_event_id] );
                        continue;
                    }
                }

                // Update the post
                $post               = get_post( $matching_event_id );

                if ( null !== $post ) {
                    $post->post_title   = $event->get( 'post' )->post_title;
                    $post->post_content = $event->get( 'post' )->post_content;
                    wp_update_post( $post );

                    // Update the event
                    $event->set( 'post_id', $matching_event_id );
                    $event->set( 'post',    $post );
                    $event->save( true );
                    $count++;
                }
            }
            do_action( 'ai1ec_ics_event_saved', $event, $feed );

            // import not standard taxonomies.
            unset( $imported_cat[Ai1ec_Event_Taxonomy::CATEGORIES] );
            foreach ( $imported_cat as $tax_name => $ids ) {
                wp_set_post_terms( $event->get( 'post_id' ), array_keys( $ids ), $tax_name );
            }

            unset( $imported_tags[Ai1ec_Event_Taxonomy::TAGS] );
            foreach ( $imported_tags as $tax_name => $ids ) {
                wp_set_post_terms( $event->get( 'post_id' ), array_keys( $ids ), $tax_name );
            }

            // import the metadata used by ticket events

            $cost_type    = $e->getProperty( 'X-COST-TYPE' );
            if ( $cost_type && false === ai1ec_is_blank( $cost_type[1] ) ) {
                update_post_meta( $event->get( 'post_id' ), '_ai1ec_cost_type', $cost_type[1] );
            }

            $api_event_id = $e->getProperty( 'X-API-EVENT-ID' );
            if ( $api_event_id && false === ai1ec_is_blank( $api_event_id[1] ) ) {
                $api_event_id = $api_event_id[1];
            } else {
                $api_event_id = null;
            }

            $api_url = $e->getProperty( 'X-API-URL' );
            if ( $api_url && false === ai1ec_is_blank( $api_url[1] ) ) {
                $api_url = $api_url[1];
            } else {
                $api_url = null;
            }

            $checkout_url = $e->getProperty( 'X-CHECKOUT-URL' );
            if ( $checkout_url && false === ai1ec_is_blank( $checkout_url[1] ) ) {
                $checkout_url = $checkout_url[1];
            } else {
                $checkout_url = null;
            }

            $currency = $e->getProperty( 'X-API-EVENT-CURRENCY' );
            if ( $currency && false === ai1ec_is_blank( $currency[1] ) ) {
                $currency = $currency[1];
            } else {
                $currency = null;
            }
            if ( $api_event_id || $api_url || $checkout_url || $currency ) {
                if ( ! isset( $api ) ) {
                    $api = $this->_registry->get( 'model.api.api-ticketing' );
                }
                $api->save_api_event_data( $event->get( 'post_id' ), $api_event_id, $api_url, $checkout_url, $currency );
            }

            $wp_images_url  = $e->getProperty( 'X-WP-IMAGES-URL' );
            if ( $wp_images_url && false === ai1ec_is_blank( $wp_images_url[1] ) ) {
                $images_arr = explode( ',', $wp_images_url[1] );
                foreach ( $images_arr as $key => $value ) {
                    $images_arr[ $key ] = explode( ';', $value );
                }
                if ( count( $images_arr ) > 0 ) {
                    update_post_meta( $event->get( 'post_id' ), '_featured_image', $images_arr );
                }
            }

            unset( $events_in_db[$event->get( 'post_id' )] );
        } //close while iteration

        return array(
            'count'            => $count,
            'events_to_delete' => $events_in_db,
            'messages'         => $messages,
            'name'             => $feed_name,
        );
    }

    /**
     * Parse importable feed timezone to sensible value.
     *
     * @param string $def_timezone Timezone value from feed.
     *
     * @return string Valid timezone name to use.
     */
    protected function _get_import_timezone( $def_timezone ) {
        $parser   = $this->_registry->get( 'date.timezone' );
        $timezone = $parser->get_name( $def_timezone );
        if ( false === $timezone ) {
            return 'sys.default';
        }
        return $timezone;
    }

    /**
     * time_array_to_timestamp function
     *
     * Converts time array to time string.
     * Passed array: Array( 'year', 'month', 'day', ['hour', 'min', 'sec', ['tz']] )
     * Return int: UNIX timestamp in GMT
     *
     * @param array       $time            iCalcreator time property array
     *                                     (*full* format expected)
     * @param string      $def_timezone    Default time zone in case not defined
     *                                     in $time
     * @param null|string $forced_timezone Timezone to use instead of UTC.
     *
     * @return int UNIX timestamp
     **/
    protected function _time_array_to_datetime(
        array $time,
        $def_timezone,
        $forced_timezone = null
    ) {
        $timezone = '';
        if ( isset( $time['params']['TZID'] ) ) {
            $timezone    = $time['params']['TZID'];
            $tzid_values = explode( ':', $timezone );
            if ( 2 === count( $tzid_values ) &&
                15 === strlen ( $tzid_values[1] ) ) {
                //the $e->getProperty('DTSTART') or  getProperty('DTEND') for the strings below
                //is not returning the value TZID only with the timezone name
                //DTSTART;TZID=America/Halifax:20160502T180000
                //DTEND;TZID=America/Halifax:20160502T200000
                $timezone    = $tzid_values[0];
                $tzid_values = explode( 'T', $tzid_values[1] );
                if ( 2 === count( $tzid_values ) ) {
                    //01234567 012345
                    //20160607 180000
                    $time['value']['year']  = substr( $tzid_values[0], 0, 4 );
                    $time['value']['month'] = substr( $tzid_values[0], 4, 2 );
                    $time['value']['day']   = substr( $tzid_values[0], 6, 4 );
                    $time['value']['hour']  = substr( $tzid_values[1], 0, 2 );
                    $time['value']['min']   = substr( $tzid_values[1], 2, 2 );
                    $time['value']['sec']   = substr( $tzid_values[1], 4, 2 );
                }
            }
        } elseif (
                isset( $time['value']['tz'] ) &&
                'Z' === $time['value']['tz']
        ) {
            $timezone = 'UTC';
        }
        if ( empty( $timezone ) ) {
            $timezone = $def_timezone;
        }

        $date_time = $this->_registry->get( 'date.time' );

        if ( ! empty( $timezone ) ) {
            $parser   = $this->_registry->get( 'date.timezone' );
            $timezone = $parser->get_name( $timezone );
            if ( false === $timezone ) {
                return false;
            }
            $date_time->set_timezone( $timezone );
        }

        if ( ! isset( $time['value']['hour'] ) ) {
            $time['value']['hour'] = $time['value']['min'] =
                $time['value']['sec'] = 0;
        }

        $date_time->set_date(
            $time['value']['year'],
            $time['value']['month'],
            $time['value']['day']
        )->set_time(
            $time['value']['hour'],
            $time['value']['min'],
            $time['value']['sec']
        );
        if (
            'UTC' === $timezone &&
            null !== $forced_timezone
        ) {
            $date_time->set_timezone( $forced_timezone );
        }
        return $date_time;
    }

    /**
     * Convert an event from a feed into a new Ai1ec_Event object and add it to
     * the calendar.
     *
     * @param Ai1ec_Event $event    Event object.
     * @param vcalendar   $calendar Calendar object.
     * @param bool        $export   States whether events are created for export.
     * @param array       $params   Additional parameters for export.
     *
     * @return void
     */
    protected function _insert_event_in_calendar(
            Ai1ec_Event $event,
            vcalendar $calendar,
            $export = false,
            array $params = array()
    ) {

        $tz  = $this->_registry->get( 'date.timezone' )
            ->get_default_timezone();

        $e   = & $calendar->newComponent( 'vevent' );
        $uid = '';
        if ( $event->get( 'ical_uid' ) ) {
            $uid = addcslashes( $event->get( 'ical_uid' ), "\\;,\n" );
        } else {
            $uid = $event->get_uid();
            $event->set( 'ical_uid', $uid );
            $event->save( true );
        }
        $e->setProperty( 'uid', $this->_sanitize_value( $uid ) );
        $e->setProperty(
            'url',
            get_permalink( $event->get( 'post_id' ) )
        );

        // =========================
        // = Summary & description =
        // =========================
        $e->setProperty(
            'summary',
            $this->_sanitize_value(
                html_entity_decode(
                    apply_filters( 'the_title', $event->get( 'post' )->post_title ),
                    ENT_QUOTES,
                    'UTF-8'
                )
            )
        );

        $content = apply_filters(
            'ai1ec_the_content',
            apply_filters(
                'the_content',
                $event->get( 'post' )->post_content
            )
        );

        $post_meta_values = get_post_meta( $event->get( 'post_id' ), '', false );
        $cost_type        = null;
        if ( $post_meta_values ) {
            foreach ($post_meta_values as $key => $value) {
                if ( '_ai1ec_cost_type' === $key ) {
                    $cost_type    = $value[0];
                }
                if (
                    isset( $params['xml'] ) &&
                    $params['xml'] &&
                    false !== preg_match( '/^x\-meta\-/i', $key )
                ) {
                    $e->setProperty(
                        $key,
                        $this->_sanitize_value( $value )
                    );
                }
             }
        }

        if ( false === ai1ec_is_blank( $cost_type ) ) {
            $e->setProperty(
                'X-COST-TYPE',
                $this->_sanitize_value( $cost_type )
            );
        }

        $url          = '';
        $api          = $this->_registry->get( 'model.api.api-ticketing' );
        $api_event_id = $api->get_api_event_id( $event->get( 'post_id' ) );
        if ( $api_event_id ) {
            //getting all necessary informations that will be necessary on imported ticket events
            $e->setProperty( 'X-API-EVENT-ID'      , $api_event_id );
            $e->setProperty( 'X-API-URL'           , $api->get_api_event_url( $event->get( 'post_id' ) ) );
            $e->setProperty( 'X-CHECKOUT-URL'      , $api->get_api_event_checkout_url( $event->get( 'post_id' ) ) );
            $e->setProperty( 'X-API-EVENT-CURRENCY', $api->get_api_event_currency( $event->get( 'post_id' ) ) );
        } else if ( $event->get( 'ticket_url' ) ) {
            $url = $event->get( 'ticket_url' );
        }

        //Adding Ticket URL to the Description field
        if ( false === ai1ec_is_blank( $url ) ) {
            $content = $this->_remove_ticket_url( $content );
            $content = $content
                     . '<p>' . __( 'Tickets: ', AI1EC_PLUGIN_NAME )
                     . '<a class="ai1ec-ticket-url-exported" href="'
                     . $url . '">' . $url
                     . '</a>.</p>';
        }

        $content = str_replace(']]>', ']]&gt;', $content);
        $content = html_entity_decode( $content, ENT_QUOTES, 'UTF-8' );

        // Prepend featured image if available.
        $size    = null;
        $avatar  = $this->_registry->get( 'view.event.avatar' );

        $images  = null;
        // try to find a featured image
        if ( has_post_thumbnail( $event->get( 'post_id' )  ) ) {

            $post_id = get_post_thumbnail_id( $event->get( 'post_id' ) );
            $added   = null;
            foreach ( array( 'thumbnail', 'medium', 'large', 'full' ) as $_size ) {
                $attributes = wp_get_attachment_image_src( $post_id, $_size );
                if ( false !== $attributes ) {
                    $key_str    = sprintf( '%d_%d', $attributes[1], $attributes[2]);
                    if ( null === $added || false === isset( $added[$key_str] ) ) {
                        $added[$key_str] = true;
                        array_unshift( $attributes, $_size );
                        $images[] = implode( ';', $attributes );
                    }

                }
            }

            if ( $img_url = $avatar->get_post_thumbnail_url( $event, $size ) ) {
                $content = '<div class="ai1ec-event-avatar alignleft timely"><img src="' .
                    esc_attr( $img_url ) . '" width="' . $size[0] . '" height="' .
                    $size[1] . '" /></div>' . $content;
            }
        } else {

            $matches = $avatar->get_image_from_content( $content );

            if ( ! empty( $matches ) ) {

                $patternWidth = '/(width="|width=\')(?P<width>\w+)/i';
                preg_match( $patternWidth, $matches[0], $matchesWidth );

                $patternHeight = '/(height="|height=\')(?P<height>\w+)/i';
                preg_match( $patternHeight, $matches[0], $matchesHeight );

                if ( ! empty( $matchesWidth ) && ! empty( $matchesHeight ) ) {

                    foreach ( array( 'thumbnail', 'medium', 'large', 'full' ) as $_size ) {
                        $attributes = array( $_size, $matches[2], $matchesWidth['width'], $matchesHeight['height'] );
                        $images[] = implode( ';', $attributes );
                    }
                }
            }
        }

        if ( null !== $images ) {
            $e->setProperty(
                'X-WP-IMAGES-URL',
                $this->_sanitize_value(
                    implode( ',', $images )
                )
            );
        }

        if ( isset( $params['no_html'] ) && $params['no_html'] ) {
            $e->setProperty(
                'description',
                $this->_sanitize_value(
                    strip_tags( strip_shortcodes( $content ) )
                )
            );
            if ( ! empty( $content ) ) {
                $html_content = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">\n' .
                    '<HTML>\n<HEAD>\n<TITLE></TITLE>\n</HEAD>\n<BODY>' . $content .
                    '</BODY></HTML>';
                $e->setProperty(
                    'X-ALT-DESC',
                    $this->_sanitize_value( $html_content ),
                    array(
                        'FMTTYPE' => 'text/html',
                    )
                );
                unset( $html_content );
            }
        } else {
            $e->setProperty( 'description', $this->_sanitize_value( $content ) );
        }
        $revision = (int)current(
            array_keys(
                wp_get_post_revisions( $event->get( 'post_id' ) )
            )
        );
        $e->setProperty( 'sequence', $revision );

        // =====================
        // = Start & end times =
        // =====================
        $dtstartstring = '';
        $dtstart = $dtend = array();
        if ( $event->is_allday() ) {
            $dtstart['VALUE'] = $dtend['VALUE'] = 'DATE';
            // For exporting all day events, don't set a timezone
            if ( $tz && ! $export ) {
                $dtstart['TZID'] = $dtend['TZID'] = $tz;
            }

            // For exportin' all day events, only set the date not the time
            if ( $export ) {
                $e->setProperty(
                    'dtstart',
                    $this->_sanitize_value(
                        $event->get( 'start' )->format( 'Ymd' )
                    ),
                    $dtstart
                );
                $e->setProperty(
                    'dtend',
                    $this->_sanitize_value(
                        $event->get( 'end' )->format( 'Ymd' )
                    ),
                    $dtend
                );
            } else {
                $e->setProperty(
                    'dtstart',
                    $this->_sanitize_value(
                        $event->get( 'start' )->format( "Ymd\T" )
                    ),
                    $dtstart
                );
                $e->setProperty(
                    'dtend',
                    $this->_sanitize_value(
                        $event->get( 'end' )->format( "Ymd\T" )
                    ),
                    $dtend
                );
            }
        } else {
            if ( $tz ) {
                $dtstart['TZID'] = $dtend['TZID'] = $tz;
            }
            // This is used later.
            $dtstartstring = $event->get( 'start' )->format( "Ymd\THis" );
            $e->setProperty(
                'dtstart',
                $this->_sanitize_value( $dtstartstring ),
                $dtstart
            );

            if ( false === (bool)$event->get( 'instant_event' ) ) {
                $e->setProperty(
                    'dtend',
                    $this->_sanitize_value(
                        $event->get( 'end' )->format( "Ymd\THis" )
                    ),
                    $dtend
                );
            }
        }

        // ========================
        // = Latitude & longitude =
        // ========================
        if (
            floatval( $event->get( 'latitude' ) ) ||
            floatval( $event->get( 'longitude' ) )
        ) {
            $e->setProperty(
                'geo',
                $event->get( 'latitude' ),
                $event->get( 'longitude' )
            );
        }

        // ===================
        // = Venue & address =
        // ===================
        if ( $event->get( 'venue' ) || $event->get( 'address' ) ) {
            $location = array(
                $event->get( 'venue' ),
                $event->get( 'address' )
            );
            $location = array_filter( $location );
            $location = implode( ' @ ', $location );
            $e->setProperty( 'location', $this->_sanitize_value( $location ) );
        }

        $categories = array();
        $language   = get_bloginfo( 'language' );

        foreach (
            $this->_taxonomy_model->get_post_categories(
                $event->get( 'post_id' )
            )
            as $cat
        ) {
            if ( 'events_categories' === $cat->taxonomy ) {
                $categories[] = $cat->name;
            }
        }
        $e->setProperty(
            'categories',
            implode( ',', $categories ),
            array( "LANGUAGE" => $language )
        );
        $tags = array();
        foreach (
            $this->_taxonomy_model->get_post_tags( $event->get( 'post_id' ) )
            as $tag
        ) {
            $tags[] = $tag->name;
        }
        if( ! empty( $tags) ) {
            $e->setProperty(
                'X-TAGS',
                implode( ',', $tags ),
                array( "LANGUAGE" => $language )
            );
        }
        // ==================
        // = Cost & tickets =
        // ==================
        if ( $event->get( 'cost' ) ) {
            $e->setProperty(
                'X-COST',
                $this->_sanitize_value( $event->get( 'cost' ) )
            );
        }
        if ( $event->get( 'ticket_url' ) ) {
            $e->setProperty(
                'X-TICKETS-URL',
                $this->_sanitize_value(
                    $event->get( 'ticket_url' )
                )
            );
        }
        // =================
        // = Instant Event =
        // =================
        if ( $event->is_instant() ) {
            $e->setProperty(
                'X-INSTANT-EVENT',
                $this->_sanitize_value( $event->is_instant() )
            );
        }

        // ====================================
        // = Contact name, phone, e-mail, URL =
        // ====================================
        $contact = array(
            $event->get( 'contact_name' ),
            $event->get( 'contact_phone' ),
            $event->get( 'contact_email' ),
            $event->get( 'contact_url' ),
        );
        $contact = array_filter( $contact );
        $contact = implode( '; ', $contact );
        $e->setProperty( 'contact', $this->_sanitize_value( $contact ) );

        // ====================
        // = Recurrence rules =
        // ====================
        $rrule = array();
        $recurrence = $event->get( 'recurrence_rules' );
        $recurrence = $this->_filter_rule( $recurrence );
        if ( ! empty( $recurrence ) ) {
            $rules = array();
            foreach ( explode( ';', $recurrence ) as $v) {
                if ( strpos( $v, '=' ) === false ) {
                    continue;
                }

                list( $k, $v ) = explode( '=', $v );
                $k = strtoupper( $k );
                // If $v is a comma-separated list, turn it into array for iCalcreator
                switch ( $k ) {
                    case 'BYSECOND':
                    case 'BYMINUTE':
                    case 'BYHOUR':
                    case 'BYDAY':
                    case 'BYMONTHDAY':
                    case 'BYYEARDAY':
                    case 'BYWEEKNO':
                    case 'BYMONTH':
                    case 'BYSETPOS':
                        $exploded = explode( ',', $v );
                        break;
                    default:
                        $exploded = $v;
                        break;
                }
                // iCalcreator requires a more complex array structure for BYDAY...
                if ( $k == 'BYDAY' ) {
                    $v = array();
                    foreach ( $exploded as $day ) {
                        $v[] = array( 'DAY' => $day );
                    }
                } else {
                    $v = $exploded;
                }
                $rrule[ $k ] = $v;
            }
        }

        // ===================
        // = Exception rules =
        // ===================
        $exceptions = $event->get( 'exception_rules' );
        $exceptions = $this->_filter_rule( $exceptions );
        $exrule = array();
        if ( ! empty( $exceptions ) ) {
            $rules = array();

            foreach ( explode( ';', $exceptions ) as $v) {
                if ( strpos( $v, '=' ) === false ) {
                    continue;
                }

                list($k, $v) = explode( '=', $v );
                $k = strtoupper( $k );
                // If $v is a comma-separated list, turn it into array for iCalcreator
                switch ( $k ) {
                    case 'BYSECOND':
                    case 'BYMINUTE':
                    case 'BYHOUR':
                    case 'BYDAY':
                    case 'BYMONTHDAY':
                    case 'BYYEARDAY':
                    case 'BYWEEKNO':
                    case 'BYMONTH':
                    case 'BYSETPOS':
                        $exploded = explode( ',', $v );
                        break;
                    default:
                        $exploded = $v;
                        break;
                }
                // iCalcreator requires a more complex array structure for BYDAY...
                if ( $k == 'BYDAY' ) {
                    $v = array();
                    foreach ( $exploded as $day ) {
                        $v[] = array( 'DAY' => $day );
                    }
                } else {
                    $v = $exploded;
                }
                $exrule[ $k ] = $v;
            }
        }

        // add rrule to exported calendar
        if ( ! empty( $rrule ) && ! isset( $rrule['RDATE'] ) ) {
            $e->setProperty( 'rrule', $this->_sanitize_value( $rrule ) );
        }
        // add exrule to exported calendar
        if ( ! empty( $exrule ) && ! isset( $exrule['EXDATE'] ) ) {
            $e->setProperty( 'exrule', $this->_sanitize_value( $exrule ) );
        }

        // ===================
        // = Exception dates =
        // ===================
        // For all day events that use a date as DTSTART, date must be supplied
        // For other other events which use DATETIME, we must use that as well
        // We must also match the exact starting time
        $recurrence_dates = $event->get( 'recurrence_dates' );
        $recurrence_dates = $this->_filter_rule( $recurrence_dates );
        if ( ! empty( $recurrence_dates ) ) {
            $params    = array(
                'VALUE' => 'DATE-TIME',
                'TZID'  => $tz,
            );
            $dt_suffix = $event->get( 'start' )->format( '\THis' );
            foreach (
                explode( ',', $recurrence_dates )
                as $exdate
            ) {
                // date-time string in EXDATES is formatted as 'Ymd\THis\Z', that
                // means - in UTC timezone, thus we use `format_to_gmt` here.
                $exdate = $this->_registry->get( 'date.time', $exdate )
                    ->format_to_gmt( 'Ymd' );
                $e->setProperty(
                    'rdate',
                    array( $exdate . $dt_suffix ),
                    $params
                );
            }
        }
        $exception_dates = $event->get( 'exception_dates' );
        $exception_dates = $this->_filter_rule( $exception_dates );
        if ( ! empty( $exception_dates ) ) {
            $params    = array(
                'VALUE' => 'DATE-TIME',
                'TZID'  => $tz,
            );
            $dt_suffix = $event->get( 'start' )->format( '\THis' );
            foreach (
                explode( ',', $exception_dates )
                as $exdate
            ) {
                // date-time string in EXDATES is formatted as 'Ymd\THis\Z', that
                // means - in UTC timezone, thus we use `format_to_gmt` here.
                $exdate = $this->_registry->get( 'date.time', $exdate )
                    ->format_to_gmt( 'Ymd' );
                $e->setProperty(
                    'exdate',
                    array( $exdate . $dt_suffix ),
                    $params
                );
            }
        }
        return $calendar;
    }

    /**
     * _sanitize_value method
     *
     * Convert value, so it be safe to use on ICS feed. Used before passing to
     * iCalcreator methods, for rendering.
     *
     * @param string $value Text to be sanitized
     *
     * @return string Safe value, for use in HTML
     */
    protected function _sanitize_value( $value ) {
        if ( ! is_scalar( $value ) ) {
            return $value;
        }
        $safe_eol = "\n";
        $value    = strtr(
                trim( $value ),
                array(
                    "\r\n" => $safe_eol,
                    "\r"   => $safe_eol,
                    "\n"   => $safe_eol,
                )
        );
        $value = addcslashes( $value, '\\' );
        return $value;
    }

    /**
     * Takes a comma-separated list of tags or categories.
     * If they exist, reuses
     * the existing ones. If not, creates them.
     *
     * The $imported_terms array uses keys to store values rather than values to
     * speed up lookups (using isset() insted of in_array()).
     *
     * @param string  $terms
     * @param array   $imported_terms
     * @param boolean $is_tag
     * @param boolean $use_name
     *
     * @return array
     */
    public function add_categories_and_tags(
        $terms,
        array $imported_terms,
        $is_tag,
        $use_name
    ) {
        $taxonomy       = $is_tag ? 'events_tags' : 'events_categories';
        $categories     = explode( ',', $terms );
        $event_taxonomy = $this->_registry->get( 'model.event.taxonomy' );

        foreach ( $categories as $cat_name ) {
            $cat_name = trim( $cat_name );
            if ( empty( $cat_name ) ) {
                continue;
            }
            $term = $event_taxonomy->initiate_term( $cat_name, $taxonomy, ! $use_name );
            if ( false !== $term ) {
                if ( ! isset( $imported_terms[$term['taxonomy']] ) ) {
                    $imported_terms[$term['taxonomy']] = array();
                }
                $imported_terms[$term['taxonomy']][$term['term_id']] = true;
            }
        }
        return $imported_terms;
    }

    /**
     * Returns modified ical uid for google recurring edited events.
     *
     * @param vevent $e Vevent object.
     *
     * @return string ICAL uid.
     */
    protected function _get_ical_uid( $e ) {
        $ical_uid      = $e->getProperty( 'uid' );
        $recurrence_id = $e->getProperty( 'recurrence-id' );
        if ( false !== $recurrence_id ) {
            $ical_uid = implode( '', array_values( $recurrence_id ) ) . '-' .
                $ical_uid;
        }

        return $ical_uid;
    }

    /**
     * Returns modified exclusions structure for given event.
     *
     * @param vcalendar       $e          Vcalendar event object.
     * @param array           $exclusions Exclusions.
     * @param Ai1ec_Date_Time $start Date time object.
     *
     * @return array Modified exclusions structure.
     */
    protected function _add_recurring_events_exclusions( $e, $exclusions, $start ) {
        $recurrence_id = $e->getProperty( 'recurrence-id' );
        if (
            false === $recurrence_id ||
            ! isset( $recurrence_id['year'] ) ||
            ! isset( $recurrence_id['month'] ) ||
            ! isset( $recurrence_id['day'] )
        ) {
            return $exclusions;
        }
        $year = $month = $day = $hour = $min = $sec = null;
        extract( $recurrence_id, EXTR_IF_EXISTS );
        $timezone = '';
        $exdate   = sprintf( '%04d%02d%02d', $year, $month, $day );
        if (
            null === $hour ||
            null === $min ||
            null === $sec
        ) {
            $hour = $min = $sec = '00';
            $timezone = 'Z';
        }
        $exdate .= sprintf(
            'T%02d%02d%02d%s',
            $hour,
            $min,
            $sec,
            $timezone
        );
        $exclusions[$e->getProperty( 'uid' )][] = $exdate;
        return $exclusions;
    }

    /**
     * Filter recurrence / exclusion rule or dates. Avoid throwing exception for old, malformed values.
     *
     * @param string $rule Rule or dates value.
     *
     * @return string Fixed rule or dates value.
     */
    protected function _filter_rule( $rule ) {
        if ( null === $this->_rule_filter ) {
            $this->_rule_filter = $this->_registry->get( 'recurrence.rule' );
        }
        return $this->_rule_filter->filter_rule( $rule );
    }

    /**
     * Remove the Ticket URL that maybe exists inside the field Description of the Event
     */
    protected function _remove_ticket_url( $description ) {
        return preg_replace( '/<p>[^<>]+<a[^<>]+class=[\'"]?ai1ec-ticket-url-exported[\'"]?[^<>]+>.[^<>]+<\/a>[\.\s]*<\/p>/'
                , ''
                , $description );
    }

}
