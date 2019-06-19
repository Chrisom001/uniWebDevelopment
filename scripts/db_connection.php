<?php   
	Class dbObj{

	function getConnString(){
		try{
			$host = "lochnagar.abertay.ac.uk";
			$dbname = "sql1605458";
			$un = "sql1605458";
			$pw = "HXggqTUTIAtH";
			$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$un, $pw);
		} catch (PDOException $ex) {
			die("An error occured");
		}
		
		return $pdo;
	}
}
?>