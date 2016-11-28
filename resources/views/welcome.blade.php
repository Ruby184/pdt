<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mapbox-token" content="{{ config('services.mapbox.token') }}">
        <title>PDT</title>
        <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />
        <link href="https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.css" rel="stylesheet" />
    </head>
    <body>
        <div id="app">
            <div id="sidebar-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="map"></div>
        </div>
        <script src="https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.js"></script>
        <script type="text/javascript" src="{!! elixir('js/app.js') !!}"></script>
    </body>
</html>
