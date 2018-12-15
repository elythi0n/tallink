This is just a test demo! do not use this in production without asking permission.

### Usage (Fetch journeys)
```php
<?php

$fetch_journeys = new Tallink();
  $fetch_journeys->from = 'tal'; /* from station */
  $fetch_journeys->to = 'hel'; /* to station */
  $fetch_journeys->oneWay = true; /* true or false */
  $fetch_journeys->locale = 'en'; /* locale */
  $fetch_journeys->voyageType = 'SHUTTLE'; /* voyage type */
  $fetch_journeys->dateFrom = '2018-12-15'; /* date from */
  $fetch_journeys->dateTo = '2018-12-18'; /* date to */
  $fetch_journeys->fetchType = 'echo'; /* print type (print_r, var_dump, echo_single, echo) */
$fetch_journeys = Tallink::fetch_journeys($fetch_journeys);

echo $fetch_journeys /* prints full list of journeys between dateFrom and dateTo */ 

/*
Gives you:

31 
DTER
LSA2
0
1635583
TAL-HEL
Tallinn-Helsinki
STAR
2018-12-15T16:00
TAL
HEL
2018-12-15T12:30
3.5
1
*/

?>
```

