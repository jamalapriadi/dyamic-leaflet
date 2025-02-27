jQuery(document).ready(function($) {
    var map = L.map('my-map').setView([51.505, -0.09], 13); //Example coordinates

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([51.5, -0.09]).addTo(map)
        .bindPopup('A pretty CSS popup.<br> Easily customizable.')
        .openPopup();

    // Access localized data
    console.log(leaflet_data.ajax_url);
    console.log(leaflet_data.some_variable);
});