<?php

require_once "../src/Tallink.php";

$params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => "2022-06-02",
    "dateTo" => "2022-06-04",
];

$tallink = new marcosraudkett\Tallink($params);

// fetch journeys
$tallink->journeys();

// set outwardSailId parameter (you can get this from journeys "sailId")
$tallink->setParam("outwardSailId", "2195288");

// fetch vehicle prices (for id 2195288)
$tallink->vehiclePrices();

// fetch land services (for id 2195288)
$tallink->landServices();

// print out the results
print_r(
    $tallink->results()
);

// ** to only get journeys
$journeys = $tallink->results()["journeys"];