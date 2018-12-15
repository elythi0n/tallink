<?php

/**
 * Tallink API Class (just a test)
 *
 * PHP version 7
 *
 *
 * @category   Tallink
 * @package    Tallink
 * @author     Marcos Raudkett <info@marcosraudkett.com>
 * @copyright  2018 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    0.0.1
 */

class Tallink
{
  /**
   * @var url api url
   */
  private static $timetables_url = 'https://booking.tallink.com/api/timetables';

  /**
   * @var from station
   */
  public $from;

  /**
   * @var to station
   */
  public $to;

  /**
   * @var locale
   */
  public $locale;

  /**
   * @var country
   */
  public $country;

  /**
   * @var overnight
   */
  public $overnight;

  /**
   * @var dateFrom date
   */
  public $dateFrom;

  /**
   * @var dateTo date
   */
  public $dateTo;

  /**
   * @var voyageType
   */
  public $voyageType;

  /**
   * @var oneWay boolean
   */
  public $oneWay;

  /**
   * @var fetchType 1 or 2
   */
  public $fetchType;

  /**
    * Fetch journeys
    *
    * @param string $from      from which station
    * @param string $to        to which station
    * @param string $locale    language
    * @param string $country   country
    * @param string $overnight overnight
    * @param string $dateFrom  from date
    * @param string $dateTo    to date
    * @return array
    */
  public static function fetch_journeys(Tallink $fetch_journeys)
  {
    /* check required parameters */
    if(isset($fetch_journeys->from) && isset($fetch_journeys->to) && isset($fetch_journeys->dateFrom) && isset($fetch_journeys->dateTo) && isset($fetch_journeys->voyageType) && isset($fetch_journeys->fetchType))
    {
      /* parameter bindings */
      $bindings = array(
      'from' => $fetch_journeys->from,
      'to' => $fetch_journeys->to,
      'oneWay' => $fetch_journeys->oneWay,
      'locale' => $fetch_journeys->locale,
      'voyageType' => $fetch_journeys->voyageType,
      'dateFrom' => $fetch_journeys->dateFrom,
      'dateTo' => $fetch_journeys->dateTo
      );
      /* parameters */
      $parameters = http_build_query($bindings);
      /* full url */
      $api_url = static::$timetables_url.'?'.$parameters;
      /* Get Contents */
      $query = file_get_contents($api_url);
      /* Decode JSON */
      $obj = json_decode($query, true);
      /* dateperiod between dateFrom and dateTo */
      $period = new DatePeriod(
                new DateTime($fetch_journeys->dateFrom),
                new DateInterval('P1D'),
                new DateTime($fetch_journeys->dateTo)
             );
      /* count the days between dateFrom and dateTo, this is to know how many times to loop throught journeys */
      $count_period = iterator_count($period);
      /* turn dateFrom and dateTo into DateTime objects */
      $begin = new DateTime($fetch_journeys->dateFrom);
      $end = new DateTime($fetch_journeys->dateTo);
      /* daterange (for foreach) to know each date that we would be looping through */
      $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

      /* parse each journey */
      $dc = 0; /* date counter */
      foreach($daterange as $date)
      {
        /* convert date to usable format */
        $convert_date = $date->format("Y-m-d");
        /* foreach trip turing that day */
        $tc = 0;
        foreach($obj['trips'][$convert_date]['outwards'] as $trip)
        {
          $data = array(
            'arrivalIsoDate' => $trip['arrivalIsoDate'],
            'cityFrom' => $trip['cityFrom'],
            'cityTo' => $trip['cityTo'],
            'departureIsoDate' => $trip['departureIsoDate'],
            'duration' => $trip['duration'],
            'hasRoom' => $trip['hasRoom'],
            'isDisabled' => $trip['isDisabled'],
            'isOvernight' => $trip['isOvernight'],
            'isVoucherApplicable' => $trip['isVoucherApplicable'],
            'marketingMessage' => $trip['marketingMessage'],
            'personPrice' => $trip['personPrice'],
            'pierFrom' => $trip['pierFrom'],
            'pierTo' => $trip['pierTo'],
            'pointsPrice' => $trip['pointsPrice'],
            'sailId' => $trip['sailId'],
            'sailPackageCode' => $trip['sailPackageCode'],
            'sailPackageName' => $trip['sailPackageName'],
            'shipCode' => $trip['shipCode'],
            'vehiclePrice' => $trip['vehiclePrice']
           );
           switch($fetch_journeys->fetchType)
           {
             default:
             case "print_r":
               print_r($data);
             break;

             case "var_dump":
               var_dump($data);
             break;

             case 'return':
                /* return each trip arrivalIsoDate */
               return $trip['arrivalIsoDate'];
             break;

             case 'echo':
                /* return each trip */
               echo implode("<br> ", $data);
             break;
           }
          $tc++;
        }
        $dc++;
      }
    }

  }


}
