<?php
include('../classes/Tallink.class.php');


$page_title = 'Find Cheapest Journeys - Tallink API Demo';
$dashboard_title = 'Find Cheapest Journeys';
$current_page = 'cheapest';
?>


<!doctype html>
<html lang="en">
  <head>
    <?php include("includes/header.php"); ?>
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Tallink API Demo</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    </nav>

    <div class="container-fluid">
      <div class="row">
        <?php include("includes/navbar.php"); ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><?php echo $dashboard_title; ?></h1>
          </div>

          <form method="GET" action="">
          	<div class="input-group">
          		<div class="col-md-6">
          			<input style="display: inline-flex;" class="form-control" id="datepicker" type="text" name="dateFrom" placeholder="Departing" value="<?php if(isset($_GET["dateFrom"])) { echo $_GET["dateFrom"]; } else { echo date('d.m.Y'); } ?>" autocomplete="off">
          			<br><br>
          			<input class="form-control" id="datepicker1" type="text" name="dateTo" placeholder="Arrival" value="<?php if(isset($_GET["dateTo"])) { echo $_GET["dateTo"]; } else { echo date('31.m.Y'); } ?>" autocomplete="off">
          		</div>
          	</div>

          	<br>

          	<div class="input-group">
          		<div class="col-md-6">
          			<input id="from" class="form-control" type="text" name="from" placeholder="Helsinki" value="<?php if(isset($_GET["from"])) { echo $_GET["from"]; } else { echo 'Helsinki'; } ?>">
          		</div>
          	</div>

          	<br>

          	<div class="input-group">
          		<div class="col-md-6">
          			<input id="to" class="form-control" type="text" name="to" placeholder="Tallinn" value="<?php if(isset($_GET["to"])) { echo $_GET["to"]; } else { echo 'Tallinn'; } ?>">
          		</div>
          	</div>

            <br>

            <div class="input-group">
              <div class="col-md-6">
                <input class="form-control" type="text" name="maxPrice" placeholder="Max Price" value="<?php if(isset($_GET["maxPrice"])) { echo $_GET["maxPrice"]; } else { echo '25'; } ?>">
              </div>
            </div>

          	<br>

          	<input type="submit" class="btn btn-primary" value="Find Journeys"> 

      			<input type="hidden" name="locale" value="en">
      			<input type="hidden" name="voyageType" value="SHUTTLE">
          </form>

          <br>

          <h2>Results</h2>
          <div class="table-responsive">
            <table id="journeys" class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th> <!-- sailId -->
                  <th>Departure</th> <!-- departureIsoDate -->
                  <th>Arrival</th> <!-- arrivalIsoDate -->
                  <th>From</th> <!-- cityFrom -->
                  <th>To</th> <!-- cityTo -->
                  <th>Duration</th> <!-- duration -->
                  <th>Has Room</th> <!-- hasRoom -->
                  <th>Available?</th> <!-- isDisabled -->
                  <th>Price</th> <!-- personPrice -->
                  <th>Pier From</th> <!-- pierFrom -->
                  <th>Pier To</th> <!-- pierTo -->
                  <th>Points Price</th> <!-- pointsPrice -->
                  <th>Pckg Code</th> <!-- sailPackageCode -->
                  <th>Pckg Name</th> <!-- sailPackageName -->
                  <th>Ship Code</th> <!-- shipCode -->
                  <th>Vehicle Price</th> <!-- vehiclePrice -->
                </tr>
              </thead>
              <tbody>
          <?php 

          	if(isset($_GET["from"]) && isset($_GET["to"]) && isset($_GET["dateFrom"]) && isset($_GET["dateTo"]) && isset($_GET["voyageType"]))
    		{
    			/* check if station exists*/
    			$from_exists = Tallink::check_station_exists($_GET["from"]);
    			$to_exists = Tallink::check_station_exists($_GET["to"]);

    			if($from_exists == 1 && $to_exists == 1) {

					$fetch_journeys = new Tallink();
					  $fetch_journeys->from = Tallink::get_station_id_by_name($_GET["from"]);
					  $fetch_journeys->to = Tallink::get_station_id_by_name($_GET["to"]);
					  $fetch_journeys->oneWay = true;
					  $fetch_journeys->locale = 'en';
					  $fetch_journeys->voyageType = 'SHUTTLE';
					  $fetch_journeys->dateFrom = ucwords(strftime('%Y-%m-%d', strtotime($_GET["dateFrom"]))); /* from date */
					  $fetch_journeys->dateTo = ucwords(strftime('%Y-%m-%d', strtotime($_GET["dateTo"]))); /* to date */
					  $fetch_journeys->fetchType = 'echo';
					$fetch_journeys = Tallink::fetch_journeys($fetch_journeys);

					if($fetch_journeys != null && $fetch_journeys != '')
					{

	    			foreach($fetch_journeys as $row) {
              if($row["personPrice"] <= $_GET["maxPrice"]) { 

	    	?>
	                <tr>
	                  <td><a href="javascript:void(0);" data-sailId="<?php echo $row["sailId"]; ?>" class="land-services"><?php echo $row["sailId"]; ?></td>
	                  <td><?php echo ucwords(strftime('%d.%m.%Y %H:%M', strtotime($row["departureIsoDate"]))); ?></td>
	                  <td><?php echo ucwords(strftime('%d.%m.%Y %H:%M', strtotime($row["arrivalIsoDate"]))); ?></td>
	                  <td><?php echo $row["cityFrom"]; ?></td>
	                  <td><?php echo $row["cityTo"]; ?></td>
	                  <td><?php echo $row["duration"]; ?>h</td>
	                  <td><?php if($row["hasRoom"] == '1') { echo 'Yes'; } else { echo 'No'; } ?></td>
	                  <td><?php if($row["isDisabled"] == '1') { echo 'No'; } else { echo 'Yes'; } ?></td>
	                  <td><?php echo $row["personPrice"]; ?>€</td>
	                  <td><?php echo $row["pierFrom"]; ?></td>
	                  <td><?php echo $row["pierTo"]; ?></td>
	                  <td><?php echo $row["pointsPrice"]; ?>€</td>
	                  <td><?php echo $row["sailPackageCode"]; ?></td>
	                  <td><?php echo $row["sailPackageName"]; ?></td>
	                  <td><?php echo $row["shipCode"]; ?></td>
	                  <td><a href="javascript:void(0);" data-sailId="<?php echo $row["sailId"]; ?>" class="vehicle-prices">Get Prices</a></td>
	                </tr>
	                <?php } }
	            } else {
	              if($fetch_journeys != null && $fetch_journeys != '') {
	      			echo '<tr><td colspan="19"><center>Fill out the form to find view journeys</center></td></tr>';
			      } else {
	      			echo '<tr><td colspan="19"><center>No journeys found with given parameters.</center></td></tr>';

			      }


      }  


      } else {
			  	echo '<tr><td colspan="19"><center>Please check your stations!</center></td></tr>';
			  }
  }?>

              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <?php include("includes/footer.php"); ?>
    <script>
      /* fetch vehicle prices */
      $(document.body).on('click', '.vehicle-prices',function(){
          let sailId = $(this).attr("data-sailId");
          let dataString = 'sailId=' + sailId;
          $.ajax({
            'url': 'includes/vehicle-prices.php',
            'type': 'GET',
            'data': dataString,
            beforeSend: function (data) {
              $("#vehiclePrice").remove();
            },
            success: function(data) {
              $("body").append(data);
              //setTimeout( function(){

                $("#vehiclePrice").modal("toggle");
              //}, 1500);
            },
            error: function() {
              console.log("fail");
            }
          })
      });

      /* fetch land services */
      $(document.body).on('click', '.land-services',function(){
          let sailId = $(this).attr("data-sailId");
          let dataString = 'sailId=' + sailId;
          $.ajax({
            'url': 'includes/land-services.php',
            'type': 'GET',
            'data': dataString,
            beforeSend: function (data) {
              $("#landServices").remove();
            },
            success: function(data) {
              $("body").append(data);
              //setTimeout( function(){

                $("#landServices").modal("toggle");
              //}, 1500);
            },
            error: function() {
              console.log("fail");
            }
          })
      });
	
      /* replace feather icons */
      feather.replace()

      $( function() {
    /* autocomplete stations */
    var availableTags = [
      <?php echo Tallink::stations(); ?>
    ];
    $( "#from" ).autocomplete({
      source: availableTags
    });
    $( "#to" ).autocomplete({
      source: availableTags
    });
  } );

      $(document).ready(function() {
	    $('#journeys').DataTable({
        'order': [[1, 'asc']]
      });
	  });

	  $( function() {
	    var dateFormat = "dd.mm.yy",
	      from = $( "#datepicker" )
	        .datepicker({
	          defaultDate: "+1w",
	          changeMonth: true,
	          numberOfMonths: 3
	        })
	        .on( "change", function() {
	          to.datepicker( "option", "minDate", getDate( this ) );
	        }),
	      to = $( "#datepicker1" ).datepicker({
	        defaultDate: "+1w",
	        changeMonth: true,
	        numberOfMonths: 3
	      })
	      .on( "change", function() {
	        from.datepicker( "option", "maxDate", getDate( this ) );
	      });
	 
	    function getDate( element ) {
	      var date;
	      try {
	        date = $.datepicker.parseDate( dateFormat, element.value );
	      } catch( error ) {
	        date = null;
	      }
	 
	      return date;
	    }
	  } );
    </script>
  </body>
</html>
