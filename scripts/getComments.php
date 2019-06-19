<?php
function getComments($articleID, $offset){
	$commentstxt = json_decode(getAllCommentsByArticle($articleID, $offset));
	$count = count($commentstxt);

	$output = "";
	

	if($count > 0){
		$i = 0;
		while($i < $count){
			$output .= "<div class='comment'>";
			$output .= "<p>Comment ID:".$commentstxt[$i] -> commentID. "</p>";
			$output .= "<p>Comment Content:".$commentstxt[$i] -> commentContent. "</p>";
			
			$explodeTimeDate = explode(' ', $commentstxt[$i] -> timePosted);
							
			$date = $explodeTimeDate[0];
			$time = $explodeTimeDate[1];
			$output .= "<p>Time Posted: ".$time. "</p>";
			$output .= "<p>Date Posted: ".$date. "</p>";
							
			$userID = $commentstxt[$i] -> postedBy;
			$usernametxt = checkUsernameByID($userID);
			$username = json_decode($usernametxt);
			$output .= "<p>User Name:".$username."</p>";
			if(!isset($_SESSION) || empty($_SESSION)){
				
			} else if($_SESSION['user'][1] == "admin"){
				$output .= "<form id='deleteComment' name='deleteComment' method='POST' action=''>";
				$output .= "<input type='hidden' id='commentID' name='commentID' value=".$commentstxt[$i] -> commentID.">";
				$output .= "<input type='submit' name ='Submit' value='Delete Comment' id='Submit' />";
				$output .= "</form>";
				}
				$output .= "</div>";
				$output .= "</br>";
			
			$i++;
		}
		
	} else {
		$output .= "There are no comments yet. Be the first to post one";
	} 
	return $output;
}
?>