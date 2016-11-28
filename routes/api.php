<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/

Route::get('points', function (Request $request) {
    $points = DB::select("SELECT ST_AsGeoJSON(st_transform(way, 4326)) AS geojson FROM planet_osm_point WHERE planet_osm_point.amenity='restaurant';");

    foreach ($points as $point) {
        $data[] = [
            'type' => 'Feature',
            'geometry' => json_decode($point->geojson)
        ];
    }

    return $data;
});
