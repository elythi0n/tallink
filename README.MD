This is just a test demo! do not use this without permission.

### Usage (Fetch journeys)
```php
$fetch_journeys = new Tallink();
  $fetch_journeys->from = 'tal'; /* from station */
  $fetch_journeys->to = 'hel'; /* to station */
  $fetch_journeys->oneWay = true; /* true or false */
  $fetch_journeys->locale = 'en'; /* locale */
  $fetch_journeys->voyageType = 'SHUTTLE'; /* voyage type */
  $fetch_journeys->dateFrom = '2018-12-15'; /* date from */
  $fetch_journeys->dateTo = '2018-12-18'; /* date to */
  $fetch_journeys->fetchType = 'echo'; /* print type (check Tallink.class.php */
$fetch_journeys = Tallink::fetch_journeys($fetch_journeys);

echo $fetch_journeys /* prints full list of journeys */ 
```

