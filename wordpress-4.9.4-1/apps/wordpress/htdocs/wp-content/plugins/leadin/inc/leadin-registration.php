<?php
if (!defined('LEADIN_PLUGIN_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    wp_die();
}

if (is_admin()) {
    add_action('wp_ajax_leadin_registration_ajax', 'leadin_registration_ajax'); // Call when user logged in
    add_action('wp_ajax_leadin_deregistration_ajax', 'leadin_deregistration_ajax');
}

function leadin_registration_ajax()
{
    $existingPortalId = get_option('leadin_portalId');
    $existingHapikey = get_option('leadin_hapikey');

    if (!empty($existingPortalId)) {
        header('HTTP/1.0 400 Bad Request');
        wp_die('{"error": "Registration is already complete for this portal"}');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    $newPortalId = $data['portalId'];
    $slumberMode = $data['slumberMode'];

    error_log($data['hapikey']);

    if (empty($newPortalId)) {
        error_log("Registration error");
        header('HTTP/1.0 400 Bad Request');
        wp_die('{"error": "Registration missing required fields"}');
    }

    add_option('leadin_portalId', $newPortalId);
    add_option('leadin_slumber_mode', '1');

    if (!empty($existingHapikey)) {
        delete_option('leadin_hapikey');
    }

    wp_die('{"message": "Success!"}');
}

function leadin_deregistration_ajax() {
    delete_option('leadin_portalId');
    delete_option('leadin_hapikey');

    wp_die('{"message": "Success!"}');
}

?>