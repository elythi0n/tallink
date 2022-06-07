<?php

require_once "../src/Tallink.php";

$hotels = marcosraudkett\Tallink::getInstance([
    "departureDate" => date('Y-m-d'), // required for hotels
    "dateFrom" => date('Y-m-d'),
    "dateTo" => date('Y-m-d', strtotime('+4 days')),
])->hotels();

// ** hotels
print_r($hotels);
