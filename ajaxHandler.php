<?php

	require_once 'init.php';
	require_once("controller/WeatherController.php");

	$weatherController = new WeatherController();

	$_GET[$_POST['action']] = "";

	echo $weatherController->doControll();