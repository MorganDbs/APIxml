<h1>Météo</h1>
<p class="divider" />

<?php
$opts = [
    'http' => [
        'proxy'=> 'tcp://127.0.0.1:8080',
        'request_fulluri'=> true
    ]
];
$context = stream_context_create($opts);

$positon = json_decode(file_get_contents('http://ip-api.com/json'));

$meteo = file_get_contents('http://www.infoclimat.fr/public-api/gfs/xml?_ll=' . $positon->lat . ',' . $positon->lon . '&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2', false);

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