<?php

/**
 * This class renders the html for the single event page.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.View.Event
 */
class Ai1ec_View_Event_Single extends Ai1ec_Base {

    /**
     * Renders the html of the page and returns it.
     *
     * @param Ai1ec_Event $event
     *
     * @return string the html of the page
     */
    public function get_content( Ai1ec_Event $event ) {
        $settings = $this->_registry->get( 'model.settings' );
        $rrule    = $this->_registry->get( 'recurrence.rule' );
        $taxonomy = $this->_registry->get( 'view.event.taxonomy' );
        $location = $this->_registry->get( 'view.event.location' );
        $ticket   = $this->_registry->get( 'view.event.ticket' );
        $content  = $this->_registry->get( 'view.event.content' );
        $time     = $this->_registry->get( 'view.event.time' );

        $subscribe_url = AI1EC_EXPORT_URL . '&ai1ec_post_ids=' .
            $event->get( 'post_id' );

        $event->set_runtime(
            'tickets_url_label',
            $ticket->get_tickets_url_label( $event, false )
        );
        $event->set_runtime(
            'content_img_url',
            $content->get_content_img_url( $event )
        );

        $extra_buttons = apply_filters(
            'ai1ec_rendering_single_event_actions',
            '',
            $event
        );

        $venues_html = apply_filters(
            'ai1ec_rendering_single_event_venues',
            nl2br( $location->get_location( $event ) ),
            $event
        );
        $default_tz = $this->_registry->get( 'date.timezone' )->get_default_timezone();
        $timezone_info = array(
            'show_timezone'       => $this->_registry->get( 'model.settings' )->get( 'always_use_calendar_timezone' ),
            'using_calendar_tz'   => $this->_registry->get( 'model.settings' )->get( 'always_use_calendar_timezone' ),
            'event_timezone'      => str_replace( '_', ' ', $event->get( 'timezone_name' ) ) . ' ' . __( 'Timezone', AI1EC_PLUGIN_NAME ),
            'calendar_timezone'   => str_replace( '_', ' ', $default_tz ) . ' ' . __( 'Timezone', AI1EC_PLUGIN_NAME ),
        );

        $banner_image_meta = get_post_meta( $event->get( 'post_id' ), 'ai1ec_banner_image' );
        $banner_image = $banner_image_meta ? $banner_image_meta[0] : '';

        // objects are passed by reference so an action is ok
        do_action( 'ai1ec_single_event_page_before_render', $event );

        $filter_groups_html = apply_filters( 'ai1ec_get_filter_groups_html', $event );

        $args = array(
            'event'                   => $event,
            'recurrence'              => $rrule->rrule_to_text( $event->get( 'recurrence_rules' ) ),
            'exclude'                 => $time->get_exclude_html( $event, $rrule ),
            'categories'              => $taxonomy->get_categories_html( $event ),
            'tags'                    => $taxonomy->get_tags_html( $event ),
            'location'                => html_entity_decode( $venues_html ),
            'filter_groups'           => $filter_groups_html,
            'map'                     => $location->get_map_view( $event ),
            'contact'                 => $ticket->get_contact_html( $event ),
            'back_to_calendar'        => $content->get_back_to_calendar_button_html(),
            'subscribe_url'           => $subscribe_url,
            'subscribe_url_no_html'   => $subscribe_url . '&no_html=true',
            'edit_instance_url'       => null,
            'edit_instance_text'      => null,
            'google_url'              => 'https://www.google.com/calendar/render?cid=' . urlencode( $subscribe_url ),
            'show_subscribe_buttons'  => ! $settings->get( 'turn_off_subscription_buttons' ),
            'hide_featured_image'     => $settings->get( 'hide_featured_image' ),
            'extra_buttons'           => $extra_buttons,
            'show_get_calendar'       => ! $settings->get( 'disable_get_calendar_button' ),
            'text_add_calendar'       => __( 'Add to Calendar', AI1EC_PLUGIN_NAME ),
            'subscribe_buttons_text'  => $this->_registry
                ->get( 'view.calendar.subscribe-button' )
                ->get_labels(),
            'text_get_calendar'       => Ai1ec_I18n::__( 'Get a Timely Calendar' ),
            'text_when'               => __( 'When:', AI1EC_PLUGIN_NAME ),
            'text_where'              => __( 'Where:', AI1EC_PLUGIN_NAME ),
            'text_cost'               => __( 'Cost:', AI1EC_PLUGIN_NAME ),
            'text_contact'            => __( 'Contact:', AI1EC_PLUGIN_NAME ),
            'text_tickets'            => __( 'Tickets:', AI1EC_PLUGIN_NAME ),
            'text_free'               => __( 'Free', AI1EC_PLUGIN_NAME ),
            'text_categories'         => __( 'Categories', AI1EC_PLUGIN_NAME ),
            'text_tags'               => __( 'Tags', AI1EC_PLUGIN_NAME ),
            'buy_tickets_text'        => __( 'Buy Tickets', AI1EC_PLUGIN_NAME ),
            'timezone_info'           => $timezone_info,
            'banner_image'            => $banner_image,
            'content_img_url'         => $event->get_runtime( 'content_img_url' ),
            'post_id'                 => $event->get( 'post_id' ),
            'ticket_url'              => $event->get( 'ticket_url' ),
            'tickets_url_label'       => $event->get_runtime( 'tickets_url_label' ),
            'start'                   => $event->get( 'start' ),
            'end'                     => $event->get( 'end' ),
            'cost'                    => $event->get( 'cost' ),
            'instance_id'             => $event->get( 'instance_id' ),
        );

        if (
            ! empty( $args['recurrence'] ) &&
            $event->get( 'instance_id' ) &&
            current_user_can( 'edit_ai1ec_events' )
        ) {
            $args['edit_instance_url']  = ai1ec_admin_url(
                'post.php?post=' . $event->get( 'post_id' ) .
                '&action=edit&instance=' . $event->get( 'instance_id' )
            );
            $args['edit_instance_text'] = sprintf(
                Ai1ec_I18n::__( 'Edit this occurrence (%s)' ),
                $event->get( 'start' )->format_i18n( 'M j' )
            );
        }
        $loader = $this->_registry->get( 'theme.loader' );
        $api    = $this->_registry->get( 'model.api.api-ticketing' );
        if ( false === ai1ec_is_blank( $event->get( 'ical_feed_url' ) ) ) {
            $ticket_url             = $api->get_api_event_buy_ticket_url( $event->get( 'post_id' ) );
            if ( ! empty ( $ticket_url ) ) {
                $args['ticket_url'] = $ticket_url;
            }
        } else {
            $api_event_id = $api->get_api_event_id( $event->get( 'post_id' ) );
            if ( $api_event_id ) {
                $api                   = $this->_registry->get( 'model.api.api-ticketing' );
                $ticket_types          = json_decode( $api->get_ticket_types( $event->get( 'post_id' ), false ) );
                $args['has_tickets']   = true;
                $args['API_URL']       = AI1EC_API_URL;
                $args['tickets_block'] = $loader->get_file(
                    'tickets.twig',
                    array(
                        'tickets_checkout_url' => $api->get_api_event_buy_ticket_url( $event->get( 'post_id' ) ),
                        'tickets'              => $ticket_types->data,
                        'text_tickets'         => $args['text_tickets'],
                        'buy_tickets_text'     => $args['buy_tickets_text'],
                        'api_event_id'         => $api_event_id
                    ), false
                )->get_content();
            }
        }

        return $loader->get_file( 'event-single.twig', $args, false )
            ->get_content();
    }

    /**
     * Add meta OG tags to the event details page
     */
    public function add_meta_tags() {
        // Add tags only on Event Details page
        $aco = $this->_registry->get( 'acl.aco' );
        if ( ! $aco->is_our_post_type() ) return;

        // Get Event and process description
        $instance_id     = ( isset( $_GET[ 'instance_id' ] ) ) ? $_GET[ 'instance_id' ] : null;

        if ( !is_null( $instance_id ) ) {
            $instance_id = preg_replace( '/\D/', '', $instance_id );
        }
        $event           = $this->_registry->get( 'model.event', get_the_ID(), $instance_id );
        $content         = $this->_registry->get( 'view.event.content' );
        $desc            = $event->get( 'post' )->post_content;
        $desc            = apply_filters( 'the_excerpt', $desc );
        $desc            = strip_shortcodes( $desc );
        $desc            = str_replace( ']]>', ']]&gt;', $desc );
        $desc            = strip_tags( $desc );
        $desc            = preg_replace( '/\n+/', ' ', $desc);
        $desc            = substr( $desc, 0, 300 );

        $og              = array(
            'url'         => home_url( esc_url( add_query_arg( null, null ) ) ),
            'title'       => htmlspecialchars(
                $event->get( 'post' )->post_title .
                ' (' . substr( $event->get( 'start' ) , 0, 10 ) . ')'
            ),
            'type'        => 'article',
            'description' => htmlspecialchars( $desc ),
            'image'       => $content->get_content_img_url( $event )
        );
        foreach ( $og as $key => $val ) {
            echo "<meta property=\"og:$key\" content=\"$val\" />\n";
        }
        // Twitter meta tags
        $twitter         = array(
            'card'        => 'summary',
            'title'       => htmlspecialchars(
                $event->get( 'post' )->post_title .
                ' (' . substr( $event->get( 'start' ) , 0, 10 ) . ')'
                ),
            'description' => htmlspecialchars( $desc ),
            'image'       => $content->get_content_img_url( $event )
        );
        foreach ( $twitter as $key => $val ) {
            if ( empty( $val ) && 'image' !== $key ) {
                $val = Ai1ec_I18n::__( 'No data' );
            }
            echo "<meta name=\"twitter:$key\" content=\"$val\" />\n";
        }
    }

    /**
     * @param Ai1ec_Event $event
     *
     * @return The html of the footer
     */
    public function get_footer( Ai1ec_Event $event ) {

        $text_calendar_feed = null;

        $feed_url = trim( strtolower( $event->get( 'ical_feed_url' ) ) );

        if ( strpos( $feed_url, 'http' ) === 0 ) {
            $text_calendar_feed = Ai1ec_I18n::__(
                'This post was replicated from another site\'s <a href="%s" title="iCalendar feed"><i class="ai1ec-fa ai1ec-fa-calendar"></i> calendar feed</a>.'
            );
        } else {
            $text_calendar_feed = Ai1ec_I18n::__(
                'This post was imported from a CSV/ICS file.'
            );
        }

        $loader = $this->_registry->get( 'theme.loader' );
        $text_calendar_feed = sprintf(
            $text_calendar_feed,
            esc_attr( str_replace( 'http://', 'webcal://', $event->get( 'ical_feed_url' ) ) )
        );
        $args   = array(
            'event'              => $event,
            'text_calendar_feed' => $text_calendar_feed,
            'text_view_post'     => Ai1ec_I18n::__( 'View original' ),
        );
        return $loader->get_file( 'event-single-footer.twig', $args, false )
            ->get_content();
    }

    /**
     * Render the full article for the event – title, content, and footer.
     *
     * @param Ai1ec_Event $event
     * @param string      $footer Footer HTML to append to event
     */
    public function get_full_article( Ai1ec_Event $event, $footer = '' ) {
        $title         = apply_filters(
            'the_title',
            $event->get( 'post' )->post_title,
            $event->get( 'post_id' )
        );
        $event_details = $this->get_content( $event );
        $content       = wpautop(
            apply_filters(
                'ai1ec_the_content',
                apply_filters(
                    'the_content',
                    $event->get( 'post' )->post_content
                )
            )
        );
        $args = compact( 'title', 'event_details', 'content', 'footer' );
        $loader = $this->_registry->get( 'theme.loader' );
        return $loader->get_file( 'event-single-full.twig', $args, false )
            ->get_content();
    }
}
