<?php
include "scripts/db_connection.php";
include "scripts/header.php";
include "model/api-articles.php";
include "model/api-comments.php";
include "scripts/getComments.php";
include "model/api-users.php";
include "scripts/pagination.php";

//This gets the Article by the ID selected
$id = $_GET["id"];
$articletxt = getArticleById($id);
$articlejson = json_decode($articletxt);

//This controls the paginations current page, how many pages there will be and hte offset for the SQL query
$currentPage = "0";
$limit = 3;
//This works out the number of pages required based on the limit and the ID of the article.
$numOfPages = getNumberOfPaginationPagesComments($limit, $id);
//This checks if there is a page number set in the URL, if there is it then sets that as current page
//Otherwise it assumes it's page 1 and sets currentpage as 1.
if(isset($_GET["page"])){
	$currentPage = $_GET["page"];
} else {
	$currentPage = 1;
}
//This takes the Current Page number and Limit to work out the offset required for that page.
$offset = getOffset($currentPage, $limit);
//This uses the ID, Current Page Number and Number of Pages to generate the pagination bar for the bottom of the page
$paginationOutput = displayPagination($id, $currentPage, $numOfPages, "comment");
					
//These are the alerts which will be used on this page depending on results given
$commentDeleteSuccess = "<div class='alert alert-success' role='alert'>The comment was deleted succesfully! Refresh the page to see the change!</div>";
$commentDeleteFailure = "<div class='alert alert-danger' role='alert'>The comment wasn't deleted, please try again!</div>";
$commentSuccess = "<div class='alert alert-success' role='alert'>Your comment was added succesfully!</div>";
$commentFailure = "<div class='alert alert-danger' role='alert'>Your comment wasn't added, please try again!</div>";

//This gets all the comments for the requested ID
$output = getComments($id, $offset);

//This creates the comment form
$commentForm = "<form id='createComment' name='createComment' method='POST' action='scripts/addArticle.php'>";
$commentForm .= "<label for='comment'><span>Comment:</span></label></br>";
$commentForm .= "<textarea name='comment' rows='5' cols='100' maxlength='255' wrap required/> </textarea></br>";
$commentForm .= "<input type='hidden' id='articleID' name='articleID' value=$id>";
$commentForm .= "<input type='submit' name ='Submit' value='Submit' id='Submit' />";
$commentForm .= "</form>";
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
  </head>
  <body>
	<?php echo $navbar;
	
		//This checks if there are any get results, if there are it will display the relevant alert.
		if(isset($_GET['add'])){
			$addResult = $_GET['add'];
			if (strcmp($addResult, 'failed') == 0){
				echo $commentFailure;
			} else if (strcmp($addResult, 'success') == 0){
				echo $commentSuccess;
			} else {
				echo "failed";
			}
		}
		
		//This checks if the delete comment button was pressed and performs the operation and displays the result for the user.
		if(isset($_POST["Submit"])){
			$deleteResult = json_decode(deleteComment($_POST["commentID"]));
			if($deleteResult){
				echo $commentDeleteSuccess;
			} else {
				echo $commentDeleteFailure;
			}
		}
	?>
	<div class="container">
		<div class="articleContainer">
			<div class="article">
				<section class="headline">
					<div id = "articleHeadline">
						<h1><?php echo $articlejson[0] -> articleHeadline; ?> </h1>
						<?php echo "<img src='".$articlejson[0]->articleThumbnail."' alt='fake news' height='100' width='200'>"; ?>
						<?php $postedBy = json_decode(checkUsernameByID($articlejson[0] -> postedBy));?>
						<p>Posted By: <?php echo $postedBy; ?></p>
						<p>Posted On: <?php echo $articlejson[0] -> datePosted; ?>
					</div>
					<div id="articleContent">
						<?php echo "<p>".$articlejson[0] -> articleContent1."</p>"; ?>
					</div>
					
				</section>
				
				<?php 
					if($articlejson[0] -> articleSubheading1 != null){
						echo "<div class = 'subHeadline1'>";
						echo "<div id= 'subHeading1'>";
						echo "<h4>" . $articlejson[0] -> articleSubheading1 . "</h4>";
						echo "</div>";
						
						echo "<div id = 'leftText'>";
						echo $articlejson[0] -> articleContent2;
						echo "</div>";
						echo "<div id = 'rightImage'>";
						echo "<img src='".$articlejson[0]->articleImage1."' alt='fake news'>";
						echo "</div>";
						echo "</div>";
					}
				?>
				
				<?php 
					if($articlejson[0] -> articleSubheading2 != null){
						echo "<div class = 'subHeadline2'>";
						echo "<div id= 'subHeading1'>";
						echo "<h4>" . $articlejson[0] -> articleSubheading2 . "</h4>";
						echo "</div>";
						
						echo "<div id = 'rightText'>";
						echo $articlejson[0] -> articleContent3;
						echo "</div>";
						echo "<div id = 'leftImage'>";
						echo "<img src='".$articlejson[0]->articleImage2."' alt='fake news'>";
						echo "</div>";
						echo "</div>";
					}
				?>	
			</div>
			<?php
				if($articlejson[0]->youtubeVideo != null){
					echo "<div class='embed-responsive embed-responsive-16by9'>";
					echo "<iframe class='embed-responsive-item' src='".$articlejson[0]->youtubeVideo."' allowfullscreen></iframe>";
					echo "</div>";
				}
			?>
			</br></br>
			<section class="comments">
				<?php 
					if(!isset($_SESSION) || empty($_SESSION) || $_SESSION['user'][0] == "failed"){
						echo "Please login to submit a comment";
					} else {
						echo "<button type='button' class='btn btn-info' data-toggle='collapse' data-target='#commentForm'>Create a Comment</button>";
						echo "<div class='collapse' id='commentForm'>";
						echo $commentForm;
						echo "</div>";
					}
					
					echo "</br>";
					echo $output;
					
					echo $paginationOutput; 
				?>
			</section>		
		</div>
	</div>
	
	</br></br></br>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
	<footer class="footer">
		<?php include "scripts/footer.php"; ?>
	</footer>
</html>