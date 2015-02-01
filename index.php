<?php

	require_once 'init.php';

	require_once("HTMLView.php");
	require_once("controller/WeatherController.php");



	$weatherController = new WeatherController();

	$auth = $weatherController->weatherModel->auth;

	$htmlBody = $weatherController->doControll();

	if($auth->checkRedirectCode()) 
	{
		header('Location: index.php');
	}

	$view = new HTMLView();
	$view->echoHTML($htmlBody);






