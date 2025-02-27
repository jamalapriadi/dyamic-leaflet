<?php 

if(!defined('ABSPATH')){
    exit;
}

if( ! function_exists( 'dynamic_leaflet_enqueue_styles_and_scripts' ) ){
    function dynamic_leaflet_enqueue_styles_and_scripts(){
        wp_enqueue_script( 'tabbed-admin-script', DYNAMIC_LEAFLET_PLUGIN_URL . 'assets/js/setting.js', array( 'jquery' ), '1.0.0', true );

        // Enqueue Leaflet CSS
        wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );

        // Enqueue Leaflet JS
        wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );

        wp_enqueue_script( 'leaflet-custom-js', DYNAMIC_LEAFLET_PLUGIN_URL . 'assets/js/dynamic-leaflet.js', array( 'jquery','leaflet-js' ), DYNAMIC_LEAFLET_PLUGIN_VERSION, true );

        wp_localize_script( 'leaflet-custom-js', 'leaflet_data', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'some_variable' => 'some_value',
        ));

    }

    add_action( 'admin_enqueue_scripts', 'dynamic_leaflet_enqueue_styles_and_scripts' );
}