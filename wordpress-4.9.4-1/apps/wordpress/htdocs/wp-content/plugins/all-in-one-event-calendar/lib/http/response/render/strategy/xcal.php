<?php

/**
 * Render the request as xcal.
 *
 * @author     Time.ly Network Inc.
 * @since      2.3
 *
 * @package    AI1EC
 * @subpackage AI1EC.Http.Response.Render.Strategy
 */
class Ai1ec_Render_Strategy_Xcal extends Ai1ec_Http_Response_Render_Strategy {

    /* (non-PHPdoc)
     * @see Ai1ec_Http_Response_Render_Strategy::render()
    */
    public function render( array $params ) {
        $this->_dump_buffers();
        header( 'Content-Type: application/force-download; name="calendar.xml"' );
        header( 'Content-type: text/xml' );
        header( 'Content-Transfer-Encoding: binary' );
        header( 'Content-Disposition: attachment; filename="calendar.xml"' );
        header( 'Expires: 0' );
        header( 'Cache-Control: no-cache, must-revalidate' );
        header( 'Pragma: no-cache' );
        echo $params['data'];
        return Ai1ec_Http_Response_Helper::stop( 0 );
    }

}