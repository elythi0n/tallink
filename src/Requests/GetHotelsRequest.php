<?php

namespace marcosraudkett\Tallink\Requests;

use marcosraudkett\Tallink\Constants\Locale;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetHotelsRequest extends Request
{
    /**
     * HTTP Method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    public function __construct(
        public $dateFrom,
        public ?string $locale = null,
    ){
        if (!$locale) {
            $this->locale = Locale::ENGLISH;
        }
    }

    protected function defaultQuery(): array
    {
        return [
            'locale' => $this->locale,
            'dateFrom' => $this->dateFrom,
            'departureDate' => $this->dateFrom,
        ];
    }

    /**
     * Resolve the endpoint
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/hotels';
    }
}