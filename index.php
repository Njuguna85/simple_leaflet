<?php
require 'dbase.php';

$db = new database();
$result = $db->get_points();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

  
  <link rel="stylesheet" type="text/css" href="leaflet-measure-master/scss/leaflet-measure.css">
  <link rel="stylesheet" type="text/css" href="Leaflet.LinearMeasurement-master/sass/Leaflet.LinearMeasurement.scss" />
    
  <!-- Leaflet css cdn link -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  
  <!-- Leaflet from a CDN -->
  <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
  integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
  crossorigin=""></script>
  <script src="leaflet-measure-master/src/leaflet-measure.js"></script>
  <script type="text/javascript" src="Leaflet.LinearMeasurement-master/src/Leaflet.LinearMeasurement.js"></script>

  
  <title>Leaflet</title>
</head>

<body>

    <h2>Let's create a Map</h2>

    <!-- Div tag to hold the map -->
    <div id="map" style="width: 900px; height: 500px"></div>

    <script>
    // Create a new instance of the map class
    var my_map = L.map(
        'map',{
            center: [-1.43128,36.68618],
            zoom: 7
        });

    //L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?').addTo(my_map);
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?', {attribution: '<a href="http://mutall.co.ke">Mutall</a>'});
    var  grayscale = L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png'); 
   
    // Add Point to map
    var mutall_marker = L.marker([-1.4289660,36.6888946]).bindPopup("Mutall Business Centre").addTo(my_map);
    
    // Add polyline
    var polyline = L.polyline([
        [-1.42723,36.68594],
        [-1.42586,36.69039],
        [-1.42299,36.69494]],
        {color: 'red', weight:8}
    ).addTo(my_map);

    // Add polygon
    var my_polygon = L.polygon(
        [[-1.42724,36.68586],
        [-1.42585,36.69038],
        [-1.42290,36.69490]],
        {color:'black', weight:2, fillColor: 'blue', fillOpacity:1}
    ).addTo(my_map);

    // Custom Marker point
    var customicon = L.icon({
                        iconSize: [50, 70],
                        iconAnchor: [12, 28],
                        popupAnchor: [0, 25],
                        iconUrl: "zone3.svg"
                    });
    var marker1 = L.marker([-1.4279660,36.6885946], {icon: customicon}).addTo(my_map);

    // Custom Functions
    var marker2 = L.marker([-1.427930,36.6885946]).addTo(my_map).bindPopup(createPopup("Text as a Parameter"));
    
    function createPopup(x) {
        return L.popup({
            keepInView:true, 
            closeButton:false
        }).setContent(x);
    }
   
    // Points from database
    var w_meters = <?php echo JSON_encode($result); ?>;
       for (var i = 0; i < w_meters.length; i++){
            L.marker(
                [w_meters[i].latitude, w_meters[i].longitude])
                .bindPopup(w_meters[i].full_name)
                .addTo(my_map);
       }

    // Control Layers
    var baseMaps = {
        "OSM": osm,
        "Grayscale": grayscale
    };

    var vector_contents = L.layerGroup([w_meters, my_polygon, polyline]);
    
    var overlays = {
        // "Water Meters": w_meters,
        // "Polygon": my_polygon,
        // "Polyline": polyline,
        "Content": vector_contents,
        };

    var controlLayers = L.control.layers(baseMaps, overlays, {collapsed: false}).addTo(my_map);


        // Adding Plugins
    var measureControl = L.control.measure({primaryLengthUnit: 'metres'});
    measureControl.addTo(my_map);

    map.addControl(new L.Control.LinearCore({
      unitSystem: 'imperial',
      color: '#FF0080',
      type: 'line'
    }));





    </script>


</body>


</html>