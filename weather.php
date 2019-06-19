<?php
include "scripts/db_connection.php";
include "scripts/header.php";

$weatherjson = file_get_contents('http://api.openweathermap.org/data/2.5/weather?id=2650752&APPID=944af91855a0dffe965b3d3c75066f7d&units=metric');
$weathertxt = json_decode($weatherjson);
//This takes the values in the main object and puts it into an array
$tempcheck = get_object_vars($weathertxt->main);
//this takes the values in the wind object and puts them into an array
$windcheck = get_object_vars($weathertxt->wind);
?>

<!doctype html>
<html lang="en">
  <head>
  
	<!--- Stylesheet include -->
	<link href="css/style.css" rel="stylesheet">
	
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Gaming Newsletter</title>
  </head>
  <body>
	
	
	<?php echo $navbar; ?>
	<div class="container">
	<p>
	Welcome to the FoxCo Gaming Newsletter where we will endeavour to bring you the current weather from Openweathermaps. 
	</p>
	The current weather for Dundee is
	<!-- The table takes values from each of the arrays in order to fill the relevant sections to display the current weather to the user.-->
	<table border=1>
	<tr>
		<th>Current Temperature</th>
		<td><?php echo array_values($tempcheck)[0] . " Celcius"; ?></td> 
	</tr>
	<tr>
		<th>Min Temperature</th>
		<td><?php echo array_values($tempcheck)[3] . " Celcius"; ?></td>
	</tr>
	<tr>
		<th>Max Temperature</th>
		<td><?php echo array_values($tempcheck)[4] . " Celcius"; ?></td>
	</tr>
	<tr>
		<th>Humidity</th>
		<td><?php echo array_values($tempcheck)[2]; ?></td>
	</tr>
	<tr>
		<th>Pressure</th>
		<td><?php echo array_values($tempcheck)[1] . " millibars"; ?></td>
	</tr>
	<tr>
		<th>Wind Speed</th>
		<td><?php echo array_values($windcheck)[0] . " Meters a Second"; ?></td>
	</tr>
	<tr>
		<th>Overall Weather</th>
		<td><?php echo $weathertxt->weather[0]->description;?></td>
	</tr>
	</table>
	
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