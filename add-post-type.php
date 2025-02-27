<?php 
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
        'key' => 'group_67a722805f9ed',
        'title' => 'Map Information',
        'fields' => array(
            array(
                'key' => 'field_67a722800e1cd',
                'label' => 'Latitude',
                'name' => 'latitude',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_67a722920e1ce',
                'label' => 'Longtitude',
                'name' => 'longtitude',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'allow_in_bindings' => 0,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
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
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ) );
} );

add_action( 'init', function() {
	register_post_type( 'dynamic-leaflet', array(
        'labels' => array(
            'name' => 'Dymanic Leaflet',
            'singular_name' => 'Dynamic Leaflet',
            'menu_name' => 'Dymanic Leaflet',
            'all_items' => 'All Dymanic Leaflet',
            'edit_item' => 'Edit Dynamic Leaflet',
            'view_item' => 'View Dynamic Leaflet',
            'view_items' => 'View Dymanic Leaflet',
            'add_new_item' => 'Add New Dynamic Leaflet',
            'add_new' => 'Add New Dynamic Leaflet',
            'new_item' => 'New Dynamic Leaflet',
            'parent_item_colon' => 'Parent Dynamic Leaflet:',
            'search_items' => 'Search Dymanic Leaflet',
            'not_found' => 'No dymanic leaflet found',
            'not_found_in_trash' => 'No dymanic leaflet found in Trash',
            'archives' => 'Dynamic Leaflet Archives',
            'attributes' => 'Dynamic Leaflet Attributes',
            'insert_into_item' => 'Insert into dynamic leaflet',
            'uploaded_to_this_item' => 'Uploaded to this dynamic leaflet',
            'filter_items_list' => 'Filter dymanic leaflet list',
            'filter_by_date' => 'Filter dymanic leaflet by date',
            'items_list_navigation' => 'Dymanic Leaflet list navigation',
            'items_list' => 'Dymanic Leaflet list',
            'item_published' => 'Dynamic Leaflet published.',
            'item_published_privately' => 'Dynamic Leaflet published privately.',
            'item_reverted_to_draft' => 'Dynamic Leaflet reverted to draft.',
            'item_scheduled' => 'Dynamic Leaflet scheduled.',
            'item_updated' => 'Dynamic Leaflet updated.',
            'item_link' => 'Dynamic Leaflet Link',
            'item_link_description' => 'A link to a dynamic leaflet.',
        ),
        'public' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-admin-site-alt2',
        'supports' => array(
            0 => 'title',
            1 => 'editor',
            2 => 'thumbnail',
            3 => 'custom-fields',
        ),
        'delete_with_user' => false,
    ) );
} );



