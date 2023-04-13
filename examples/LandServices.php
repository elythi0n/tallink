<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

// ** parameters
$params = [
    // ** required for vehicle prices
    "outwardSailId" => "2195288",
];

// ** land services
$landServices = marcosraudkett\Tallink::getInstance()->setParams($params)->landServices();

// ** land services
print_r($landServices);
