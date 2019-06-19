<?php
function getCurrentWeather(){
$currentWeather="";
$currentWeather=file_get_contents("http://dataservice.accuweather.com/currentconditions/v1/327794?apikey=zNLtUtvolOmh6pSPTDyMEqqttjNAtRye");

return $currentWeather;	
}
?>