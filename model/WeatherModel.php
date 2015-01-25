<?php

 /*
 * Huvudmodellklass
 *
 **/

 require_once("WeatherApiHandler.php");
 require_once("UserDAL.php");

class WeatherModel {


	public $weatherApiHandler;
	private $userDAL;

	public function __construct() {
		$this->weatherApiHandler = new WeatherApiHandler();
		$this->userDAL = new UserDAL();
	}

	//Returns City data on rsult of users query. Multiple cities if needed.
	public function checkCityResultFromQuery($userQuery) {
		//Check cityId
		$cityIdArray = $this->weatherApiHandler->searchCityId($userQuery);

		$cityDataArray = array();


		//LÄGG TILL KOLL SÅ ATT APIET HAR LADDAT NER NÅGOT HÄR.

		if(isset($_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID]) && !is_array($_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID])) {
			$_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID] = array();
		}

		foreach ($cityIdArray as $key => $geonameId) {
			//try get cityData from repository. Returns null if city sere not found in repository.
			$city = $this->weatherApiHandler->tryGetCityDataFromRepository($geonameId);
			
			//if not possible get from Web
			if($city == null) {
				$city = $this->weatherApiHandler->getHierarchyToCityObj($geonameId);
//				var_dump("get city from webb: " . $city->provinceName);
			} else {
				$city->existsOnDatabse = true;
//				var_dump("city found in repository: " . $city->provinceName);
			}

			array_push($cityDataArray, $city);

			$_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID][$city->geonameId] = $city;
		}

		return $cityDataArray;
	}



	public function getSpecificCityWeather($cityDataArray) {

		$weatherReport;

		//Kolla om stad finns på databasen eller inte.
		if($cityDataArray[0]->existsOnDatabse == true) {

			//Ska vi använda cachad data på databasen.
			if($cityDataArray[0]->nextUpdate > time()) {
				//Använd cache. Hämta väderrapporten från databasen. Visa den som resultat.
//				var_dump("Use cache");

				$weatherReport = $this->weatherApiHandler->getWeatherDaysFromRepository($cityDataArray[0]);
			} else {
				$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);
				$this->weatherApiHandler->updateOldWeatherReportFromRepository($cityDataArray[0], $weatherReport);
			}

		} else {
//			var_dump("Dont use cache");

			$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);
			$cityId = $this->weatherApiHandler->saveCityToRepository($weatherReport->city);
			$weatherReport->city->cityId = $cityId;
			$this->weatherApiHandler->saveDaysToRepository($weatherReport);
		}

		return $weatherReport;
	}

	public function logUserIn($loginParam) {

		//Om inte användaren är registrerad på vår databas innan, så registrera.

		$this->userDAL->logUserIn($loginParam);

		$this->userDAL->getUserFavourites($loginParam);

		$_SESSION['userLoggedIn'] = true;
		$_SESSION['userLoggedInEmail'] = $loginParam;

		return true;
	}


	public function logUserOutSession() {
		$_SESSION['userLoggedIn'] = false;
		$_SESSION['userLoggedInEmail'] = "";
	}




	public function getLatestChosenCitySession($geonameId) {
		return $_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID][$geonameId];
	}
}