<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiController extends Controller
{
    protected $amenityIcons = [
        'cinema' => 'cinema',
        'theatre' => 'theatre',
        'bar' => 'bar',
        'pub' => 'beer',
        'restaurant' => 'restaurant',
        'cafe' => 'cafe',
        'gambling' => 'rocket',
    ];

    public function getPoints(Request $request) {
        $whereInAmenity = implode(', ', array_fill(0, count($request->amenity), '?'));

        $points = DB::select(
            "SELECT point.name, point.amenity, ST_AsGeoJSON(st_transform(point.way, 4326)) AS geojson
            FROM planet_osm_point point
            JOIN planet_osm_polygon polygon
            ON ST_Contains(polygon.way, point.way)
            WHERE point.amenity IN ({$whereInAmenity})
            AND polygon.name IN ('Karlova Ves');",
            $request->input('amenity', [])
        );

        $data = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points as $point) {
            $data['features'][] = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geojson),
                'properties' => [
                    'title' => $point->name,
                    'marker-symbol' => $this->amenityIcons[$point->amenity],
                    'marker-color' => '#548cba'
                ],
            ];
        }

        return $data;
    }

    public function getSections(Request $request) {
        $whereInName = implode(', ', array_fill(0, count($request->name), '?'));

        $sections = DB::select(
            "SELECT name, st_asgeojson(st_transform(planet_osm_polygon.way, 4326)) as geojson
            FROM planet_osm_polygon
            WHERE planet_osm_polygon.name IN ({$whereInName})",
            $request->input('name', [])
        );

        $data = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($sections as $section) {
            $data['features'][] = [
                'type' => 'Feature',
                'geometry' => json_decode($section->geojson),
                'properties' => [
                    'title' => $section->name,
                ],
            ];
        }

        return $data;
    }
}
