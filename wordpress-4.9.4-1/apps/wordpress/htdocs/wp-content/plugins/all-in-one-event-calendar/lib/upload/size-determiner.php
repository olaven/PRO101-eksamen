<?php

/**
 * Upload size determiner
 *
 * @author       Time.ly Network, Inc.
 * @since        2.0
 * @package      Ai1EC
 * @subpackage   Ai1EC.Upload
 */
class Ai1ec_Upload_Size_Determiner_Utility extends Ai1ec_Base {

    /**
     * Returns the maximum upload file size in bytes
     *
     * @param string $size Human readable size
     *
     * @return int Maximum upload file size
     */
    public function get_maximum_upload_file_size_bytes( $size ) {
        $converter_utility = $this->_registry->get( 'size.converter' );

        $maximum_size = $converter_utility->convert_hr_to_bytes( $size );

        if ( $maximum_size <= 0  ||  $maximum_size > wp_max_upload_size() ) {
            $maximum_size = wp_max_upload_size();
        }

        return $maximum_size;
    }

    /**
     * Returns human readable maximum upload file size
     *
     * @param string $size Human readable size
     *
     * @return string Human readable maximum upload file size
     */
    public function get_maximum_upload_file_size_string( $size ) {
        $size_string = size_format( $this->get_maximum_upload_file_size_bytes( $size ), 2 );

        return $size_string;
    }
}
