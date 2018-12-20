<?php
/**
 * Tallink API Class
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
   * @var timetables_url url
   */
  private static $timetables_url = 'https://booking.tallink.com/api/timetables';
  /**
   * @var land_services_url url
   */
  private static $land_url = 'https://booking.tallink.com/api/land';
  /**
   * @var vehicle prices url
   */
  private static $vehicle_url = 'https://booking.tallink.com/api/vehicles';
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
    * @param string  $from       from which station -required
    * @param string  $to         to which station -required
    * @param string  $locale     language -required
    * @param string  $country    country -required
    * @param boolean $overnight  overnight -required
    * @param string  $voyageType voyageType (SHUTTLE/CRUISE) -required
    * @param date    $dateFrom   from date (format: yyyy-mm-dd) -required
    * @param date    $dateTo     to date (format: yyyy-mm-dd) -required
    * @return array (journeys between $dateFrom and $dateTo)
    */
  public static function fetch_journeys(Tallink $fetch_journeys)
  {
    if($fetch_journeys->fetchType == 'json') { header('Content-type: application/json'); }
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
      /* turn dateFrom and dateTo into DateTime objects */
      $begin = new DateTime($fetch_journeys->dateFrom);
      $end = new DateTime($fetch_journeys->dateTo);
      /* daterange (for foreach) to know each date that we would be looping through */
      $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
      /* parse each journey */
      $date_data = array();
      $dc = 0; /* date counter */
      foreach($daterange as $date)
      {
        /* convert date to usable format */
        $convert_date = $date->format("Y-m-d");
        /* foreach trip turing that day */
        $trip_data = array();
        $tc = 0;
        foreach($obj['trips'][$convert_date]['outwards'] as $trip)
        {
          $data[] = array(
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
        }
          $tc++;
      }
      $dc++;
    }
    return $data;
  }

  /**
    * Fetch vehicle prices
    *
    * @param string locale           locale (required)
    * @param string country          country (not required)
    * @param string outwardSailId    outwardSailId (required)
    * @return array (vehicle prices for outwardSailId journey)
    */
  public static function fetch_vehicle_prices($locale, $country, $outwardSailId)
  {

    /* check required parameters */
    if(isset($locale) && isset($outwardSailId))
    {
      /* parameter bindings */
      $bindings = array(
      'locale' => $locale,
      'country' => $country,
      'outwardSailId' => $outwardSailId
      );
      /* parameters */
      $parameters = http_build_query($bindings);
      /* full url */
      $api_url = static::$vehicle_url.'?'.$parameters;
      /* Get Contents */
      $query = file_get_contents($api_url);
      /* Decode JSON */
      $obj = json_decode($query, true);
      foreach($obj['vehicles'] as $vehicle)
      {
        $data[] = array(
          'carCategory' => $vehicle['carCategory'],
          'licensePlates' => $vehicle['licensePlates'],
          'outwardDetails' => $vehicle['outwardDetails'],
          'returnDetails' => $vehicle['returnDetails']
         );
      }
    }
    return $data;

  }

  /**
    * Fetch land services
    *
    * @param string locale           locale (required)
    * @param string country          country (not required)
    * @param string outwardSailId    outwardSailId (required)
    * @return array (land services for outwardSailId journey)
    */
  public static function fetch_land_services(Tallink $fetch_land_services)
  {
    /* check required parameters */
    if(isset($fetch_land_services->locale) && isset($fetch_land_services->outwardSailId))
    {
      /* parameter bindings */
      $bindings = array(
      'locale' => $fetch_land_services->locale,
      'country' => $fetch_land_services->country,
      'outwardSailId' => $fetch_land_services->outwardSailId
      );
      /* parameters */
      $parameters = http_build_query($bindings);
      /* full url */
      $api_url = static::$land_url.'?'.$parameters;
      /* Get Contents */
      $query = file_get_contents($api_url);
      /* Decode JSON */
      $obj = json_decode($query, true);
      foreach($obj['landServices'] as $land_service)
      {
        $data[] = array(
          'title' => $land_service['title'],
          'imageUrl' => $land_service['imageUrl'],
          'description' => $land_service['description'],
          'eventTimes' => $land_service['eventTimes']
         );
      }
    }
    return $data;
  }
  /**
   *
   * Get stations
   *
   * @return string
   */
  public static function stations()
  {
    /* stations */
    $stations = '"Helsinki", 
      "Tallinn", 
      "Stockholm", 
      "Turku", 
      "Riga", 
      "Åland", 
      "Visby"';
    return $stations;
  }
  /**
   *
   * Get station id by name
   *
   * @param $station_name
   * @return value
   */
  public static function get_station_id_by_name($station_name)
  {
    /* stations */
    $stations = array(
      'hel' => 'Helsinki', 
      'tal' => 'Tallinn', 
      'sto' => 'Stockholm', 
      'tur' => 'Turku', 
      'rig' => 'Riga', 
      'ala' => 'Åland', 
      'vis' => 'Visby'
    );
    return array_search($station_name, $stations , true);
  }
  /**
   *
   * Check if station exists
   *
   * @param $station
   * @return boolean true / false
   */
  public static function check_station_exists($station)
  {
    /* stations */
    $stations = array(
      'hel' => 'Helsinki', 
      'tal' => 'Tallinn', 
      'sto' => 'Stockholm', 
      'tur' => 'Turku', 
      'rig' => 'Riga', 
      'ala' => 'Åland', 
      'vis' => 'Visby'
    );
    $search = array_search($station, $stations);
    if($search == true)
    {
      return true;
    } else {
      return false;
    }
  }
}
?>
