<?php

namespace marcosraudkett\Tallink\Responses;

use Saloon\Http\Response;
use Saloon\Contracts\Response as BaseResponseContract;
use Saloon\Traits\Responses\HasResponseHelpers;

class GetTimetablesResponse extends Response
{
    /**
     * TODO 
     * 
     * Get the body of the response as string.
     *
     * @return string
     */
    public function body(): string
    {
        $body = json_decode($this->stream()->getContents(), true);

        $mutatedResponse = [];

        $daterange = new \DatePeriod(
            new \DateTime($this->dateFrom),
            new \DateInterval('P1D'),
            new \DateTime($this->dateTo)
        );
        $dc = 0; // ** date counter
        foreach ($daterange as $date) {
            // ** convert date
            $converted_date = $date->format("Y-m-d");
            $tc = 0; // ** trip counter
            if (isset($body['trips'][$converted_date]['outwards'])) {
                // ** foreach trip
                foreach ($body['trips'][$converted_date]['outwards'] as $tk => $trip) {
                    foreach ($trip as $key => $value) {
                        $this->results["journeys"][$this->results["timetables_request_count"]][$tk][$key] = $value;
                    }
                }
                $tc++;
            }
        }
        $dc++;

        return "{}";
    }
}