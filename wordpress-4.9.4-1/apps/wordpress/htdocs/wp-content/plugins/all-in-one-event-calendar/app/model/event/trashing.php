<?php

/**
 * Handles trash/delete operations.
 *
 * NOTICE: only operations on events entries themselve is handled.
 * If plugins need some extra handling - they must bind to appropriate
 * actions on their will.
 *
 * @author     Time.ly Network Inc.
 * @since      2.0
 *
 * @package    AI1EC
 * @subpackage AI1EC.Model
 */
class Ai1ec_Event_Trashing extends Ai1ec_Base {

    /**
     * Trash/untrash/deletes child posts
     *
     * @param id $post_id
     * @param string $action
     */
    protected function _manage_children( $post_id, $action ) {
        try {
            $ai1ec_event = $this->_registry->get( 'model.event', $post_id );
            if (
                $ai1ec_event->get( 'post' ) &&
                    $ai1ec_event->get( 'recurrence_rules' )
            ) {
                // when untrashing also get trashed object
                $children = $this->_registry->get( 'model.event.parent' )
                    ->get_child_event_objects( $ai1ec_event->get( 'post_id' ), $action === 'untrash' );
                $function = 'wp_' . $action . '_post';
                foreach ( $children as $child ) {
                    $function( $child->get( 'post_id' ) );
                }
            }
        } catch ( Ai1ec_Event_Not_Found_Exception $exception ) {
            // ignore - not an event
        }
    }

    /**
     * Trashes child posts
     *
     * @param int $post_id
     */
    public function trash_children( $post_id ) {
        $this->_manage_children( $post_id, 'trash' );
    }

    /**
     * Delete child posts
     *
     * @param int $post_id
     */
    public function delete_children( $post_id ) {
        $this->_manage_children( $post_id, 'delete' );
    }

    /**
     * Untrashes child posts
     *
     * @param int $post_id
     */
    public function untrash_children( $post_id ) {
        $this->_manage_children( $post_id, 'untrash' );
    }

    /**
     * Handle PRE (event) trashing.
     *
     * @wp_hook trash_post
     *
     * @param int $post_id ID of post, which was trashed.
     *
     * @return bool Success.
     */
    public function trash_post( $post_id ) {
        $api             = $this->_registry->get( 'model.api.api-ticketing' );
        $post            = get_post( $post_id );
        $restored_status = get_post_meta( $post_id, '_wp_trash_meta_status', true );
        $fields          = array(
            'status' => 'trash'
        );
        $ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
        $message = $api->update_api_event_fields( $post, $fields, 'trash', $ajax );
        if ( null !== $message )  {
            if ( $ajax ) {
                wp_die( $message );
            } else {
                wp_redirect( $this->get_sendback_page( $post_id ) );
                exit();
            }
        }
        return true;
    }

    /**
     * Handle POST (event) trashing.
     *
     * @wp_hook trashed_post
     *
     * @param int $post_id ID of post, which was trashed.
     *
     * @return bool Success.
     */
    public function trashed_post( $post_id ) {
        return $this->trash_children( $post_id );
    }

    private function get_sendback_page( $post_id ) {
        $sendback  = wp_get_referer();
        $page_base = Ai1ec_Wp_Uri_Helper::get_pagebase( $sendback ); //$_SERVER['REQUEST_URI'] );
        if ( 'post.php' === $page_base ) {
            return get_edit_post_link( $post_id, 'url' );
        } else {
            return admin_url( 'edit.php?post_type=ai1ec_event' );
        }
    }

    /**
     * Handle PRE (event) untrashing.
     *
     * @wp_hook untrash_post
     *
     * @param int $post_id ID of post, which was untrashed.
     *
     * @return bool Success. Interrupt the action with exit is
     * the integration with API fails
     */
    public function untrash_post ( $post_id ) {
        $api             = $this->_registry->get( 'model.api.api-ticketing' );
        $post            = get_post( $post_id );
        $restored_status = get_post_meta( $post_id, '_wp_trash_meta_status', true );
        $fields          = array(
            'status' => $restored_status
        );
        $ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
        $message = $api->update_api_event_fields( $post, $fields, 'untrash', $ajax );
        if ( null !== $message )  {
            if ( $ajax ) {
                wp_die( $message );
            } else {
                wp_redirect( $this->get_sendback_page( $post_id ) );
                exit();
            }
        }
        return true;
    }

    /**
     * Handle POST (event) untrashing.
     *
     * @wp_hook untrashed_post
     *
     * @param int $post_id ID of post, which was untrashed.
     *
     * @return bool Success.
     */
    public function untrashed_post( $post_id ) {
        return $this->untrash_children( $post_id );
    }

    /**
     * Handle PRE (event) deletion.
     *
     * Executed before post is deleted, but after meta is removed.
     *
     * @wp_hook delete_post
     *
     * @param int $post_id ID of post, which was trashed.
     *
     * @return bool Success. Interrupt the action with exit is
     * the integration with API fails
     */
    public function before_delete_post( $post_id ) {
        $api     = $this->_registry->get( 'model.api.api-ticketing' );
        $ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
        $message = $api->delete_api_event( $post_id, 'delete', $ajax );
        if ( null !==  $message )  {
            if ( $ajax ) {
                wp_die( $message );
            } else {
                wp_redirect( $this->get_sendback_page( $post_id ) );
                exit();
            }
        }
        return true;
    }

    /**
     * Handle POST (event) deletion.
     *
     * Executed before post is deleted, but after meta is removed.
     *
     * @wp_hook delete_post
     *
     * @param int $post_id ID of post, which was trashed.
     *
     * @return bool Success.
     */
    public function delete( $post_id ) {
        $post_id = (int)$post_id;
        $where   = array( 'post_id' => (int)$post_id );
        $format  = array( '%d' );
        $dbi     = $this->_registry->get( 'dbi.dbi' );
        $success = $this->delete_children( $post_id );
        $success = $dbi->delete( 'ai1ec_events', $where, $format );
        $success = $this->_registry->get( 'model.event.instance' )->clean( $post_id );
        unset( $where, $dbi );
        return $success;
    }

}