<?php
if (!defined('LEADIN_PLUGIN_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    wp_die();
}

if (is_admin()) {
    add_action('wp_ajax_leadin_disconnect_ajax', 'leadin_disconnect_ajax'); // Call when user in slumber mode would like to disconnect their account
}

function leadin_disconnect_ajax()
{   
    if (get_option('leadin_portalId')) {
       delete_option('leadin_portalId');
       delete_option('leadin_slumber_mode');
       delete_option('leadin_hapikey');

       wp_die('{"message": "Success!"}'); 
    } else {
        error_log("Disconnect error");
        header('HTTP/1.0 400 Bad Request');
        wp_die('{"error": "No leadin_portalId found, cannot disconnect."}');
    }
    
}

?>