<?php

require_once("WeatherReport.php");
require_once("WeatherDay.php");
require_once("City.php");
require_once("AppDAL.php");
require_once("WebserviceDAL.php");
require_once("myDummyXML.php");


class WeatherApiHandler {
	
	const SESSION_KEY_CITY_GEONAME_ID = "cityGeonameId";

	public $dummyStrXML;
	private $repositoryDAL;
	private $webserviceDAL;

	public function __construct() {

		$myDummyXML = new myDummyXML();
		$this->dummyStrXML = $myDummyXML->xml;
		$this->repositoryDAL = new RepositoryDAL();
		$this->webserviceDAL = new WebserviceDAL();


		if(isset($_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID]) && !is_array($_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID])) {
			$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID] = array();
		}

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
		
		$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID][$city->geonameId] = $city;

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