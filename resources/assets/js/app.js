
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
$('#amenity').select2();

/*
$('#sections').select2({
    ajax: {
        url: 'api/sections-select'
    }
});
*/

$.getJSON('api/sections-select', function(json) {
    $('#sections').select2({
        data: json
    })
});

const map = L.mapbox.map('map', 'mapbox.streets').setView([48.14, 17.108], 13);

var layer = L.mapbox.featureLayer().addTo(map);
var place = L.mapbox.featureLayer().addTo(map);

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

var position = L.mapbox.featureLayer();
var circleMarker;
var latlng;

map.on('click', function(ev) {
    if (!map.hasLayer(position)) {
        return;
    }

    var c = latlng = ev.latlng;

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

    $('#distance').trigger('change');
});

$('#amenity, #sections').on('change', function(event) {
    layer.clearLayers();

    $.getJSON('api/points', { 'amenity': $('#amenity').val(), 'sections': $('#sections').val() }, function(json) {
        layer.setGeoJSON(json);
    });
});

$('#sections').on('change', function(event) {
    $.getJSON('api/sections', { 'ids': $(this).val() }, function(json) {
        sections.setGeoJSON(json);
    });
});

$('#distance').on('change', function(event) {
    layer.clearLayers();

    if (circleMarker) {
        circleMarker.remove();
    }

    if (latlng) {
        $.getJSON(
            'api/position/' + latlng.lng + '/' + latlng.lat + '/' + $(this).val() * 1000,
            {
                'amenity': $('#amenity').val()
            },
            function(json) {
                layer.setGeoJSON(json);
            }
        );

        circleMarker = L.circle([latlng.lat, latlng.lng], $(this).val() * 1000).addTo(map);
    }
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr('href') // activated tab

    if (target == '#filter-sections') {
        map.removeLayer(position);
        map.addLayer(sections);

        if (circleMarker) {
            circleMarker.remove();
        }

        $('#sections').trigger('change');
    } else if (target == '#filter-position') {
        map.addLayer(position);
        map.removeLayer(sections);

        $('#distance').trigger('change');
    }
});

layer.on('click', function(e) {
    var vehicle = $('input[name="place"]:checked').val();

    console.log('api/place/' + e.latlng.lng + '/' + e.latlng.lat + '/' + vehicle);

    $.getJSON('api/place/' + e.latlng.lng + '/' + e.latlng.lat + '/' + vehicle,
        function(json) {
            place.setGeoJSON(json);
        }
    );
});
