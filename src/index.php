<?php
$opts = [
    'http' => [
        'proxy'=> 'tcp://www-cache:3128',
        'request_fulluri'=> true
    ]
];
$context = stream_context_create($opts);
stream_context_set_default($opts);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Interopérabilité</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../src/public/assets/materialize/css/materialize.min.css">
	<script src="public/assets/jquery/jquery-3.3.1.min.js"></script> 
	<script src="public/assets/materialize/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="public/assets/leaflet/leaflet.css">
	<script src="public/assets/leaflet/leaflet.js"></script> 
	<script src="public/assets/app/app.js"></script> 
</head>
<body>

	<nav>
		<div class="nav-wrapper blue">
			<a href="#" class="brand-logo center">Interopérabilité</a>
		</div>
	</nav>

	<div class="container">
		<?php require ('meteo.php'); ?>
		<p class="divider"></p>
		<?php
			$xml = simplexml_load_string(file_get_contents('http://www.velostanlib.fr/service/carto'));
			foreach ($xml->markers->children() as $k => $v) {
				$marker = [
					'name' => current($v['name']),
					'number' => current($v['number']),
					'address' => current($v['address']),
					'fullAddress' => current($v['fullAddress']),
					'lat' => current($v['lat']),
					'lng' => current($v['lng']),
					'open' => current($v['open']),
					'bonus' => current($v['bonus']),
					'station'=> []
				];

				$station = simplexml_load_string(file_get_contents('http://www.velostanlib.fr/service/stationdetails/nancy/' . $marker['number']));
				$marker['station'] = $station;

				$markers[] = $marker;
			}
		?>
			<script type="text/javascript">
			$(() => {
				Interoperabilite.init(<?php echo file_get_contents('http://ip-api.com/json'); ?>, <?php echo json_encode($markers); ?>);
			});
		</script>
		<div class="row">
			<div id="map" class="col l12" style="height: 400px;"></div>
		</div>
	</div>

</body>
</html>