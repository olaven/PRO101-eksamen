<?php

// ====================================================================
// = Trigger Uninstall process only if WP_UNINSTALL_PLUGIN is defined =
// ====================================================================
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    return;
}

global $wp_filesystem;

/**
 * remove_taxonomy function
 *
 * Remove a taxonomy
 *
 * @return void
 **/
function ai1ec_remove_taxonomy( $taxonomy ) {
    global $wp_taxonomies;
    // get all terms in $taxonomy
    $terms = get_terms( $taxonomy );

    // delete all terms in $taxonomy
    foreach ( $terms as $term ) {
        wp_delete_term( $term->term_id, $taxonomy );
    }

    // deregister $taxonomy
    unset( $wp_taxonomies[$taxonomy] );

    // do we need to flush the rewrite rules?
    $GLOBALS['wp_rewrite']->flush_rules();
}

/**
 * unregister our CRON
 */
function ai1ec_uninstall_crons() {
    foreach ( _get_cron_array() as $time => $cron ) {
        foreach ( $cron as $name => $args ) {
            if ( substr( $name, 0, 6 ) === 'ai1ec_' ) {
                wp_clear_scheduled_hook( $name );
            }
        }
    }
}

/**
 * Delete our options
 */
function ai1ec_uninstall_options() {
    global $wpdb;
    $options = $wpdb->get_col(
        'SELECT `option_name` FROM ' . $wpdb->options .
        ' WHERE `option_name` LIKE \'%ai1ec%\''
    );
    foreach ( $options as $option ) {
        delete_option( $option );
    }
}

/**
 * Delete restore tables created during upgrade
 *
 * @param string $table
 */
function ai1ec_delete_table_and_backup( $table ) {
    global $wpdb;
    $query = 'SHOW TABLES LIKE \'' . $table . '%\'';
    foreach ( $wpdb->get_col( $query ) as $table_name ) {
        // Delete table events
        $wpdb->query( 'DROP TABLE IF EXISTS ' . $table_name );
    }
}

/**
 * Deletes posts and drop tables
 */
function ai1ec_clean_up_tables() {
    global $wpdb;
    // Delete events
    $table_name = $wpdb->prefix . 'ai1ec_events';
    $query      = 'SELECT DISTINCT `ID` FROM `' . $wpdb->posts .
        '` WHERE `post_type` = \'ai1ec_event\'';
    foreach ( $wpdb->get_col( $query ) as $postid ) {
        wp_delete_post( (int) $postid, true );
    }

    // Delete table events
    ai1ec_delete_table_and_backup( $table_name );

    // Delete table event instances
    $table_name = $wpdb->prefix . 'ai1ec_event_instances';
    ai1ec_delete_table_and_backup( $table_name );

    // Delete table event feeds
    $table_name = $wpdb->prefix . 'ai1ec_event_feeds';
    ai1ec_delete_table_and_backup( $table_name );

    // Delete table category colors
    $table_name = $wpdb->prefix . 'ai1ec_event_category_meta';
    ai1ec_delete_table_and_backup( $table_name );

    // Delete legacy logging table
    $table_name = $wpdb->prefix . 'ai1ec_logging';
    ai1ec_delete_table_and_backup( $table_name );
}

/**
 * Deletes custom user roles and capabilities
 */
function ai1ec_remove_custom_user_roles_capabilities() {
    global $wp_roles; // global class wp-includes/capabilities.php

    // Remove AI1EC custom role
    remove_role( 'ai1ec_event_assistant' );

    // List of roles
    $roles = array(
        'administrator',
        'editor',
        'author',
        'subscriber'
    );

    // Complete list of AI1EC capabilities
    $caps = array(
        'delete_ai1ec_event',
        'delete_ai1ec_events',
        'delete_others_ai1ec_events',
        'delete_private_ai1ec_events',
        'delete_published_ai1ec_events',
        'edit_ai1ec_event',
        'edit_ai1ec_events',
        'edit_others_ai1ec_events',
        'edit_private_ai1ec_events',
        'edit_published_ai1ec_events',
        'manage_ai1ec_feeds',
        'manage_ai1ec_options',
        'publish_ai1ec_events',
        'read_ai1ec_event',
        'read_ai1ec_events',
        'read_private_ai1ec_events',
        'switch_ai1ec_themes'
    );

    foreach ( $roles as $role ) {
        foreach ( $caps as $cap ) {
            // Remove the capability.
            $wp_roles->remove_cap( $role, $cap );
        }
    }
}

/**
 * Deletes custom user meta
 */
function ai1ec_remove_custom_user_meta() {

    // List of custom user meta
    $metas = array(
            'closedpostboxes_ai1ec_event',
            'metaboxhidden_ai1ec_event'
    );

    $users = get_users('');

    foreach ($users as $user) {
        foreach ( $metas as $meta )
        delete_user_meta( $user->ID, $meta );
    }
}

function ai1ec_clean_up_site() {
    // Delete event categories taxonomy
    ai1ec_remove_taxonomy( 'events_categories' );
    // Delete event tags taxonomy
    ai1ec_remove_taxonomy( 'events_tags' );
    // Delete custom user roles and capabilities
    ai1ec_remove_custom_user_roles_capabilities();
    // Delete custom user meta
    ai1ec_remove_custom_user_meta();
    ai1ec_uninstall_crons();
    ai1ec_uninstall_options();
    ai1ec_clean_up_tables();
}

// Based on Codex article:
// http://codex.wordpress.org/Function_Reference/register_uninstall_hook
if ( is_multisite() ) { // For Multisite
    global $wpdb;
    $blog_ids         = $wpdb->get_col( 'SELECT blog_id FROM ' . $wpdb->blogs );
    $original_blog_id = get_current_blog_id();
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        ai1ec_clean_up_site();
    }
    switch_to_blog( $original_blog_id );
}
ai1ec_clean_up_site();

// Delete themes folder
if ( is_object( $wp_filesystem ) && ! is_wp_error( $wp_filesystem->errors ) ) {
    // Get the base plugin folder
    $themes_dir = $wp_filesystem->wp_content_dir() . AI1EC_THEME_FOLDER;
    if ( ! empty( $themes_dir ) ) {
        $themes_dir = trailingslashit( $themes_dir );
        $wp_filesystem->delete( $themes_dir, true );
    }
}
