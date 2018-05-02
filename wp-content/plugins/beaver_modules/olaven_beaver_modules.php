<?php
/**
 * Plugin Name: Campus Plugin
 * Description: Vis info om et campus 
 * Version: 1.0
 * Author: Olav
 */
define( 'BEAVER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEAVER_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

function my_load_module_examples() {
    if ( class_exists( 'FLBuilder' ) ) {
        // Include your custom modules here.
        require_once 'campus/campus.php';
        require_once 'ruterwidget/ruterwidget.php';
    }
}
add_action( 'init', 'my_load_module_examples' );

?>