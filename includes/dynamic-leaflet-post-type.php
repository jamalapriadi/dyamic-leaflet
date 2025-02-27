<?php 

if(!defined('ABSPATH')){
    exit;
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
        'show_in_rest' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive'=> true,
        'rewrite' => array('slug' => 'dynamic-leaflet'),
        'support'=>array('title','editor','thumbnail','custom-fields'),
        'capability_type' => 'post',
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-site-alt2'
    );

    register_post_type('dynamic-leaflet', $args);
}

add_action('init', 'dynamic_leaflet_register_post_type');
