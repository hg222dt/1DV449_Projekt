<?php

require_once("WeatherReport.php");

class WeatherApiHandler {
	
	private $weatherReport;


	public function __construct() {
		$weatherReport = new WeatherReport();
	}

	//Gör försök att logga in åt användaren
	public function retrieveWeatherData($userInput) {


		$city = new City();

		$city = $this->searchcity($userInput);

		if($this->shouldWeUseCache($city)) {
			//Använd cache och hämta från databasen
			$data = $getDataFromRepository($city);

			//Konvertera data till WeatherReport



		} else {
			//Hämta från webbservice
			$data = $retrieveWeatherDataFromWeb($city);

			//Konvertera data till WeatherReport

		}

		return null;
	}

	public function shouldWeUseCache($city) {
		
		//Check in repositry if sity exists, and if cache is expired or not.
		return false;

	}

	public function searchcity($userInput) {

		//Sök på geonames och leta upp
		//	1. GeonameId
		//	2. CityName
		//	3. TopononymName
		//	4. ProvinceName
		//	5. CountryName

	}

	public function getDataFromRepository($city) {

		//Hämta data från databasen baserat på uppgifter på city.

	}

	public function retrieveWeatherDataFromWeb($city) {

		//Get data from Yr.no api


	}

	public function curlGetRequest() {



	}

}