<?php

namespace marcosraudkett\Tallink;

use Saloon\Http\Connector;

class Tallink extends Connector
{
    /**
     * Constructor
     */
    public function __construct() 
    {
    }

    /**
     * Resolve the base URL of the service.
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://booking.tallink.com/api';
    }

    /**
     * Define default headers
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

}