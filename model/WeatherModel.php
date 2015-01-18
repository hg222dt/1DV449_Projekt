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

	public function checkCityResultFromQuery($userQuery) {
		//Check cityId
		$cityIdArray = $this->weatherApiHandler->searchCityId($userQuery);

		//Checkif use cache or not

		$cityDataArray = array();

		//LÄGG TILL KOLL SÅ ATT APIET HAR LADDAT NER NÅGOT HÄR.

		foreach ($cityIdArray as $key => $geonameId) {
			//try get cityData from repository. Returns null if city sere not found in repository.
			$city = $this->weatherApiHandler->tryGetCityDataFromRepository($geonameId);
			
			//if not possible get from Web
			if($city == null) {
//				var_dump("get city from webb");
				$city = $this->weatherApiHandler->getHierarchyToCityObj($geonameId);
			} else {
//				var_dump("city found in repository");
				$city->existsOnDatabse = true;
			}

			array_push($cityDataArray, $city);
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
//				var_dump("Dont use cache");

				//Ladda ner nytt från webben.
				//Ta bort tidigare poster på forecastday
				//Ändra nexupdate i databasen på City
				//Lägg till nya nerladdade
				//visa resultat i form av väderrapporten

				$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);

				//$weatherReport->city->nextUpdate = time() + 20;

				$this->weatherApiHandler->updateOldWeatherReportFromRepository($cityDataArray[0], $weatherReport);
			}

		} else {
//			var_dump("Dont use cache");

			//Ladda ner nytt från webben.
			//Lägg till stad. Få CityId i return.
			//Lägg till nya poster på databasen. 

			$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);
			$cityId = $this->weatherApiHandler->saveCityToRepository($weatherReport->city);

			$weatherReport->city->cityId = $cityId;

			$this->weatherApiHandler->saveDaysToRepository($weatherReport);
		}

		return $weatherReport;
	}




	public function getLatestChosenCitySession($geonameId) {
		return $_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID][$geonameId];
	}
}