[![Tests](https://github.com/marcosraudkett/tallink/actions/workflows/run-tests.yml/badge.svg)](https://github.com/marcosraudkett/tallink/actions/workflows/run-tests.yml)

# PHP SDK for the Tallink API

This is an unofficial Tallink PHP SDK and should not be used in production without asking permission from Tallink.

## Requirements

- PHP 8.1+

If you're using an older version of PHP then you can use the [2.1.0](https://github.com/marcosraudkett/tallink/releases/tag/2.1.0) version.

## Installation

```
composer require marcosraudkett/tallink
```
## Usage 

Example on how to fetch journeys
### Journeys
```php
use marcosraudkett\Tallink\Constants\Voyage;
use marcosraudkett\Tallink\Constants\Locale;
use marcosraudkett\Tallink\Constants\Station;
use marcosraudkett\Tallink\Requests\GetTimetablesRequest;
use marcosraudkett\Tallink\Tallink;

$tallink = new Tallink;
$response = $tallink->send(new GetTimetablesRequest(
    oneWay: true,
    voyageType: Voyage::SHUTTLE,
    dateFrom: date('Y-m-d'),
    dateTo: date('Y-m-d', strtotime('+2 days')),
    from: Station::HELSINKI, // hel
    to: Station::TALLINN,    // tal
    locale: Locale::ENGLISH, // en
));

print_r($journeys->json()); 
```

Check inside `/examples` folder for more examples.

## Available requests

| Request | Description |
| - | - | 
| GetTimetablesRequest | Get the list of journeys | 
| GetTravelClassesRequest | Get the list of travel classes | 
| GetVehiclesRequest | Get the list of vehicle availability & pricing | 
| GetMealsRequest | Get the list of meal plans | 
| GetHotelsRequest | Get the list of hotels | 
| GetLandRequest | Get the list of land services | 
| GetOnboardServicesRequest | Get the list of onboard services | 


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