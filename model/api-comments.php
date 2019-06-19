<?php
//include "../scripts/db_connection.php";
$db = new dbObj();
$pdo =  $db->getConnstring();

function getAllCommentsByArticle($articleID, $offset)
{
	global $pdo;
	//$readComByArt = "SELECT * FROM GW_Comments WHERE articleID = '$articleID' ORDER BY timePosted DESC LIMIT 3";
	$readComByArt = "SELECT * FROM GW_Comments WHERE articleID = '$articleID' ORDER BY timePosted DESC LIMIT 3 OFFSET $offset";
	$readComByArtQuery = $pdo -> query($readComByArt);
	
	$readCommentsByArticle = $readComByArtQuery -> fetchAll(PDO::FETCH_OBJ);
		
	//  convert to JSON
	return json_encode($readCommentsByArticle);
}

function getNumberOfComments($articleID){
	global $pdo;
	
	$getNumCom = "SELECT COUNT(articleID) FROM GW_Comments WHERE articleID = '$articleID'";
	$check = $pdo -> prepare($getNumCom);
    $check -> execute();
	$checkResult = $check -> fetchcolumn();
	
	return json_encode($checkResult);
}

function addArticle($comment, $postedBy, $articleID, $dateTime){
	global $pdo;
	
	$insertTempSQL = "INSERT INTO GW_Comments(commentContent, postedBy, articleID, timePosted) VALUES(:commentContent, :postedBy, :articleID, :time)";
	$statement = $pdo -> prepare($insertTempSQL);

	$success = $statement -> execute([
        "commentContent" => $comment,
		"postedBy" => $postedBy,
		"articleID" => $articleID,
		"time" => $dateTime
		]);
	
	if($success && $statement -> rowCount() > 0){
		return json_encode(true);
	} else {
		return json_encode(false);
	}
}

function deleteComment($commentID){
	global $pdo;
	
	$deleteCommentSQL = "DELETE FROM GW_Comments WHERE commentID = :commentID";
	$statement = $pdo -> prepare($deleteCommentSQL);
	
	$success = $statement -> execute([
        "commentID" => $commentID
		]);
		
	if($success && $statement -> rowCount() > 0){
		return json_encode(true);
	} else {
		return json_encode(false);
	}
}
?>