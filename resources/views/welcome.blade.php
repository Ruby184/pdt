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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap2/bootstrap-switch.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css" rel="stylesheet" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    </head>
    <body>
        <div id="app">
            <div id="sidebar-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Kam večer</h2>
                            <form>
                                <fieldset class="form-group">
                                    <legend>Chcem navštíviť</legend>
                                    <div class="form-group">
                                        <select multiple class="form-control" id="amenity">
                                            <option value="cinema">Kino</option>
                                            <option value="theatre">Divadlo</option>
                                            <option value="restaurant">Reštaurácia</option>
                                            <option value="pub">Krčma</option>
                                            <option value="bar">Bar</option>
                                            <option value="cafe">Kaviareň</option>
                                            <option value="gambling">Herňa</option>
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset class="form-group">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#filter-sections"><span class="glyphicon glyphicon-search"></span> Mestské časti</a></li>
                                        <li><a data-toggle="tab" href="#filter-position"><span class="glyphicon glyphicon-map-marker"></span> Pozícia na mape</a></li>
                                    </ul>
                                </fieldset>

                                <div class="tab-content">
                                    <div id="filter-sections" class="tab-pane fade in active">
                                        <div class="form-group">
                                            <select multiple class="form-control" id="sections">

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="checkbox" name="show-sections" id="show-sections" checked />
                                        </div>
                                    </div>
                                    <div id="filter-position" class="tab-pane fade">
                                        <div class="form-group">
                                            <label class="sr-only" for="distance">Vzdialenosť (v kilometroch)</label>
                                            <div class="input-group">
                                                <input type="number" min="0" step="0.1" class="form-control" id="distance" value="2" placeholder="Vzdialenosť">
                                                <div class="input-group-addon">km</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <fieldset class="form-group">
                                    <legend>Na presun chcem použiť</legend>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <i class="fa fa-car"></i>
                                            <input type="radio" name="place" value="car" autocomplete="off" checked> Auto
                                        </label>
                                        <label class="btn btn-primary">
                                            <i class="fa fa-bus"></i>
                                            <input type="radio" name="place" value="bus" autocomplete="off"> MHD
                                        </label>
                                    </div>
                                </fieldset>
                                <input type="checkbox" name="show-trace" id="show-trace" checked />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map"></div>
        </div>
        <script type="text/javascript" src="https://api.mapbox.com/mapbox.js/v3.0.1/mapbox.js"></script>
        <script type="text/javascript" src="{!! elixir('js/app.js') !!}"></script>
    </body>
</html>
