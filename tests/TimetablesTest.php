<?php

require_once dirname(__DIR__). "/vendor/autoload.php";

test('Fetch timetables', function () {
    $tallink = new marcosraudkett\Tallink\Tallink;
    $request = new marcosraudkett\Tallink\Requests\GetTimetablesRequest(
        oneWay: true,
        voyageType: "SHUTTLE",
        dateFrom: date('Y-m-d'),
        dateTo: date('Y-m-d', strtotime('+2 days')),
    );
    $request = $tallink->send($request);

    $response = $request->json();

    expect($response['defaultSelections'])->toBeArray();
    expect($response['trips'])->toBeArray();
});