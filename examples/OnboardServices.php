<?php

require_once "../src/Tallink.php";

// ** parameters
$params = [
    "outwardSailId" => "2152524"
];

$services = marcosraudkett\Tallink::getInstance()->setParams($params)->onboardServices();

// ** services
print_r($services);
