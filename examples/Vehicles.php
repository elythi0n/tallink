<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    // ** required for vehicle prices
    "outwardSailId" => "2195288",
];

// ** journey vehicle prices and availability
$vehicles = marcosraudkett\Tallink::getInstance($params)->vehiclePrices();

// ** vehicles
print_r($vehicles);
