<?php

require_once("WeatherApiHandler.php");

$srApiHandler = new SrApiHandler();

if($_GET['action'] == "getLatest") {

	echo $srApiHandler->useCacheOrNewCall();
}