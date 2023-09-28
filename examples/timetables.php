<?php

require_once __DIR__ . "/vendor/autoload.php";

use marcosraudkett\Tallink\Constants\Locale;
use marcosraudkett\Tallink\Constants\Station;
use marcosraudkett\Tallink\Constants\Voyage;
use marcosraudkett\Tallink\Requests\GetTimetablesRequest;
use marcosraudkett\Tallink\Tallink;

$tallink = new Tallink;

$request = new GetTimetablesRequest(
    oneWay: true,
    voyageType: Voyage::CRUISE,
    dateFrom: date('Y-m-d'),
    dateTo: date('Y-m-d', strtotime('+2 days')),
    from: Station::STOCKHOLM,
    to: Station::TALLINN,
    locale: Locale::ENGLISH
);

$request = $tallink->send($request);

$response = $request->json();

print_r($response);