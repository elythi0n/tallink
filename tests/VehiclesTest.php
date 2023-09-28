<?php

require_once dirname(__DIR__). "/vendor/autoload.php";

test('Fetch timetables', function () {
    $tallink = new marcosraudkett\Tallink\Tallink;
    $request = new marcosraudkett\Tallink\Requests\GetVehiclesRequest(
        outwardSailId: "2195288",
    );
    $request = $tallink->send($request);

    $response = $request->json();

    expect($response['vehicles'])->toBeArray();
});