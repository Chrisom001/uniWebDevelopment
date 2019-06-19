<?php
include_once 'db_connection.php';
include "../model/api-users.php";
require_once 'recaptchalib.php';
include "header.php";
//Secret Key
$secretKey = "6Ld6FnUUAAAAAHquscQ8b0J_GNl01vE8cGAQXuSH";
//empty response
$response = null;
//check secret key
$reCaptcha = new ReCaptcha($secretKey);
//Recaptcha Post Data
$reCaptchaPost = $_POST["g-recaptcha-response"];

//echo $reCaptchaPost;
if($reCaptchaPost == null){
	header('Location: ../login.php?login=reCaptchaNotClicked');
} else {
	$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $reCaptchaPost);
}

if ($response != null && $response->success) {
	session_start();
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

	$usertxt = checkUser($username, $password);
	$userjson = json_decode($usertxt);

	if($userjson == "False"){
		echo "Logon Failed";
		$_SESSION['user'] = array();
		$_SESSION['user'][] = "failed";
		header('Location: ../login.php?login="failed"');
	} else {
		$roletxt = roleCheck($username);
		$role = json_decode($roletxt);
		
		$userIDtxt = getUserIDByUsername($username);
		$userid = json_decode($userIDtxt);
		
		$_SESSION['user'] = array();
		$_SESSION['user'][] = $username;
		$_SESSION['user'][] = $role;
		$_SESSION['user'][] = $userid;
		
		header('Location: ../index.php');
	}
} else {
	  header('Location: ../login.php?login="reCaptchaFailed"');
  } 


?>