<?php 

namespace DynamicLeaflet\Includes;

if(!defined('ABSPATH')){
    exit;
}

class DynamicLeafletSettingAdminPage{
    function __construct(){
        add_action( 'admin_enqueue_scripts', array($this, 'dynamic_leaflet_enqueue_styles_and_scripts') );
    }

    public function init(){
        add_action('admin_menu', array($this, 'dynamic_leaflet_custom_admin_menu'), 11);
        add_action('admin_init', array($this, 'dynamic_leaflet_register_my_settings'));   
    }   

    /**
     * add scripts and styles for admin page
     */
    function dynamic_leaflet_enqueue_styles_and_scripts(){
        if (is_user_logged_in() && current_user_can('manage_options') && is_admin()){
            wp_enqueue_style('dynamic-leaflet-style', DYNAMIC_LEAFLET_PLUGIN_URL . 'assets/css/dynamic-leaflet-style.css', array(), '1.0.0', 'all');
            wp_enqueue_script( 'tabbed-admin-script', DYNAMIC_LEAFLET_PLUGIN_URL . 'assets/js/setting.js', array( 'jquery' ), '1.0.0', true );

            wp_localize_script( 'leaflet-custom-js', 'leaflet_data', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'some_variable' => 'some_value',
            ));
        }

    }

    /**
     * script for custom admin menu
     */
    function dynamic_leaflet_custom_admin_menu() {
        $post_type = 'dynamic-leaflet'; // Change this to your CPT slug
    
        add_submenu_page(
            "edit.php?post_type=$post_type", // Parent menu (CPT)
            'Settings', // Page title
            'Settings', // Menu title
            'manage_options', // Capability
            'setting-dynamic-leaflet', // Menu slug
            array($this,'dynamic_leaflet_setting_page') // Callback function
        );
    }

    /**
     * callback function for custom admin menu
     */
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
                <a href="#tab-3" class="nav-tab">Help & Getting Started</a>
            </h2>
    
            <div id="tab-1" class="tab-content">
                <?php
                if (isset($_POST['submit_setting_map'])) {
                    $this->handleForm();
                }
                ?>
                <form method="POST">
                    <input type="hidden" name="submit_setting_map" value="true">

                    <?php settings_fields('dynamic_leaflet_settings_group_tab_1'); ?>
                    <?php do_settings_sections('tabbed-settings-tab-1'); ?>
                    <?php submit_button(); ?>
                </form>
            </div>
    
            <div id="tab-3" class="tab-content" style="display: none;">
                <h3>Getting started with Dynamic Leaflet</h3>
                <ul class="styled-list">
                    <li>Use the page editor or Elementor to insert the "Dynamic Leaflet" block onto a page. Alternatively, you can use the shortcode [dynamic-leaflet-map]</li>
                    <li>You can <a href="<?php echo esc_url(admin_url('edit.php?post_type=dynamic-leaflet')); ?>">manage Locations</a> under Dynamic Leaflet > All Locations</li>
                    <li><a href="<?php echo esc_url(admin_url('edit.php?post_type=dynamic-leaflet&page=setting-dynamic-leaflet')); ?>">Customize</a> styles and features under Dynamic Leaflet > Settings</li>
                </ul>
            </div>
    
        </div>
        <?php
    }

    function handleForm() {
        // Sanitize and validate input
        if(current_user_can('manage_options')){
            if ( ! isset( $_POST['leaflet_map_options'] ) ) {
                return;
            }
        }

        $data = array(
            'latitude' => sanitize_text_field($_POST['leaflet_map_options']['latitude']),
            'longitude' => sanitize_text_field($_POST['leaflet_map_options']['longitude']),
            'zoom' => intval($_POST['leaflet_map_options']['zoom']),
            'height' => sanitize_text_field($_POST['leaflet_map_options']['height']),
            'width' => sanitize_text_field($_POST['leaflet_map_options']['width']),
            'tile_url' => sanitize_text_field($_POST['leaflet_map_options']['tile_url']),
            'attribution' => sanitize_textarea_field($_POST['leaflet_map_options']['attribution']),
            'max_zoom' => intval($_POST['leaflet_map_options']['max_zoom']),
            'zoom_control'=> sanitize_textarea_field($_POST['leaflet_map_options']['zoom_control']),
            'scrool_wheel_zoom'=> sanitize_textarea_field($_POST['leaflet_map_options']['scrool_wheel_zoom']),
            'double_click_zoom'=> sanitize_textarea_field($_POST['leaflet_map_options']['double_click_zoom']),
            'attribution_control'=> sanitize_textarea_field($_POST['leaflet_map_options']['attribution_control']),
        );

        // Update options
        update_option('leaflet_map_options', $data);

        // Display success message
        echo '<div class="updated"><p>Settings saved.</p></div>';
    }

    function dynamic_leaflet_register_my_settings() {
        register_setting('dynamic_leaflet_settings_group_tab_1', 'my_tab_1_setting');


        /**
         * Group setting for tab 1
         */
        add_settings_section('tab_map_settings', 'Map Settings', '__return_false', 'tabbed-settings-tab-1');
        add_settings_field(
            'leaflet_map_center',
            'Map Center (Lat & Lng)',
            array($this, 'leaflet_map_center_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );
        
        add_settings_field(
            'leaflet_map_zoom',
            'Default Zoom Level',
            array($this,'leaflet_map_zoom_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );
        
        add_settings_field(
            'leaflet_map_max_zoom',
            'Max Zoom',
            array($this,'leaflet_map_max_zoom_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );

        add_settings_field(
            'leaflet_map_zoom_control',
            'Zoom Control',
            array($this,'leaflet_map_zoom_control_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );

        add_settings_field(
            'leaflet_map_scrool_wheel_zoom',
            'Scrool Wheel Zoom',
            array($this,'leaflet_map_scrool_wheel_zoom_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );

        add_settings_field(
            'leaflet_map_double_click_zoom',
            'Double Click Zoom',
            array($this,'leaflet_map_double_click_zoom_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );

        add_settings_field(
            'leaflet_map_dimensions',
            'Map Size (Height & Width)',
            array($this,'leaflet_map_dimensions_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );
        
        add_settings_field(
            'leaflet_map_tile_url',
            'Tile Layer URL',
            array($this,'leaflet_map_tile_url_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );

        add_settings_field(
            'leaflet_map_attribution_control',
            'Attribution Control',
            array($this,'leaflet_map_attribution_control_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );
        
        add_settings_field(
            'leaflet_map_attribution',
            'Attribution',
            array($this,'leaflet_map_attribution_callback'),
            'tabbed-settings-tab-1',
            'tab_map_settings'
        );
    }

    function leaflet_map_center_callback() {
        $options = get_option('leaflet_map_options');
        $latitude = isset($options['latitude']) ? esc_attr($options['latitude']) : '';
        $longitude = isset($options['longitude']) ? esc_attr($options['longitude']) : '';
        echo '<input type="text" name="leaflet_map_options[latitude]" value="' . $latitude . '" placeholder="Latitude" /> <input type="text" name="leaflet_map_options[longitude]" value="' . $longitude . '" placeholder="Longitude" />';
    }

    function leaflet_map_zoom_callback() {
        $options = get_option('leaflet_map_options');
        $zoom = isset($options['zoom']) ? intval($options['zoom']) : 13;
        echo '<input type="number" name="leaflet_map_options[zoom]" value="' . $zoom . '" min="1" max="18" />';
    }

    function leaflet_map_tile_url_callback() {
        $options = get_option('leaflet_map_options');
        $tile_url = isset($options['tile_url']) ? esc_attr($options['tile_url']) : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        echo '<input type="text" name="leaflet_map_options[tile_url]" value="' . $tile_url . '" size="80" />';
    }

    function leaflet_map_dimensions_callback() {
        $options = get_option('leaflet_map_options');
        $height = isset($options['height']) ? esc_attr($options['height']) : '400px';
        $width = isset($options['width']) ? esc_attr($options['width']) : '100%';
        echo '<input type="text" name="leaflet_map_options[height]" value="' . $height . '" placeholder="Height" /> <input type="text" name="leaflet_map_options[width]" value="' . $width . '" placeholder="Width" />';
    }

    function leaflet_map_attribution_callback() {
        $options = get_option('leaflet_map_options');
        $attribution = isset($options['attribution']) ? esc_textarea($options['attribution']) : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
        echo '<textarea name="leaflet_map_options[attribution]" rows="3" cols="80">' . $attribution . '</textarea>';
    }

    function leaflet_map_max_zoom_callback() {
        $options = get_option('leaflet_map_options');
        $max_zoom = isset($options['max_zoom']) ? intval($options['max_zoom']) : 18;
        echo '<input type="number" name="leaflet_map_options[max_zoom]" value="' . $max_zoom . '" min="1" max="22" />';
    }

    function leaflet_map_zoom_control_callback() {
        $options = get_option('leaflet_map_options');
        $zoom_control = isset($options['zoom_control']) ? esc_attr($options['zoom_control']) : 'yes';
        echo '<select name="leaflet_map_options[zoom_control]">';
        echo '<option value="yes" ' . selected('yes', $zoom_control, false) . '>Yes</option>';
        echo '<option value="no" ' . selected('no', $zoom_control, false) . '>No</option>';
        echo '</select>';
    }

    function leaflet_map_scrool_wheel_zoom_callback() {
        $options = get_option('leaflet_map_options');
        $scrool_wheel_zoom = isset($options['scrool_wheel_zoom']) ? esc_attr($options['scrool_wheel_zoom']) : 'yes';
        echo '<select name="leaflet_map_options[scrool_wheel_zoom]">';
        echo '<option value="yes" ' . selected('yes', $scrool_wheel_zoom, false) . '>Yes</option>';
        echo '<option value="no" ' . selected('no', $scrool_wheel_zoom, false) . '>No</option>';
        echo '</select>';
    }

    function leaflet_map_double_click_zoom_callback() {
        $options = get_option('leaflet_map_options');
        $double_click_zoom = isset($options['double_click_zoom']) ? esc_attr($options['double_click_zoom']) : 'yes';
        echo '<select name="leaflet_map_options[double_click_zoom]">';
        echo '<option value="yes" ' . selected('yes', $double_click_zoom, false) . '>Yes</option>';
        echo '<option value="no" ' . selected('no', $double_click_zoom, false) . '>No</option>';
        echo '</select>';
    }

    function leaflet_map_attribution_control_callback() {
        $options = get_option('leaflet_map_options');
        $attribution_control = isset($options['attribution_control']) ? esc_attr($options['attribution_control']) : 'yes';
        echo '<select name="leaflet_map_options[attribution_control]">';
        echo '<option value="yes" ' . selected('yes', $attribution_control, false) . '>Yes</option>';
        echo '<option value="no" ' . selected('no', $attribution_control, false) . '>No</option>';
        echo '</select>';
    }
}

