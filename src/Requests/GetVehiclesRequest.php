<?php

namespace marcosraudkett\Tallink\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetVehiclesRequest extends Request
{
    /**
     * HTTP Method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    public function __construct(
        public string $outwardSailId
    ){
    }

    protected function defaultQuery(): array
    {
        return [
            'outwardSailId' => $this->outwardSailId
        ];
    }

    /**
     * Resolve the endpoint
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/vehicles';
    }
}