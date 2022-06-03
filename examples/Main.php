<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => "2022-06-02",
    "dateTo" => "2022-06-04",

    // ** required for vehicle prices
    "outwardSailId" => "2195288",
];

$tallink = new marcosraudkett\Tallink($params);

// ** journeys
$journeys = $tallink->journeys();

// ** journeys
print_r($journeys);

// ** journey vehicle prices and availability
$vehicles = $tallink->vehiclePrices();

// ** vehicles
print_r($vehicles);

// ** journey land services
$landServices = $tallink->landServices();

// ** land services
print_r($landServices);

// ** print all results
print_r(
    $tallink->results()
);
