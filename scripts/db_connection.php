<?php   
	Class dbObj{

	function getConnString(){
		try{
			$host = "XXXX";
			$dbname = "XXXX";
			$un = "XXXX";
			$pw = "XXXX";
			$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$un, $pw);
		} catch (PDOException $ex) {
			die("An error occured");
		}
		
		return $pdo;
	}
}
?>
