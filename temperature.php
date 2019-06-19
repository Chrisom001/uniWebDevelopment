<?php
	include "scripts/db_connection.php";
	include "model/api-temp.php";
	 // decode the json body from the request
	$jsonbody = file_get_contents('php://input') ;
	
	$result = insertTemp($jsonbody);

	$jsonResult = json_decode($result);
	if($jsonResult == "Success"){
		echo "Inserted Successfully";
	} else {
		echo "Failed, try again";
	}
	?>