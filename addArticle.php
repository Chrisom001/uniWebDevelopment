<?php
include "scripts/db_connection.php";
include "model/api-articles.php";
include "scripts/header.php";

$inputForm = "";
$inputForm .="<form id='newArticle' name='newArticle' method='POST' action='addArticle.php'>";
$inputForm .="<label for='articleHeadline'><span>Article Headline</span></label>
				<input type='text' name='articleHeadline' id='articleHeadline' form='newArticle' maxlength='100' size='100' required>
				</text></br>";
$inputForm .="<label for='articleSummary'><span>Article Summary</span></label>
				<input type='text' name='articleSummary' id='articleSummary' form='newArticle' maxlength='200' size='100' required>
				</br>";
$inputForm .="<label for='articleContent'><span>Initial Article Content:</span></label>
				<textarea name='articleContent' id='articleContent' form='newArticle' cols=70 rows=10 maxlength=1000 required></textarea> </br>";
$inputForm .="<label for='articleSubHeading1'><span>Subheading 1:</span></label>
				<input type='text' name='articleSubHeading1' id='articleSubHeading1' form='newArticle' maxlength=50 size='50'></br>";
$inputForm .="<label for='articleContent2'><span>Article Content 2:</span></label></br>
				<textarea name='articleContent2' id='articleContent2' form='newArticle' cols=70 rows=10 maxlength=1000></textarea> </br>";
$inputForm .="<label for='articleSubHeading2'><span>Subheading 2:</span></label>
				<input type='text' name='articleSubHeading2' id='articleSubHeading2' form='newArticle' maxlength=50 size='50'></br>";
$inputForm .="<label for='articleContent3'><span>Article Content 3:</span></label></br>
				<textarea name='articleContent3' id='articleContent3' form='newArticle' cols=70 rows=10 maxlength=1000></textarea> </br>";
$inputForm .="<input type='submit' name ='articleSubmit' value='articleSubmit' id='articleSubmit' />";
$inputForm .="</form>";
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

	
	<p>
	Please enter your new article below. Ensure that you fill in each relevant section. If there is no headline for a subheading, it will NOT be displayed on screen.
	</p>
	
	<div class="container">
		<?php
			if(isset($_POST["articleSubmit"])){
				$articleHeadline = cleanText($_POST["articleHeadline"]);
				$articleSummary = cleanText($_POST["articleSummary"]);
				$articleContent = cleanText($_POST["articleContent"]);
				$articleSubHeading1 = cleanText($_POST["articleSubHeading1"]);
				$articleContent2 = cleanText($_POST["articleContent2"]);
				$articleSubHeading2 = cleanText($_POST["articleSubHeading2"]);
				$articleContent3 = cleanText($_POST["articleContent3"]);
				
				$result = json_decode(insertArticle($articleHeadline, $articleSummary, $articleContent, $articleSubHeading1, $articleContent2, $articleSubHeading2, $articleContent3, $_SESSION["user"][2]));
				if(!$result){
					echo "Insert Failed";
				} else {
					echo "You need to upload images for Article " . $result;
					echo "<form action='scripts/imageupload.php' method='post' enctype='multipart/form-data'>";
					echo "Select image to upload as a thumbnail:";
					echo "<input type='file' name='articleThumbnail' id='articleThumbnail' required></br>";
					$articleArray = json_decode(getArticleById($result));
					//var_dump($articleArray);
					if($articleArray[0]->articleSubheading1 == ""){
						
					}else{
						echo "Select image to upload for the first subheading:";
						echo "<input type='file' name='articleSubheading1' id='articleSubheading1' required></br>";
					}
					
					if($articleArray[0]->articleSubheading2 == ""){
						
					}else{
						echo "Select image to upload for the second subheading:";
						echo "<input type='file' name='articleSubheading2' id='articleSubheading2' required></br>";
					}
					echo "<input type='hidden' name='article' id='article' value='".$result."'>";
					echo "<input type='Submit' value='Upload Image' name='imageSubmit'>";
					echo "</form>";
				}
			} else {
				echo $inputForm;
			}
			
			
			function cleanText($input){
				$output = trim($input);
				$output = stripslashes($output);
				$output = htmlspecialchars($output);
	
				return $output;
			}
		?>
	</div>
	</br></br></br></br>
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