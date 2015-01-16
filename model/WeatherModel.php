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

	public function retrieveWeatherDataFromWeb($city) {

		if($this->weatherApiHandler->shouldWeUseCache($city->geonameId)) {
			$this->weatherApiHandler->getDataFromRepository($city->geonameId);
		} else {
			$cities = array(0 => $city); 
			$this->weatherApiHandler->retrieveWeatherDataFromWeb($cities);
		}
	}

	public function getLatestChosenCitySession($geonameId) {
		return $_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID][$geonameId];
	}
}