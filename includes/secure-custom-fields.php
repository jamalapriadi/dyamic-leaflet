<?php 

if(!defined('ABSPATH')){
    exit;
}

// Include Smart Custom Fields
if (!class_exists('ACF')) {
    require_once plugin_dir_path(__FILE__) . 'secure-custom-fields/secure-custom-fields.php';
}

function dynamic_leaflet_check_scf_dependency() {
    if (!class_exists('ACF')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>Secure Custom Fields is required</strong>. Please install and activate <a href="https://wordpress.org/plugins/secure-custom-fields/">Secure Custom Fields</a>.</p></div>';
        });
    }
}

add_action('admin_init', 'dynamic_leaflet_check_scf_dependency');