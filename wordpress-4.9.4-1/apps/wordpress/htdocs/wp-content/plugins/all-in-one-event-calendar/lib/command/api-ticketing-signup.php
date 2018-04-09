<?php

/**
 * The concrete command that sends sign up data to API
 *
 * @author     Time.ly Network Inc.
 * @since      2.4
 *
 * @package    AI1EC
 * @subpackage AI1EC.Command
 */
class Ai1ec_Command_Api_Ticketing_Signup extends Ai1ec_Command_Save_Abstract {

    /* (non-PHPdoc)
     * @see Ai1ec_Command::is_this_to_execute()
    */
    public function do_execute() {
        $api      = $this->_registry->get( 'model.api.api-registration' );
        if ( true === isset($_POST['ai1ec_signout']) && '1' === $_POST['ai1ec_signout'] ) {
            $api->signout();
        } else {
            if ( '1' === $_POST['ai1ec_signing'] ) {
                $api->signup();
            } else {
                $api->signin();
            }
        }
        return array(
            'url'        => ai1ec_admin_url(
                'edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings'
            ),
            'query_args' => array(
                'message' => ''
            ),
        );
    }

}
