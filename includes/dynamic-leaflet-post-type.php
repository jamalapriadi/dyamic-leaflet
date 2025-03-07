<?php 

namespace DynamicLeaflet\Includes;

if(!defined('ABSPATH')){
    exit;
}

class DynamicLeafletRegisterPostType{
    function __construct(){
        
    }

    function init(){
        add_action('init', array($this, 'dynamic_leaflet_register_post_type'));
        add_action('acf/init', array($this,'dynamic_leaflet_register_acf_fields'));
        add_filter( 'manage_dynamic-leaflet_posts_columns', array($this,'acf_admin_columns_add_columns') ); 
        add_action( 'manage_dynamic-leaflet_posts_custom_column', array($this,'acf_admin_columns_display_columns'), 10, 2 ); 
        add_filter( 'manage_edit-dynamic-leaflet_sortable_columns', array($this,'acf_admin_columns_sortable_columns') ); 
        add_action( 'pre_get_posts', array($this,'acf_admin_columns_orderby') );
    }

    function dynamic_leaflet_register_post_type(){
        $labels = array(
            'name' => 'Dymanic Leaflet',
            'singular_name' => 'Dynamic Leaflet',
            'menu_name' => 'Dymanic Leaflet',
            'all_items' => 'All Locations',
            'edit_item' => 'Edit Location',
            'view_item' => 'View Locations',
            'view_items' => 'View Location',
            'add_new_item' => 'Add New Location',
            'add_new' => 'Add New Location',
            'new_item' => 'New Location',
            'parent_item_colon' => 'Parent Location:',
            'search_items' => 'Search Location',
            'not_found' => 'No Location Found',
            'not_found_in_trash' => 'No Location found in Trash',
            'archives' => 'Location Archives',
            'attributes' => 'Location Attributes',
            'insert_into_item' => 'Insert into Location',
            'uploaded_to_this_item' => 'Uploaded to this Location',
            'filter_items_list' => 'Filter Location list',
            'filter_by_date' => 'Filter Location by date',
            'items_list_navigation' => 'Location list navigation',
            'items_list' => 'Location list',
            'item_published' => 'Location published.',
            'item_published_privately' => 'Location published privately.',
            'item_reverted_to_draft' => 'Location reverted to draft.',
            'item_scheduled' => 'Location scheduled.',
            'item_updated' => 'Location updated.',
            'item_link' => 'Location Link',
            'item_link_description' => 'A link to a Location.',
        );
    
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'has_archive'=> true,
            'rewrite' => array('slug' => 'dynamic-leaflet'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'capability_type' => 'post',
            'menu_position' => 5,
            'menu_icon' => 'dashicons-admin-site-alt2',
            // 'taxonomies'   => array('category'),
        );
    
        register_post_type('dynamic-leaflet', $args);
    }

    function dynamic_leaflet_register_acf_fields() {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'dynamic_leaflet_map_information',
                'title' => 'Map Information',
                'fields' => array(
                    array(
                        'key' => 'dynamic_leaflet_field_latitude',
                        'label' => 'Latitude',
                        'name' => 'latitude',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'dynamic_leaflet_field_longtitude',
                        'label' => 'Longtitude',
                        'name' => 'longtitude',
                        'type' => 'text',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'dynamic-leaflet',
                        ),
                    ),
                ),
            ));
        }
    }

    function dynamic_leaflet_remove_acf_fields() {
        if (function_exists('acf_get_field_groups')) {
            $groups = acf_get_field_groups();
    
            foreach ($groups as $group) {
                if ($group['key'] === 'dynamic_leaflet_map_information') { 
                    acf_delete_field_group($group['ID']);
                }
            }
        }
    }

    function acf_admin_columns_add_columns( $columns ) {
        $columns['latitude'] = __( 'Latitude', 'dyamic-leaflet' ); 
        $columns['longtitude'] = __( 'Longtitude', 'dyamic-leaflet' );
    
        if (isset($columns['date'])) {
            unset($columns['date']); // Remove the date column
        }
    
        $columns['date'] = __( 'Date', 'dyamic-leaflet' );
    
        return $columns;
    }

    function acf_admin_columns_display_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'latitude':
                $acf_field_value = get_field( 'latitude', $post_id ); // Replace 'my_acf_field' with your ACF field name
                if ( $acf_field_value ) {
                    echo esc_html( $acf_field_value ); // Escape the output
                } else {
                    echo '—'; // Display a placeholder if the field is empty
                }
                break;
            case 'longtitude':
                $acf_field_value = get_field( 'longtitude', $post_id ); // Replace 'my_acf_field' with your ACF field name
                if ( $acf_field_value ) {
                    echo esc_html( $acf_field_value ); // Escape the output
                } else {
                    echo '—'; // Display a placeholder if the field is empty
                }
                break;
        }
    }

    //Make ACF column sortable
    function acf_admin_columns_sortable_columns( $columns ) {
        $columns['latitude'] = 'latitude'; // Replace 'my_acf_field' with your ACF field name
        $columns['longtitude'] = 'longtitude';
        return $columns;
    }

    function acf_admin_columns_orderby( $query ) {
        if ( ! is_admin() ) {
            return;
        }
    
        $orderby = $query->get( 'orderby');
    
        if ( 'latitude' == $orderby ) { // Replace 'my_acf_field' with your ACF field name
            $query->set( 'meta_key', 'latitude' ); // Replace 'my_acf_field' with your ACF field name
            $query->set( 'orderby', 'meta_value' );
        }else if('longtitude' == $orderby){
            $query->set( 'meta_key', 'longtitude' );
            $query->set( 'orderby', 'meta_value' );
        }
    }
}
