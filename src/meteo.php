<h1>Météo</h1>
<p class="divider" />

<?php
$positon = simplexml_load_string(file_get_contents('http://ip-api.com/xml/' . $_SERVER['SERVER_ADDR']));
$lat = (string) current($positon->lat);
$lon = (string) current($positon->lon);

$meteo = file_get_contents('http://www.infoclimat.fr/public-api/gfs/xml?_ll=' . $lat . ',' . $lon . '&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2');

$meteo_xml = simplexml_load_string($meteo);

# START XSLT
$xslt = new XSLTProcessor();

# IMPORT STYLESHEET 1
$XSL = new DOMDocument();
$XSL->load( 'xml/meteo.xsl' );
$xslt->importStylesheet( $XSL );


#PRINT
$rendu = $xslt->transformToXML( $meteo_xml );
print_r($rendu);
?>
