<?php

/**
 * Renderer of settings page custom option.
 *
 * @author       Time.ly Network, Inc.
 * @instantiator new
 * @since        2.4
 * @package      Ai1EC
 * @subpackage   Ai1EC.Html
 */
class Ai1ec_Html_Setting_Custom extends Ai1ec_Html_Element_Settings {

    /* (non-PHPdoc)
     * @see Ai1ec_Html_Element_Settings::render()
     */
    public function render( $output = '' ) {
        $label   = $this->_args['renderer']['label'];
        $content = $this->_args['renderer']['content'];
        $loader  = $this->_registry->get( 'theme.loader' );
        $file    = $loader->get_file( 'setting/custom.twig', array(
            'label'   => $label,
            'content' => $content
        ), true );
        return parent::render( $file->get_content() );
    }

}
