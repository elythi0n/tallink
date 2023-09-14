<?php

namespace marcosraudkett\Tallink\Requests;

use marcosraudkett\Tallink\Enums\Locale;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOnboardServicesRequest extends Request
{
    /**
     * HTTP Method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    public function __construct(
        public string $outwardSailId,
        public ?string $locale = null,
    ){
        if (!$locale) {
            $this->locale = Locale::ENGLISH;
        }
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
        return '/meals';
    }
}