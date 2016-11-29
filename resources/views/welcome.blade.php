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
        <link href="http://www.bootstrap-switch.org/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css" rel="stylesheet" />
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
                                    <legend>Chcem ísť do</legend>
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
                                    <legend>Filter</legend>
                                    <div class="form-group">
                                        <label class="sr-only" for="distance">Vzdialenosť (v kilometroch)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" id="distance" value="5" placeholder="Vzdialenosť">
                                            <div class="input-group-addon">km</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sections">Mestské časti</label>
                                        <select multiple class="form-control" id="sections">
                                            <option value="Staré Mesto">Staré Mesto</option>
                                            <option value="Ružinov">Ružinov</option>
                                            <option value="Vrakuňa">Vrakuňa</option>
                                            <option value="Podunajské Biskupice">Podunajské Biskupice</option>
                                            <option value="Nové Mesto">Nové Mesto</option>
                                            <option value="Rača">Rača</option>
                                            <option value="Vajnory">Vajnory</option>
                                            <option value="Karlova Ves">Karlova Ves</option>
                                            <option value="Dúbravka">Dúbravka</option>
                                            <option value="Lamač">Lamač</option>
                                            <option value="Devín">Devín</option>
                                            <option value="Devínska Nová Ves">Devínska Nová Ves</option>
                                            <option value="Záhorská Bystrica">Záhorská Bystrica</option>
                                            <option value="Petržalka">Petržalka</option>
                                            <option value="Jarovce">Jarovce</option>
                                            <option value="Rusovce">Rusovce</option>
                                            <option value="Čunovo">Čunovo</option>
                                        </select>
                                    </div>
                                    <input type="checkbox" name="show-sections" id="show-sections" />
                                </fieldset>
                                <fieldset class="form-group">
                                    <legend>Pôjdem</legend>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="car" checked>
                                            Autom (nájdi mi parkoviská)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="bus">
                                            MHD (nájdi mi zastávky)
                                        </label>
                                    </div>
                                </fieldset>
                                <input type="checkbox" name="show-trace" />
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
