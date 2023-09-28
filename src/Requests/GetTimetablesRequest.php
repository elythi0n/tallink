<?php

namespace marcosraudkett\Tallink\Requests;

use marcosraudkett\Tallink\Constants\Locale;
use marcosraudkett\Tallink\Constants\Station;
use marcosraudkett\Tallink\Constants\Voyage;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetTimetablesRequest extends Request
{
    /**
     * HTTP Method
     *
     * @var Method
     */
    protected Method $method = Method::GET;

    public function __construct(
        public bool $oneWay,
        public string $voyageType,
        public $dateFrom,
        public $dateTo,
        public ?string $from = null,
        public ?string $to = null,
        public ?string $locale = null,
        public ?string $type = "general",
        public ?string $departureDate = null,
        public ?bool $shoppingCruise = false,
        public ?bool $includeRegularCabins = true,
    ){
        if (!$voyageType) {
            $this->voyageType = Voyage::SHUTTLE;
        }
        
        if (!$locale) {
            $this->locale = Locale::ENGLISH;
        }

        if (!$from) {
            $this->from = Station::HELSINKI;
        }

        if (!$to) {
            $this->to = Station::TALLINN;
        }

        $departureDate = $dateFrom;
    }

    protected function defaultQuery(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'locale' => $this->locale,
            'oneWay' => $this->oneWay,
            'voyageType' => $this->voyageType,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
        ];
    }

    /**
     * Resolve the endpoint
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/timetables';
    }
}