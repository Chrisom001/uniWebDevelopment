<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$navbar = "";
$navbar .= "<nav class = 'navbar navbar-dark bg-dark'>";
$navbar .= "<a class='navbar-brand' href='index.php'>FoxCo Gaming Newsletter</a>";
$navbar .= "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavAltMarkup' aria-controls='navbarNavAltMarkup' aria-expanded='false' aria-label='Toggle navigation'>";
$navbar .= "<span class='navbar-toggler-icon'></span>";
$navbar .= "</button>";
$navbar .= "<div class='collapse navbar-collapse' id='navbarNavAltMarkup'>";
$navbar .= "<div class='navbar-nav'>";
$navbar .= "<a class='nav-item nav-link' href='displayTemperatureData.php'>Internet Of Things</a>";
$navbar .= "<a class='nav-item nav-link' href='rss.xml'>RSS File</a>";
$navbar .= "<a class='nav-item nav-link' href='displayRSS.php'>RSS Interrogation</a>";
$navbar .= "<a class='nav-item nav-link' href='XSLTdisplayRSS.php'>BBC News</a>";
$navbar .= "<a class='nav-item nav-link' href='weather.php'>Weather</a>";

$navbar .= "</div>";
$navbar .= "</div>";
$navbar .= "<div class='form-inline'>";

	if(!isset($_SESSION) || empty($_SESSION)){
		$navbar .= "<a href='register.php'>Register</a> | <a href='login.php'>Login</a>";
	} elseif ($_SESSION['user'][0] == "failed"){
		$navbar .= "<a href='register.php'>Register</a> | <a href='login.php'>Login</a>";
	} else {
		$navbar .= "Welcome " . $_SESSION['user'][0] . " | ";
		if($_SESSION['user'][1] == "contributor"){
			$navbar .= "<a href='addArticle.php'>Add an Article</a> | ";
		} else if($_SESSION['user'][1] == "admin"){
			$navbar .= "<a href='addArticle.php'>Add an Article</a> |  ";
		}
		$navbar .= "<a href='logout.php'>Logout</a>";
	}
	$navbar .= "</div>";
	$navbar .= "</nav>";
?>