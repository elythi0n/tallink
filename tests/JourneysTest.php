<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

test('Fetch journeys', function () {
    $journeys = (new marcosraudkett\Tallink([
        // ** minimum required params for journeys()
        "from" => "tal",
        "to" => "hel",
        "dateFrom" => date('Y-m-d'),
        "dateTo" => date('Y-m-d', strtotime('+2 days')),
    ]))->journeys();

    expect($journeys[0]["sailId"])->toBeInt();
});