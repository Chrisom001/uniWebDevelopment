<?php
include "scripts/db_connection.php";
include "scripts/header.php";
include "model/api-users.php";

//This checks if the submit button has been pressed, if it has, it fills the variables

if(isset($_POST["Submit"])){
	$userName = cleanText($_POST["username"]);
	$fName = cleanText($_POST["fName"]);
	$lName = cleanText($_POST["lName"]);
	$emailAddress = $_POST["email"];
	$password1 = cleanText($_POST["password1"]);
	$password2 = cleanText($_POST["password2"]);
	
	function cleanText($input){
				$output = trim($input);
				$output = strip_tags($output);
				$output = stripslashes($output);
				$output = htmlspecialchars($output);
	
				return $output;
			}
	
	$validEmailCheck = filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
}

//This puts the register form into a variable so it can be called easily when required

$registerForm = "<p>Please enter your details below to register</p> </br></br>";
$registerForm .= "<form id='register' name='register' method='POST' action=''>";
$registerForm .= "<label for='username'><span>Username:</span></label>  ";
$registerForm .= "<input type='text' name='username' id='username' required/> </br>";
$registerForm .= "<label for='email'><span>Email Address:</span></label>";
$registerForm .= "<input type='text' name='email' id='email' required/> </br>";
$registerForm .= "<label for='fName'><span>First Name:</span></label>";
$registerForm .= "<input type='text' name='fName' id='fName' required/> </br>";
$registerForm .= "<label for='lName'><span>Last Name:</span></label>";
$registerForm .= "<input type='text' name='lName' id='lName' required/> </br>";
$registerForm .= "<label for='password'><span>Password:</span></label>";
$registerForm .= "<input type='password' name='password1' id='password1' required/></br>";
$registerForm .= "<label for='password'><span>Confirm Password:</span></label>";
$registerForm .= "<input type='password' name='password2' id='password2' required/></br>";
$registerForm .= "<input type='submit' name ='Submit' value='Submit' id='Submit' />";
$registerForm .= "</form>";
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
	<div class="registerContainer">
		
			<?php
				if(!isset($emailAddress)){
					echo "<div class='registerForm'>";
					echo $registerForm;
					echo "</div>";
				} else {
					$userNameCheck = checkUsername($userName);
					$emailCheck = checkEmailAddress($emailAddress);
					$userNamejson = json_decode($userNameCheck);
					$emailJson = json_decode($emailCheck);
					//This checks that the passwords match each other
					if($password1 != $password2){
						echo "<div class='alert alert-warning' role='alert'>";
						echo "<strong>Warning!</strong> The two passwords do not match.";
						echo "</div>";
						echo "</br>";
						echo $registerForm;
						//This checks that the email address is valid
					} elseif ($validEmailCheck == false){
						echo "<div class='alert alert-warning' role='alert'>";
						echo "<strong>Warning!</strong> Please enter a valid email address.";
						echo "</div>";
						echo "</br>";
						echo $registerForm;
						//This checks if the username already exists in the database
					}elseif ($userNamejson == "True"){
						echo "<div class='alert alert-warning' role='alert'>";
						echo "<strong>Warning!</strong> The selected username already exists";
						echo "</div>";
						echo "</br>";
						echo $registerForm;
						//This checks if the email address already exists in the database
					} elseif ($emailJson == "True"){
						echo "<div class='alert alert-warning' role='alert'>";
						echo "<strong>Warning!</strong> The selected email address is already in use";
						echo "</div>";
						echo "</br>";
						echo $registerForm;
					}else {
						$userRegister = insertUser($userName, $password1, $fName, $lName, $emailAddress);
						$userJson = json_decode($userRegister);
						if ($userJson == "Success"){
							echo "<div class='alert alert-success' role='alert'>
								<strong>Success</strong> Your account has been created successfully. Proceed to <a href='login.php'>Login</a> or <a href='index.php'>Main Page</a>
							</div>";
						} else {
							echo "<div class='alert alert-danger' role='alert'>
							<strong>Warning!</strong> User Account wasn't created. Please try again
							</div>";
							echo $registerForm;
						}
					}
				}
			?>
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