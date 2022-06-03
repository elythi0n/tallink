<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

test('Fetch journeys', function () {
    $journeys = (new marcosraudkett\Tallink([
        // ** minimum required params for journeys()
        "from" => "tal",
        "to" => "hel",
        "dateFrom" => "2022-06-02",
        "dateTo" => "2022-06-04",
    ]))->journeys();

    expect($journeys[0]["sailId"])->toBeInt();
});