<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

test('Fetch hotels', function () {
    $hotels = (new marcosraudkett\Tallink())->setParams([
        "departureDate" => date('Y-m-d'), // required for hotels
        "dateFrom" => date('Y-m-d'),
        "dateTo" => date('Y-m-d', strtotime('+4 days')),
    ])->hotels();
  
    expect($hotels["list"][0]["code"])->toBeString();
});