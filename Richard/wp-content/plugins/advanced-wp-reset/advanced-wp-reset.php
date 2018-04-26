<?php
if (!defined('ABSPATH') || !is_main_site()) return;

/*
Plugin Name: Advanced WordPress Reset
Plugin URI: http://sigmaplugin.com/downloads/advanced-wordpress-reset
Description: Reset your WordPress database back to its first original status, just like if you make a fresh installation.
Version: 1.0.1
Author: Younes JFR.
Author URI: http://www.sigmaplugin.com
Contributors: symptote
Text Domain: advanced-wp-reset
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/********************************************************************
* Define common constants
********************************************************************/
if (!defined("DBR_PLUGIN_VERSION")) 				define("DBR_PLUGIN_VERSION", "1.0.0");
if (!defined("DBR_PLUGIN_DIR_PATH")) 				define("DBR_PLUGIN_DIR_PATH", plugins_url('' , __FILE__));
if (!defined("DBR_PLUGIN_BASENAME")) 				define("DBR_PLUGIN_BASENAME", plugin_basename(__FILE__));

/********************************************************************
* Load language
********************************************************************/
add_action('plugins_loaded', 'DBR_load_textdomain');
function DBR_load_textdomain() {
	load_plugin_textdomain('advanced-wp-reset', false, plugin_basename(dirname(__FILE__)) . '/languages');
}

/********************************************************************
* Add sub menu under tools
********************************************************************/
add_action('admin_menu', 'DBR_add_admin_menu');
function DBR_add_admin_menu() {
	global $DBR_tool_submenu;
	$DBR_tool_submenu = add_submenu_page('tools.php', 'Advanced WP Reset', 'Advanced WP Reset', 'manage_options', 'advanced_wp_reset', 'DBR_main_page_callback');
}

/********************************************************************
* Load CSS and JS
********************************************************************/
add_action('admin_enqueue_scripts', 'DBR_load_styles_and_scripts');
function DBR_load_styles_and_scripts($hook) {
	// Enqueue our js and css in the plugin pages only
	global $DBR_tool_submenu;
	if($hook != $DBR_tool_submenu){
		return;
	}
	wp_enqueue_style('DBR_css', DBR_PLUGIN_DIR_PATH . '/css/admin.css');
	//wp_enqueue_script('DBR_js', DBR_PLUGIN_DIR_PATH . '/js/admin.js');
    //wp_enqueue_script('jquery');
    //wp_enqueue_script('jquery-ui-dialog');
	//wp_enqueue_style('wp-jquery-ui-dialog');
}

/********************************************************************
* Activation of the plugin
********************************************************************/
register_activation_hook(__FILE__, 'DBR_activate_plugin');
function DBR_activate_plugin(){
	// Anything to do on activation? Maybe later...
}

/********************************************************************
* Deactivation of the plugin
********************************************************************/
register_deactivation_hook(__FILE__, 'DBR_deactivate_plugin');
function DBR_deactivate_plugin(){
	// Anything to do on deactivation? Maybe later...
}

/********************************************************************
* UNINSTALL
********************************************************************/
register_uninstall_hook(__FILE__, 'DBR_uninstall');
function DBR_uninstall(){
	// Anything to do on uninstall? Maybe later...
}

/********************************************************************
* The admin page of the plugin
********************************************************************/
function DBR_main_page_callback(){
	if(!current_user_can("manage_options")){
		_e('You do not have sufficient permissions to access this page.','advanced-wp-reset');
		die();
	}
	if(array_key_exists('reset-db', $_GET)){
		echo '<div id="DBR_message" class="updated notice is-dismissible"><p>';
		_e('Your database has been reset successfully!','advanced-wp-reset');
		echo '</p></div>';
	}
	?>
	<div class="wrap">
		<h2>Advanced WordPress Reset</h2>
		<div class="DBR-margin-r-300">
			<div class="DBR-tab-box">
				<div class="DBR-tab-box-div">
					<?php include_once 'includes/reset.php'; ?>
				</div>
			</div>
			<div class="DBR-sidebar"><?php include_once 'includes/sidebar.php'; ?></div>
		</div>
	</div>
<?php 
}

/***************************************************************
* Get functions
***************************************************************/
include_once 'includes/functions.php';

?>