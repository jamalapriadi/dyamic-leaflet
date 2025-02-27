<?php 
/*
Plugin Name: Dynamic Leaflet
Plugin URI: http://www.wordpress.org/plugins/dynamic-leaflet
Description: A plugin to display a dynamic map using Leaflet
Version: 1.0
Author: Jamal Apriadi
Author URI: https://www.jamalapriadi.com
License: GPLv2 or later
Text Domain: dynamic-leaflet
*/

if(!defined('ABSPATH')){
	exit;
}

//define plugin path
define('DYNAMIC_LEAFLET_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DYNAMIC_LEAFLET_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DYNAMIC_LEAFLET_PLUGIN_VERSION', '1.0');

// include plugin files
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/styles-and-scripts.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/dynamic-leaflet-post-type.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/secure-custom-fields.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/dynamic-leaflet-custom-fields.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/sort-column.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/setting.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/shortcode.php';


//activation hook	
function dynamic_leaflet_activate(){
	dynamic_leaflet_register_post_type();
	dynamic_leaflet_check_scf_dependency();
	dynamic_leaflet_register_acf_fields();
	add_filter('manage_dynamic-leaflet_columns', 'dynamic_leaflet_add_custom_columns');

	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'dynamic_leaflet_activate');

//deactivation hook
function dynamic_leaflet_deactivate(){
	unregister_post_type('dynamic-leaflet');
	dynamic_leaflet_remove_acf_fields();

	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'dynamic_leaflet_deactivate');

