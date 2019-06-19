<?php
include "scripts/db_connection.php";
include "scripts/header.php";

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
	Welcome to the FoxCo Gaming Newsletter where we will endeavour to bring you the latest gaming news from around the web. 
	</p>
	
	<div class="container">
	<?php
	$xml = simplexml_load_file("http://feeds.bbci.co.uk/news/world/us_and_canada/rss.xml") ;

	$xsl = simplexml_load_file("news.xsl");
	$proc = new XSLTProcessor() ;
	$proc->importStyleSheet($xsl);
	$result = $proc->transformtoXML($xml);
	echo $result;
	?>
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