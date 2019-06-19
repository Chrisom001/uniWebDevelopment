<?php
include "scripts/db_connection.php";
include "model/api-articles.php";
include "scripts/header.php";
include "scripts/pagination.php";

//This controls the paginations current page, how many pages there will be and hte offset for the SQL query
$currentPage = "0";
$limit = 6;
//This works out the number of pages required based on the limit and the ID of the article.
$numOfPages = 0;
//This checks if there is a page number set in the URL, if there is it then sets that as current page
//Otherwise it assumes it's page 1 and sets currentpage as 1.
if(isset($_GET["page"])){
	$currentPage = $_GET["page"];
} else {
	$currentPage = 1;
}
//This takes the Current Page number and Limit to work out the offset required for that page.
$offset = getOffset($currentPage, $limit);
$paginationOutput = "";

if(isset($_GET["date"])){
	$date = $_GET['date'];
	$numOfPages = getNumberOfPaginationPagesArticles($limit, $date);
	$articletxt = getAllArticlesByDate($date, $offset);
	$paginationOutput = displayPagination($date, $currentPage, $numOfPages, "article");
}else {
	$articletxt = getAllArticles($offset);
	$numOfPages = getNumberOfPaginationPagesArticles($limit, null);
	$paginationOutput = displayPagination(null, $currentPage, $numOfPages, "article");
}	
//This uses the ID, Current Page Number and Number of Pages to generate the pagination bar for the bottom of the page
	

	$articleOutput = "";
	$artCount = 0;  //This starts a counter to record how many articles have been displayed
	$artRow = 1;	//This shows how far the row counter is.
	
	$articlejson = json_decode($articletxt);

	if (sizeof($articlejson) < 1){
		$articleOutput .= "There were no articles found";
	} else {
		for ($i=0; $i<sizeof($articlejson); $i++){
			$artCount++;
			if($artCount == 1 || $artCount == $artRow + 3){
				$articleOutput .= "<div class='row'>";
				if($artCount != 1){
					$artRow = $artRow + 3;
				}
			} 
			
			$articleOutput .= "<div class='col-sm'>";
				$articleOutput .= "<div class='card' style='width: 18rem;'>";
					$articleOutput .= "<img class='card-img-top' src='".$articlejson[$i]->articleThumbnail."' alt='fakenews' height='150' width='200'>";
					$articleOutput .= "<div class='card-body'>";
					$articleOutput .= "<h5 class='card-title'>".$articlejson[$i]->articleHeadline. "</h5>";
					$articleOutput .= "<p class='card-text'>".$articlejson[$i]->articleSummary. "</p>";
					$articleOutput .= "<a href='displayArticle.php?id=".$articlejson[$i]->articleID."' class='btn btn-primary'>Read Article</a>";
					$articleOutput .= "</div>";
				$articleOutput .= "</div>";
			$articleOutput .= "</div>";

			//This checks if the article ID can be divided by three, as if it can be, then a new row needs to be started.
			if($artCount == 3) {
				$articleOutput .= "</div> <hr>";
			}
		}
	}	
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
	<div class="container">
	<p>
	Welcome to the FoxCo Gaming Newsletter where we will endeavour to bring you the latest gaming news from around the web. 
	</p>
	
	
	<form action="index.php" method="get">
		<label>Search by Date</label> 
		<input type="date" name="date"></input>
		<input type="submit"></input>
	</form>
	
	
		<?php
			echo $articleOutput;			
		?>
		</div> <hr>
		<?php echo $paginationOutput; ?>
	</div>
	
	</br></br></br>
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