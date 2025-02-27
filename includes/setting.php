<?php 

if(!defined('ABSPATH')){
    exit;
}

function dynamic_leaflet_custom_admin_menu() {
    $post_type = 'dynamic-leaflet'; // Change this to your CPT slug

    add_submenu_page(
        "edit.php?post_type=$post_type", // Parent menu (CPT)
        'Settings', // Page title
        'Settings', // Menu title
        'manage_options', // Capability
        'setting-dynamic-leaflet', // Menu slug
        'dynamic_leaflet_setting_page' // Callback function
    );
}
add_action('admin_menu', 'dynamic_leaflet_custom_admin_menu', 11);

function dynamic_leaflet_setting_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $default_tab = 'general';
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
    ?>
    <div class="wrap">
        <h1>Dynamic Leaflet Settings</h1>
        
        <h2 class="nav-tab-wrapper">
            <a href="#tab-1" class="nav-tab nav-tab-active">Map Settings</a>
            <a href="#tab-2" class="nav-tab">Filter & Categories</a>
            <a href="#tab-3" class="nav-tab">Help & Getting Started</a>
        </h2>

        <div id="tab-1" class="tab-content">
            <h3>Tab 1 Content</h3>
            <p>Settings for Tab 1.</p>
            <?php settings_fields('my_plugin_settings_group_tab_1'); ?>
            <?php do_settings_sections('tabbed-settings-tab-1'); ?>
            <?php submit_button(); ?>
        </div>

        <div id="tab-2" class="tab-content" style="display: none;">
            <h3>Tab 2 Content</h3>
            <p>Settings for Tab 2.</p>
            <?php settings_fields('my_plugin_settings_group_tab_2'); ?>
            <?php do_settings_sections('tabbed-settings-tab-2'); ?>
            <?php submit_button(); ?>
        </div>

        <div id="tab-3" class="tab-content" style="display: none;">
            <h3>Tab 3 Content</h3>
            <p>Settings for Tab 3.</p>
            <?php settings_fields('my_plugin_settings_group_tab_3'); ?>
            <?php do_settings_sections('tabbed-settings-tab-3'); ?>
            <?php submit_button(); ?>
        </div>

    </div>
    <?php
}

function register_my_settings() {
    register_setting('my_plugin_settings_group_tab_1', 'my_tab_1_setting');
    add_settings_section('my_tab_1_section', 'Tab 1 Settings', '__return_false', 'tabbed-settings-tab-1');
    add_settings_field('my_tab_1_field', 'Tab 1 Field', 'my_tab_1_field_callback', 'tabbed-settings-tab-1', 'my_tab_1_section');

    register_setting('my_plugin_settings_group_tab_2', 'my_tab_2_setting');
    add_settings_section('my_tab_2_section', 'Tab 2 Settings', '__return_false', 'tabbed-settings-tab-2');
    add_settings_field('my_tab_2_field', 'Tab 2 Field', 'my_tab_2_field_callback', 'tabbed-settings-tab-2', 'my_tab_2_section');

    register_setting('my_plugin_settings_group_tab_3', 'my_tab_3_setting');
    add_settings_section('my_tab_3_section', 'Tab 3 Settings', '__return_false', 'tabbed-settings-tab-3');
    add_settings_field('my_tab_3_field', 'Tab 3 Field', 'my_tab_3_field_callback', 'tabbed-settings-tab-3', 'my_tab_3_section');
}
add_action('admin_init', 'register_my_settings');

function my_tab_1_field_callback(){
    $value = esc_attr(get_option('my_tab_1_setting'));
    echo "<input type='text' name='my_tab_1_setting' value='$value' />";
}
function my_tab_2_field_callback(){
    $value = esc_attr(get_option('my_tab_2_setting'));
    echo "<input type='text' name='my_tab_2_setting' value='$value' />";
}
function my_tab_3_field_callback(){
    $value = esc_attr(get_option('my_tab_3_setting'));
    echo "<input type='text' name='my_tab_3_setting' value='$value' />";
}