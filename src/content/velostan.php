<?php
$opts = [
	'http' => [
		'proxy'=> 'tcp://127.0.0.1:8080', 
		'request_fulluri'=> true
	]
];
$context = stream_context_create($opts); 

$velostan = file_get_contents('http://www.velostanlib.fr/service/carto', false);

echo '<pre>';
print_r(simplexml_load_string($velostan));
echo '</pre>';
?>

<link rel="stylesheet" type="text/css" href="../src/public/assets/leaflet/leaflet.css">
<script src="../src/public/assets/leaflet/leaflet.js"></script> 
<script src="../src/public/assets/app/app.js"></script> 

<h1>Vélostan</h1>

<div id="map"></div>