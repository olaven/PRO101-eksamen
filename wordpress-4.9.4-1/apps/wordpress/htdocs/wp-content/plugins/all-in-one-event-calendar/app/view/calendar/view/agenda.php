<?php

/**
 * The concrete class for agenda view.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_Calendar_View_Agenda extends Ai1ec_Calendar_View_Abstract {

    /* (non-PHPdoc)
     * @see Ai1ec_Calendar_View_Abstract::get_name()
    */
    public function get_name() {
        return 'agenda';
    }

    /* (non-PHPdoc)
     * @see Ai1ec_Calendar_View_Abstract::get_content()
    */
    public function get_content( array $view_args ) {

        $type = $this->get_name();
        $time = $this->_registry->get( 'date.system' );
        // Get localized time
        $timestamp = $time->current_time();

        // Get events, then classify into date array
        $per_page_setting = $type . '_events_per_page';
        $search           = $this->_registry->get( 'model.search' );
        $settings         = $this->_registry->get( 'model.settings' );
        $events_limit     = is_numeric( $view_args['events_limit'] )
            ? $view_args['events_limit']
            : $settings->get( $per_page_setting );
        $events_limit = apply_filters(
            'ai1ec_events_limit',
            $events_limit
        );
        $relative_to_reference = in_array( $this->get_name(), array( 'agenda', 'posterboard', 'stream' ) );
        if ( $relative_to_reference ) {
            $results = $search->get_events_relative_to_reference(
                $view_args['time_limit'],
                $events_limit,
                $view_args['page_offset'],
                apply_filters(
                    'ai1ec_get_events_relative_to_filter',
                    array(
                        'post_ids'     => $view_args['post_ids'],
                        'auth_ids'     => $view_args['auth_ids'],
                        'cat_ids'      => $view_args['cat_ids'],
                        'tag_ids'      => $view_args['tag_ids'],
                        'instance_ids' => $view_args['instance_ids'],
                    ),
                    $view_args
                    ),
                apply_filters(
                    'ai1ec_show_unique_events',
                    false
                    )
                );
        } else {
            $results = $search->get_events_relative_to(
                $timestamp,
                $events_limit,
                $view_args['page_offset'],
                apply_filters(
                    'ai1ec_get_events_relative_to_filter',
                    array(
                        'post_ids'     => $view_args['post_ids'],
                        'auth_ids'     => $view_args['auth_ids'],
                        'cat_ids'      => $view_args['cat_ids'],
                        'tag_ids'      => $view_args['tag_ids'],
                        'instance_ids' => $view_args['instance_ids'],
                    ),
                    $view_args
                ),
                $view_args['time_limit'],
                apply_filters(
                    'ai1ec_show_unique_events',
                    false
                )
            );
        }
        $this->_update_meta( $results['events'] );
        $dates = $this->get_agenda_like_date_array(
            $results['events'],
            $view_args['request']
        );


        // Generate title of view based on date range month & year.
        $range_start       = $results['date_first'] &&
                                false === $results['date_first']->is_empty() ?
                                    $results['date_first'] :
                                    $this->_registry->get( 'date.time', $timestamp );
        $range_end         = $results['date_last'] &&
                                false === $results['date_last']->is_empty() ?
                                    $results['date_last'] :
                                    $this->_registry->get( 'date.time', $timestamp );
        $range_start       = $this->_registry->get( 'date.time', $range_start );
        $range_end         = $this->_registry->get( 'date.time', $range_end );
        $start_year        = $range_start->format_i18n( 'Y' );
        $end_year          = $range_end->format_i18n( 'Y' );
        $start_month       = $range_start->format_i18n( 'F' );
        $start_month_short = $range_start->format_i18n( 'M' );
        $end_month         = $range_end->format_i18n( 'F' );
        $end_month_short   = $range_end->format_i18n( 'M' );
        if ( $start_year === $end_year && $start_month === $end_month ) {
            $title = "$start_month $start_year";
            $title_short = "$start_month_short $start_year";
        } elseif ( $start_year === $end_year ) {
            $title = "$start_month – $end_month $end_year";
            $title_short = "$start_month_short – $end_month_short $end_year";
        } else {
            $title = "$start_month $start_year – $end_month $end_year";
            $title_short = "$start_month_short $start_year – $end_month_short $end_year";
        }

        // Create navigation bar if requested.
        $navigation       = '';
        $loader           = $this->_registry->get( 'theme.loader' );
        $pagination_links = '';
        if ( ! $view_args['no_navigation'] ) {

            if ( $relative_to_reference ) {
                $pagination_links = $this->_get_pagination_links(
                    $view_args,
                    $results['prev'],
                    $results['next'],
                    $results['date_first'],
                    $results['date_last'],
                    $title,
                    $title_short,
                    $view_args['page_offset'] + -1,
                    $view_args['page_offset'] + 1
                    );
            } else {
                $pagination_links = $this->_get_agenda_like_pagination_links(
                    $view_args,
                    $results['prev'],
                    $results['next'],
                    $results['date_first'],
                    $results['date_last'],
                    $title,
                    $title_short,
                    null === $view_args['time_limit'] ||
                                0 === $view_args['time_limit'] ?
                                    $timestamp :
                                    $view_args['time_limit']
                );
            }

            $pagination_links = $loader->get_file(
                'pagination.twig',
                array(
                    'links'      => $pagination_links,
                    'data_type'  => $view_args['data_type'],
                ),
                false
            )->get_content();

            // Get HTML for navigation bar.
            $nav_args = array(
                'no_navigation'    => $view_args['no_navigation'],
                'pagination_links' => $pagination_links,
                'views_dropdown'   => $view_args['views_dropdown'],
                'below_toolbar'    => apply_filters(
                    'ai1ec_below_toolbar',
                    '',
                    $type,
                    $view_args
                ),
            );
            // Add extra buttons to Agenda view's nav bar if events were returned.
            if ( $type === 'agenda' && $dates ) {
                $button_args = array(
                    'text_collapse_all' => __( 'Collapse All', AI1EC_PLUGIN_NAME ),
                    'text_expand_all'   => __( 'Expand All', AI1EC_PLUGIN_NAME ),
                );
                $nav_args['after_pagination'] = $loader
                    ->get_file( 'agenda-buttons.twig', $button_args, false )
                    ->get_content();
            }
            $navigation = $this->_get_navigation( $nav_args );
        }

        $is_ticket_button_enabled = apply_filters( 'ai1ec_' . $type . '_ticket_button', false );
        $args = array(
            'title'                     => $title,
            'dates'                     => $dates,
            'type'                      => $type,
            'show_year_in_agenda_dates' => $settings->get( 'show_year_in_agenda_dates' ),
            'expanded'                  => $settings->get( 'agenda_events_expanded' ),
            'show_location_in_title'    => $settings->get( 'show_location_in_title' ),
            'page_offset'               => $view_args['page_offset'],
            'navigation'                => $navigation,
            'pagination_links'          => $pagination_links,
            'post_ids'                  => join( ',', $view_args['post_ids'] ),
            'data_type'                 => $view_args['data_type'],
            'is_ticket_button_enabled'  => $is_ticket_button_enabled,
            'text_upcoming_events'      => __( 'There are no upcoming events to display at this time.', AI1EC_PLUGIN_NAME ),
            'text_edit'                 => __( 'Edit', AI1EC_PLUGIN_NAME ),
            'text_read_more'            => __( 'Read more', AI1EC_PLUGIN_NAME ),
            'text_categories'           => __( 'Categories:', AI1EC_PLUGIN_NAME ),
            'text_tags'                 => __( 'Tags:', AI1EC_PLUGIN_NAME ),
            'text_venue_separator'      => __( '@ %s', AI1EC_PLUGIN_NAME ),
        );

        // Allow child views to modify arguments passed to template.
        $args = $this->get_extra_template_arguments( $args );

        return
            $this->_registry->get( 'http.request' )->is_json_required(
                $view_args['request_format'], $type
            )
            ? $loader->apply_filters_to_args( $args, $type . '.twig', false )
            : $this->_get_view( $args );
    }

    /* (non-PHPdoc)
     * @see Ai1ec_Calendar_View_Abstract::get_extra_arguments()
     */
    public function get_extra_arguments( array $view_args, $exact_date ) {
        $view_args += $this->_request->get_dict( array(
            'page_offset',
            'time_limit',
        ) );
        if( false !== $exact_date ) {
            $view_args['time_limit'] = $exact_date;
        }
        return $view_args;
    }

    /**
     * Breaks down the given ordered array of event objects into dates, and
     * outputs an ordered array of two-element associative arrays in the
     * following format:
     *    key: localized UNIX timestamp of date
     *    value:
     *        ['events'] => two-element associatative array broken down thus:
     *            ['allday'] => all-day events occurring on this day
     *            ['notallday'] => all other events occurring on this day
     *        ['today'] => whether or not this date is today
     *
     * @param array                     $events Event results
     * @param Ai1ec_Abstract_Query|null $query  Current calendar page request, if
     *                                          any (null for widget)
     *
     * @return array
     */
    public function get_agenda_like_date_array(
        $events,
        Ai1ec_Abstract_Query $query = null
    ) {
        $dates    = array();
        $time     = $this->_registry->get( 'date.system' );
        $settings = $this->_registry->get( 'model.settings' );
        $this->_registry->get( 'controller.content-filter' )
            ->clear_the_content_filters();
        // Classify each event into a date/allday category
        foreach ( $events as $event ) {
            $start_time    = $this->_registry
                ->get(
                    'date.time',
                    $event->get( 'start' )->format( 'Y-m-d\T00:00:00' ),
                    'sys.default'
                );
            $exact_date    = $time->format_datetime_for_url(
                $start_time,
                $settings->get( 'input_date_format' )
            );
            $href_for_date = $this->_create_link_for_day_view( $exact_date );
            // timestamp is used to have correctly sorted array as UNIX
            // timestamp never goes in decreasing order for increasing dates.
            $timestamp     = $start_time->format();
            // Ensure all-day & non all-day categories are created in correct
            // order: "allday" preceding "notallday".
            if ( ! isset( $dates[$timestamp]['events'] ) ) {
                $dates[$timestamp]['events'] = array(
                    'allday'    => array(),
                    'notallday' => array(),
                );
            }
            $this->_add_runtime_properties( $event );
            // Add the event.
            $category                           = $event->is_allday()
                ? 'allday'
                : 'notallday';
            $event_props                        = array();
            $event_props['post_id']             = $event->get( 'post_id' );
            $event_props['instance_id']         = $event->get( 'instance_id' );
            $event_props['venue']               = $event->get( 'venue' );
            $event_props['ticket_url']          = $event->get( 'ticket_url' );
            $event_props['filtered_title']      = $event->get_runtime( 'filtered_title' );
            $event_props['edit_post_link']      = $event->get_runtime( 'edit_post_link' );
            $event_props['content_img_url']     = $event->get_runtime( 'content_img_url' );
            $event_props['filtered_content']    = $event->get_runtime( 'filtered_content' );
            $event_props['ticket_url_label']    = $event->get_runtime( 'ticket_url_label' );
            $event_props['permalink']           = $event->get_runtime( 'instance_permalink' );
            $event_props['categories_html']     = $event->get_runtime( 'categories_html' );
            $event_props['category_bg_color']   = $event->get_runtime( 'category_bg_color' );
            $event_props['category_text_color'] = $event->get_runtime( 'category_text_color' );
            $event_props['tags_html']           = $event->get_runtime( 'tags_html' );
            $event_props['post_excerpt']        = $event->get_runtime( 'post_excerpt' );
            $event_props['short_start_time']    = $event->get_runtime( 'short_start_time' );
            $event_props['is_allday']           = $event->is_allday();
            $event_props['is_multiday']         = $event->is_multiday();
            $event_props['enddate_info']        = $event->getenddate_info();
            $event_props['timespan_short']      = $event->_registry->
                get( 'view.event.time' )->get_timespan_html( $event, 'short' );
            $event_props['avatar']              = $event->getavatar();
            $event_props['avatar_not_wrapped']  = $event->getavatar( false );
            $event_props['avatar_url']  = $this->_registry
                ->get( 'view.event.avatar' )->get_event_avatar_url( $event );
            $event_props['category_divider_color'] = $event->get_runtime(
                'category_divider_color'
            );

            $meta = $this->_registry->get( 'model.meta-post' );
            if ( ! $event_props['ticket_url'] ) {
                $timely_tickets = $meta->get(
                    $event->get( 'post_id' ),
                    '_ai1ec_timely_tickets_url',
                    null
                );
                if ( $timely_tickets ) {
                    $event_props['ticket_url'] = $timely_tickets;
                    $event->set( 'ticket_url', $event_props['ticket_url'] );
                }
            }
            if (
                true === apply_filters(
                    'ai1ec_buy_button_product',
                    false
                )
            ) {
                $full_details = $meta->get(
                    $event->get( 'post_id' ),
                    '_ai1ec_ep_product_details',
                    null
                );
                if (
                    is_array( $full_details ) &&
                    isset( $full_details['show_buy_button'] ) &&
                    true === $full_details['show_buy_button']
                    && $event_props['ticket_url']
                ) {
                    // Tickets button is shown by default in this case.
                } else {
                    // Otherwise not.
                    $event_props['ticket_url'] = false;
                }
                $event->set( 'ticket_url', $event_props['ticket_url'] );
            }

            $event_object = $event_props;
            if (
                $this->_compatibility->use_backward_compatibility()
            ) {
                $event_object = $event;
            }

            $months   = apply_filters( 'ai1ec_i18n_months', array() );
            $weekdays = apply_filters( 'ai1ec_i18n_weekdays', array() );

            $dates[$timestamp]['events'][$category][] = $event_object;
            $dates[$timestamp]['href']                = $href_for_date;
            $dates[$timestamp]['day']                 = $this->_registry->
                get( 'date.time', $timestamp )->format_i18n( 'j' );

            $w                                        = $this->
                _registry->get( 'date.time', $timestamp )->format_i18n( 'D' );
            $dates[$timestamp]['weekday']             = array_key_exists( $w, $weekdays ) ? $weekdays[$w] : $w;

            $m                                        = $this->
                _registry->get( 'date.time', $timestamp )->format_i18n( 'M' );
            $dates[$timestamp]['month']               = array_key_exists( $m, $months ) ? $months[$m] : $m;

            $this->_registry->
                get( 'date.time', $timestamp )->format_i18n( 'M' );

            $dates[$timestamp]['full_month']          = $this->_registry->
                get( 'date.time', $timestamp )->format_i18n( 'F' );
            $dates[$timestamp]['full_weekday']        = $this->_registry->
                get( 'date.time', $timestamp )->format_i18n( 'l' );
            $dates[$timestamp]['year']                = $this->_registry->
                get( 'date.time', $timestamp )->format_i18n( 'Y' );
        }
        $this->_registry->get( 'controller.content-filter' )
            ->restore_the_content_filters();
        // Flag today
        $today = $this->_registry->get( 'date.time', 'now', 'sys.default' )
            ->set_time( 0, 0, 0 )
            ->format();
        if ( isset( $dates[$today] ) ) {
            $dates[$today]['today'] = true;
        }
        return $dates;
    }

    /**
     * Returns an associative array of two links for any agenda-like view of the
     * calendar:
     *    previous page (if previous events exist),
     *    next page (if next events exist).
     * Each element is an associative array containing the link's enabled status
     * ['enabled'], CSS class ['class'], text ['text'] and value to assign to
     * link's href ['href'].
     *
     * @param array $args Current request arguments
     *
     * @param bool     $prev         Whether there are more events before
     *                               the current page
     * @param bool     $next         Whether there are more events after
     *                               the current page
     * @param Ai1ec_Date_Time|null $date_first
     * @param Ai1ec_Date_Time|null $date_last
     * @param string   $title        Title to display in datepicker button
     * @param string   $title_short  Short month names.
     * @param int|null $default_time_limit  The default time limit in the case of pagination ends.
     * @return array      Array of links
     */
    protected function _get_agenda_like_pagination_links(
        $args,
        $prev               = false,
        $next               = false,
        $date_first         = null,
        $date_last          = null,
        $title              = '',
        $title_short        = '',
        $default_time_limit = 0
    ) {
        $links = array();

        if (
            $this->_registry->get(
                'model.settings'
            )->get( 'ai1ec_use_frontend_rendering' )
        ) {
            $args['request_format'] = 'json';
        }
        $args['page_offset'] = -1;
        if ( null === $date_first || $date_first->is_empty() ) {
            $args['time_limit'] = $default_time_limit;
        } else {
            $args['time_limit'] = $this->_registry
                ->get( 'date.time', $date_first )->set_time(
                    $date_first->format( 'H' ),
                    $date_first->format( 'i' ),
                    $date_first->format( 's' ) - 1
                )->format_to_gmt();
        }
        $href = $this->_registry->get(
            'html.element.href',
            $args
        );
        $links[] = array(
            'class'   => 'ai1ec-prev-page',
            'text'    => '<i class="ai1ec-fa ai1ec-fa-chevron-left"></i>',
            'href'    => $href->generate_href(),
            'enabled' => $prev,
        );

        // Minical datepicker.
        $factory = $this->_registry->get( 'factory.html' );
        $links[] = $factory->create_datepicker_link(
            $args,
            $date_first->format_to_gmt(),
            $title,
            $title_short
        );

        $args['page_offset'] = 1;
        if ( null === $date_last || $date_last->is_empty() ) {
            $args['time_limit'] = $default_time_limit;
        } else {
            $args['time_limit'] = $this->_registry
                ->get( 'date.time', $date_last )->set_time(
                    $date_last->format( 'H' ),
                    $date_last->format( 'i' ),
                    $date_last->format( 's' ) + 1
                )->format_to_gmt();
        }
        $href = $this->_registry->get(
            'html.element.href',
            $args
        );
        $links[] = array(
            'class'   => 'ai1ec-next-page',
            'text'    => '<i class="ai1ec-fa ai1ec-fa-chevron-right"></i>',
            'href'    => $href->generate_href(),
            'enabled' => $next,
        );

        return $links;
    }

    /**
     * Returns an associative array of two links for any agenda-like view of the
     * calendar:
     *    previous page (if previous events exist),
     *    next page (if next events exist).
     * Each element is an associative array containing the link's enabled status
     * ['enabled'], CSS class ['class'], text ['text'] and value to assign to
     * link's href ['href'].
     *
     * @param array $args Current request arguments
     *
     * @param bool     $prev         Whether there are more events before
     *                               the current page
     * @param bool     $next         Whether there are more events after
     *                               the current page
     * @param Ai1ec_Date_Time|null $date_first
     * @param Ai1ec_Date_Time|null $date_last
     * @param string   $title        Title to display in datepicker button
     * @param string   $title_short  Short month names.
     * @param int|null $default_time_limit  The default time limit in the case of pagination ends.
     * @return array      Array of links
     */
    protected function _get_pagination_links(
        $args,
        $prev = false,
        $next = false,
        $date_first = null,
        $date_last = null,
        $title = '',
        $title_short = '',
        $prev_offset = -1,
        $next_offset = 1) {

        $links = array();

        if ( $this->_registry->get( 'model.settings' )->get( 'ai1ec_use_frontend_rendering' ) ) {
            $args['request_format'] = 'json';
        }
        $args['page_offset'] = $prev_offset;

        $href = $this->_registry->get( 'html.element.href', $args );
        $links[] = array(
            'class' => 'ai1ec-prev-page',
            'text' => '<i class="ai1ec-fa ai1ec-fa-chevron-left"></i>',
            'href' => $href->generate_href(),
            'enabled' => $prev );

        // Minical datepicker.
        $factory = $this->_registry->get( 'factory.html' );
        $links[] = $factory->create_datepicker_link( $args, $date_first->format_to_gmt(), $title, $title_short );

        $args['page_offset'] = $next_offset;
        $href = $this->_registry->get( 'html.element.href', $args );
        $links[] = array(
            'class' => 'ai1ec-next-page',
            'text' => '<i class="ai1ec-fa ai1ec-fa-chevron-right"></i>',
            'href' => $href->generate_href(),
            'enabled' => $next );

        return $links;
    }

    /* (non-PHPdoc)
     * @see Ai1ec_Calendar_View_Abstract::_add_view_specific_runtime_properties()
    */
    protected function _add_view_specific_runtime_properties( Ai1ec_Event $event ) {
        $taxonomy = $this->_registry->get( 'view.event.taxonomy' );
        $avatar   = $this->_registry->get( 'view.event.avatar' );
        $event->set_runtime(
            'categories_html',
            $taxonomy->get_categories_html( $event )
        );
        $event->set_runtime(
            'tags_html',
            $taxonomy->get_tags_html( $event )
        );
        $event->set_runtime(
            'content_img_url',
            $avatar->get_content_img_url( $event )
        );
    }
}
