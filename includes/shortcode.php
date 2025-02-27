<?php 
if(!defined('ABSPATH')){
    exit;
}

function dynamic_leaflet_map_shortcode( $atts ) {
    // Shortcode attributes
    $atts = shortcode_atts( array(
        'lat'    => '-6.898678379194156', // Default latitude
        'lng'    => '109.12307135343205',  // Default longitude
        'zoom'   => '13',     // Default zoom level
        'height' => '400px', // Default map height
        'marker_lat' => '-6.898678379194156', //optional marker latitude
        'marker_lng' => '109.12307135343205', //optional marker longitude
        'icon_url'   => 'https://cdn-icons-png.flaticon.com/512/5860/5860579.png', // URL to the custom icon
        'popup_text' => '',
    ), $atts );

    // Generate unique map ID
    $map_id = 'leaflet-map-' . uniqid();

    // Output HTML
    ob_start();
    ?>
    
    <div id="<?php echo esc_attr( $map_id ); ?>" style="height: <?php echo esc_attr( $atts['height'] ); ?>;"></div>
    
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var map = L.map('<?php echo esc_attr( $map_id ); ?>').setView([<?php echo esc_attr( $atts['lat'] ); ?>, <?php echo esc_attr( $atts['lng'] ); ?>], <?php echo intval( $atts['zoom'] ); ?>);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        <?php if ( $atts['marker_lat'] && $atts['marker_lng'] ) : ?>
            <?php if ( ! empty( $atts['icon_url'] ) ) : ?>
                var customIcon = L.icon({
                    iconUrl: '<?php echo esc_url( $atts['icon_url'] ); ?>',
                    iconSize: [32, 37], // size of the icon
                    iconAnchor: [16, 37], // point of the icon which will correspond to marker's location
                    popupAnchor: [0, -37] // point from which the popup should open relative to the iconAnchor
                });
                var marker = L.marker([<?php echo esc_attr( $atts['marker_lat'] ); ?>, <?php echo esc_attr( $atts['marker_lng'] ); ?>], {icon: customIcon}).addTo(map);

            <?php else : ?>
                var marker = L.marker([<?php echo esc_attr( $atts['marker_lat'] ); ?>, <?php echo esc_attr( $atts['marker_lng'] ); ?>]).addTo(map);
            <?php endif; ?>

            <?php if ( ! empty( $atts['popup_text'] ) ) : ?>
                marker.bindPopup('<?php echo esc_html( $atts['popup_text'] ); ?>');
            <?php endif; ?>
        <?php endif; ?>

    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode( 'dynamic_leaflet_map', 'dynamic_leaflet_map_shortcode' );