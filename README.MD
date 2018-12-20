This is just a test demo! do not use this in production without asking permission. (inofficial)

### Usage
```php
<?php
  require_once 'classes/Tallink.class.php';
  /* or use autoloader */
?>
```


### Journeys
```php
<?php

/* fetch journeys from tallinn to helsinki between dateFrom and dateTo */
$fetch_journeys = new Tallink();
  $fetch_journeys->from = 'tal';
  $fetch_journeys->to = 'hel';
  $fetch_journeys->oneWay = true;
  $fetch_journeys->locale = 'en';
  $fetch_journeys->voyageType = 'SHUTTLE';
  $fetch_journeys->dateFrom = '2018-12-15'; /* from date */
  $fetch_journeys->dateTo = '2018-12-18'; /* to date */
$fetch_journeys = Tallink::fetch_journeys($fetch_journeys);

foreach($fetch_journeys as $row)
{
	echo '<br>'.$row["shipCode"]; /* prints out each journey's shipCode */
}

?>
```

### Land services 

```php
<?php
$fetch_land_services = new Tallink();
  $fetch_land_services->locale = 'en'; /* locale */
  $fetch_land_services->country = ''; /* country */
  $fetch_land_services->outwardSailId = '1633780'; /* outwardSailId */
$fetch_land_services = Tallink::fetch_land_services($fetch_land_services);

foreach($fetch_land_services as $row)
{
	echo $row["title"].'<br>'; /* prints each land service title for that trip */
	echo $row["description"].'<br>'; /* prints each land service description for that trip */
}
?>
```

### Get station id by name 

```php
<?php
  $station_name = 'Tallinn';
  $get_station_id_by_name = Tallink::get_station_id_by_name($station_name);
  echo $get_station_id_by_name /* returns 'tal' */
?>
```

### Check if station exists

```php
<?php
  $station = 'Tallinn';
  $check_station_exists = Tallink::check_station_exists($station);
  echo $check_station_exists /* returns 1 */
?>
```
