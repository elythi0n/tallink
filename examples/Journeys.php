<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

use marcosraudkett\Tallink;

// ** parameters
$params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => date('Y-m-d'),
    "dateTo" => date('Y-m-d', strtotime('+2 days')),
];

$journeys = Tallink::getInstance()->setParams($params)->journeys();

// ** journeys
print_r($journeys);
