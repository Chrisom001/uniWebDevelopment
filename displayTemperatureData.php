<?php
include "scripts/db_connection.php";
include "scripts/header.php";
include "model/api-temp.php";
//This variable holds the temperature data taken by the IoT Sensor that's in the database
$tempData = json_decode(retrieveData());
$table = "<table data-role='table' id='table-column-toggle' data-mode='columntoggle' class='ui-responsive table-stroke'>";
	$table .= "<thead>";
		$table .= "<tr>";
			$table .= "<th>Data ID</th>";
			$table .= "<th data-priority='2'>Device ID</th>";
			$table .= "<th data-priority='3'>Date/Time</th>";
			$table .= "<th data-priority='4'>Int.Temperature</th>";
			$table .= "<th data-priority='5'>Ext. Temperature</th>";
			$table .= "<th data-priority='6'>Light Level</th>";
			$table .= "<th data-priority='7'>Voltage</th>";
		$table .= "</tr>";
	$table .= "</th>";
	$table .= "<tbody>";
	//This loops through each of the results and displays each section in hte correct part of the table
	for($i = 0; $i < sizeof($tempData); $i++){
		$sensorData = json_decode($tempData[$i]->sensorJson);
		$table .= "<tr>";
		$table .= "<th>".$tempData[$i]->tempID."</th>";
		$table .= "<td>".$sensorData->device."</td>";
		$table .= "<td>".$tempData[$i]->dateTime."</td>";
		$table .= "<td>".$sensorData->internal."</td>";
		$table .= "<td>".$sensorData->external."</td>";
		$table .= "<td>".$sensorData->light."</td>";
		$table .= "<td>".$sensorData->volt."</td>";
		$table .= "</tr>";
	}
$table .= "";
	$table .= "</tbody>";
$table .= "</table>";
?>
<!doctype html>
<html lang="en">
  <head>
  
	<!--- Stylesheet include -->
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jqueryMobile/jquery.mobile-1.4.5.min.css">
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
    <title>Gaming Newsletter</title>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
  </head>
  <body>
			<?php echo $navbar; ?>
	<div class="container">
	<p>
	Welcome to the FoxCo Gaming Newsletter temperature centre, where we have linked our local weather station to this page to display the latest data avaliable.
	</p>
	
	<?php echo $table; ?> 
	
	</div>
	</br></br></br>
	</body>
	<footer class="footer">
		<?php include "scripts/footer.php"; ?>
	</footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
</html>