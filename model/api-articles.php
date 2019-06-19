<?php
//include "../scripts/db_connection.php";
$db = new dbObj();
$pdo =  $db->getConnstring();

function getAllArticles($offset)
{
	global $pdo;
		//$sqlReadArticles = "SELECT * FROM GW_Articles";
		$sqlReadArticles = "SELECT * FROM GW_Articles ORDER BY datePosted DESC, timePosted DESC LIMIT 6 OFFSET $offset";
		$readArticlesQuery = $pdo -> query($sqlReadArticles);
		$readArticles = $readArticlesQuery -> fetchAll(PDO::FETCH_OBJ);
		
		//  convert to JSON
		return json_encode($readArticles);
}

function getNumberOfArticles(){
	global $pdo;
	
	$getNumArt = "SELECT COUNT(articleID) FROM GW_Articles";
	$check = $pdo -> prepare($getNumArt);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
	
	return json_encode($checkResult);
}

function getNumberOfArticlesByDate($date){
	global $pdo;
	
	$getNumArt = "SELECT COUNT(articleID) FROM GW_Articles WHERE datePosted = '$date'";
	$check = $pdo -> prepare($getNumArt);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
	
	return json_encode($checkResult);
}

function getAllArticlesByDate($date)
{
	global $pdo;
	$readArtByDate = "SELECT * FROM GW_Articles WHERE datePosted = '$date'";

	$readArtByDateQuery = $pdo -> query($readArtByDate);
	
	$readArticlesByDate = $readArtByDateQuery -> fetchAll(PDO::FETCH_OBJ);
		
	//  convert to JSON
	return json_encode($readArticlesByDate);
}

function getArticleById($id)
{
	global $pdo;
	$readArtByID = "SELECT * FROM GW_Articles WHERE articleID = '$id' LIMIT 1";

 	$readArticlesQuery = $pdo -> query($readArtByID);
	$readArticles = $readArticlesQuery -> fetchAll(PDO::FETCH_OBJ);
	
 	return json_encode($readArticles);
}

function insertArticle($articleHeadline, $articleSummary, $articleContent, $articleSubHeading1, $articleContent2, $articleSubHeading2, $articleContent3, $id){
	global $pdo;
	$insertArticle = "INSERT INTO GW_Articles(articleHeadline, articleSummary, articleContent1, articleSubheading1, articleContent2, articleSubheading2, articleContent3, postedBy, datePosted, timePosted) VALUES (:headline, :summary, :content1, :subheading1, :content2, :subheading2, :content3, :postedBy, :datePosted, :timePosted);";
	
	$statement = $pdo -> prepare($insertArticle);
	$date = date("Y-m-d");
	$time = date("H:i:s");
	$success = $statement -> execute([
        "headline" => $articleHeadline,
		"summary" => $articleSummary,
		"content1" => $articleContent,
		"subheading1" => $articleSubHeading1,
		"content2" => $articleContent2,
		"subheading2" => $articleSubHeading2,
		"content3" => $articleContent3,
		"postedBy" => $id,
		"datePosted" => $date,
		"timePosted" => $time
		]);
		
	if($success && $statement -> rowCount() > 0){
		$lastEntryID = "SELECT articleID FROM GW_Articles WHERE datePosted = '$date' && timePosted = '$time'";
		$check = $pdo -> prepare($lastEntryID);
		$check -> execute();
		$checkResult = $check -> fetchcolumn();
		
		return json_encode($checkResult);
		
	} else {
		return json_encode($pdo->errorInfo());
	}
}

function deleteArticle($articleID){
	global $pdo;
	
	$deleteArticle = "DELETE FROM GW_Articles WHERE articleID = :articleID";
	$statement = $pdo -> prepare($deleteArticle);
	
	$success = $statement -> execute([
        "articleID" => $articleID
		]);
		
	if($success && $statement -> rowCount() > 0){
		return json_encode(true);
	} else {
		return json_encode(false);
	}
}

function updateArticleImage($type, $location, $articleID){
	global $pdo;
	
	$updateArticleImages = "UPDATE GW_Articles SET ".$type." = :location WHERE articleID = '$articleID'";
	$statement = $pdo -> prepare($updateArticleImages);
	
	$success = $statement -> execute([
        "location" => $location
		]);
		
	if($success && $statement -> rowCount() > 0){
		return json_encode(true);
	} else {
		return json_encode(false);
	}
}
?>