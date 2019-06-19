<?php
//include "../scripts/db_connection.php";
$db = new dbObj();
$pdo =  $db->getConnstring();
$salt1 = "Lj!6K";
$salt2 = "e!S6v";

function checkUser($userName, $password){
 	global $pdo;
	global $salt1;
	global $salt2;
	
	$passwordSalt = $salt1 . $password . $salt2;
	$hash = hash('sha256', $passwordSalt);
	
	$checkUserSQL = "SELECT * FROM GW_Users WHERE userName = :userName AND password = :password";
	
	$statement = $pdo -> prepare($checkUserSQL);
	
	$success = $statement -> execute ([
		"userName" => $userName,
		"password" => $hash
	]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode("True");
	} else {
		return json_encode("False");
	}
}

function roleCheck($userName){
	global $pdo;
	$checkUserRole = "SELECT role FROM GW_Users WHERE userName = '$userName'";
    $check = $pdo -> prepare($checkUserRole);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
		
	return json_encode($checkResult);
}

function checkUsername($userName)
{
 	global $pdo;
	
	$checkUsernameSQL = "SELECT * FROM GW_Users WHERE userName = :userName";
	$statement = $pdo -> prepare($checkUsernameSQL);
	
	$success = $statement -> execute ([
		"userName" => $userName
	]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode("True");
	} else {
		return json_encode("False");
	}
}

function checkUsernameByID($id)
{
 	global $pdo;
	
	$checkUsernameSQL = "SELECT userName FROM GW_Users WHERE userID = $id";
	$check = $pdo -> prepare($checkUsernameSQL);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
	
	return json_encode($checkResult);
}

function getUserIDByUsername($userName){
	global $pdo;
	$checkUserIDSQL = "SELECT userID FROM GW_Users WHERE userName = '$userName'";

	$check = $pdo -> prepare($checkUserIDSQL);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
	
	return json_encode($checkResult);
}

function checkEmailAddress($emailAddress){
	global $pdo;
	
	$checkEmailSQL = "SELECT * FROM GW_Users WHERE emailAddress = :email";
	$statement = $pdo -> prepare($checkEmailSQL);
	
	$success = $statement -> execute ([
		"email" => $emailAddress
	]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode("True");
	} else {
		return json_encode("False");
	}
}

function insertUser($userName, $password, $fName, $lName, $emailAddress){
	global $pdo;
	global $salt1;
	global $salt2;
	
	$passwordSalt = $salt1 . $password . $salt2;
	$hash = hash('sha256', $passwordSalt);
	
	$insertUserSQL = "INSERT INTO GW_Users(userName, password, firstName, lastName, emailAddress, role) VALUES (:userName, :password,:fName,:lName,:emailAdress, 'user')";
	$statement = $pdo -> prepare($insertUserSQL);

	$success = $statement -> execute([
        "userName" => $userName,
        "password" => $hash,
        "fName" => $fName,
		"lName" => $lName,
		"emailAdress" => $emailAddress
    ]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode("Success");
	} else {
		return json_encode("Fail");
	}
}
?>