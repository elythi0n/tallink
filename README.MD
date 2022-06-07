[![Tests](https://github.com/marcosraudkett/tallink/actions/workflows/run-tests.yml/badge.svg)](https://github.com/marcosraudkett/tallink/actions/workflows/run-tests.yml)

# PHP client for the Tallink API

This is just a test demo! do not use this in production without asking permission from Tallink. (inofficial)

## Installation

```
composer require marcosraudkett/tallink
```

### Features

- Fetch data
  - Journeys between 2 dates with parameters
    - Journey info
      - Prices (with or without points)
      - Has rooms available
      - Piers
      - Cities
      - Dates
      - etc...
  - Hotels and information about hotels
    - Hotel info (code, name descriptions, images, checkInTime, checkOutTime, city, rating)
    - Availability
    - Rooms
    - List of cities
  - Vehicle prices and availability by journey id
    - Category
    - Capacity
    - Availability
    - Price
  - Land services by journey id
- List all ports
- Check if a port exists


## Usage (without autoloader)
```php
<?php
  require_once "path/to/classes/Tallink.class.php";
  /* or use autoloader */
?>
```

### Journeys
```php
<?php

  $journeys = marcosraudkett\Tallink::getInstance([
      // ** minimum required params for journeys()
      "from" => "tal",
      "to" => "hel",
      "dateFrom" => "2022-06-02",
      "dateTo" => "2022-06-04",
  ])->journeys();

  // ** print journeys
  print_r($journeys); 

?>
```
### Fetch data
Doing multiple calls and printing the results
```php
<?php 

  $params = [
    // ** minimum required params for journeys()
    "from" => "tal",
    "to" => "hel",
    "dateFrom" => "2022-06-02",
    "dateTo" => "2022-06-04",
  ];

  $tallink = new marcosraudkett\Tallink($params);

  // fetch journeys
  $tallink->journeys();

  // set outwardSailId parameter (you can get this from journeys "sailId")
  $tallink->setParam("outwardSailId", "2195288");

  // fetch vehicle prices (for id 2195288)
  $tallink->vehiclePrices();

  // or set the id 2195288
  $tallink->vehiclePrices("2195288");

  // fetch land services (for id 2195288)
  $tallink->landServices();

  // print out the results
  print_r(
    $tallink->results()
  );

  // ** to only get journeys
  $journeys = $tallink->results()["journeys"];

?>
```

Check inside `/examples` folder for more examples.

## Available methods
<table>
  <thead>
    <tr>
      <th>Function</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>journeys</td>
      <td>Get the list of journeys</td>
    </tr>
    <tr>
      <td>vehiclePrices</td>
      <td>Get vehicle availability and prices</td>
    </tr>
    <tr>
      <td>landSerivces</td>
      <td>Land services</td>
    </tr>
    <tr>
      <td>meals</td>
      <td>Get meals for the joruney</td>
    </tr>
    <tr>
      <td>hotels</td>
      <td>Get the list of hotels and availability</td>
    </tr>
  </tbody>
</table>

## Testing

```
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/marcosraudkett/tallink/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Marcos Raudkett](https://github.com/marcosraudkett)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.