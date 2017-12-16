<?php

/*
Plugin Name:  Foodstack Framework
Plugin URI:   https://github.com/monecchi/FoodStack-Framework
Description:  Derived from Ebor Framework by TommusRhodus Theme, this alternate version was specially crafted for WooCommerce Restaurant & Food Store websites
Version:      1.3.9
Author:       Adriano Monecchi
Author URI:   http://www.plandesign.com.br/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  ebor-framework
Domain Path:  /languages
*/

/**
 * Plugin definitions
 */
define( 'EBOR_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'EBOR_FRAMEWORK_VERSION', '1.3.9');

/**
 * Styles & Scripts
 */
if(!( function_exists('ebor_framework_admin_load_scripts') )){
	function ebor_framework_admin_load_scripts(){
		wp_enqueue_style('ebor_framework_font_awesome', plugins_url( '/css/font-awesome.min.css' , __FILE__ ) );
		wp_enqueue_style('ebor_framework_admin_css', plugins_url( '/css/ebor-framework-admin.css' , __FILE__ ) );
		wp_enqueue_script('ebor_framework_admin_js', plugins_url( '/js/ebor-framework-admin.js' , __FILE__ ) );
	}
	add_action('admin_enqueue_scripts', 'ebor_framework_admin_load_scripts', 200);
}

/**
 * Some items are definitely always loaded, these are those.
 */
/**
 * Grab all custom post type functions
 */
require_once( EBOR_FRAMEWORK_PATH . 'ebor_cpt.php' );

/**
 * Grab all generic functions
 */
require_once( EBOR_FRAMEWORK_PATH . 'ebor_functions.php' );

/**
 * Everything else in the framework is conditionally loaded depending on theme options.
 * Let's include all of that now.
 */
require_once( EBOR_FRAMEWORK_PATH . 'init.php' );

/**
 * ebor_ajax_import_data
 * 
 * Use this to auto import a demo-data.xml for the theme.
 * demo-data.xml must be in your active theme root folder, you should also copy this into a child theme if you supply one.
 * 
 * @author TommusRhodus
 * @since v1.0.0
 */
if(!( function_exists('ebor_ajax_import_data') )){
	function ebor_ajax_import_data() {				
		require_once( EBOR_FRAMEWORK_PATH . 'wordpress-importer/demo_import.php' );
		die('ebor_import');
	}
	add_action('wp_ajax_ebor_ajax_import_data', 'ebor_ajax_import_data');
}

/**
 * Theme updates
 */
//custom mrancho
//require_once( EBOR_FRAMEWORK_PATH . 'envato-wp-updater/updater-init.php' );

/**
 * Plugin Updates
 * This plugin updates from wp-updates.com
 * I've tried various github updaters, but they all seem to break very simply, this should be quite reliable.
 * 
 * @author TommusRhodus
 * @since v1.0.0
 */
//require_once(EBOR_FRAMEWORK_PATH . 'wp-updates-plugin.php');
//new WPUpdatesPluginUpdater_745( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

/**
 * Github updater class
 */
if( ! class_exists( 'Github_Updater' ) ) {
	include_once( plugin_dir_path( __FILE__ ) . 'git-updater.php' );
}

$updater = new Github_Updater( __FILE__ );
$updater->set_username( 'monecchi' );
$updater->set_repository( 'FoodStack-Framework' ); 

/* Access Token for private repo */
$updater->authorize( '4b3a61692b95542474665d25f0112f53928372e9' ); // Your auth code goes here for private repos

$updater->initialize();