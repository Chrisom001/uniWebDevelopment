<?php
include_once 'db_connection.php';
include "../model/api-articles.php";
include "header.php";

//These are the alerts which will be used on this page depending on results given
$ThumbnailSuccess = "<div class='alert alert-success' role='alert'>The thumbnail upload was successful. Click <a href='../index.php'>HERE!</a> to back to the index page</div>";
$ThumbnailFailure = "<div class='alert alert-danger' role='alert'>The thumbnail upload was unsuccessful. Click <a href='../index.php'>HERE!</a> to back to the index page and contact an Admin</div>";
$section1Success = "<div class='alert alert-success' role='alert'>The 1st Image upload was successful. Click <a href='../index.php'>HERE!</a> to back to the index page</div>";
$section1Failure = "<div class='alert alert-danger' role='alert'>The 1st Image upload was unsuccessful. Click <a href='../index.php'>HERE!</a> to back to the index page and contact an Admin</div>";
$section2Success = "<div class='alert alert-success' role='alert'>The 2nd Image upload was successful. Click <a href='../index.php'>HERE!</a> to back to the index page</div>";
$section2Failure = "<div class='alert alert-danger' role='alert'>The 2nd Image upload was unsuccessful. Click <a href='../index.php'>HERE!</a> to back to the index page and contact an Admin</div>";

$article = $_POST['article'];
$subHeading1Image = "";
$subHeading2Image = "";
$thumbnailImage = "articleThumbnail";
$thumbNailResult = uploadFile($article, $thumbnailImage, $thumbnailImage);
$subHeading1Result = null;
$subHeading2Result = null;

if(!file_exists($_FILES['articleSubheading1']['tmp_name']) || !is_uploaded_file($_FILES['articleSubheading1']['tmp_name'])) {
    //echo 'No upload';
} else {
	$subHeading1Image = "articleSubheading1";
	$imageLocation = "articleImage1";
	$subHeading1Result = uploadFile($article, $subHeading1Image, $imageLocation);
}

if(!file_exists($_FILES['articleSubheading2']['tmp_name']) || !is_uploaded_file($_FILES['articleSubheading2']['tmp_name'])) {
    //echo 'No upload';
} else {
	$subHeading2Image = "articleSubheading2";
	$imageLocation = "articleImage2";
	$subHeading2Result = uploadFile($article, $subHeading2Image, $imageLocation);
}

function uploadFile($article, $fileUploadType, $imageLocation){
	$target_dir = "../img/";
	$target_file = $target_dir . basename($_FILES[$fileUploadType]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES[$fileUploadType]["tmp_name"]);
		if($check !== false) {
			return false;
			$uploadOk = 1;
		} else {
			return false;
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		return false;
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES[$fileUploadType]["size"] > 500000) {
		return false;
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		return false;
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		return false;
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES[$fileUploadType]["tmp_name"], $target_file)) {
			$filename = basename($_FILES[$fileUploadType]['name']);
			$filelocation = "../img/$filename";
			$fileDBlocation = "img/$filename";
			$result = updateArticleImage($imageLocation, $fileDBlocation, $article);
			if(!$result){
				return false;
			} else {
				chmod($filelocation, 0644);
				return true;
			}
		} else {
			return false;
		}
	}
}
?>

<!doctype html>
<html lang="en">
  <head>
  
	<!--- Stylesheet include -->
	<link href="../css/style.css" rel="stylesheet">
	
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Gaming Newsletter</title>
  </head>
  <body>
    <nav class = "navbar navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">FoxCo Gaming Newsletter</a>
		<div class="form-inline">
			<?php echo $navbar; ?>
		</div>
	</nav>
	<div class="container">
	<p>
	This section will let you know if the files you attempted to upload were successful. Click the FoxCo name at the top right to go back to the index page.
	</p>
	
	<?php
		if($thumbNailResult){
			echo $ThumbnailSuccess;
		} else {
			echo $ThumbnailFailure;
		}
		if($subHeading1Result != null){
			if($subHeading1Result){
			echo $section1Success;
			} else {
				echo $section2Failure;
			}
		}
		
		if($subHeading2Result != null){
			if($subHeading2Result){
				echo $section2Success;
			} else {
				echo $section2Failure;
			}
		}
		
	?>

	</div>
	</br></br></br>
	</body>
	<footer class="footer">
		<?php include "footer.php"; ?>
	</footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
</html>