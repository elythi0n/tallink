<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => date('Y-m-d'),
    "dateTo" => date('Y-m-d', strtotime('+2 days')),
];

$journeys = marcosraudkett\Tallink::getInstance()->setParams($params)->journeys();

// ** journeys
print_r($journeys);
