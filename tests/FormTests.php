<?php
include('../Tallink.class.php');

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Tallink Demo</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/dashboard/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Tallink PHP Demo</a>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="#">
                  <span data-feather="home"></span>
                  API Demo <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://github.com/marcosraudkett/tallink">
                  <span data-feather="github"></span>
                  Fork on GitHub
                </a>
              </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>More Demos</span>
              <a class="d-flex align-items-center text-muted" href="https://github.com/marcosraudkett/tallink">
                <span data-feather="plus-circle"></span>
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="info"></span>
                  Coming soon
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Cheapest Ferry</h1>
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

          	<input type="submit" class="btn btn-primary" value="Find Journeys"> 

  			<input type="hidden" name="locale" value="en">
  			<input type="hidden" name="voyageType" value="SHUTTLE">
          </form>

          <br>

          <h2>Journeys</h2>
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
                  <th>Overnight?</th> <!-- isOvernight -->
                  <th>Voucher Applicable</th> <!-- isVoucherApplicable -->
                  <th>Marketing Message</th> <!-- marketingMessage -->
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
	    	?>
	                <tr>
	                  <td><?php echo $row["sailId"]; ?></td>
	                  <td><?php echo $row["departureIsoDate"]; ?></td>
	                  <td><?php echo $row["arrivalIsoDate"]; ?></td>
	                  <td><?php echo $row["cityFrom"]; ?></td>
	                  <td><?php echo $row["cityTo"]; ?></td>
	                  <td><?php echo $row["duration"]; ?>h</td>
	                  <td><?php if($row["hasRoom"] == '1') { echo 'Yes'; } else { echo 'No'; } ?></td>
	                  <td><?php if($row["isDisabled"] == '1') { echo 'No'; } else { echo 'Yes'; } ?></td>
	                  <td><?php echo $row["isOvernight"]; ?></td>
	                  <td><?php echo $row["isVoucherApplicable"]; ?></td>
	                  <td><?php echo $row["marketingMessage"]["description"]; ?></td>
	                  <td><?php echo $row["personPrice"]; ?>€</td>
	                  <td><?php echo $row["pierFrom"]; ?></td>
	                  <td><?php echo $row["pierTo"]; ?></td>
	                  <td><?php echo $row["pointsPrice"]; ?>€</td>
	                  <td><?php echo $row["sailPackageCode"]; ?></td>
	                  <td><?php echo $row["sailPackageName"]; ?></td>
	                  <td><?php echo $row["shipCode"]; ?></td>
	                  <td><?php echo $row["vehiclePrice"]; ?>€</td>
	                </tr>
	                <?php } 
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      feather.replace()

      $( function() {
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
	    $('#journeys').DataTable();
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

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
          datasets: [{
            data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
    </script>
  </body>
</html>
