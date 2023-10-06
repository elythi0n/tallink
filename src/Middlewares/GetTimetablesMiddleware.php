<?php

namespace marcosraudkett\Tallink\Middlewares;

use Saloon\Contracts\Response;
use Saloon\Contracts\ResponseMiddleware;

/**
 * TODO: convert timetables response into an easier structure & migrate to saloon v3.
 */
class GetTimetablesMiddleware implements ResponseMiddleware
{
    public function __invoke(Response $response): void
    {
        // print_r($response);
        // print_r($response->pendingRequest->request->dateFrom);
    }
}