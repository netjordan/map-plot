<?php
require_once "mapplot.class.php";

$mapplot = new MapPlot('test.png', -180, 180, -90, 90);
$mapplot->plot(-1.2, 53);
$mapplot->plot(-1.2, -53);
$mapplot->output();