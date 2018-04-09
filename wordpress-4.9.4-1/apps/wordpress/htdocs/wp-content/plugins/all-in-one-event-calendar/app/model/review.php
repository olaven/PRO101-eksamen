<?php

/**
 * Class to manage the review made by the user.
 * The data are saved inside the wp_option table
 *
 * @author     Time.ly Network Inc.
 *
 * @package    AI1ECCFG
 */
class Ai1ec_Review extends Ai1ec_Base {

    const EMAIL_FEEDBACK_DESTINATION = 'info@time.ly';
    const OPTION_KEY                 = '_ai1ec_review';
    const FEEDBACK_FIELD             = 'feedback';
    const RELEASE_DATE_FIELD         = 'release_date';
    const PUBLISHED_THRESHOLD        = 15;
    const FUTURE_EVENTS_THRESHOLD    = 3;
    const WEEK_OFFSET_SEC_FIELD      = 604800; //1 week in seconds (7 * 86400)

    /**
     * review colletion.
     *
     * @var array
     */
    protected $_review_items = array();

    /**
     * Option class.
     *
     * @var Ai1ec_Option
     */
    protected $_option;

    public function __construct( Ai1ec_Registry_Object $registry ) {
        parent::__construct( $registry );
        $this->_option       = $registry->get( 'model.option' );
        $this->_review_items = $this->_get_array( self::OPTION_KEY );
    }

    private function _get_array( $option_key ) {
        $items  = $this->_option->get( $option_key );
        if ( ! is_array( $items ) ) {
            $items = array();
        }
        return $items;
    }

    private function _get_field( $field_name, $default_value ) {
        if ( isset( $this->_review_items[$field_name] ) ) {
            $value = $this->_review_items[$field_name];
            if ( ai1ec_is_blank( $value ) ) {
                return $default_value;
            } else {
                return $value;
            }
        } else {
            return $default_value;
        }
    }

    protected function _save( array $values  ) {
        foreach ($values as $key => $value) {
            $this->_review_items[$key] = $value;
        }
        $this->_option->set( self::OPTION_KEY, $this->_review_items );
        return true;
    }

    protected function _is_show_box_review() {
        //only show for admins
        if ( false === is_admin() ) {
            return false;
        }
        $user_id = get_current_user_id();
        if ( empty( $user_id ) ) {
            return false;
        }
        //if the user already gave his feedback does not ask him again
        if ( $this->_has_feedback( $user_id ) ) {
            return false;
        }
        $release_date_str = $this->_get_field( self::RELEASE_DATE_FIELD, '' );
        if ( ai1ec_is_blank( $release_date_str ) ) {
            //the first time this page is loaded is save the moment as the release date
            //to just ask the user a review after 2 weeks
            $this->_save( array(
                    self::RELEASE_DATE_FIELD => $this->_registry->get( 'date.time' )->format()
                ) );
            return false;
        } else {
            $current_time = $this->_registry->get( 'date.time' );
            $release_date = $this->_registry->get( 'date.time', $release_date_str );
            $diff_sec     = $release_date->diff_sec( $current_time );
            //verify is passed 2 weeks after we release this feature
            if ( $diff_sec < self::WEEK_OFFSET_SEC_FIELD ) {
                return false;
            }
        }
        //count the published events
        $event_count = count_user_posts( $user_id, AI1EC_POST_TYPE, true );
        if ( $event_count < self::PUBLISHED_THRESHOLD ) {
            return false;
        }
        //count the future events
        $count_future_events = apply_filters( 'ai1ec_count_future_events', $user_id );
        if ( $count_future_events < self::FUTURE_EVENTS_THRESHOLD ) {
            return false;
        }
        return true;
    }

    public function get_content( $theme_loader ) {
        if ( $this->_is_show_box_review() ) {
            $current_user = wp_get_current_user();
            $review_args = array();
            if ( $current_user instanceof WP_User ) {
                $review_args['contact_name']  = $current_user->display_name;
                $review_args['contact_email'] = $current_user->user_email;
            } else {
                $review_args['contact_name']  = '';
                $review_args['contact_email'] = '';
            }
            $review_args['site_url']  = get_option( 'siteurl' );
            $theme_loader             = $this->_registry->get( 'theme.loader' );
            return $theme_loader->get_file( 'box_ask_customer_review.php', $review_args, true )->get_content();
        } else {
            return null;
        }
    }

    public function save_feedback_review() {
        $user_id = get_current_user_id();
        if ( empty( $user_id ) ) {
            throw new Exception( 'User not identified' );
        }
        if ( ai1ec_is_blank( $_POST['feedback'] ) ||
            !in_array( $_POST['feedback'], array( 'y', 'n' ) ) ) {
            throw new Exception( 'The field is not filled or invalid' );
        }
        $values = $this->_get_field( self::FEEDBACK_FIELD, null );
        if ( null === $values ) {
            $values = array();
        }
        $values[ $user_id ] = $_POST['feedback'];
        $this->_save( array(
                self::FEEDBACK_FIELD => $values
        ) );
    }

    protected function _has_feedback( $user_id ) {
        $values = $this->_get_field( self::FEEDBACK_FIELD, null );
        if ( null === $values ) {
            return false;
        }
        $user  = (string) $user_id;
        $value = isset( $values[$user] ) ? $values[$user] : '';
        return 0 === strcasecmp( 'y', $value ) || 0 === strcasecmp( 'n', $value );
    }

    public function send_feedback_message() {
        if ( ai1ec_is_blank( $_POST['name'] ) ||
            ai1ec_is_blank( $_POST['email'] ) ||
            ai1ec_is_blank( $_POST['site'] ) ||
            ai1ec_is_blank( $_POST['message'] )
        ) {
            throw new Exception( 'All fields are required' );
        }
        $subject = __( 'Feedback provided by user', AI1EC_PLUGIN_NAME );
        $content = sprintf( '<b>%s:</b><br/>%s<br/><br/><b>%s:</b><br/>%s<br/><br/><b>%s:</b><br/>%s<br/><br/><b>%s:</b><br/>%s',
                __( 'Name', AI1EC_PLUGIN_NAME ),
                $_POST['name'],
                __( 'E-mail', AI1EC_PLUGIN_NAME ),
                $_POST['email'],
                __( 'Site URL', AI1EC_PLUGIN_NAME ),
                $_POST['site'],
                __( 'Message', AI1EC_PLUGIN_NAME ),
                nl2br( $_POST['message'] )
            );
        $dispatcher = $this->_registry->get(
            'notification.email',
            $content,
            explode( ',', self::EMAIL_FEEDBACK_DESTINATION ),
            $subject
        );
        $headers = array(
                'Content-type: text/html',
                sprintf( 'From: %s <%s>', $_POST['name'], $_POST['email'])
            );
        if ( $dispatcher->send( $headers ) ) {
            $_POST['feedback'] = 'n';
            $this->save_feedback_review();
        }
    }
}
