
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/*
Vue.component('app-menu', require('./components/Menu.vue'));
Vue.component('app-map', require('./components/Map.vue'));
*/

const app = new Vue({
    el: '#app'
});

$('input[type="checkbox"]').bootstrapSwitch();
$('select').select2();

const map = L.mapbox.map('map', 'mapbox.streets').setView([48.14, 17.108], 13);

var layer = L.mapbox.featureLayer().addTo(map);

layer.on('click', function(e) {
    e.layer.openPopup();
});

layer.on('mouseout', function(e) {
    e.layer.closePopup();
});

var sections = L.mapbox.featureLayer().addTo(map);

$('#show-sections').on('switchChange.bootstrapSwitch', function(event, state) {
    if (state && !map.hasLayer(sections)) {
        map.addLayer(sections);
    } else if (!state && map.hasLayer(sections)) {
        map.removeLayer(sections);
    }
});

var position = L.mapbox.featureLayer().addTo(map);

map.on('click', function(ev) {
    var c = ev.latlng;

    var geojson = {
        type: 'FeatureCollection',
        features: [
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [c.lng, c.lat]
                },
                "properties": {
                    "marker-color": "#ff8888",
                    'marker-symbol': 'star'
                }
            }
        ]
    };

    position.setGeoJSON(geojson);
});

$('#amenity').on('change', function(event) {
    $.getJSON('api/points', { 'amenity': $(this).val() }, function(json) {
        layer.setGeoJSON(json);
    });
});

$('#sections').on('change', function(event) {
    $.getJSON('api/sections', { 'name': $(this).val() }, function(json) {
        sections.setGeoJSON(json);
    });
});
