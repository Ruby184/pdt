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
        $whereInSections = implode(', ', array_fill(0, count($request->sections), '?'));

        $points = DB::select(
            "SELECT point.name, point.amenity, ST_AsGeoJSON(st_transform(point.way, 4326)) AS geojson
            FROM planet_osm_point point
            JOIN planet_osm_polygon polygon
            ON ST_Contains(polygon.way, point.way)
            WHERE point.amenity IN ({$whereInAmenity})
            AND polygon.osm_id IN ({$whereInSections});",
            array_merge(
                $request->input('amenity', []),
                $request->input('sections', [])
            )
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
        $whereInIds = implode(', ', array_fill(0, count($request->ids), '?'));

        $sections = DB::select(
            "SELECT name, st_asgeojson(st_transform(planet_osm_polygon.way, 4326)) as geojson
            FROM planet_osm_polygon
            WHERE planet_osm_polygon.osm_id IN ({$whereInIds})
            AND admin_level = '9'",
            $request->input('ids', [])
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

    public function getSectionsSelect(Request $request) {
        return DB::select(
            "SELECT sections.osm_id AS id, sections.name AS text FROM planet_osm_polygon sections
            JOIN planet_osm_polygon city ON ST_INTERSECTS(city.way, sections.way)
            WHERE city.name = 'Bratislava'
            AND sections.boundary = 'administrative'
            AND sections.admin_level = '9'
            GROUP BY id, text
            ORDER BY text ASC"
        );
    }

    public function getPosition(Request $request, $lng, $lat, $distance) {
        $whereInAmenity = implode(', ', array_fill(0, count($request->amenity), '?'));

        $points = DB::select(
            "SELECT point.name, point.amenity, ST_AsGeoJSON(st_transform(point.way, 4326)) AS geojson
            FROM planet_osm_point point
            WHERE point.amenity IN ({$whereInAmenity})
            AND ST_Distance_Sphere(
                    ST_GeomFromText('POINT({$lng} {$lat})', 4326),
                    st_transform(point.way, 4326)
                ) <= ?",
            array_merge(
                $request->input('amenity', []),
                [$distance]
            )
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

    public function getPlace(Request $request, $lng, $lat, $vehicle = 'car') {
        if ($vehicle === 'car') {
            $where = "place.amenity IN ('"
                .implode("', '", [
                    'parking_entrance',
                    'parking_space',
                    'parking',
                ])."')";
        } else {
            $where = "place.highway = 'bus_stop'";
        }

        $place = DB::select(
            "SELECT place.name, place.amenity, ST_AsGeoJSON(st_transform(place.way, 4326)) AS geojson
            FROM planet_osm_point place
            WHERE {$where}
            ORDER BY ST_Distance(
                ST_GeomFromText('POINT({$lng} {$lat})', 4326),
                st_transform(place.way, 4326)
            ) ASC LIMIT 1"
        );

        $data = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($place as $p) {
            $data['features'][] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geojson),
                'properties' => [
                    'title' => $p->name,
                    'marker-symbol' => $vehicle === 'car' ? 'parking' : 'bus',
                    'marker-color' => $vehicle === 'car' ? '#1035b2' : '#efda1c'
                ],
            ];
        }

        return $data;
    }
}
