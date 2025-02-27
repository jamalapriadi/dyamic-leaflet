<?php 

if(!defined('ABSPATH')){
    exit;
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

add_action('acf/init', 'dynamic_leaflet_register_acf_fields');

function dynamic_leaflet_remove_acf_fields() {
    if (function_exists('acf_get_field_groups')) {
        $groups = acf_get_field_groups();

        foreach ($groups as $group) {
            if ($group['key'] === 'dynamic_leaflet_map_information') { // Replace with your group key
                acf_delete_field_group($group['ID']);
            }
        }
    }
}