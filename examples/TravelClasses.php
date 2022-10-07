<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    "outwardSailId" => "2195135",
    "includeRegularCabins" => true,
    "includeSpecialCabins" => false,
    "includeSharedCabins" => false,
    "includePetCabins" => false,
];

$results = marcosraudkett\Tallink::getInstance()->setParams($params)->travelClasses();

// ** results
print_r($results);
