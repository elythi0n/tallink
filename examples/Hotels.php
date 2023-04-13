<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

$hotels = marcosraudkett\Tallink::getInstance()->setParams([
    "departureDate" => date('Y-m-d'), // required for hotels
    "dateFrom" => date('Y-m-d'),
    "dateTo" => date('Y-m-d', strtotime('+4 days')),
])->hotels();

// ** hotels
print_r($hotels);
