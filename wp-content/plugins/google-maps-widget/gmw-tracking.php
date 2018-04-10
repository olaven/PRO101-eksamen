<?php
/*
 * Google Maps Widget
 * Plugin usage tracking
 * (c) Web factory Ltd, 2012 - 2018
 */


// this is an include only WP file
if (!defined('ABSPATH')) {
  die;
}


class GMW_tracking {
  static $cron_biweekly = 'gmw_biweekly_cron';

  // set things up
  static function init() {
    self::check_opt_in_out();

    add_action(self::$cron_biweekly, array(__CLASS__, 'send_data'));
    GMW_tracking::setup_cron();
  } // init


  // register additional cron interval
  static function register_cron_intervals($schedules) {
    $schedules['gmw_weekly'] = array(
      'interval' => DAY_IN_SECONDS * 7,
      'display' => 'Once a Week');
    $schedules['gmw_biweekly'] = array(
      'interval' => DAY_IN_SECONDS * 14,
      'display' => 'Once every two Weeks');

    return $schedules;
  } // cron_intervals


  // clear cron scheadule
  static function clear_cron() {
    wp_clear_scheduled_hook(self::$cron_biweekly);
  } // clear_cron


  // setup cron job when user allows tracking
  static function setup_cron() {
    $options = GMW::get_options();

    if (isset($options['allow_tracking']) && $options['allow_tracking'] === true) {
      if (!wp_next_scheduled(self::$cron_biweekly)) {
        wp_schedule_event(current_time('timestamp') + 60, 'gmw_biweekly', self::$cron_biweekly);
      }
    } else {
      self::clear_cron();
    }
  } // setup_cron


  // save user's choice for (not) allowing tracking
  static function check_opt_in_out() {
    if (isset($_GET['gmw_tracking']) && $_GET['gmw_tracking'] == 'opt_in') {
      GMW::set_options(array('allow_tracking' => true));
      self::send_data(true);
      wp_redirect(esc_url_raw(remove_query_arg('gmw_tracking')));
      die();
    } elseif (isset($_GET['gmw_tracking']) && $_GET['gmw_tracking'] == 'opt_out') {
      GMW::set_options(array('allow_tracking' => false));
      wp_redirect(esc_url_raw(remove_query_arg('gmw_tracking')));
      die();
    }
  } // check_opt_in_out


  // display tracking notice
  static function tracking_notice() {
    $optin_url = add_query_arg('gmw_tracking', 'opt_in');
    $optout_url = add_query_arg('gmw_tracking', 'opt_out');

    echo '<div class="updated"><p>';
    echo __('Please help us improve <strong>Google Maps Widget</strong> by allowing tracking of anonymous usage data. Absolutely <strong>no sensitive data is tracked</strong> (<a href="http://www.gmapswidget.com/plugin-tracking-info/" target="_blank">complete disclosure &amp; details of our tracking policy</a>).', 'google-maps-widget');
    echo '<br /><a href="' . esc_url($optin_url) . '" style="vertical-align: baseline; margin-top: 15px;" class="button-primary">' . __('Allow', 'google-maps-widget') . '</a>';
    echo '&nbsp;&nbsp;<a href="' . esc_url($optout_url) . '" class="">' . __('Do not allow tracking', 'google-maps-widget') . '</a>';
    echo '</p></div>';
  } // tracking_notice


  // send usage data once a week to our server
  static function send_data($force = false) {
    $options = GMW::get_options();

    if ($force == false && (!isset($options['allow_tracking']) || $options['allow_tracking'] !== true)) {
      return;
    }
    if ($force == false && ($options['last_tracking'] && $options['last_tracking'] > strtotime( '-6 days'))) {
      return;
    }

    $data = self::prepare_data();
    $request = wp_remote_post('http://www.gmapswidget.com/tracking.php', array(
                              'method' => 'POST',
                              'timeout' => 10,
                              'redirection' => 3,
                              'httpversion' => '1.0',
                              'body' => $data,
                              'user-agent' => 'GMW/' . GMW::$version));

    $options['last_tracking'] = current_time('timestamp');
    update_option(GMW::$options, $options);
  } // send_data


  // get and prepare data that will be sent out
  static function prepare_data() {
    $options = GMW::get_options();
    $data = array();
    $current_user = wp_get_current_user();

    $data['url'] = home_url();
    if ($current_user && isset($current_user->user_email) && !empty($current_user->user_email)) {
      $data['admin_email'] = $current_user->user_email;
    } else {
      $data['admin_email'] = get_bloginfo('admin_email');
    }
    $data['wp_version'] = get_bloginfo('version');
    $data['gmw_version'] = GMW::$version;
    $data['gmw_first_version'] = $options['first_version'];
    $data['gmw_first_install'] = $options['first_install'];
    $data['ioncube'] = extension_loaded('IonCube Loader');
    $data['gmw_count'] = self::count_active_widgets();

    $theme = wp_get_theme();
    $data['theme_name'] = $theme->Name;
    $data['theme_version'] = $theme->Version;

    // get current plugin information
    if (!function_exists('get_plugins')) {
      include ABSPATH . '/wp-admin/includes/plugin.php';
    }

    $plugins = get_plugins();
    $active_plugins = get_option('active_plugins', array());

    foreach ($active_plugins as $plugin) {
      $data['plugins'][$plugin] = @$plugins[$plugin];
    }

    return $data;
  } // prepare_data


  // counts the number of active GMW widgets in sidebars
  static function count_active_widgets() {
    $count = 0;

    $sidebars = get_option('sidebars_widgets', array());
    foreach ($sidebars as $sidebar_name => $widgets) {
      if (strpos($sidebar_name, 'inactive') !== false || strpos($sidebar_name, 'orphaned') !== false) {
        continue;
      }
      if (is_array($widgets)) {
        foreach ($widgets as $widget_name) {
          if (strpos($widget_name, 'googlemapswidget') !== false) {
            $count++;
          }
        }
      }
    } // foreach sidebar

    return $count;
  } // count_active_widgets
} // class GMW_tracking