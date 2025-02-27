<?php 

if(!defined('ABSPATH')){
    exit;
}

function acf_admin_columns_add_columns( $columns ) {
    // $columns['shortcode'] = __( 'Shortcode', 'shortcode' );
    $columns['latitude'] = __( 'Latitude', 'latitude' ); // Replace 'my_acf_field' with your ACF field name
	$columns['longtitude'] = __( 'Longtitude', 'Longtitude' );

    if (isset($columns['date'])) {
        unset($columns['date']); // Remove the date column
    }

    $columns['date'] = __( 'Date', 'date' );

    return $columns;
}
add_filter( 'manage_dynamic-leaflet_posts_columns', 'acf_admin_columns_add_columns' ); // Replace 'post' with your post type

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
add_action( 'manage_dynamic-leaflet_posts_custom_column', 'acf_admin_columns_display_columns', 10, 2 ); // Replace 'post' with your post type

//Make ACF column sortable
function acf_admin_columns_sortable_columns( $columns ) {
    $columns['latitude'] = 'latitude'; // Replace 'my_acf_field' with your ACF field name
	$columns['longtitude'] = 'longtitude';
    return $columns;
}
add_filter( 'manage_edit-dynamic-leaflet_sortable_columns', 'acf_admin_columns_sortable_columns' ); // Replace 'post' with your post type

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

add_action( 'pre_get_posts', 'acf_admin_columns_orderby' );