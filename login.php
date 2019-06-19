<?php
include "scripts/db_connection.php";
include "scripts/header.php";

$warning = "<div class='alert alert-warning' role='alert'>
  <strong>Warning!</strong> Username or Password was incorrect. Try again.
</div>";

$reCaptcha = "<div class='alert alert-warning' role='alert'>
  <strong>Warning!</strong> You didn't click the reCaptcha. If you're sure you're not a robot, Please try again
</div>";

$reCaptchaFailed = "<div class='alert alert-warning' role='alert'>
  <strong>Warning!</strong> The reCaptcha failed, please try to login again and ensure it has been clicked.
</div>";
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
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
	<?php echo $navbar; 
	
	$failReason = "";
	
	if(isset($_GET['login'])){
		$failReason = $_GET['login'];
		if (strcmp($failReason, '"failed"') == 0){
			echo $warning;
		} else if (strcmp($failReason, '"reCaptchaNotClicked"') == 0){
			echo $reCaptcha;
		} else if (strcmp($failReason, '"reCaptchaFailed"') == 0){
			echo $reCaptchaFailed;
		} else {
			echo "failed";
		}
	}
	?>
	
	<div class="loginContainer">
		<div class="loginBox">
			<p>Please enter your login information below</p> 
				<form id="login" name="login" method="POST" action="scripts/attemptLogin.php">
					<label for="username"><span>Username:</span></label>  
					<input type="text" name="username" id="username" required/> </br>
					<label for="password"><span>Password:</span></label>
					<input type="password" name="password" id="password" required/>
					<div class="g-recaptcha" data-sitekey="6Ld6FnUUAAAAANXPRY9VdP-wSys-QEFpIA8Z0zry"></div>
					<input type="submit" value="Submit" id="loginsubmit" />
				</form>
		</div>
	</div>
	</br></br>
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