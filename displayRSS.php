<?php
$xml = simplexml_load_file("rss.xml") or die("Unable to create object");

echo "<h1>List of Articles</h1>";

for($i = 0; $i < sizeof($xml->channel->item); $i++){
	$headline = (string) $xml->channel->item[$i]->headline;
	$category =(string)$xml->channel->item[$i]->category;
	$description = (string)$xml->channel->item[$i]->description;
	$createdOn = (string)$xml->channel->item[$i]->createdOn;
	$author = (string)$xml->channel->item[$i]->author;
	$link = (string)$xml->channel->item[$i]->url;

	echo "Headline: " . $headline . "</br>";
	echo "Category: " . $category . "</br>";
	echo "Description: " . $description . "</br>";
	echo "Author: " . $author . "</br>";
	echo "Link: <a href='".$link."'>Click Here</a></br>";
	echo "</br>";
}
?>