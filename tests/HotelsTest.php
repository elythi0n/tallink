<?php

require_once dirname(__DIR__). "/vendor/autoload.php";

test('Fetch timetables', function () {
    $tallink = new marcosraudkett\Tallink\Tallink;
    $request = new marcosraudkett\Tallink\Requests\GetHotelsRequest(
        dateFrom: date('Y-m-d'),
    );
    $request = $tallink->send($request);

    $response = $request->json();

    expect($response['dateFrom'])->toBeString();
    expect($response['cities'])->toBeArray();
    expect($response['hotels'])->toBeArray();
});