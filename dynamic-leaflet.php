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

namespace DynamicLeafletPlugin;

defined( 'ABSPATH' ) or die( 'Direct access is not allowed.' );

//define plugin path
define('DYNAMIC_LEAFLET_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DYNAMIC_LEAFLET_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DYNAMIC_LEAFLET_PLUGIN_VERSION', '1.0');

// include plugin files
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/dynamic-leaflet-post-type.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/secure-custom-fields.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/setting_admin_page.php';
require_once DYNAMIC_LEAFLET_PLUGIN_PATH . 'includes/dynamic_leaflet_shortcode.php';

use DynamicLeaflet\Includes\DynamicLeafletRegisterPostType;
use DynamicLeaflet\Includes\DynamicLeafletSettingAdminPage;
use DynamicLeaflet\Includes\DynamicLeafletShortcode;

class DynamicLeafletPlugin{
	private $registerPostType;
	private $adminPage;
	private $shortcode;

	function __construct(){
		$this->registerPostType = new DynamicLeafletRegisterPostType();
		$this->adminPage = new DynamicLeafletSettingAdminPage();
		$this->shortcode = new DynamicLeafletShortcode();

		add_action('plugins_loaded', array($this, 'init'));
	}

	public function init() {
		register_activation_hook(__FILE__, array($this, 'dynamic_leaflet_activate'));
		register_deactivation_hook(__FILE__, array($this, 'dynamic_leaflet_deactivate'));

		$this->registerPostType->init();
		$this->adminPage->init();
    }

	//activation hook	
	function dynamic_leaflet_activate(){
		dynamic_leaflet_check_scf_dependency();
		add_filter('manage_dynamic-leaflet_columns', 'dynamic_leaflet_add_custom_columns');

		flush_rewrite_rules();
	}

	//deactivation hook
	function dynamic_leaflet_deactivate(){
		unregister_post_type('dynamic-leaflet');

		$this->registerPostType->dynamic_leaflet_remove_acf_fields();

		flush_rewrite_rules();
	}
}

$dynamicLeafletPlugin = new DynamicLeafletPlugin();