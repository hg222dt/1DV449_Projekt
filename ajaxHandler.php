<?php

	require_once 'init.php';
	require_once("controller/WeatherController.php");


	if($_SESSION['csrfToken'] == (isset($_POST['csrfToken']) && $_POST['csrfToken']) OR $_SESSION['csrfToken'] == (isset($_GET['csrfToken']) && $_GET['csrfToken'])) {	

		$weatherController = new WeatherController();

		if(key($_GET) == null) {
			$_GET[$_POST['action']] = "";
		}
		
		echo $weatherController->doControll();

	} else {
		echo "csrfAttack";
	}