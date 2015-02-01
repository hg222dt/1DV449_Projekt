<?php

require_once('../init.php');
require_once("WeatherModel.php");


$weatherModel = new WeatherModel();

if($_GET['action'] == "isUserLoggedIn") {

	$userLoggedIn = $weatherModel->isUserLoggedIn();

	if($userLoggedIn == false) {
		$data = Array("userLoggedIn" => false);
	} else {
		$data = Array("userLoggedIn" => true);
	}

	echo json_encode($data);
	
}
