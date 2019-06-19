<?php
include "header.php";
include "db_connection.php";
include "../model/api-comments.php";


$commentContent = $_POST["comment"];
$articleID = $_POST["articleID"];
$userID = $_SESSION['user'][2];
$dateTime = date("Y-m-d H:i:s");

$commentResult = json_decode(addArticle(textClean($commentContent), $userID, $articleID, $dateTime));

if($commentResult){
	header("Location: ../displayArticle.php?id=$articleID&add=success");
} else {
	header("Location: ../displayArticle.php?id=$articleID&add=failed");
}

function textClean($commentContent){
	$comment = trim($commentContent);
	$comment = stripslashes($comment);
	$comment = htmlspecialchars($comment);
	
	return $comment;
}
?>