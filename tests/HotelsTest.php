<?php

require_once dirname(__DIR__). "/vendor/autoload.php";

use marcosraudkett\Tallink\Constants\Locale;

test('Fetch hotels & hotel services', function () {
    $tallink = new marcosraudkett\Tallink\Tallink;
    $request = new marcosraudkett\Tallink\Requests\GetHotelsRequest(
        dateFrom: date('Y-m-d'),
        locale: Locale::FINNISH
    );
    $request = $tallink->send($request);
    $response = $request->json();

    expect($response['dateFrom'])->toBeString();
    expect($response['cities'])->toBeArray();
    expect($response['hotels'])->toBeArray();
});