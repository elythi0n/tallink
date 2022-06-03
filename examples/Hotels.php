<?php

require_once "../src/Tallink.php";

$hotels = marcosraudkett\Tallink::getInstance([
    "from" => "hel",
    "to" => "tal",
    "dateFrom" => "2022-06-02",
    "departureDate" => "2022-06-02",
])->hotels();

// ** hotels
print_r($hotels);
