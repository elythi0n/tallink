<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

test('Fetch hotels', function () {
    $hotels = (new marcosraudkett\Tallink([
        "from" => "hel",
        "to" => "tal",
        "dateFrom" => "2022-06-02",
        "departureDate" => "2022-06-02",
    ]))->hotels();
  
    expect($hotels["list"][0]["code"])->toBeString();
});