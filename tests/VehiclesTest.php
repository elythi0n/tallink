<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

test('Fetch vehicles', function () {
    $vehicles = (new marcosraudkett\Tallink([
        "outwardSailId" => "2195288"
    ]))->vehiclePrices();
  
    expect($vehicles[0]["carCategory"])->toBeString();
});