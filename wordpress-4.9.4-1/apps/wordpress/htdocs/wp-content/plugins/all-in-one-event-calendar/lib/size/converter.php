<?php

/**
 * Size converter utility
 *
 * @author       Time.ly Network, Inc.
 * @since        2.0
 * @package      Ai1EC
 * @subpackage   Ai1EC.Size
 */
class Ai1ec_Size_Converter_Utility extends Ai1ec_Base {

    /**
     * Returns number of bytes from human readable string
     * Note: This is similar to wp_convert_hr_bytes(), but this one accepts values with decimals
     *
     * @param string $size Human readable size string
     *
     * @return string Converted number of bytes from human readable size string
     */
    public function convert_hr_to_bytes( $size ) {
        $size  = strtolower( $size );
        $bytes = preg_replace( '/[^0-9\.]/', '', $size );

        // Sanity check
        if ( empty( $bytes ) ) {
            $bytes = 0;
        }

        if ( strpos( $size, 'k' ) !== false ) {
            $bytes = $bytes * 1024;
        } elseif ( strpos( $size, 'm' ) !== false ) {
            $bytes = $bytes * 1024 * 1024;
        } elseif ( strpos( $size, 'g' ) !== false ) {
            $bytes = $bytes * 1024 * 1024 * 1024;
        }

        return $bytes;
    }
}
