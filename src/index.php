<!DOCTYPE html>
<html>
<head>
	<title>Interopérabilité</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../src/public/assets/materialize/css/materialize.min.css">
	<script src="../src/public/assets/jquery/jquery-3.3.1.min.js"></script> 
	<script src="../src/public/assets/materialize/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../src/public/assets/leaflet/leaflet.css">
	<script src="../src/public/assets/leaflet/leaflet.js"></script> 
	<script src="../src/public/assets/app/app.js"></script> 
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
		<div class="row">
			<div id="map" class="col l12" style="height: 400px;"></div>
		</div>
	</div>

</body>
</html>