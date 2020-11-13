<?php
$url =  "https://newsapi.org/v2/top-headlines?country=us&category=general&apikey=cebd0330d8dd41208bcf09710d677bb6";
$datos = file_get_contents($url);
$datos = json_decode($datos);
?>
