<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    // ** required for vehicle prices
    "outwardSailId" => "2195288",
];

// ** land services
$landServices = marcosraudkett\Tallink::getInstance($params)->landServices();

// ** land services
print_r($landServices);
