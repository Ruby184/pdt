
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


const map = L.mapbox.map('map', 'mapbox.streets').setView([48.14, 17.108], 13);

$.getJSON("api/points", function(json) {
    var layer = L.mapbox.featureLayer(json).addTo(map);

    layer.on('click', function(e) {
        e.layer.openPopup();
    });

    layer.on('mouseout', function(e) {
        e.layer.closePopup();
    });
});
