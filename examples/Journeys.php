<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => "2022-06-02",
    "dateTo" => "2022-06-04",
];

$journeys = marcosraudkett\Tallink::getInstance($params)->journeys();

// ** journeys
print_r($journeys);
