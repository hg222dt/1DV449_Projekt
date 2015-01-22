<?php

require_once("WeatherReport.php");
require_once("WeatherDay.php");
require_once("City.php");
require_once("RepositoryDAL.php");
require_once("WebserviceDAL.php");

class WeatherApiHandler {
	
	const SESSION_KEY_CITY_GEONAME_ID = "cityGeonameId";

	private $repositoryDAL;
	private $webserviceDAL;

	public function __construct() {

		$this->repositoryDAL = new RepositoryDAL();
		$this->webserviceDAL = new WebserviceDAL();

	}

	public function searchCityId($userInput) {
		return $this->getGeonameId($userInput);
	}

	public function getWeatherDaysFromRepository($city) {

		//Hämta data från databasen baserat på uppgifter på city.
		$forecastDays = $this->repositoryDAL->retrieveDaysRepository($city->cityId);

		return new WeatherReport($forecastDays, $city);
	}

	public function tryGetCityDataFromRepository($geonameId) {
		return $this->repositoryDAL->retrieveCityRepository($geonameId);
	}


	public function getGeonameId($userInput) {

		return $this->webserviceDAL->getGeonameIds($userInput);

	}

	public function getHierarchyToCityObj($geonameId) {

		$city = $this->webserviceDAL->getFullCityDataWeb($geonameId);

		return $city;
	}

	public function saveDaysToRepository($weatherReport) {

		$this->repositoryDAL->saveToRepository($weatherReport);

	}


	public function updateOldWeatherReportFromRepository($city, $weatherReport) {

		$this->repositoryDAL->deleteOldWeatherReportFromRepository($city->cityId);

		$this->repositoryDAL->updateNextUpdate($city);
		
		$this->saveDaysToRepository($weatherReport);

	}

	public function saveCityToRepository($city) {

		$cityId = $this->repositoryDAL->saveCityToRepository($city);

		return $cityId;
	}

	public function retrieveWeatherDataFromWeb($cities) {

		return $this->webserviceDAL->retrieveWeatherDataFromWeb($cities);

	}
}