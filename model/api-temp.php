<?php
//include .//scripts/header.php";
$db = new dbObj();
$pdo =  $db->getConnstring();

function insertTemp($sensorData){
	global $pdo;
	
	$insertTempSQL = "INSERT INTO temperature(sensorJson) VALUES(:sensorData)";
	$statement = $pdo -> prepare($insertTempSQL);

	$success = $statement -> execute([
        "sensorData" => $sensorData]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode("Success");
	} else {
		return json_encode("Fail");
	}
}

function retrieveData(){
	global $pdo;
	
	$retrieveTempData = "SELECT * FROM temperature ORDER BY dateTime DESC LIMIT 10";
	$retrieveTempDataQuery = $pdo -> query($retrieveTempData);
	$TempData = $retrieveTempDataQuery -> fetchAll(PDO::FETCH_OBJ);
		
	//  convert to JSON
	return json_encode($TempData);
}
?>