<?php
	function getNumberOfPaginationPagesComments($limit, $articleID){
		$numberOfPages = 0;
		$commentCount = json_decode(getNumberOfComments($articleID));
		$numberOfPages = ceil($commentCount / $limit);
		
		return $numberOfPages;
	}
	
	function getNumberOfPaginationPagesArticles($limit, $date){
		$numberOfPages = 0;
		if($date == null){
			$articleCount = json_decode(getNumberOfArticles());
		} else {
			$articleCount = json_decode(getNumberOfArticlesByDate($date));
		}
		
		$numberOfPages = ceil($articleCount / $limit);
		
		return $numberOfPages;
	}
	
	function getOffset($currentPage, $limit){
		$offset = 0;
		if($currentPage > 1){
			$offset = ($currentPage - 1) * $limit;
		} else {
			$offset = 0;
		}
		
		return $offset;
	}
	
	function displayPagination($id, $currentPage, $numOfPages, $location){
		$paginationOutput = "";
		$link = "";
		if($location == "comment"){
			$link .= "displayArticle.php?id=";
			$link .= $id;
			$link .= "&page=";
		} else {
			if($id == null){
				$link .= "index.php?";
				$link .= "page=";
			} else {
				$link .= "index.php?date=";
				$link .= $id;
				$link .= "&page=";
			}
		}
		
		
		
		$paginationOutput .= "<nav aria-label='...'>";
		$paginationOutput .= "<ul class='pagination'>";
		
		if($currentPage == 1){ 
			$paginationOutput .= "<li class='page-item disabled'>";
			$paginationOutput .= "<a class='page-link' href='".$link."' tabindex='-1'>Previous</a>";
			$paginationOutput .= "</li>";
		} else {
			$paginationOutput .= "<li class='page-item'>";
			$paginationOutput .= "<a class='page-link' href='". $link . ($currentPage - 1)."'>Previous</a>";
			$paginationOutput .= "</li>";
		}
		
		for($i = 1; $i <= $numOfPages; $i++){
			$paginationOutput .= "<li class='page-item'><a class='page-link' href='".$link . $i."'>".$i."</a></li>";
		}
		
		if($currentPage == $numOfPages){ 
			$paginationOutput .= "<li class='page-item disabled'>";
			$paginationOutput .= "<a class='page-link' href='".$link."' tabindex='-1'>Next</a>";
			$paginationOutput .= "</li>";
		} else {
			$paginationOutput .= "<li class='page-item'>";
			$paginationOutput .= "<a class='page-link' href='". $link . ($currentPage + 1)."'>Next</a>";
			$paginationOutput .= "</li>";
		}
		
		$paginationOutput .= "</ul>";
		$paginationOutput .= "</nav>";
		
		return $paginationOutput;
	}
?>