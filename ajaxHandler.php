<?php

	require_once 'init.php';
	require_once("controller/WeatherController.php");

	$weatherController = new WeatherController();

	if(key($_GET) == null) {
		$_GET[$_POST['action']] = "";
	}
	
	echo $weatherController->doControll();