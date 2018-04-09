<?php
/**
 * Helper for template links.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Template.Link
 */
class Ai1ec_Template_Link_Helper {

    /**
     * Retrieve the permalink for current page or page ID.
     *
     * Respects page_on_front. Use this one.
     *
     * @param int|object $post      Optional. Post ID or object.
     * @param bool       $leavename Optional, defaults to false.
     *                              Whether to keep page name.
     * @param bool       $sample    Optional, defaults to false.
     *                              Is it a sample permalink.
     *
     * @return string
     */
    public function get_page_link( $post = false, $leavename = false, $sample = false ) {
        return get_page_link( $post, $leavename, $sample );
    }

    /**
     * Retrieve full permalink for current post or post ID.
     *
     * @since 1.0.0
     *
     * @param int $id Optional. Post ID.
     * @param bool $leavename Optional, defaults to false. Whether to keep post name or page name.
     * @return string
     */
    public function get_permalink( $id = 0, $leavename = false ) {
        return get_permalink( $id, $leavename );
    }

    /**
     * Retrieve full calendar permalink even if Calendar page is set to be
     * homepage.
     *
     * @param int|object $post      Optional. Post ID or object.
     * @param bool       $leavename Optional. Leave name.
     * @param bool       $sample    Optional. Sample permalink.
     *
     * @return string
     */
    public function get_full_permalink(
        $post = false,
        $leavename = false,
        $sample = false
    ) {
        if ( false === $post ) {
            return '';
        }
        return _get_page_link( $post, $leavename, $sample );
    }
}
