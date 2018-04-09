<?php

/**
 * The get tax options box.
 *
 * @author     Time.ly Network Inc.
 * @since      2.4
 *
 * @package    AI1EC
 * @subpackage AI1EC.View
 */
class Ai1ec_View_Admin_Get_Tax_Box extends Ai1ec_Base {
    /**
     * get_tax_box function
     *
     * @return string
     **/
    public function get_tax_box() {
        $api      = $this->_registry->get( 'model.api.api-ticketing' );
        $post_id  = $_POST['ai1ec_event_id'];
        $modal    = $api->get_tax_options_modal( $post_id );
        $output   = array(
            'error'   => $modal->error,
            'message' => $modal->data
        );
        $json_strategy = $this->_registry->get( 'http.response.render.strategy.json' );
        $json_strategy->render( array( 'data' => $output ) );
    }

}
