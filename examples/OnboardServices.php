<?php

require_once dirname(__DIR__) . "/src/Tallink.php";

// ** parameters
$params = [
    "outwardSailId" => "2152524"
];

$services = marcosraudkett\Tallink::getInstance()->setParams($params)->onboardServices();

// ** services
print_r($services);
