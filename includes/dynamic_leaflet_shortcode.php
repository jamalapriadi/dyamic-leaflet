<?php 

namespace DynamicLeaflet\Includes;

if(!defined('ABSPATH')){
    exit;
}

class DynamicLeafletShortcode{
    function __construct(){
        add_action( 'wp_enqueue_scripts', array($this, 'dynamic_leaflet_enqueue_styles_and_scripts') );
        add_action('wp_enqueue_scripts', array($this, 'set_diplay_markers'));
        add_shortcode( 'dynamic-leaflet-map', [$this,'display_leaflet_map'] );
    }

    /**
     * add style and script for frontend
     */
    function dynamic_leaflet_enqueue_styles_and_scripts(){

        // Enqueue Leaflet CSS
        wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', array(), '1.9.4' );

        // Enqueue Leaflet JS
        wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
        wp_enqueue_script( 'custom-leaflet', DYNAMIC_LEAFLET_PLUGIN_URL . 'assets/js/dynamic-leaflet.js', array( 'jquery','leaflet-js' ), DYNAMIC_LEAFLET_PLUGIN_VERSION, true );

    }

    /**
     * show all markers on the map
     */
    function set_diplay_markers( $atts ) {
        $options = get_option('leaflet_map_options');

        $posts = get_posts(array(
            'post_type'      => 'dynamic-leaflet', // Replace with your custom post type
            'posts_per_page' => -1,
        ));
    
        $map_data = array();
        foreach ($posts as $post) {
            $latitude  = get_field('latitude', $post->ID); // ACF field for latitude
            $longitude = get_field('longitude', $post->ID); // ACF field for longitude

            if ($latitude && $longitude) {
                $map_data[] = array(
                    'title'     => get_the_title($post->ID),
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                );
            }
        }

        $args = array(
            'post_type'      => 'dynamic-leaflet', // Replace with your custom post type
            'posts_per_page' => -1, // Number of posts to retrieve
        );
        
        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $latitude  = get_field('latitude', get_the_ID());
                $longitude = get_field('longtitude', get_the_ID());
                
                $map_data[] = array(
                    'title'     => get_the_title(),
                    'excerpt'   => get_the_excerpt(),
                    'permalink'=> get_the_permalink(),
                    'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                );
            }

            $localize_data = array(
                'map_id'      => 'leaflet-map-' . uniqid(),
                'mapData'     => $map_data,
                'ajaxUrl'     => admin_url('admin-ajax.php'),
                'siteUrl'     => get_site_url(),
                'mapSettings' => array(
                    'defaultLat' =>esc_attr($options['latitude'] ? $options['latitude'] : '-6.898678379194156'),   // Default map center latitude
                    'defaultLng' =>esc_attr($options['longitude'] ? $options['longitude'] : '109.12307135343205'),   // Default map center longitude
                    'zoomLevel'  =>isset($options['zoom']) ? $options['zoom'] : 13,   // Default zoom level
                    'max_zoom'    =>isset($options['max_zoom']) ? $options['max_zoom'] : 18,   // Default max zoom level
                    'zoom_control' =>isset($options['zoom_control']) ? $options['zoom_control'] == 'yes' ? true : false : true,   // Default zoom control
                    'scrool_wheel_zoom' =>isset($options['scrool_wheel_zoom']) ? $options['scrool_wheel_zoom'] == 'yes' ? true : false : true,   // Default scroll wheel
                    'double_click_zoom' =>isset($options['double_click_zoom']) ? $options['double_click_zoom'] == 'yes' ? true : false : true,
                    'height'     =>esc_attr($options['height'] ? $options['height'] : '400px'),   // Default map height
                    'width'      =>esc_attr($options['width'] ? $options['width'] : '100%'),   // Default map width
                    'tile_url'   =>esc_attr($options['tile_url'] ? $options['tile_url'] : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),   // Default tile layer URL
                    'attribution'=>esc_attr($options['attribution'] ? $options['attribution'] : 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'),
                    'attribution_control'=>isset($options['attribution_control']) ? $options['attribution_control'] == 'yes' ? true : false : true,
                ),
                'nonce'       => wp_create_nonce('leaflet_nonce'), // Security nonce
            );

            wp_reset_postdata();
        }

        
        wp_localize_script('custom-leaflet', 'mapParams', $localize_data);
    }

    /**
     * Display the map
     */
    function display_leaflet_map() {
        $options = get_option('leaflet_map_options');

        return '<div id="dynamic_leaflet_map" style="height: '.esc_attr( $options['height'] ? $options['height'] : '400px' ).';width: '.esc_attr($options['width'] ? $options['width'] : '100%').'"></div>';
    }
}