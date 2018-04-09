<?php

/**
 * Class for Timely API communication related to Discover Events and Feeds.
 *
 * @author     Time.ly Network, Inc.
 * @since      2.4
 * @package    Ai1EC
 * @subpackage Ai1EC.Model
 */
class Ai1ec_Api_Feeds extends Ai1ec_Api_Abstract {

    // Feed status
    // c = Feed not migrated yet to API
    // a = Feed migrated to API (all events)
    // b = Feed migrated to API (individual events were selected)
    public static $FEED_NOT_MIGRATED_CODE    = 'c';
    public static $FEED_API_ALL_EVENTS_CODE  = 'a';
    public static $FEED_API_SOME_EVENTS_CODE = 'b';

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
     * Get static var (for PHP 5.2 compatibility)
     *
     * @param String $var
     */
    public function getStaticVar($var) {
        return self::$$var;
    }

    /**
     * Getting a suggested events list.
     * @return stClass Response using the following format:
     * [total] => 10
     * [per_page] => 8
     * [current_page] => 1
     * [last_page] => 2
     * [next_page_url] =>
     * [prev_page_url] =>
     * [from] => 1
     * [to] => 8
     * [data] => Array list of suggested events
     */
    public function get_suggested_events() {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            throw new Exception( 'Calendar ID not found' );
        }

        $body = null;
        if (
            isset( $_POST[ 'lat' ] ) &&
            isset( $_POST[ 'lng' ] ) &&
            isset( $_POST[ 'radius' ] )
        ) {
            $body = array(
                'lat'    => $_POST[ 'lat' ],
                'lng'    => $_POST[ 'lng' ],
                'radius' => $_POST[ 'radius' ]
            );
        }

        $page     = isset( $_POST[ 'page' ] ) ? $_POST[ 'page' ] : 1;
        $max      = isset( $_POST[ 'max' ] ) ? $_POST[ 'max' ] : 8;
        $term     = isset( $_POST[ 'term' ] ) && $_POST[ 'term' ]
            ? urlencode( $_POST[ 'term' ] )
            : '*';
        $location = isset( $_POST[ 'location' ] ) && $_POST[ 'location' ]
            ? '&location=' . urlencode( $_POST[ 'location' ] )
            : '';

        $url      = AI1EC_API_URL .
            "calendars/$calendar_id/discover/events?page=$page&max=$max&term=$term" .
            $location;

        $response = $this->request_api( 'GET', $url,
            $body,
            true //decode body response
        );

        if ( $this->is_response_success( $response ) ) {
            return $response->body;
        }  else {
            $this->save_error_notification(
                $response,
                __( 'We were unable to get the Suggested Events from Time.ly Network', AI1EC_PLUGIN_NAME )
            );
            throw new Exception( 'We were unable to get the Suggested Events from Time.ly Network' );
        }
    }

    /**
     * Call the API to Process and Import the Feed
     */
    public function import_feed( $entry ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            throw new Exception( 'Calendar ID not found' );
        }
        $response = $this->request_api( 'POST', AI1EC_API_URL . 'calendars/' . $calendar_id . '/feeds/import',
            array(
                'url'                           => $entry['feed_url'],
                'categories'                    => $entry['feed_category'],
                'tags'                          => $entry['feed_tags'],
                'allow_comments'                => $entry['comments_enabled'],
                'show_maps'                     => $entry['map_display_enabled'],
                'import_any_tag_and_categories' => $entry['keep_tags_categories'],
                'preserve_imported_events'      => $entry['keep_old_events'],
                'assign_default_utc'            => $entry['import_timezone']
            )
        );

        if ( $this->is_response_success( $response ) ) {
            // Refresh list of subscriptions and limits
            $this->get_subscriptions( true );

            return $response->body;
        } else {
            $this->save_error_notification(
                $response,
                __( 'We were unable to import feed', AI1EC_PLUGIN_NAME )
            );
            throw new Exception( $this->get_api_error_msg( $response->raw ) );
        }
    }

    /**
     * Call the API to get the feed
     */
    public function get_feed( $feed_id ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            throw new Exception( 'Calendar ID not found' );
        }
        $response = $this->request_api( 'GET', AI1EC_API_URL . 'calendars/' . $calendar_id . '/feeds/get/' . $feed_id,
            array( 'max' => '9999' )
        );

        if ( $this->is_response_success( $response ) ) {
            return $response->body;
        } else {
            $this->save_error_notification(
                $response,
                __( 'We were unable to get feed data', AI1EC_PLUGIN_NAME )
            );
            throw new Exception( $this->get_api_error_msg( $response->raw ) );
        }
    }

    /**
     * Call the API to get list of feed subscriptions
     */
    public function get_feed_subscriptions( $force_refresh = false ) {
        $feeds_subscriptions = get_transient( 'ai1ec_api_feeds_subscriptions' );

        if ( $force_refresh || false === $feeds_subscriptions ) {
            $response = $this->request_api( 'GET', AI1EC_API_URL . 'calendars/' . $this->_get_ticket_calendar() . '/feeds/list',
                null,
                true
            );

            if ( $this->is_response_success( $response ) ) {
                $feeds_subscriptions = (array) $response->body;
            } else {
                $feeds_subscriptions = array();
            }

            // Save for 5 minutes
            $minutes = 5;
            set_transient( 'ai1ec_api_feeds_subscriptions', $feeds_subscriptions, $minutes * 60 );
        }

        return $feeds_subscriptions;
    }

    /**
     * Sync feed subscriptions
     */
    public function get_and_sync_feed_subscriptions() {
        $feeds_subscriptions = $this->get_feed_subscriptions();

        $db = $this->_registry->get( 'dbi.dbi' );
        $table_name = $db->get_table_name( 'ai1ec_event_feeds' );

        // Select all feeds
        $rows = $db->select(
            $table_name,
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

        // Iterate over API response
        foreach( $feeds_subscriptions as $api_feed ) {
            $found           = false;

            foreach ( $rows as $row ) {
                // Check if URL is the same
                if ( trim( $row->feed_url ) === trim( $api_feed->url ) ) {
                    $found = true;

                    // Update feed
                    $db->update(
                        $table_name,
                        array(
                            'comments_enabled'     => $api_feed->allow_comments,
                            'map_display_enabled'  => $api_feed->show_maps,
                            'keep_tags_categories' => $api_feed->import_any_tag_and_categories,
                            'keep_old_events'      => $api_feed->preserve_imported_events,
                            'import_timezone'      => $api_feed->assign_default_utc,
                            'feed_name'            => $api_feed->feed_id
                        ),
                        array(
                            'feed_id'              => $row->feed_id
                        )
                    );
                }
            }

            // Not found in local database.. Insert
            if ( ! $found ) {
                $entry = array(
                    'feed_url'             => $api_feed->url,
                    'feed_name'            => $api_feed->feed_id,
                    'feed_category'        => $api_feed->categories,
                    'feed_tags'            => $api_feed->tags,
                    'comments_enabled'     => $api_feed->allow_comments,
                    'map_display_enabled'  => $api_feed->show_maps,
                    'keep_tags_categories' => $api_feed->import_any_tag_and_categories,
                    'keep_old_events'      => $api_feed->preserve_imported_events,
                    'import_timezone'      => $api_feed->assign_default_utc
                );
                $format = array( '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d' );
                $db->insert(
                    $table_name,
                    $entry,
                $format
                );
            }
        }
    }

    /**
     * Call the API to subscribe feed
     */
    public function subscribe_feed( $feed_id, $feed_event_uid = '' ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            throw new Exception( 'Calendar ID not found' );
        }

        $response = $this->request_api( 'POST', AI1EC_API_URL . 'calendars/' . $calendar_id . '/feeds/subscribe',
            array(
                'feed_id'        => $feed_id,
                'feed_event_uid' => $feed_event_uid
            )
        );

        // Refresh list of subscriptions and limits
        $this->get_subscriptions( true );

        if ( $this->is_response_success( $response ) ) {
            return $response->body;
        } else {
            $this->save_error_notification(
                $response,
                __( 'We were unable to subscribe feed', AI1EC_PLUGIN_NAME )
            );
            throw new Exception( $this->get_api_error_msg( $response->raw ) );
        }
    }

    /**
     * Call the API to unsubscribe feed
     */
    public function unsubscribe_feed( $feed_id, $feed_event_uid = '' ) {
        $calendar_id = $this->_get_ticket_calendar();
        if ( 0 >= $calendar_id ) {
            throw new Exception( 'Calendar ID not found' );
        }

        $response = $this->request_api( 'POST', AI1EC_API_URL . 'calendars/' . $calendar_id . '/feeds/unsubscribe',
            array(
                'feed_id'        => $feed_id,
                'feed_event_uid' => $feed_event_uid
            )
        );

        // Refresh list of subscriptions and limits
        $this->get_subscriptions( true );

        if ( $this->is_response_success( $response ) ) {
            return $response->body;
        } else {
            $this->save_error_notification(
                $response,
                __( 'We were unable to unsubscribe feed', AI1EC_PLUGIN_NAME )
            );
            throw new Exception( $this->get_api_error_msg( $response->raw ) );
        }
    }
}
