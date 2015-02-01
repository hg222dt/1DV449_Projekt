<?php

	require_once 'init.php';

	require_once("HTMLView.php");
	require_once("controller/WeatherController.php");

	$db = new DB;
	$googleClient = new Google_Client;

	$auth = new GoogleAuth($db, $googleClient);


	$weatherController = new WeatherController($auth);

	$htmlBody = $weatherController->doControll();

	if($auth->checkRedirectCode()) 
	{
		header('Location: index.php');
	}

	$view = new HTMLView();
	$view->echoHTML($htmlBody);






