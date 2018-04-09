<?php

/**
 * Email validator.
 *
 * @author       Time.ly Network Inc.
 * @since        2.3
 * @instantiator new
 * @package      AI1EC
 * @subpackage   AI1EC.Validator
 */
class Ai1ec_Validator_Email extends Ai1ec_Validator {

    /* (non-PHPdoc)
     * @see Ai1ec_Validator::validate()
     */
    public function validate() {
        if (
            ! empty( $this->_value ) &&
            ! is_email( $this->_value )
        ) {
            throw new Ai1ec_Value_Not_Valid_Exception();
        }
        return $this->_value;
    }

}