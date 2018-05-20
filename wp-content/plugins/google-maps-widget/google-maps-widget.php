<?php
/*
Plugin Name: Google Maps Widget
Plugin URI: http://www.gmapswidget.com/
Description: Display a single image super-fast loading Google map in a widget. A larger, full featured map is available in a lightbox. Includes a user-friendly interface and numerous appearance options.
Author: Web Factory Ltd
Version: 3.85
Author URI: http://www.webfactoryltd.com/
Text Domain: google-maps-widget
Domain Path: lang

  Copyright 2012 - 2018  Web factory Ltd  (email : gmw@webfactoryltd.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}


if (!class_exists('GMW')) {

define('GMW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GMW_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GMW_BASE_FILE', basename(__FILE__));

require_once GMW_PLUGIN_DIR . 'gmw-tracking.php';
require_once GMW_PLUGIN_DIR . 'gmw-widget.php';

class GMW {
  static $version;
  static $options = 'gmw_options';
  static $licensing_servers = array('http://license.gmapswidget.com/', 'http://license2.gmapswidget.com/');


  // get plugin version from header
  static function get_plugin_version() {
    $plugin_data = get_file_data(__FILE__, array('version' => 'Version'), 'plugin');
    GMW::$version = $plugin_data['version'];

    return $plugin_data['version'];
  } // get_plugin_version


  // hook everything up
  static function init() {
    if (is_admin()) {
      // check if minimal required WP version is present
      if (false === GMW::check_wp_version(4.0)) {
        return false;
      }

      // check a few variables
      GMW::maybe_upgrade();
      add_filter('pre_set_site_transient_update_plugins', array('GMW', 'update_filter'));
      add_filter('plugins_api', array('GMW', 'update_details'), 100, 3);

      // aditional links in plugin description
      add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
                 array('GMW', 'plugin_action_links'));
      add_filter('plugin_row_meta', array('GMW', 'plugin_meta_links'), 10, 2);

      // enqueue admin scripts
      add_action('admin_enqueue_scripts', array('GMW', 'admin_enqueue_scripts'), 100);
      add_action('customize_controls_enqueue_scripts', array('GMW', 'admin_enqueue_scripts'));

      // JS dialog markup
      add_action('admin_footer', array('GMW', 'admin_dialogs_markup'));

      // register AJAX endpoints
      add_action('wp_ajax_gmw_test_api_key', array('GMW', 'test_api_key_ajax'));
      add_action('wp_ajax_gmw_get_trial', array('GMW', 'get_trial_ajax'));
      add_action('wp_ajax_gmw_activate', array('GMW', 'activate_license_key_ajax'));
      add_action('wp_ajax_gmw_dismiss_pointer', array('GMW', 'dismiss_pointer_ajax'));

      // custom admin actions
      add_action('admin_action_gmw_dismiss_notice', array('GMW', 'dismiss_notice'));

      // add options menu
      add_action('admin_menu', array('GMW', 'add_menus'));

      // settings registration
      add_action('admin_init', array('GMW', 'register_settings'));

      // display various notices
      add_action('current_screen', array('GMW', 'add_notices'));

    } else {
      // enqueue frontend scripts
      add_action('wp_enqueue_scripts', array('GMW', 'register_scripts'));
      add_action('wp_footer', array('GMW', 'dialogs_markup'));
    }

    // track plugin usage
    GMW_tracking::init();
  } // init


  // some things have to be loaded earlier
  static function plugins_loaded() {
    GMW::get_plugin_version();

    load_plugin_textdomain('google-maps-widget', false, basename(dirname(__FILE__)) . '/lang');
    add_filter('cron_schedules', array('GMW_tracking', 'register_cron_intervals'));
  } // plugins_loaded


  // initialize widgets
  static function widgets_init() {
    register_widget('GoogleMapsWidget');
  } // widgets_init


  // all settings are saved in one option
  static function register_settings() {
    register_setting(GMW::$options, GMW::$options, array('GMW', 'sanitize_settings'));
  } // register_settings


  // sanitize settings on save
  static function sanitize_settings($values) {
    $old_options = GMW::get_options();

    foreach ($values as $key => $value) {
      switch ($key) {
        case 'api_key':
          $values[$key] = str_replace(' ', '', $value);
        break;
      } // switch
    } // foreach

    if (strlen($values['api_key']) < 30) {
      add_settings_error(GMW::$options, 'api_key', __('Google Maps API key is not valid. Access <a href="https://console.developers.google.com/project">Google Developers Console</a> to generate a key for free.', 'google-maps-widget'), 'error');
    }

    return array_merge($old_options, $values);
  } // sanitize_settings


  // return default options
  static function default_options() {
    $defaults = array('sc_map'               => 'gmw',
                      'api_key'              => '',
                      'track_ga'             => '0',
                      'include_jquery'       => '1',
                      'include_gmaps_api'    => '1',
                      'include_lightbox_js'  => '1',
                      'include_lightbox_css' => '1',
                      'disable_tooltips'     => '0',
                      'disable_sidebar'      => '0',
                      'activation_code'      => '',
                      'license_active'       => '',
                      'license_expires'      => '',
                      'license_type'         => ''
                     );

    return $defaults;
  } // default_settings


  // get plugin's options
  static function get_options() {
    $options = get_option(GMW::$options, array());

    if (!is_array($options)) {
      $options = array();
    }
    $options = array_merge(GMW::default_options(), $options);

    return $options;
  } // get_options


  // update and set one or more options
  static function set_options($new_options) {
    if (!is_array($new_options)) {
      return false;
    }

    $options = GMW::get_options();
    $options = array_merge($options, $new_options);

    update_option(GMW::$options, $options);

    return $options;
  } // set_options


  // add widgets link to plugins page
  static function plugin_action_links($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=gmw_options') . '" title="' . __('Settings for Google Maps Widget', 'google-maps-widget') . '">' . __('Settings', 'google-maps-widget') . '</a>';
    $widgets_link = '<a href="' . admin_url('widgets.php') . '" title="' . __('Configure Google Maps Widget for your theme', 'google-maps-widget') . '">' . __('Widgets', 'google-maps-widget') . '</a>';

    array_unshift($links, $settings_link);
    array_unshift($links, $widgets_link);

    return $links;
  } // plugin_action_links


  // add links to plugin's description in plugins table
  static function plugin_meta_links($links, $file) {
    $documentation_link = '<a target="_blank" href="http://www.gmapswidget.com/documentation/" title="' . __('View Google Maps Widget documentation', 'google-maps-widget') . '">'. __('Documentation', 'google-maps-widget') . '</a>';
    $support_link = '<a target="_blank" href="http://wordpress.org/support/plugin/google-maps-widget" title="' . __('Problems? We are here to help!', 'google-maps-widget') . '">' . __('Support', 'google-maps-widget') . '</a>';
    $review_link = '<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/google-maps-widget?filter=5#pages" title="' . __('If you like it, please review the plugin', 'google-maps-widget') . '">' . __('Review the plugin', 'google-maps-widget') . '</a>';
    $activate_link = '<a href="' . esc_url(admin_url('options-general.php?page=gmw_options&gmw_open_promo_dialog')) . '">' . __('Activate PRO features', 'google-maps-widget') . '</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $documentation_link;
      $links[] = $support_link;
      $links[] = $review_link;
      if (!GMW::is_activated()) {
        $links[] = $activate_link;
      }
    }

    return $links;
  } // plugin_meta_links


  // check if user has the minimal WP version required by GMW
  static function check_wp_version($min_version) {
    if (!version_compare(get_bloginfo('version'), $min_version,  '>=')) {
        add_action('admin_notices', array('GMW', 'notice_min_version_error'));
        return false;
    }

    return true;
  } // check_wp_version


  // display error message if WP version is too low
  static function notice_min_version_error() {
    echo '<div class="error"><p>' . sprintf(__('Google Maps Widget <b>requires WordPress version 4.0</b> or higher to function properly. You are using WordPress version %s. Please <a href="%s">update it</a>.', 'google-maps-widget'), get_bloginfo('version'), admin_url('update-core.php')) . '</p></div>';
  } // notice_min_version_error


  // get users maps api key or one of temporary plugin ones
  static function get_api_key($type = 'static') {
    $options = GMW::get_options();
    $default_api_keys = array('AIzaSyDlGWq9fCAJopqM0FakFvUWH0J52-tr3UM',
                              'AIzaSyA57MZ9B2Tez5JOTsnKFdzc-wi2A_pNOng',
                              'AIzaSyDucyTgTfcvoP7BUYo9xdy9mk9QS0WTIe0',
                              'AIzaSyBkMYtzfCn08icKNrr_-XySw7o8Bky0P94',
                              'AIzaSyBhFAsR3i68B_i_uta8Dq8RiBKl8TvjhI0',
                              'AIzaSyD5a9xsEzMRP1kBsSpeOq24iRBS04juDK4',
                              'AIzaSyDxqnkk_83SF6c5uvIIIZwILR51DlH1XY8',
                              'AIzaSyB2B_Kdw8afRUo2vd4wxCx1puD3QU0NnM8',
                              'AIzaSyAAznHhsGtU4J4ua8btTu_qHH2KBngDT3A',
                              'AIzaSyAMdoX_dkbALmUcN6vXazWXRoMz-gG8lVI',
                              'AIzaSyBvCK51-6tqdH0gu_lsUK8SxlGrvfUzIfo',
                              'AIzaSyBgRQXLrwhx6Gh8OS8B89Dzgy7vWHHaZY8',
                              'AIzaSyAafHqw4pT9u7LH3uW7NAj5gsLx9MzJrhc',
                              'AIzaSyDkIvwEd4xKBJFhBjJ3nnW6at8N8HeqLso',
                              'AIzaSyAi0nz2wyFAGU2jy3x_WsEZ-OCYqWFeS5Q',
                              'AIzaSyCyD5k7KE2BqpCVoy4dPACJdjvRr2n5ofE');

	  if ($type == 'test' && strlen($options['api_key']) < 30) {
      return false;
    }

    if (!empty($options['api_key'])) {
      return $options['api_key'];
    } else {
      shuffle($default_api_keys);
      return $default_api_keys[0];
    }
  } // get_api_key


  // checkes if API key is active for all needed API services
  static function test_api_key_ajax() {
    check_ajax_referer('gmw_test_api_key');

    $msg = '';
    $error = false;
    $api_key = trim(@$_GET['api_key']);

    $test = wp_remote_get(esc_url_raw('https://maps.googleapis.com/maps/api/staticmap?center=new+york+usa&size=100x100&key=' . $api_key));
    if (wp_remote_retrieve_response_message($test) == 'OK') {
      $msg .= 'Google Static Maps API test - OK' . "\n";
    } else {
      $msg .= 'Google Static Maps API test - FAILED' . "\n";
      $error = true;
    }

    $test = wp_remote_get(esc_url_raw('https://www.google.com/maps/embed/v1/place?q=new+york+usa&key=' . $api_key));
    if (wp_remote_retrieve_response_message($test) == 'OK') {
      $msg .= 'Google Embed Maps API test - OK' . "\n\n";
    } else {
      $msg .= 'Google Embed Maps API test - FAILED' . "\n\n";
      $error = true;
    }

    if ($error) {
      $msg .= 'Something is not right. Please read the instruction below on how to generate the API key and double-check everything.';
    } else {
      $msg = 'The API key is OK! Don\'t forget to save it ;)';
    }

    wp_send_json_success($msg);
  } // test_api_key


  // build a complete URL for the iframe map
  static function build_lightbox_url($widget) {
    $map_params = array();

    if ($widget['lightbox_mode'] == 'place') {
      $map_params['q'] = $widget['address'];
      $map_params['attribution_source'] = get_bloginfo('name')? get_bloginfo('name'): 'Google Maps Widget';
      $map_params['attribution_web_url'] = get_home_url();
      $map_params['attribution_ios_deep_link_id'] = 'comgooglemaps://?daddr=' . $widget['address'];
      $map_params['maptype'] = $widget['lightbox_map_type'];
      $map_params['zoom'] = $widget['lightbox_zoom'];
    } elseif ($widget['lightbox_mode'] == 'directions') {
      $map_params['origin'] = $widget['lightbox_origin'];
      $map_params['destination'] = $widget['address'];
      $map_params['maptype'] = $widget['lightbox_map_type'];
      if (!empty($widget['lightbox_unit']) && $widget['lightbox_unit'] != 'auto') {
        $map_params['units'] = $widget['lightbox_unit'];
      }
      if ($widget['lightbox_zoom'] != 'auto') {
        $map_params['zoom'] = $widget['lightbox_zoom'];
      }
    } elseif ($widget['lightbox_mode'] == 'search') {
      if (($coordinates = GMW::get_coordinates($widget['address'])) !== false) {
        $map_params['center'] = $coordinates['lat'] . ',' . $coordinates['lng'];
      }
      $map_params['q'] = $widget['lightbox_search'];
      $map_params['maptype'] = $widget['lightbox_map_type'];
      if ($widget['lightbox_zoom'] != 'auto') {
        $map_params['zoom'] = $widget['lightbox_zoom'];
      }
    } elseif ($widget['lightbox_mode'] == 'view') {
      if (($coordinates = GMW::get_coordinates($widget['address'])) !== false) {
        $map_params['center'] = $coordinates['lat'] . ',' . $coordinates['lng'];
      }
      $map_params['maptype'] = $widget['lightbox_map_type'];
      if ($widget['lightbox_zoom'] != 'auto') {
        $map_params['zoom'] = $widget['lightbox_zoom'];
      }
    } elseif ($widget['lightbox_mode'] == 'streetview') {
      if (($coordinates = GMW::get_coordinates($widget['address'])) !== false) {
        $map_params['location'] = $coordinates['lat'] . ',' . $coordinates['lng'];
      }
      $map_params['heading'] = $widget['lightbox_heading'];
      $map_params['pitch'] = $widget['lightbox_pitch'];
    }

    if ($widget['lightbox_lang'] != 'auto') {
      $map_params['language'] = $widget['lightbox_lang'];
    }
    $map_params['key'] = GMW::get_api_key('embed');

    $map_url = 'https://www.google.com/maps/embed/v1/' . $widget['lightbox_mode'] . '?';
    $map_url .= http_build_query($map_params, null, '&amp;');

    return $map_url;
  } // build_lightbox_url


  // fetch coordinates based on the address
  static function get_coordinates($address, $force_refresh = false) {
    $address_hash = md5('gmw_' . $address);

    if ($force_refresh || ($data = get_transient($address_hash)) === false) {
      $url = 'https://maps.googleapis.com/maps/api/geocode/xml?address=' . urlencode($address) . '&key=' . GMW::get_api_key('fallback');
      $result = wp_remote_get(esc_url_raw($url), array('sslverify' => false, 'timeout' => 10));

      if (!is_wp_error($result) && $result['response']['code'] == 200) {
        $data = new SimpleXMLElement($result['body']);

        if ($data->status == 'OK') {
          $cache_value['lat']     = (string) $data->result->geometry->location->lat;
          $cache_value['lng']     = (string) $data->result->geometry->location->lng;
          $cache_value['address'] = (string) $data->result->formatted_address;

          // cache coordinates for 2 months
          set_transient($address_hash, $cache_value, MONTH_IN_SECONDS * 2);
          $data = $cache_value;
          $data['cached'] = false;
        } elseif (!$data->status) {
          return false;
        } else {
          return false;
        }
      } else {
         return false;
      }
    } else {
       // data is cached
       $data['cached'] = true;
    }

    return $data;
  } // get_coordinates


  // print dialogs markup in footer
  static function dialogs_markup() {
     $out = '';
     $js_vars = array();
     $measure_title = array('dark');

     if (empty(GoogleMapsWidget::$widgets)) {
       return;
     }

     // add CSS and JS in footer
     $js_vars['colorbox_css'] = GMW_PLUGIN_URL . 'css/gmw.css' . '?ver=' . GMW::$version;
     wp_enqueue_script('gmw-colorbox');
     wp_enqueue_script('gmw');
     wp_localize_script('gmw', 'gmw_data', $js_vars);

     foreach (GoogleMapsWidget::$widgets as $widget) {
       $map_url = GMW::build_lightbox_url($widget);

       if ($widget['lightbox_fullscreen']) {
         $widget['lightbox_width'] = '100%';
         $widget['lightbox_height'] = '100%';
       }

       $out .= '<div class="gmw-dialog" style="display: none;" data-map-height="' . $widget['lightbox_height'] . '"
                data-map-width="' . $widget['lightbox_width'] . '" data-thumb-height="' . $widget['thumb_height'] . '"
                data-thumb-width="' . $widget['thumb_width'] . '" data-map-skin="' . $widget['lightbox_skin'] . '"
                data-map-iframe-url="' . $map_url . '" id="gmw-dialog-' . $widget['id'] . '" title="' . esc_attr($widget['title']) . '"
                data-close-button="' . (int) in_array('close_button', $widget['lightbox_feature']) . '"
                data-show-title="' . (int) in_array('title', $widget['lightbox_feature']) . '"
                data-measure-title="' . (int) in_array($widget['lightbox_skin'], $measure_title) . '"
                data-close-overlay="' . (int) in_array('overlay_close', $widget['lightbox_feature']) . '"
                data-close-esc="' . (int) in_array('esc_close', $widget['lightbox_feature']) . '">';
       if ($widget['lightbox_header']) {
         $tmp = str_ireplace(array('{address}'), array($widget['address']), $widget['lightbox_header']);
         $out .= '<div class="gmw-header">' . wpautop(do_shortcode($tmp)) . '</div>';
       }
       $out .= '<div class="gmw-map"></div>';
       if ($widget['lightbox_footer']) {
         $tmp = str_ireplace(array('{address}'), array($widget['address']), $widget['lightbox_footer']);
         $out .= '<div class="gmw-footer">' . wpautop(do_shortcode($tmp)) . '</div>';
       }
       $out .= "</div>\n";
     } // foreach $widgets

     echo $out;
  } // dialogs_markup


  // add plugin menus
  static function add_menus() {
    $title = __('Google Maps Widget', 'google-maps-widget');
    add_options_page($title, $title, 'manage_options', GMW::$options, array('GMW', 'settings_screen'));
  } // add_menus


  // handle dismiss button for notices
  static function dismiss_notice() {
    if (empty($_GET['notice'])) {
      wp_redirect(admin_url());
      exit;
    }

    if ($_GET['notice'] == 'upgrade') {
      GMW::set_options(array('dismiss_notice_upgrade2' => true));
    }
    if ($_GET['notice'] == 'rate') {
      GMW::set_options(array('dismiss_notice_rate' => true));
    }
    if ($_GET['notice'] == 'api_key') {
      GMW::set_options(array('dismiss_notice_api_key' => true));
    }
    if ($_GET['notice'] == 'olduser') {
      GMW::set_options(array('dismiss_notice_olduser' => true));
    }

    if (!empty($_GET['redirect'])) {
      wp_redirect($_GET['redirect']);
    } else {
      wp_redirect(admin_url());
    }

    exit;
  } // dismiss_notice


  // controls which notices are shown
  static function add_notices() {
    $options = GMW::get_options();
    $notice = false;

    // upgrade notice is shown after install
    if (!$notice && empty($options['dismiss_notice_upgrade2']) &&
       !GMW::is_activated() &&
       (current_time('timestamp') - $options['first_install']) > 2) {
      add_action('admin_notices', array('GMW', 'notice_upgrade'));
      $notice = true;
    } // show upgrade notice

    // API key notification is shown only on GMW settings page
    if (!GMW::get_api_key('test') && GMW::is_plugin_admin_page('settings')) {
      add_action('admin_notices', array('GMW', 'notice_api_key'));
      $notice = true;
    } // show api key notice

    // rating notification is shown after 7 days if you have active widgets
    if (!$notice && empty($options['dismiss_notice_rate']) &&
        GMW_tracking::count_active_widgets() > 0 &&
        (current_time('timestamp') - $options['first_install']) > (DAY_IN_SECONDS * 3)) {
      add_action('admin_notices', array('GMW', 'notice_rate_plugin'));
      $notice = true;
    } // show rate notice

    // tracking notification is shown after 20 days
    // disabled - will be completely removed soon
    if (false && !$notice && !isset($options['allow_tracking']) &&
        GMW::is_plugin_admin_page('widgets') &&
        ((current_time('timestamp') - $options['first_install']) > (DAY_IN_SECONDS * 20))) {
      add_action('admin_notices', array('GMW_tracking', 'tracking_notice'));
      $notice = true;
    } // show tracking notice

    // upsell to old users
    if (!$notice && empty($options['dismiss_notice_olduser']) &&
        ((current_time('timestamp') - $options['first_install']) > (DAY_IN_SECONDS * 60))) {
      add_action('admin_notices', array('GMW', 'notice_olduser'));
      $notice = true;
    } // upsell to old users
  } // add_notices


  // display message to get pro features for GMW
  static function notice_upgrade() {
    $promo_delta = HOUR_IN_SECONDS - 2;
    $options = GMW::get_options();
    $activate_url = admin_url('options-general.php?page=gmw_options&gmw_open_promo_dialog');
    $dismiss_url = add_query_arg(array('action' => 'gmw_dismiss_notice', 'notice' => 'upgrade', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php'));

    echo '<div id="gmw_activate_notice" class="updated notice"><p>' . __('<b>Google Maps Widget <span style="color: #d54e21;">PRO</span></b> has more than 50 extra features &amp; options. Our support is super fast &amp; friendly and with the unlimited license you can install GMW on as many sites as you need.</p>', 'google-maps-widget');

    if (current_time('timestamp') - $options['first_install'] < $promo_delta) {
      $delta = $options['first_install_gmt'] + $promo_delta - time();
      $h = $delta / 3600 % 24;
      if ($h) {
        $h .= 'h';
      } else {
        $h = '';
      }
      $min = $delta / 60 % 60;
      echo '<p>We\'ve prepared a special <b>20% welcoming discount</b> available only for another <b class="gmw-countdown" data-endtime="' . ($options['first_install_gmt'] + $promo_delta) . '" style="font-weight: bold;">' . $h . ' ' . $min . 'min</b>.</p>';
      echo '<p><a href="' . esc_url($activate_url) . '" style="vertical-align: baseline; margin-top: 15px;" class="button-primary"><b>Get a lifetime PRO license now for only $23 - LIMITED OFFER!</b></a>';
    } else {
      echo '<p><a href="' . esc_url($activate_url) . '" style="vertical-align: baseline; margin-top: 15px;" class="button-primary">' . __('See what PRO has to offer', 'google-maps-widget') . '</a>';
    }

    echo '&nbsp;&nbsp;<a href="' . esc_url($dismiss_url) . '" class="">' . __('I\'m not interested (remove notice)', 'google-maps-widget') . '</a>';
    echo '</p></div>';
  } // notice_activate_extra_features


  // display message to get pro features for GMW
  static function notice_olduser() {
    $options = GMW::get_options();
    $activate_url = admin_url('options-general.php?page=gmw_options&gmw_open_promo_dialog');
    $dismiss_url = add_query_arg(array('action' => 'gmw_dismiss_notice', 'notice' => 'olduser', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php'));

    echo '<div class="updated notice">';
    echo '<p style="font-size: 14px;">We have a <a class="open_promo_dialog" href="' . $activate_url . '">special offer</a> only for users like <b>you</b> who\'ve been using Google Maps Widget for over two months: a <b>one time payment</b>, lifetime license for <b>only $23</b>! No nonsense!<br><a class="open_promo_dialog" href="' . $activate_url . '">Upgrade now</a> to <span class="gmw-pro-red">PRO</span> &amp; get more than 50 extra options &amp; features. License is valid for 3 sites.</p><br>';

    echo '<a class="open_promo_dialog button button-primary" href="' . $activate_url . '"><b>Grab the limited offer!</b></a>&nbsp;&nbsp;<a href="' . esc_url($dismiss_url) . '" style="margin: 3px 0 0 5px; display: inline-block;">' . __('I\'m not interested (remove notice)', 'google-maps-widget') . '</a>';
    echo '</p></div>';
  } // notice_olduser


  // display message to rate plugin
  static function notice_rate_plugin() {
    $rate_url = 'https://wordpress.org/support/view/plugin-reviews/google-maps-widget?rate=5#postform';
    $dismiss_url = add_query_arg(array('action' => 'gmw_dismiss_notice', 'notice' => 'rate', 'redirect' => urlencode($_SERVER['REQUEST_URI'])), admin_url('admin.php'));

    echo '<div id="gmw_rate_notice" class="updated notice"><p>' . __('Hi! We saw you\'ve been using <b>Google Maps Widget</b> for a week and wanted to ask for your help to make the plugin better.<br>We just need a minute of your time to rate the plugin. Thank you!', 'google-maps-widget');

    echo '<br><a target="_blank" href="' . esc_url($rate_url) . '" style="vertical-align: baseline; margin-top: 15px;" class="button-primary">' . __('Help make the plugin better by rating it', 'google-maps-widget') . '</a>';
    echo '&nbsp;&nbsp;<a href="' . esc_url($dismiss_url) . '">' . __('I already rated the plugin', 'google-maps-widget') . '</a>';
    echo '</p></div>';
  } // notice_rate_plugin


  // display message to enter API key
  static function notice_api_key() {
    echo '<div id="gmw_api_key_notice" class="error notice"><p>';
    echo '<b>Important!</b> Google rules dictate that you have to register for a <b>free Google Maps API key</b>. ';
    echo 'Please follow our <a href="http://www.gmapswidget.com/documentation/generate-google-maps-api-key/" target="_blank">short instructions</a> to get the key. If you don\'t configure the API key the maps will not work properly.';
    echo '</p></div>';
  } // notice_api_key


  // register frontend scripts and styles
  static function register_scripts() {
    wp_register_style('gmw', GMW_PLUGIN_URL . 'css/gmw.css', array(), GMW::$version);

    wp_register_script('gmw-colorbox', GMW_PLUGIN_URL . 'js/jquery.colorbox.min.js', array('jquery'), GMW::$version, true);
    wp_register_script('gmw', GMW_PLUGIN_URL . 'js/gmw.js', array('jquery'), GMW::$version, true);
  } // register_scripts


  // enqueue CSS and JS scripts in admin
  static function admin_enqueue_scripts() {
    $js_localize = array('dialog_map_title' => __('Pick an address by drag &amp; dropping the pin', 'google-maps-widget'),
                         'undocumented_error' => __('An undocumented error has occured. Please refresh the page and try again.', 'google-maps-widget'),
                         'bad_api_key' => __('The API key format does not look right. Please double-check it.', 'google-maps-widget'),
                         'dialog_promo_title' => '<img alt="' . __('Google Maps Widget PRO', 'google-maps-widget') . '" title="' . __('Google Maps Widget PRO', 'google-maps-widget') . '" src="' . GMW_PLUGIN_URL . 'images/gmw-logo-pro-dialog.png' . '">',
                         'dialog_pins_title' => __('Pins Library', 'google-maps-widget'),
                         'plugin_name' => __('Google Maps Widget', 'google-maps-widget'),
                         'id_base' => 'googlemapswidget',
                         'map_picker_not_active' => __('Drag&drop address picking interface is a PRO feature. Interested in switching to PRO?', 'google-maps-widget'),
                         'customizer_address_picker' => __('At the moment, the address picker is not available in the theme customizer. Please use it in the admin widget GUI.', 'google-maps-widget'),
                         'customizer_pro_dialog' => __('To see what the PRO version offers please open GMW settings in the admin.', 'google-maps-widget'),
                         'map' => false,
                         'marker' => false,
                         'settings_url' => admin_url('options-general.php?page=gmw_options'),
                         'nonce_test_api_key' => wp_create_nonce('gmw_test_api_key'),
                         'nonce_activate_license_key' => wp_create_nonce('gmw_activate_license_key'),
                         'nonce_get_trial' => wp_create_nonce('gmw_get_trial'),
                         'deactivate_confirmation' => __('Are you sure you want to deactivate Google Maps Widget?' . "\n" . 'All maps will be removed from the site. If you are removing it because of a problem please contact our support. They will be more than glad to help.', 'google-maps-widget'));

    if (GMW::is_plugin_admin_page('widgets') || GMW::is_plugin_admin_page('settings') || is_customize_preview()) {
      wp_enqueue_script('jquery-ui-tabs');
      wp_enqueue_script('jquery-ui-dialog');
      wp_enqueue_script('wp-pointer');
      wp_enqueue_script('gmw-gmap', '//maps.google.com/maps/api/js?key=' . GMW::get_api_key('fallback'), array(), GMW::$version, true);
      wp_enqueue_script('gmw-select2', GMW_PLUGIN_URL . 'js/select2.min.js', array('jquery'), GMW::$version, true);
      wp_enqueue_script('gmw-admin', GMW_PLUGIN_URL . 'js/gmw-admin.js', array('jquery'), GMW::$version, true);

      wp_enqueue_style('wp-jquery-ui-dialog');
      wp_enqueue_style('wp-pointer');
      wp_enqueue_style('gmw-select2', GMW_PLUGIN_URL . 'css/select2.min.css', array(), GMW::$version);
      wp_enqueue_style('gmw-admin', GMW_PLUGIN_URL . 'css/gmw-admin.css', array(), GMW::$version);

      wp_localize_script('gmw-admin', 'gmw', $js_localize);

      // fix for agressive plugins
      wp_dequeue_style('uiStyleSheet');
      wp_dequeue_style('wpcufpnAdmin' );
      wp_dequeue_style('unifStyleSheet' );
      wp_dequeue_style('wpcufpn_codemirror');
      wp_dequeue_style('wpcufpn_codemirrorTheme');
      wp_dequeue_style('collapse-admin-css');
      wp_dequeue_style('jquery-ui-css');
      wp_dequeue_style('tribe-common-admin');
      wp_dequeue_style('file-manager__jquery-ui-css');
      wp_dequeue_style('file-manager__jquery-ui-css-theme');
      wp_dequeue_style('wpmegmaps-jqueryui');
      wp_dequeue_style('facebook-plugin-css');
      wp_dequeue_style('facebook-tip-plugin-css');
      wp_dequeue_style('facebook-member-plugin-css');
      wp_dequeue_style('jquery-ui-tooltip-css');
      wp_dequeue_style('social_warfare_admin');
    } // if

    if (GMW::is_plugin_admin_page('plugins')) {
      wp_enqueue_script('gmw-admin-plugins', GMW_PLUGIN_URL . 'js/gmw-admin-plugins.js', array('jquery'), GMW::$version, true);
      wp_localize_script('gmw-admin-plugins', 'gmw', $js_localize);
    }


    $pointers = get_transient('gmw_pointers');
    if ($pointers && !GMW::is_plugin_admin_page('widgets')) {
      $pointers['_nonce_dismiss_pointer'] = wp_create_nonce('gmw_dismiss_pointer');
      wp_enqueue_script('wp-pointer');
      wp_enqueue_script('gmw-pointers', plugins_url('js/gmw-admin-pointers.js', __FILE__), array('jquery'), self::$version, true);
      wp_enqueue_style('wp-pointer');
      wp_localize_script('wp-pointer', 'gmw_pointers', $pointers);
    }
  } // admin_enqueue_scripts


  // reset all pointers to default state - visible
  static function reset_pointers() {
    $pointers = array();
    $pointers['welcome'] = array('target' => '#menu-appearance', 'edge' => 'left', 'align' => 'right', 'content' => 'Thank you for installing <b>Google Maps Widget</b>! Please open <a href="' . admin_url('widgets.php'). '">Appearance - Widgets</a> to create your first map in seconds.');

    set_transient('gmw_pointers', $pointers, 60 * DAY_IN_SECONDS);
  } // reset_pointers


  // permanently dismiss a pointer
  static function dismiss_pointer_ajax() {
    check_ajax_referer('gmw_dismiss_pointer');

    $pointers = get_transient('gmw_pointers');
    $pointer = trim($_POST['pointer']);

    if (empty($pointers) || empty($pointers[$pointer])) {
      wp_send_json_error();
    }

    unset($pointers[$pointer]);
    set_transient('gmw_pointers', $pointers);

    wp_send_json_success();
  } // dismiss_pointer_ajax


  // check if plugin's admin page is shown
  static function is_plugin_admin_page($page = 'widgets') {
    $current_screen = get_current_screen();

    if ($page == 'widgets' && $current_screen->id == 'widgets') {
      return true;
    }

    if ($page == 'settings' && $current_screen->id == 'settings_page_gmw_options') {
      return true;
    }

    if ($page == 'plugins' && $current_screen->id == 'plugins') {
      return true;
    }

    return false;
  } // is_plugin_admin_page


  // check if license key is valid and not expired
  static function is_activated() {
    $options = GMW::get_options();

    if (isset($options['license_active']) && $options['license_active'] === true &&
        isset($options['license_expires']) && $options['license_expires'] >= date('Y-m-d')) {
      return true;
    } else {
      return false;
    }
  } // is_activated


  // check if activation code is valid
  static function validate_activation_code($code) {
    $request_params = array('sslverify' => false, 'timeout' => 15, 'redirection' => 2);
    $request_args = array('action' => 'validate_license',
                          'code' => $code,
                          'codebase' => 'free',
                          'version' => GMW::$version,
                          'site' => get_home_url());

    $out = array('success' => false, 'license_active' => false, 'activation_code' => $code, 'error' => '', 'license_type' => '', 'license_expires' => '1900-01-01');

    $url = add_query_arg($request_args, GMW::$licensing_servers[0]);
    $response = wp_remote_get(esc_url_raw($url), $request_params);

    if (is_wp_error($response) || !wp_remote_retrieve_body($response)) {
      $url = add_query_arg($request_args, GMW::$licensing_servers[1]);
      $response = wp_remote_get(esc_url_raw($url), $request_params);
    }

    if (!is_wp_error($response) && wp_remote_retrieve_body($response)) {
      $result = json_decode(wp_remote_retrieve_body($response), true);
      if (is_array($result['data']) && sizeof($result['data']) == 4) {
        $out['success'] = true;
        $out = array_merge($out, $result['data']);
      } else {
        $out['error'] = 'Invalid response from licensing server. Please try again later.';
      }
    } else {
      $out['error'] = 'Unable to contact licensing server. Please try again in a few moments.';
    }

    return $out;
  } // validate_activation_code


  // echo markup for promo dialog; only on widgets page
  static function admin_dialogs_markup() {
    $out = '';
    $options = GMW::get_options();
    $promo_delta = 1 * HOUR_IN_SECONDS - 5;
    $promo_active = (bool) ((current_time('timestamp') - $options['first_install']) < $promo_delta);
    $promo_active2 = (bool) ((current_time('timestamp') - $options['first_install']) > DAY_IN_SECONDS * 45);

    if (GMW::is_plugin_admin_page('widgets') || GMW::is_plugin_admin_page('settings')) {
      $current_user = wp_get_current_user();
      if (empty($current_user->user_firstname)) {
        $name = $current_user->display_name;
      } else {
        $name = $current_user->user_firstname;
      }

      $out .= '<div id="gmw_promo_dialog" style="display: none;">';

      $out .= '<div id="gmw_dialog_intro" class="gmw_promo_dialog_screen">
               <div class="content">
                  <div class="header"><p><a href="#" class="gmw_goto_pro">Learn more</a> about <span class="gmw-pro">PRO</span> features or <a href="#" class="gmw_goto_activation">enter your license key</a></p>';
      if ($promo_active) {
        $delta = $options['first_install_gmt'] + $promo_delta - time();
        $h = $delta / 3600 % 24;
        $min = $delta / 60 % 60;
        $out .= '<div class="gmw-discount">We\'ve prepared a special <b>20% welcoming discount</b> available only for another <b class="gmw-countdown" data-endtime="' . ($options['first_install_gmt'] + $promo_delta) . '">' . $h . 'h ' . $min . 'min 0sec</b>. Discounts have been applied on the licenses below.</div>';
      }
      $out .= '</div>'; // header

      $out .= '<table id="gmw-pricing-table">';
      $out .= '<colgroup></colgroup><colgroup></colgroup><colgroup></colgroup>';
      $out .= '<tr>';
      $out .= '<td><div class="gmw-promo-icon"><img src="' . GMW_PLUGIN_URL . 'images/icon-agency.png" alt="Unlimited Agency Lifetime License" title="Unlimited Agency Lifetime License"></div><h3>Unlimited<br>Agency License</h3></td>';
      $out .= '<td><div class="gmw-promo-icon"><img src="' . GMW_PLUGIN_URL . 'images/icon-unlimited.png" alt="Lifetime Personal License" title="Lifetime Personal License"></div><h3>Lifetime<br>Personal License</h3></td>';
      $out .= '<td><div class="gmw-promo-icon"><img src="' . GMW_PLUGIN_URL . 'images/icon-yearly.png" alt="Yearly License" title="Yearly License"></div><h3>Single<br>Site License</h3></td>';
      $out .= '</tr>';
      $out .= '<tr>';
      $out .= '<td>One Time Payment</td>';
      $out .= '<td><span class="dashicons dashicons-yes"></span> One Time Payment</td>';
      $out .= '<td>Yearly Payment</td>';
      $out .= '</tr>';
      $out .= '<tr>';
      $out .= '<td>Unlimited Client &amp; Personal Sites</td>';
      $out .= '<td><span class="dashicons dashicons-yes"></span> 3 Personal Sites</td>';
      $out .= '<td>1 Personal or Client Site</td>';
      $out .= '</tr>';
      $out .= '<tr>';
      $out .= '<td>Lifetime Priority Support</td>';
      $out .= '<td><span class="dashicons dashicons-yes"></span> Lifetime Priority Support</td>';
      $out .= '<td>1 Year of Support</td>';
      $out .= '</tr>';
      $out .= '<tr>';
      $out .= '<td>Lifetime Updates</td>';
      $out .= '<td><span class="dashicons dashicons-yes"></span> Lifetime Updates</td>';
      $out .= '<td>1 Year of Updates</td>';
      $out .= '</tr>';
      $out .= '<tr>';
      $out .= '<td>';
      if ($promo_active) {
        $out .= '<div class="gmw-promo-button gmw-promo-button-extra"><a href="http://www.gmapswidget.com/buy/?p=pro-agency-welcome&r=welcome-GMW+v' . GMW::$version . '" target="_blank">only <strike>$79</strike> $54</a><span>discount: 32%</span></div>';
      } else {
        $out .= '<div class="gmw-promo-button"><a href="http://www.gmapswidget.com/buy/?p=pro-agency&r=GMW+v' . GMW::$version . '" data-noprevent="1" target="_blank">BUY $79</a></div>';
      }
      $out .= '<span class="instant-download"><span class="dashicons dashicons-yes"></span> 100% No-Risk Money Back Guarantee<br><span class="dashicons dashicons-yes"></span> Secure payment<br><span class="dashicons dashicons-yes"></span> Instant activation</span>';
      $out .= '</td>';
      $out .= '<td>';
      if ($promo_active) {
        $out .= '<div class="gmw-promo-button gmw-promo-button-extra"><a href="http://www.gmapswidget.com/buy/?p=pro-welcome3&r=welcome-GMW+v' . GMW::$version . '" target="_blank">only <strike>$29</strike> $23</a><span>discount: 20%</span></div>';
      } elseif ($promo_active2) {
        $out .= '<div class="gmw-promo-button gmw-promo-button-extra"><a href="http://www.gmapswidget.com/buy/?p=olduser2&r=olduser-GMW+v' . GMW::$version . '" target="_blank">only <strike>$29</strike> $23</a><span>discount: 20%</span></div>';
      } else {
        $out .= '<div class="gmw-promo-button"><a href="http://www.gmapswidget.com/buy/?p=pro-unlimited2&r=GMW+v' . GMW::$version . '" data-noprevent="1" target="_blank">BUY $29</a></div>';
      }
      $out .= '<span class="instant-download"><span class="dashicons dashicons-yes"></span> 100% No-Risk Money Back Guarantee<br><span class="dashicons dashicons-yes"></span> Secure payment<br><span class="dashicons dashicons-yes"></span> Instant activation</span>';
      $out .= '</td>';
      $out .= '<td><div class="gmw-promo-button"><a href="http://www.gmapswidget.com/buy/?p=yearly2&r=GMW+v' . GMW::$version . '" data-noprevent="1" target="_blank">$19 <small>/year</small></a></div>';
      $out .= '<span class="instant-download"><span class="dashicons dashicons-yes"></span> 100% No-Risk Money Back Guarantee<br><span class="dashicons dashicons-yes"></span> Secure payment<br><span class="dashicons dashicons-yes"></span> Instant activation</span>';
      $out .= '</td>';
      $out .= '</tr>';
      $out .= '</table>';

      $out .= '</div></div>'; // dialog intro

      $out .= '<div id="gmw_dialog_activate" style="display: none;" class="gmw_promo_dialog_screen">';
      $out .= '<div class="content">';

      if (GMW::is_activated()) {
        $visible = ' style="display: none;"';
      } else {
        $visible = '';
      }
      $out .= '<div class="before_activate" ' . $visible . '><p class="input_row">
                 <input type="text" id="gmw_code" name="gmw_code" placeholder="Please enter the license key">
                 <span style="display: none;" class="error gmw_code">Unable to verify license key. Unknown error.</span></p>
                 <p class="center">
                   <a href="#" class="button button-primary" id="gmw_activate">Activate PRO features</a>
                 </p>
                 <p class="center">If you don\'t have a license key - <a href="#" class="gmw_goto_intro">Get it now</a></p>
               </div>';


      if (!GMW::is_activated()) {
        $visible = ' style="display: none;"';
      } else {
        $visible = '';
      }
      $plugin = plugin_basename(__FILE__);
      $update_url = wp_nonce_url(admin_url('update.php?action=upgrade-plugin&amp;plugin=' . urlencode($plugin)), 'upgrade-plugin_' . $plugin );
      $out .= '<div class="after_activate" ' . $visible . '>';
      $out .= '<p class="center">Thank you for purchasing Google Maps Widget <b class="gmw-pro-red">PRO</b>! Your license has been verified and activated.</p><p class="center">Please <b>click the button below</b> to update plugin files to PRO version.</p>';
      $out .= '<p class="center"><a href="' . esc_url($update_url) . '" class="button button-primary">Update Google Maps Widget</a></p>';
      $out .= '</div>';

      $out .= '</div>'; // content
      $out .= '<div class="footer">
                 <ul class="gmw-faq-ul">
                   <li>Having problems paying or you misplaced your key? <a href="mailto:gmw@webfactoryltd.com?subject=Activation%20key%20problem">Email us</a></li>
                   <li>Key not working or can\'t upgrade? Our <a href="mailto:gmw@webfactoryltd.com?subject=Activation%20key%20problem">support</a> is here to help</li>
                 </ul>
               </div>';
      $out .= '</div>'; // activate screen

      $out .= '<div id="gmw_dialog_pro_features" style="display: none;" class="gmw_promo_dialog_screen">
                 <div class="content">';
      $out .= '<h4>See how <span class="gmw-pro-red">PRO</span> features can make your life easier!</h4>';
      $out .= '<div class="features-left">';
      $out .= '<b>Multiple pins support</b><br>';
      $out .= '<ul class="features-list">';
      $out .= '<li>Multiple pins support with per-pin options for appearance &amp; click behaviour</li>
               <li>14 thumbnail &amp; lightbox map skins + create your own fully custom skin</li>
               <li>1500+ map pins</li>
               <li>4 extra map image formats for even faster loading</li>
               <li>replace thumb with interactive map feature</li>
               <li>extra hidden sidebar for easier shortcode handling</li>';
      $out .= '</ul><br><br><b>Complete control over map design</b><br>';
      $out .= '<ul class="features-list">';
      $out .= '<li>19 map skins + build your own skin option</li>
               <li>custom map language option</li>
               <li>4 map modes; directions, view, street & streetview</li>
               <li>fully customizable pin options for thumbnail map</li>
               <li>Advanced cache &amp; fastest loading times</li>
               <li>JS &amp; CSS optimization options</li>';
      $out .= '</ul>';
      $out .= '</div>';
      $out .= '<div class="features-right">';
      $out .= '<b>Advanced options</b><br>';
      $out .= '<ul class="features-list">';
      $out .= '<li>Full control over all pins</li>
               <li>Complete shortcode support</li>
               <li>Clustering support</li>
               <li>Pins grouping &amp; filtering support</li>
               <li>3 additional map link types</li>
               <li>Fullscreen lightbox mode</li>
               <li>Extra lightbox features</li>
               <li>Disable thumbnail map - immediately load interactive map</li>';
      $out .= '</ul><br><br><b>Unrivaled support</b><br>';
      $out .= '<ul class="features-list">
               <li>Clone widget feature</li>
               <li>export & import tools</li>
               <li>Google Analytics integration</li>
               <li>Premium email support</li>
               <li>Continuous updates &amp; new features</li>';
      $out .= '</ul>';
      $out .= '</div>';
      $out .= '  </div>';
      $out .= '<div class="footer">';
      $out .= '<p class="center"><a href="#" class="button-secondary gmw_goto_intro">Go PRO now</a><br>
      Or <a href="#" class="gmw_goto_activation">enter the license key</a> if you already have it.</p>';
      $out .= '</div>';
      $out .= '</div>'; // pro features screen

      $out .= '<div id="gmw_dialog_trial" style="display: none;" class="gmw_promo_dialog_screen">
             <div class="content">';
      if (GMW::is_activated()) {
        $visible = ' style="display: none;"';
      } else {
        $visible = '';
      }
      $out .= '<div class="before_trial" ' . $visible . '>
             <h3>Fill out the form and get your free trial started <b>IMMEDIATELY</b>!</h3>';
      $out .= '<p class="input_row">
                 <input value="' . $name . '" type="text" id="gmw_name" name="gmw_name" placeholder="Your name">
                 <span class="error name" style="display: none;">Please enter your name.</span>
               </p>';
      $out .= '<p class="input_row">
                 <input value="' . $current_user->user_email . '" type="text" name="gmw_email" id="gmw_email" placeholder="Your email address" required="required">
                 <span style="display: none;" class="error email">Please double check your email address.</span>
               </p>';
      $out .= '<p class="center">
                 <a id="gmw_start_trial" href="#" class="button button-primary">Start my 7 days free trial</a>
                 <p class="center">Or <a href="#" class="gmw_goto_intro">go PRO now</a></p>
               </p>';
      $out .= '</div>'; // before_trial

      if (!GMW::is_activated()) {
        $visible = ' style="display: none;"';
      } else {
        $visible = '';
      }
      $plugin = plugin_basename(__FILE__);
      $update_url = wp_nonce_url(admin_url('update.php?action=upgrade-plugin&amp;plugin=' . urlencode($plugin)), 'upgrade-plugin_' . $plugin );
      $out .= '<div class="after_trial" ' . $visible . '>';
      $out .= '<p class="center">Your Google Maps Widget <b class="gmw-pro-red">PRO</b> trial has been activated!</p><p class="center">Please <b>click the button below</b> to update plugin files to PRO version.</p>';
      $out .= '<p class="center"><a href="' . esc_url($update_url) . '" class="button button-primary">Update Google Maps Widget to PRO</a></p>';
      $out .= '</div>';

      $out .= '</div>'; // content

      $out .= '<div class="footer">
                    <ul class="gmw-faq-ul">
                      <li>We\'ll never share your email address</li>
                      <li>We hate spam too, so we never send it</li>
                    </ul>
                  </div>';
      $out .= '</div>'; // trial screen

      $out .= '</div>'; // dialog
    } // promo dialog

    // address picker and pins dialog
    if (GMW::is_plugin_admin_page('widgets')) {
      $out .= '<div id="gmw_map_dialog" style="display: none;">';
      $out .= '<div id="gmw_map_canvas"></div><hr>';
      $out .= '<div id="gmw_map_dialog_footer">';

      $out .= '<p>Address picker is a <b class="gmw-pro-red">PRO</b> feature that gives you the option to easily drag &amp; drop the pin to any location you need and fine-tune its position.  <a class="open_promo_dialog" href="#">Upgrade to PRO</a> to have full control over your pins.</p><input type="hidden" autofocus="autofocus" />';
      $out .= '</div>'; // footer
      $out .= '</div>'; // dialog
    } // address picker and pins dialog if activated

    echo $out;
  } // admin_dialogs_markup


  // complete options screen markup
  static function settings_screen() {
    if (!current_user_can('manage_options')) {
      wp_die('Cheating? You don\'t have the right to access this page.', 'Google Maps Widget', array('back_link' => true));
    }

    $options = GMW::get_options();

    echo '<div class="wrap gmw-options">';
    echo '<h1><img alt="' . __('Google Maps Widget', 'google-maps-widget') . '" title="' . __('Google Maps Widget', 'google-maps-widget') . '" height="55" src="' . GMW_PLUGIN_URL . 'images/gmw-logo.png"></h1>';

    echo '<form method="post" action="options.php">';
    settings_fields(GMW::$options);

    echo '<div id="gmw-settings-tabs"><ul>';
    echo '<li><a href="#gmw-settings">' . __('Settings', 'google-maps-widget') . '</a></li>';
    echo '<li><a href="#gmw-import-pins">' . __('Import pins', 'google-maps-widget') . '</a></li>';
    echo '<li><a href="#gmw-export">' . __('Export &amp; Import', 'google-maps-widget') . '</a></li>';
    echo '<li><a href="#gmw-license">' . __('PRO License', 'google-maps-widget') . '</a></li>';
    echo '</ul>';

    echo '<div id="gmw-import-pins" style="display: none;">';
    if (!GMW::is_activated()) {
      echo '<p>Pins import is one of many <span class="gmw-pro-red">PRO</span> features. <a href="#" class="open_promo_dialog button button-primary">Upgrade now</a> to get access to more than 50 extra options &amp; features.</p>';
    }

    echo '<table class="form-table disabled">';
    echo '<tr>
          <th scope="row"><label for="widget_id">' . __('Google Maps Widget', 'google-maps-widget') . '</label></th>
          <td><select disabled="disabled" name="' . GMW::$options . '[widget_id]" id="widget_id">';
    echo '<option value="">- select the widget to import pins to -</option>';
    echo '</select><br><span class="description">Choose a widget you want to import pins to. Any existing pins will be overwritten with the new pins. Other widget options will not be altered in any way.</span></td></tr>';

    echo '<tr>
          <th scope="row"><label for="pins_txt">' . __('Pins, copy/paste', 'google-maps-widget') . '</label></th>';
    echo '<td><textarea disabled="disabled" style="width: 500px;" rows="3" name="' . GMW::$options . '[pins_txt]" id="pins_txt">';
    echo '</textarea><br><span class="description">Data has to be formatted in a CSV fashion. One pin per line, individual fields double quoted and separated by a comma. All fields have to be included.<br>
    Please refer to the <a href="https://www.gmapswidget.com/documentation/importing-pins/" target="_blank">detailed documentation article</a> or grab the <a href="https://www.gmapswidget.com/wp-content/uploads/2018/02/sample-pins-import.csv" target="_blank">sample import file and modify it.</span></td></tr>';

    echo '<tr>
          <th scope="row"><label for="pins_file">' . __('Pins, upload file', 'google-maps-widget') . '</label></th>';
    echo '<td><input type="file" disabled="disabled" name="pins_file" id="pins_file">';
    echo '<br><span class="description">See rules noted for the field above.</span></td></tr>';

    echo '<tr>
        <th scope="row" colspan="2"><input disabled="disabled" type="submit" name="submit-import-pins" id="submit-import-pins" class="button button-primary button-large" value="Import pins"><br><i style="font-weight: normal;">No data will be written to the widget until you confirm it in step #2.</i></th>';
    echo '</tr>';
    echo '</table>';

    echo '</div>'; // import pins

    echo '<div id="gmw-settings" style="display: none;">';
    echo '<table class="form-table">';
    echo '<tr>
          <th scope="row"><label for="api_key">' . __('Google Maps API Key', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[api_key]" type="text" id="api_key" value="' . esc_attr($options['api_key']) . '" class="regular-text" placeholder="Google Maps API key" oninput="setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'Please use Google Developers Console to generate an API key and enter it here. It is completely free.\')">
          <p class="description">New Google Maps usage policy dictates that everyone using the maps should register for a free API key.<br>
          Detailed instruction on how to generate a key in under a minute are available in the <a href="http://www.gmapswidget.com/documentation/generate-google-maps-api-key/" target="_blank">documentation</a>.<br>If you already have a key make sure the following APIs are enabled: Google Maps JavaScript API, Google Static Maps API, Google Maps Embed API &amp; Google Maps Geocoding API.</p></td>

          </tr>';
    echo '</table>';
    echo get_submit_button(__('Save Settings', 'google-maps-widget'));

    if (!GMW::is_activated()) {
      echo '<p>Not sure if you should upgrade to <span class="gmw-pro-red">PRO</span>? It offers more than 50 extra features like shortcodes, Google Analytics tracking, multiple pins support &amp; much more; <a href="#" class="open_promo_dialog button" data-target-screen="gmw_dialog_pro_features">compare features now</a>.</p>';
    }

    echo '<h3 class="title disabled"><br>Advanced Settings - available in the PRO version</h3>';
    echo '<table class="form-table disabled">';
    echo '<tr>
          <th scope="row"><label for="sc_map">' . __('Map Shortcode', 'google-maps-widget') . '</label></th>
          <td><input class="regular-text" name="' . GMW::$options . '[sc_map]" type="text" id="sc_map" value="' . esc_attr($options['sc_map']) . '" disabled="disabled" placeholder="Map shortcode" required="required" oninvalid="this.setCustomValidity(\'Please enter the shortcode you want to use for Google Maps Widget maps.\')" oninput="setCustomValidity(\'\')">
          <p class="description">If the default shortcode "gmw" is taken by another plugin change it to something else, eg: "gmaps".</p></td>
          </tr>';
    echo '<tr>
          <th scope="row"><label for="track_ga">' . __('Track with Google Analytics', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[track_ga]" disabled="disabled" type="checkbox" id="track_ga" value="1"' . checked('1', $options['track_ga'], false) . '>
          <span class="description">Each time the interactive map is opened either in lightbox or as a thumbnail replacement a Google Analytics Event will be tracked.<br>You need to have GA already configured on the site. It is fully compatibile with all GA plugins and all GA tracking code versions. Default: unchecked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="include_jquery">' . __('Include jQuery', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[include_jquery]" disabled="disabled" type="checkbox" id="include_jquery" value="1"' . checked('1', $options['include_jquery'], false) . '>
          <span class="description">If you\'re experiencing problems with double jQuery include disable this option. Default: checked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="include_gmaps_api">' . __('Include Google Maps API JS', 'google-maps-widget') . '</label></th>
          <td><input disabled="disabled" name="' . GMW::$options . '[include_gmaps_api]" type="checkbox" id="include_gmaps_api" value="1"' . checked('1', $options['include_gmaps_api'], false) . '>
          <span class="description">If your theme or other plugins already include Google Maps API JS disable this option. Default: checked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="include_lightbox_css">' . __('Include Colorbox &amp; Thumbnail CSS', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[include_lightbox_css]" disabled="disabled" type="checkbox" id="include_lightbox_css" value="1"' . checked('1', $options['include_lightbox_css'], false) . '>
          <span class="description">If your theme or other plugins already include Colorbox CSS disable this option.<br>Please note that widget (thumbnail map) related CSS will also be removed which will cause minor differences in the way it\'s displayed. Default: checked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="include_lightbox_js">' . __('Include Colorbox JS', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[include_lightbox_js]" disabled="disabled" type="checkbox" id="include_lightbox_js" value="1"' . checked('1', $options['include_lightbox_js'], false) . '>
          <span class="description">If your theme or other plugins already include Colorbox JS file disable this option. Default: checked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="disable_tooltips">' . __('Disable Admin Tooltips', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[disable_tooltips]" type="checkbox" disabled="disabled" id="disable_tooltips" value="1"' . checked('1', $options['disable_tooltips'], false) . '>
          <span class="description">All settings in widget edit GUI have tooltips. This setting completely disables them. Default: unchecked.</span></td></tr>';
    echo '<tr>
          <th scope="row"><label for="disable_sidebar">' . __('Disable Hidden Sidebar', 'google-maps-widget') . '</label></th>
          <td><input name="' . GMW::$options . '[disable_sidebar]" disabled="disabled" type="checkbox" id="disable_sidebar" value="1"' . checked('1', $options['disable_sidebar'], false) . '>
          <span class="description">Hidden sidebar helps you to build maps that are displayed with shortcodes. If it bothers you in the admin, disable it. Default: unchecked.</span></td></tr>';
    echo '</table>';

    echo '</div>'; // settings tab

    echo '<div id="gmw-export" style="display: none;">';
    if (!GMW::is_activated()) {
      echo '<p>Export &amp; Import are one of many <span class="gmw-pro-red">PRO</span> features. <a href="#" class="open_promo_dialog button button-primary">Upgrade now</a> to get access to more than 50 extra options &amp; features.</p>';
    }
    echo '<table class="form-table disabled">';
    echo '<tr>
          <th scope="row"><span>' . __('Export widgets', 'google-maps-widget') . '</span></th>
          <td><a href="#" class="button button-secondary button-disabled">Download export file</a>
          <p class="description">The export file will only containt Google Maps Widget widgets. This includes active (in sidebars) widgets and inactive ones as well.</p></td>
          </tr>';
    echo '<tr>
          <th scope="row"><span>' . __('Import widgets', 'google-maps-widget') . '</span></th>
          <td><input type="file" disabled="disabled" name="gmw_widgets_import" id="gmw_widgets_import" accept=".txt">
          <input type="button" disabled="disabled" name="submit-import" id="submit-import" class="button button-secondary button-large" value="Import widgets">';
    echo '<p class="description">Only use TXT export files generated by Google Maps Widget.<br>
          Existing GMW widgets will not be overwritten nor any other widgets touched. If you renamed a sidebar or old one no longer exists widgets will be placed in the inactive widgets area.</p></td>
          </tr>';
    echo '</table>';
    echo '</div>'; // export/import tab

    echo '<div id="gmw-license" style="display: none;">';
    if (GMW::is_activated()) {
      $plugin = plugin_basename(__FILE__);
      $update_url = wp_nonce_url(admin_url('update.php?action=upgrade-plugin&amp;plugin=' . urlencode($plugin)), 'upgrade-plugin_' . $plugin );

      echo '<p>Your <b class="gmw-pro-red">PRO</b> license is validated &amp; active. Please update the plugin to activate PRO features. In case of any problems, contact <a href="mailto:gmw@webfactoryltd.com?subject=Update%20problem" title="Contact Google Maps Widget PRO support">support</a>.</p>';
      echo '<p><a href="' . esc_url($update_url) . '" class="button button-primary">Update Google Maps Widget</a></p>';
    } else {
      echo '<p>If you already bought the <b class="gmw-pro-red">PRO</b> license please <a href="#" data-target-screen="gmw_dialog_activate" class="open_promo_dialog">enter your license key</a> to activate it.</p>';
      echo '<p>Interested in a lifetime <b class="gmw-pro-red">PRO</b> license that offers more than 50 extra fetures?&nbsp;&nbsp; <a href="#" class="open_promo_dialog button button-primary">Upgrade now!</a></p>';
    }

    echo '</div>'; // license tab

    echo '</form>';
    echo '</div>'; // wrap
  } // settings_screen


  // check activation code and save if valid
  static function activate_license_key_ajax() {
    check_ajax_referer('gmw_activate_license_key');

    $code = str_replace(' ', '', $_POST['code']);

    if (strlen($code) < 6 || strlen($code) > 50) {
      wp_send_json_error(__('Please double-check the license key. The format is not valid.', 'google-maps-widget'));
    }

    $tmp = GMW::validate_activation_code($code);
    if ($tmp['success']) {
      GMW::set_options(array('activation_code' => $code, 'license_active' => $tmp['license_active'], 'license_type' => $tmp['license_type'], 'license_expires' => $tmp['license_expires']));
    }
    if ($tmp['license_active'] && $tmp['success']) {
      set_site_transient('update_plugins', null);
      wp_send_json_success();
    } else {
      wp_send_json_error($tmp['error']);
    }
  } // activate_license_key_ajax


  // get info on new plugin version if one exists
  static function update_filter($current) {
    if (!GMW::is_activated()) {
      return $current;
    }

    static $response = false;
    $options = GMW::get_options();
    $plugin = plugin_basename(__FILE__);

    if(empty($response) || is_wp_error($response)) {
      $request_params = array('sslverify' => false, 'timeout' => 15, 'redirection' => 2);
      $request_args = array('action' => 'update_info',
                            'timestamp' => time(),
                            'codebase' => 'free',
                            'version' => GMW::$version,
                            'code' => $options['activation_code'],
                            'site' => get_home_url());

      $url = add_query_arg($request_args, GMW::$licensing_servers[0]);
      $response = wp_remote_get(esc_url_raw($url), $request_params);

      if (is_wp_error($response)) {
        $url = add_query_arg($request_args, GMW::$licensing_servers[1]);
        $response = wp_remote_get(esc_url_raw($url), $request_params);
      }
    } // if !$response

    if (!is_wp_error($response) && wp_remote_retrieve_body($response)) {
      $data = json_decode(wp_remote_retrieve_body($response));
      if (empty($current)) {
        $current = new stdClass();
      }
      if (empty($current->response)) {
        $current->response = array();
      }
      if (!empty($data) && is_object($data)) {
        $current->response[$plugin] = $data;
      }
    }

    return $current;
  } // update_filter


  // get plugin info for lightbox
  static function update_details($false, $action, $args) {
    if (!GMW::is_activated()) {
      return false;
    }

    static $response = false;
    $options = self::get_options();
    $plugin = basename(GMW_PLUGIN_DIR);

    if ($action != 'plugin_information' || empty($args->slug) || ($args->slug != $plugin)) {
      return false;
    }

    if(empty($response) || is_wp_error($response)) {
      $request_params = array('sslverify' => false, 'timeout' => 15, 'redirection' => 2);
      $request_args = array('action' => 'update_info',
                            'request_details' => serialize($args),
                            'codebase' => 'free',
                            'timestamp' => time(),
                            'version' => GMW::$version,
                            'code' => $options['activation_code'],
                            'site' => get_home_url());

      $url = add_query_arg($request_args, GMW::$licensing_servers[0]);
      $response = wp_remote_get(esc_url_raw($url), $request_params);

      if (is_wp_error($response) || !wp_remote_retrieve_body($response)) {
        $url = add_query_arg($request_args, GMW::$licensing_servers[1]);
        $response = wp_remote_get(esc_url_raw($url), $request_params);
      }
    } // if !$response

    if (is_wp_error($response) || !wp_remote_retrieve_body($response)) {
      $res = new WP_Error('plugins_api_failed', __('An unexpected HTTP error occurred during the API request.', 'google-maps-widget'), $response->get_error_message());
    } else {
      $res = json_decode(wp_remote_retrieve_body($response));

      if (!is_object($res)) {
        $res = new WP_Error('plugins_api_failed', __('Invalid API respone.', 'google-maps-widget'), wp_remote_retrieve_body($response));
      } else {
        $res->sections = (array) $res->sections;
        $res->banners = (array) $res->banners;
      }
    }

    return $res;
  } // update_details


  // send user's name & email to activate trial
  static function get_trial_ajax() {
    check_ajax_referer('gmw_get_trial');

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    if (defined('WPLANG')) {
      $lang = strtolower(substr(WPLANG, 0, 2));
    } else {
      $lang = 'en';
    }

    $request_params = array('sslverify' => false, 'timeout' => 15, 'redirection' => 2);
    $request_args = array('action' => 'get_trial',
                          'name' => $name,
                          'email' => $email,
                          'version' => GMW::$version,
                          'lang' => $lang,
                          'codebase' => 'free',
                          'ip' => $_SERVER['REMOTE_ADDR'],
                          'site' => get_home_url());

    $url = add_query_arg($request_args, GMW::$licensing_servers[0]);
    $response = wp_remote_get(esc_url_raw($url), $request_params);

    if (is_wp_error($response) || !wp_remote_retrieve_body($response)) {
      $url = add_query_arg($request_args, GMW::$licensing_servers[1]);
      $response = wp_remote_get(esc_url_raw($url), $request_params);
    }

    if (!is_wp_error($response) && wp_remote_retrieve_body($response)) {
      $result = wp_remote_retrieve_body($response);
      $result = json_decode($result, true);
      if (!empty($result['success']) && $result['success'] === true && is_array($result['data']) && sizeof($result['data']) == 3) {
        $result['data']['license_active'] = true;
        GMW::set_options($result['data']);
        set_site_transient('update_plugins', null);
        wp_send_json_success();
      } elseif (isset($result['success']) && $result['success'] === false && !empty($result['data'])) {
        wp_send_json_error($result['data']);
      } else {
        wp_send_json_error('Invalid response from licensing server. Please try again later.');
      }
    } else {
      wp_send_json_error('Unable to contact licensing server. Please try again in a few moments.');
    }
  } // get_trial_ajax


  // helper function for creating dropdowns
  static function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    if(!is_array($selected)) {
      $selected = array($selected);
    }

    foreach ($options as $tmp) {
      $data = '';
      if (isset($tmp['disabled'])) {
        $data .= ' disabled="disabled" ';
      }
      if ($tmp['val'] == '-1') {
        $data .= ' class="gmw_promo" ';
      }
      if (in_array($tmp['val'], $selected)) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\"{$data}>{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\"{$data}>{$tmp['label']}&nbsp;</option>\n";
      }
    } // foreach

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options


  // sanitizes color code string, leaves # intact
  static function sanitize_hex_color( $color ) {
    if (empty($color)) {
      return '#ff0000';
    }

    // 3 or 6 hex digits
    if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
      return $color;
    }
  } // sanitize_hex_color


  // converts color from human readable to hex
  static function convert_color($color) {
    $color_codes = array('black'  => '#000000', 'white'  => '#ffffff',
                         'brown'  => '#a52a2a', 'green'  => '#00ff00',
                         'purple' => '#800080', 'yellow' => '#ffff00',
                         'blue'   => '#0000ff', 'gray'   => '#808080',
                         'orange' => '#ffa500', 'red'    => '#ff0000');

    $color = strtolower(trim($color));

    if (empty($color) || !isset($color_codes[$color])) {
      return '#ff0000';
    } else {
      return $color_codes[$color];
    }
  } // convert_color


  // helper function for checkbox handling
  static function check_var_isset($values, $variables) {
    foreach ($variables as $key => $value) {
      if (!isset($values[$key])) {
        $values[$key] = $value;
      }
    }

    return $values;
  } // check_var_isset


  // activate doesn't get fired on upgrades so we have to compensate
  public static function maybe_upgrade() {
    $options = GMW::get_options();

    if (!isset($options['first_version']) || !isset($options['first_install'])) {
      $options['first_version'] = GMW::$version;
      $options['first_install_gmt'] = time();
      $options['first_install'] = current_time('timestamp');
      GMW::set_options($options);
    }

    // force plugin update for PRO users
    if (!get_site_transient('gmw_update_plugins') && $options['first_version'] != GMW::$version && GMW::is_activated()) {
      set_site_transient('update_plugins', null);
      set_site_transient('gmw_update_plugins', true, WEEK_IN_SECONDS);
    }
  } // maybe_upgrade


  // write down a few things on plugin activation
  // NO DATA for tracking is sent anywhere unless user explicitly agrees to it!
  static function activate() {
    $options = GMW::get_options();

    if (!isset($options['first_version']) || !isset($options['first_install'])) {
      $options['first_version'] = GMW::$version;
      $options['first_install'] = current_time('timestamp');
      $options['last_tracking'] = false;
      GMW::set_options($options);
    }

    self::reset_pointers();
  } // activate


  // clean up on deactivation
  static function deactivate() {
    $options = GMW::get_options();

    if (isset($options['allow_tracking']) && $options['allow_tracking'] === true) {
      GMW_tracking::clear_cron();
    }

    delete_transient('gmw_pointers');
  } // deactivate


  // clean up on uninstall / delete
  static function uninstall() {
    // at the moment, due to lite/pro upgrade we never delete options
    if (false) {
      delete_option(GMW::$options);
    }

    delete_transient('gmw_pointers');
  } // uninstall
} // class GMW

} // if GMW class exists


// hook everything up
register_activation_hook(__FILE__, array('GMW', 'activate'));
register_deactivation_hook(__FILE__, array('GMW', 'deactivate'));
register_uninstall_hook(__FILE__, array('GMW', 'uninstall'));
add_action('init', array('GMW', 'init'));
add_action('plugins_loaded', array('GMW', 'plugins_loaded'));
add_action('widgets_init', array('GMW', 'widgets_init'));
