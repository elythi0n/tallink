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
 * @copyright  2019 - 2022 Marcos Raudkett
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @version    2.0.2
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
    public static function getInstance($params)
    {
        if (self::$_instance === NULL) {
            self::$_instance = new Tallink($params);
        }

        return self::$_instance;
    }

    public function __construct($params)
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }
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
    public function journeys()
    {
        /* check required parameters */
        if ($this->isValid(["from", "to", "dateFrom", "dateTo"])) {
            $obj = $this->getData($this->route($this->routes["timetables"][$this->params["type"]], $this->buildQuery()));
            $daterange = new \DatePeriod(
                new \DateTime($this->params["dateFrom"]),
                new \DateInterval('P1D'),
                new \DateTime($this->params["dateTo"])
            );
            $dc = 0; // ** date counter
            foreach ($daterange as $date) {
                // ** convert date
                $convert_date = $date->format("Y-m-d");
                $tc = 0; // ** trip counter
                // ** foreach trip
                if (isset($obj['trips'][$convert_date]['outwards'])) {
                    foreach ($obj['trips'][$convert_date]['outwards'] as $tk => $trip) {
                        foreach ($trip as $key => $value) {
                            $this->results["journeys"][$tk][$key] = $value;
                        }
                    }
                    $tc++;
                }
            }
            $dc++;
        }

        return isset($this->results["journeys"]) ? $this->results["journeys"] : null;
    }

    /**
     * Fetch hotels
     * 
     * @param string  $from       from which station -required
     * @param string  $to         to which station -required
     * @param date    $dateFrom   from date (format: yyyy-mm-dd) -required
     * @param date    $dateTo     to date (format: yyyy-mm-dd)
     */
    public function hotels($outwardSailId = null)
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["departureDate", "dateFrom", "dateTo"])) {
            $obj = $this->getData($this->route($this->routes["hotels"], $this->buildQuery()));
            $this->results["hotels"]["list"] = $this->handleKeysAndValues($obj, "hotels");
            $this->results["hotels"]["cities"] = $this->handleKeysAndValues($obj, "cities");
            return isset($this->results["hotels"]) ? $this->results["hotels"] : null;
        }
    }

    /**
     * Fetch vehicle prices for a journey
     * 
     * @param string $locale -required
     * @param string $outwardSailId -required
     */
    public function vehiclePrices($outwardSailId = null)
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->getData($this->route($this->routes["vehicles"], $this->buildQuery()));
            $this->results["vehicles"] = $this->handleKeysAndValues($obj, "vehicles");
            return isset($this->results["vehicles"]) ? $this->results["vehicles"] : null;
        }
    }

    /**
     * Fetch land services
     * 
     * @param string locale    locale (required)
     * @param string outwardSailId    outwardSailId (required)
     */
    public function landServices($outwardSailId = null)
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->getData($this->route($this->routes["land"], $this->buildQuery()));
            $this->results["landServices"] = $this->handleKeysAndValues($obj, "landServices");
            return isset($this->results["landServices"]) ? $this->results["landServices"] : null;
        }
    }

    /**
     * Fetch meals for the journey(s)
     * 
     * @param string locale    locale (required)
     * @param string outwardSailId    outwardSailId (required)
     */
    public function meals($outwardSailId = null)
    {
        if (isset($outwardSailId)) $this->params["outwardSailId"] = $outwardSailId;
        if ($this->isValid(["outwardSailId"])) {
            $obj = $this->getData($this->route($this->routes["meals"], $this->buildQuery()));
            $this->results["meals"] = $this->handleKeysAndValues($obj, "meals");
            return isset($this->results["meals"]) ? $this->results["meals"] : null;
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
    public function route($route, $parameters)
    {
        return $this->endpoint . $route . "?" . $parameters;
    }

    /**
     * Get data using file_get_contents
     * 
     * @return array
     */
    public function getData($url)
    {
        $query = file_get_contents($url);
        /* Decode JSON */
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
