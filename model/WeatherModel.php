<?php

 /*
 * Huvudmodellklass
 *
 **/

 require_once("WeatherApiHandler.php");

class WeatherModel {


	public $weatherApiHandler;

	public function __construct() {
		$this->weatherApiHandler = new WeatherApiHandler();

	}

	public function retrieveWeatherData($userInput) {
		$this->weatherApiHandler->retrieveWeatherData($userInput);
	}
	
}