<?php

/**
 * The abstract class for a view.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
abstract class Ai1ec_Calendar_View_Abstract extends Ai1ec_Base {

    /**
     * @var Ai1ec_Request_Parser The request object
     */
    protected $_request;

    /**
     * @var Ai1ec_Compatibility_Check Theme compatibility check object.
     */
    protected $_compatibility;

    /**
     * Public constructor
     *
     * @param Ai1ec_Registry_Object $registry
     * @param Ai1ec_Request_Parser $request
     */
    public function __construct( Ai1ec_Registry_Object $registry, Ai1ec_Request_Parser $request ) {
        parent::__construct( $registry );
        $this->_request       = $request;
        $this->_compatibility = $registry->get( 'compatibility.check' );
    }

    /**
     * Get the machine name for the view
     *
     * @return string The machine name of the view.
     */
    abstract public function get_name();

    /**
     * Get extra arguments specific for the view
     *
     * @param array $view_args
     * @param int|bool $exact_date the exact date used to display the view.
     *
     * @return array The view arguments with the extra parameters added.
     */
    public function get_extra_arguments( array $view_args, $exact_date ) {
        $offset = $this->get_name() . '_offset';
        $view_args[$offset] = $this->_request->get( $offset );
        if( false !== $exact_date ) {
            $view_args['exact_date'] = $exact_date;
        }
        return $view_args;
    }

    /**
     * Get extra arguments specific for the view's template
     *
     * @param array $args
     *
     * @return array The template arguments with the extra parameters added.
     */
    public function get_extra_template_arguments( array $args ) {
        $loader                 = $this->_registry->get( 'theme.loader' );
        $args['action_buttons'] = apply_filters(
            'ai1ec_add_action_buttons',
            $this->_action_buttons()
        );
        if (
            true === apply_filters(
                'ai1ec_buy_button_product',
                false
            )
        ) {
            $args['has_product_buy_button'] = true;
        }
        return $args;
    }

    /**
     * Render the view and return the content
     *
     * @param array $view_args
     *
     * @return string the html of the view
     */
    abstract public function get_content( array $view_args );

    /**
     *
     * @return string HTML of action buttons
     */
    protected function _action_buttons() {
        $loader         = $this->_registry->get( 'theme.loader' );
        $action_buttons = $loader->get_file(
            'buttons.twig',
            array(
                'action_buttons' => apply_filters(
                    'ai1ec_action_buttons',
                    ''
                ),
                'tickets_button' => true,
                'text_tickets'   => __( 'Tickets', AI1EC_PLUGIN_NAME ),
                'has_buy_tickets_product' => apply_filters(
                    'ai1ec_buy_button_product',
                    false
                )
            ),
            false
        )->get_content();
        return $action_buttons;
    }


    /**
     *
     * @param string $exact_date
     */
    protected function _create_link_for_day_view( $exact_date ) {
        $href = $this->_registry->get(
            'html.element.href',
            array(
                'action'     => 'oneday',
                'exact_date' => $exact_date,
            )
        );
        return $href->generate_href();
    }

    /**
     * Get the view html
     *
     * @param array $view_args
     *
     * @return string
     */
    protected function _get_view( array $view_args ) {
        $loader = $this->_registry->get( 'theme.loader' );
        $view = $this->get_name();
        $file = $loader->get_file( $view . '.twig', $view_args, false );

        return apply_filters(
            'ai1ec_get_' . $view . '_view',
            $file->get_content(),
            $view_args
        );
    }

    /**
     * Applies filters to view args for front end rendering
     *
     * @param array $args
     */
    protected function _apply_filters_to_args( array $args ) {
        $loader = $this->_registry->get( 'theme.loader' );
        $view   = $this->get_name();
        return $loader->apply_filters_to_args( $args, $view . '.twig', false );
    }

    /**
     * Prepare week specific event start/end timestamps.
     *
     * @param Ai1ec_Event $event Instance of event.
     *
     * @return array Start and end respectively in 0 and 1 positions.
     */
    protected function _get_view_specific_timestamps( Ai1ec_Event $event ) {
        if ( $event->is_allday() ) {
            // reset to be day-contained with respect to current timezone
            $event_start = $this->_registry
                ->get( 'date.time', $event->get( 'start' ), 'sys.default' )
                ->set_time( 0, 0, 0 )
                ->format();
            $event_end   = $this->_registry
                ->get( 'date.time', $event->get( 'end' ), 'sys.default' )
                ->set_time( 0, 0, 0 )
                ->format();
        } else {
            $event_start = $event->get( 'start' )->format();
            $event_end   = $event->get( 'end' )->format();
        }
        return array( $event_start, $event_end );
    }

    /**
     * Update metadata for retrieved events.
     *
     * This speeds up further meta data requests.
     *
     * @param array $events List of events retrieved.
     *
     * @return void
     */
    protected function _update_meta( array $events ) {
        $post_ids = array();
        foreach ( $events as $event ) {
            $post_ids[] = (int)$event->get( 'post_id' );
        }
        update_meta_cache( 'post', $post_ids );
        $this->_registry->get( 'model.taxonomy' )
            ->update_meta( $post_ids );
    }

    /**
     * Gets the navigation bar HTML.
     *
     * @param array $nav_args Args for the navigation bar template, including
     *                        'no_navigation' which determines whether to show it
     * @return string
     */
    protected function _get_navigation( array $nav_args ) {
        $navigation                       = '';
        $loader                           = $this->_registry->get( 'theme.loader' );
        $nav_args['contribution_buttons'] = apply_filters(
            'ai1ec_contribution_buttons',
            '',
            'html',
            'render-command'
        );
        if ( true !== $nav_args['no_navigation'] ) {
            $navigation = $loader->get_file(
                'navigation.twig',
                $nav_args,
                false
            )->get_content();
        }
        return $navigation;
    }

    /**
     * Calls the get_*_pagination_links method for the current view type and
     * renders its result, returning the rendered pagination links.
     *
     * @param array  $args  Current request arguments
     * @param string $title Title to display in datepicker button
     * @return string
     */
    protected function _get_pagination( array $args, $title ) {
        $method = 'get_' . $this->get_name() . '_pagination_links';
        $pagination_links = $this->$method( $args, $title );
        $loader           = $this->_registry->get( 'theme.loader' );
        $pagination_links = $loader->get_file(
            'pagination.twig',
            array(
                'links'      => $pagination_links,
                'data_type'  => $args['data_type'],
            ),
            false
        )->get_content();
        return $pagination_links;
    }

    /**
     * Adds runtime properties to the event.
     *
     * @param Ai1ec_Event $event
     */
    protected function _add_runtime_properties( Ai1ec_Event $event ) {
        global $post;
        $original_post      = $post;
        $post               = $event->get( 'post' );
        $instance_permalink = get_permalink(
            $event->get( 'post_id' )
        );
        $instance_permalink = add_query_arg(
            'instance_id',
            $event->get( 'instance_id' ),
            $instance_permalink
        );
        $event->set_runtime( 'instance_permalink', $instance_permalink );

        $event->set_runtime(
            'filtered_title',
            apply_filters(
                'the_title',
                $event->get( 'post' )->post_title,
                $event->get( 'post_id' ),
                true
            )
        );
        $calendar_state = $this->_registry->get( 'calendar.state' );
        $calendar_state->set_append_content( false );
        $event->set_runtime(
            'filtered_content',
            apply_filters(
                'ai1ec_the_content',
                apply_filters(
                    'the_content',
                    $event->get( 'post' )->post_content
                )
            )
        );
        $calendar_state->set_append_content( true );

        $taxonomy = $this->_registry->get( 'view.event.taxonomy' );
        $ticket   = $this->_registry->get( 'view.event.ticket' );
        $event->set_runtime(
            'color_style',
            $taxonomy->get_color_style( $event )
        );
        $event->set_runtime( 'category_colors', $taxonomy->get_category_colors( $event ) );
        $event->set_runtime( 'ticket_url_label', $ticket->get_tickets_url_label( $event, false ) );
        $event->set_runtime( 'edit_post_link', get_edit_post_link( $event->get( 'post_id' ) ) );
        $event_post = $this->_registry->get( 'view.event.post' );
        $event->set_runtime( 'post_excerpt', $event_post->trim_excerpt( $event ) );
        $color = $this->_registry->get( 'view.event.color' );
        $event->set_runtime( 'faded_color', $color->get_faded_color( $event ) );
        $event->set_runtime( 'rgba_color', $color->get_rgba_color( $event ) );
        $event->set_runtime(
            'short_start_time',
            $this->_registry->get( 'view.event.time' )
            ->get_short_time( $event->get( 'start' ) )
        );
        $this->_add_view_specific_runtime_properties( $event );
        $post = $original_post;
    }

    /**
     * If some views have specific runtime properties they must extend this method
     *
     * @param Ai1ec_Event $event
     */
    protected function _add_view_specific_runtime_properties( Ai1ec_Event $event ) {

    }
}
