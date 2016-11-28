<template>
    <div id="map"></div>
</template>

<script>
    export default {
        mounted() {
            L.mapbox.map('map', 'mapbox.streets').setView([40, -74.50], 9);
        }
    }
</script>
