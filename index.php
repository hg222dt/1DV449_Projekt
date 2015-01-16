<?php

	require_once("HTMLView.php");
	require_once("controller/WeatherController.php");


	session_start();

	$weatherController = new WeatherController();

	$htmlBody = $weatherController->doControll();

	$view = new HTMLView();
	$view->echoHTML($htmlBody);