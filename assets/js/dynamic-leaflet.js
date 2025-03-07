document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('dynamic_leaflet_map', {
        center: [mapParams.mapSettings.defaultLat, mapParams.mapSettings.defaultLng],
        zoom: mapParams.mapSettings.zoomLevel,
        attributionControl:mapParams.mapSettings.attribution_control,
        scrollWheelZoom: mapParams.mapSettings.scrool_wheel_zoom, // Prevent zooming with scroll
        doubleClickZoom: mapParams.mapSettings.double_click_zoom, // Disable double-click zoom
        zoomControl: mapParams.mapSettings.zoom_control,     // Hide zoom controls
    });

    console.log(mapParams)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:mapParams.mapSettings. attribution
    }).addTo(map);

    var bounds = new L.LatLngBounds();

    if (typeof mapParams.mapData !== "undefined") {
        mapParams.mapData.forEach(function (post) {
            var marker = L.marker([post.latitude, post.longitude]).addTo(map);
            
            var html = '<b>' + post.title + '</b><br>' ;
            
            if(post.featured_image) {
                html += '<img src="' + post.featured_image + '" style="width:100%;height:auto;">' 
            }

            html += '<p>' + post.excerpt + '</p><br>';

            html += '<a href="' + post.permalink + '" target="_blank">Read More</a>';

            marker.bindPopup(html);

            bounds.extend([post.latitude, post.longitude]);
        });
    }

    map.fitBounds(bounds, { maxZoom: mapParams.mapSettings.max_zoom });

});