<?php

/**
 * Human readable size validator.
 *
 * @author       Time.ly Network Inc.
 * @since        2.0
 * @instantiator new
 * @package      AI1EC
 * @subpackage   AI1EC.Validator
 */
class Ai1ec_Validator_Human_Readable_Size extends Ai1ec_Validator {

    /* (non-PHPdoc)
     * @see Ai1ec_Validator::validate()
     */
    public function validate() {
        $checked_string = trim( strtoupper( $this->_value ) );

        // Bytes - Get the first number
        $bytes = '0';
        preg_match( '/^([0-9\.]+)/', $checked_string, $matches );
        if ( count( $matches ) == 2 ) {
            $bytes = $matches[1];
        }

        // Unit - Get the first letter
        $unit = 'B';
        preg_match( '/([KMGT]{1})/', $checked_string, $matches );
        if ( count( $matches ) == 2 ) {
            $unit = $matches[1];
        }

        return $bytes . $unit;
    }
}