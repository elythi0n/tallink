<?php

namespace marcosraudkett;

/**
 * Tallink API Class
 *
 * PHP version 7+
 *
 *
 * @category   Tallink
 * @package    Tallink
 * @author     Marcos Raudkett <info@marcosraudkett.com>
 * @copyright  2019 - 2023 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    2.1.0
 */
class Tallink
{

    /**
     * @var string Tallink API endpoint
     */
    private $endpoint = 'https://booking.tallink.com/api';

    public $routes = [
        "timetables" => [
            // types of journeys
            "general" => "/timetables",
            "daycruise" => "/daycruise"
        ],
        "vehicles" => "/vehicles",
        "travelClasses" => "/travelclasses",
        "onboard_services" => "/onboardServices/v2",
        "land" => "/land",
        "hotels" => "/hotels",
        "meals" => "/meals",
    ];

    /**
     * @var array params
     */
    public $params = [
        "voyageType" => "SHUTTLE", // SHUTTLE | CRUISE
        "type" => "general",
        "locale" => "en",
        "oneWay" => true,
        "from" => "tal",
        "to" => "hel",
        "dateFrom" => "",
        "dateTo" => "",
        "departureDate" => "",
        "shoppingCruise" => false,
        "includeRegularCabins" => true,
    ];

    /**
     * @var array result
     */
    public $results = [];

    /**
     * @var array result
     */
    public $journeys;

    // ** singleton instance
    private static $_instance;

    /**
     * Get instance
     */
    public static function getInstance()
    {
        if (self::$_instance === NULL) {
            self::$_instance = new Tallink();
        }

        return self::$_instance;
    }

    public function __construct()
    {
    }

    /**
     * Fetch journeys
     *
     * @param string  $from       from which station -required
     * @param string  $to         to which station -required
     * @param string  $locale     language -required
     * @param string  $oneWay     language -required
     * @param string  $voyageType voyageType (SHUTTLE/CRUISE) -required
     * @param date    $dateFrom   from date (format: yyyy-mm-dd) -required
     * @param date    $dateTo     to date (format: yyyy-mm-dd) -required
     * @return array (journeys between $dateFrom and $dateTo)
     */
    public function journeys(): array
    {
        /* check required parameters */
        if ($this->isValid(["from", "to", "dateFrom", "dateTo"])) {
            $obj = $this->get($this->route($this->routes["timetables"][$this->params["type"]]));
            $daterange = new \DatePeriod(
                new \DateTime($this->params["dateFrom"]),
                new \DateInterval('P1D'),
                new \DateTime($this->params["dateTo"])
            );
            $dc = 0; // ** date counter
            foreach ($daterange as $date) {
                // ** convert date
                $converted_date = $date->format("Y-m-d");
                $tc = 0; // ** trip counter
                if (isset($obj['trips'][$converted_date]['outwards'])) {
                    // ** foreach trip
                    foreach ($obj['trips'][$converted_date]['outwards'] as $tk => $trip) {
                        foreach ($trip as $key => $value) {
                            $this->results["journeys"][$this->results["timetables_request_count"]][$tk][$key] = $value;
                        }
                    }
                    $tc++;
                }
            }
            $dc++;
        }

        return isset($this->results["journeys"]) ? $this->results["journeys"] : [];
    }

    /**
     * Fetch hotels
     * 
     * @param string  $from       from which station -required
     * @param string  $to         to which station -required
     * @param date    $dateFrom   from date (format: yyyy-mm-dd) -required
     * @param date    $dateTo     to date (format: yyyy-mm-dd)
     * @return array
     */
    public function hotels($outwardSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["departureDate", "dateFrom", "dateTo"])) {
            $obj = $this->get($this->route($this->routes["hotels"]));
            $this->results["hotels"]["list"] = $this->handleKeysAndValues($obj, "hotels");
            $this->results["hotels"]["cities"] = $this->handleKeysAndValues($obj, "cities");
            return isset($this->results["hotels"]) ? (array) $this->results["hotels"] : [];
        }
    }

    /**
     * Fetch vehicle prices for a journey
     * 
     * @param string $locale -required
     * @param string $outwardSailId -required
     * @return array
     */
    public function vehiclePrices($outwardSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->get($this->route($this->routes["vehicles"]));
            $this->results["vehicles"] = $this->handleKeysAndValues($obj, "vehicles");
            return isset($this->results["vehicles"]) ? (array) $this->results["vehicles"] : [];
        }
    }

    /**
     * Fetch land services by journey
     * 
     * @param string locale    locale (required)
     * @param string outwardSailId    outwardSailId (required)
     * @return array
     */
    public function landServices($outwardSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->get($this->route($this->routes["land"]));
            $this->results["landServices"] = $this->handleKeysAndValues($obj, "landServices");
            return isset($this->results["landServices"]) ? (array) $this->results["landServices"] : [];
        }
    }

    /**
     * Fetch meals by journey
     * 
     * @param string locale    locale (required)
     * @param string outwardSailId    outwardSailId (required)
     * @return array
     */
    public function meals($outwardSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->get($this->route($this->routes["meals"]));
            $this->results["meals"] = $this->handleKeysAndValues($obj, "meals");
            return isset($this->results["meals"]) ? (array) $this->results["meals"] : [];
        }
    }

    /**
     * Fetch onboard services by journey
     * 
     * @param string outwardSailId    outwardSailId (required)
     * @return array
     */
    public function onboardServices($outwardSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->get($this->route($this->routes["onboard_services"]));
            $this->results["onboard_services"] = $obj;
            return isset($this->results["onboard_services"]) ? (array) $this->results["onboard_services"] : [];
        }
    }

    /**
     * Fetch travel classes by journey
     * 
     * @param string outwardSailId    outwardSailId (required)
     * @param string returnSailId    returnSailId (optional)
     * @param boolean includeSharedCabins (optional)
     * @param boolean includeSpecialCabins (optional)
     * @param boolean includePetCabins (optional)
     * @param boolean includeRegularCabins (optional)
     * @return array
     */
    public function travelClasses($outwardSailId = null, $returnSailId = null): array
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if (isset($returnSailId)) $this->params["returnSailId"] = $returnSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->get($this->route($this->routes["travelClasses"]));
            $this->results["travelClasses"] = $obj;
            return isset($this->results["travelClasses"]) ? (array) $this->results["travelClasses"] : [];
        }
    }

    /**
     * Handle API results
     */
    public function handleKeysAndValues($obj, $name)
    {
        $result = [];
        foreach ($obj[$name] as $lk => $land) {
            foreach ($land as $key => $value) {
                $result[$lk][$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Final results
     * 
     * @return array
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * Puts it all together
     * 
     * @return string
     */
    public function route($route)
    {
        return $this->endpoint . $route . "?" . $this->buildQuery();
    }

    /**
     * Parse last segment from url
     */
    public function parseUrl($url)
    {
        return basename(parse_url($url, PHP_URL_PATH));
    }

    /**
     * Request count setter
     */
    public function setCount($name)
    {
        isset($this->results[$name]) ?
            $this->results[$name]++
            :
            $this->results[$name] = 0;
    }

    /**
     * Get data using file_get_contents
     * 
     * @return array
     */
    public function get($url)
    {
        // ** set request count
        $this->setCount($this->parseUrl($url) . "_request_count");
        // ** get contents
        $query = file_get_contents($url);
        // ** decode
        return json_decode($query, true);
    }

    /**
     * Build query parameters
     * 
     * @return string
     */
    public function buildQuery()
    {
        /* parameter bindings */
        $bindings = [];
        foreach ($this->params as $name => $value) {
            $bindings[$name] = $value;
        }
        /* parameters */
        return http_build_query($bindings);
    }

    /**
     * isValid for journeys()
     * 
     * @return boolean
     */
    public function isValid($requiredParams)
    {
        $missing = [];
        foreach ($requiredParams as $param) {
            if (!isset($this->params[$param]) || strlen($this->params[$param]) == 0) {
                $missing[] = $param;
            }
        }

        if (empty($missing)) {
            return true;
        } else {
            // ** let the user know about missing parameters
            print_r(["missing_required_parameters" => $missing]);
            return false;
        }
    }

    /**
     * Check if outwardSailId isset
     * 
     * @return boolean
     */
    public function isOutwardSailId()
    {
        if (!isset($this->params["outwardSailId"])) {
            return false;
        }

        return true;
    }

    /**
     * Check if outwardSailId isset
     * 
     * @return boolean
     */
    public function isReturnSailId()
    {
        if (!isset($this->params["returnSailId"])) {
            return false;
        }

        return true;
    }

    /**
     * API for setting a parameter
     * 
     * @return void
     */
    public function setParam($param, $value)
    {
        $this->params[$param] = $value;

        return $this;
    }

    /**
     * API for setting multiple parameters
     * 
     * @return void
     */
    public function setParams($params)
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }

        return $this;
    }

    /**
     * API for adding in new routes - experimental
     * 
     * @return void
     */
    public function setRoutes($routes)
    {
        foreach ($routes as $key => $value) {
            $this->routes[][$key] = $value;
        }

        return $this;
    }

    /**
     *
     * Get stations
     *
     * @return array
     */
    public static function stations()
    {
        /* stations */
        $stations = [
            "Helsinki",
            "Tallinn",
            "Stockholm",
            "Turku",
            "Riga",
            "Åland",
            "Visby"
        ];
        return $stations;
    }

    /**
     *
     * Get station id by name
     *
     * @param $station_name
     * @return value
     */
    public static function stationIdByName($station_name)
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
        return array_search($station_name, $stations, true);
    }

    /**
     *
     * Check if station exists
     *
     * @param $station
     * @return boolean true / false
     */
    public static function checkStation($station)
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
        return $search;
    }
}
