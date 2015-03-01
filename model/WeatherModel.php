<?php

 /*
 * Huvudmodellklass
 *
 **/

 require_once("WeatherApiHandler.php");
 require_once("UserDAL.php");
 require_once("loginHandler/GoogleAuth.php");

class WeatherModel {

	public $weatherApiHandler;
	private $userDAL;
	public $auth;

	public function __construct() {
		$this->weatherApiHandler = new WeatherApiHandler();
		$this->userDAL = new UserDAL();
		$db = new DB;
		$googleClient = new Google_Client;
		$this->auth = new GoogleAuth($db, $googleClient);

	}

	//Returns City data on rsult of users query. Multiple cities if needed.
	public function checkCityResultFromQuery($userQuery) {
		//Check cityId
		$cityIdArray = $this->weatherApiHandler->searchCityId($userQuery);



		if(isset($_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID]) && !is_array($_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID])) {
			$_SESSION[WeatherApiHandler::SESSION_KEY_CITY_GEONAME_ID] = array();
		}

		return $this->getCitiesFromGeonameIds($cityIdArray);
	}

	public function isUserLoggedIn()
	{
		return $this->auth->isLoggedIn();
	}

	public function isUserLoggedInJson() {
		if($this->isUserLoggedIn() == 1) {
			return json_encode('{ "isUserLoggedIn": "1" }');	
		} else {
			return json_encode('{ "isUserLoggedIn": "" }');
		}
	}

	public function getUserIdFromGoogleId($user_google_id)
	{
		return $this->auth->getUserIdFromGoogleId($user_google_id);
	}

	public function getCitiesFromGeonameIds($cityIdArray) {

		$cityDataArray = array();

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

		//var_dump($cityDataArray);
		//die();

		$weatherReport;

		//Kolla om stad finns på databasen eller inte.
		if($cityDataArray[0]->existsOnDatabse == true) {

			//Ska vi använda cachad data på databasen.
			if($cityDataArray[0]->nextUpdate > time()) {
				//Använd cache. Hämta väderrapporten från databasen. Visa den som resultat.

				$weatherReport = $this->weatherApiHandler->getWeatherDaysFromRepository($cityDataArray[0]);
			} else {
				$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);				
				$this->weatherApiHandler->updateOldWeatherReportFromRepository($cityDataArray[0], $weatherReport);
			}

		} else {
			
			$weatherReport = $this->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);

			$cityId = $this->weatherApiHandler->saveCityToRepository($weatherReport->city);
			$weatherReport->city->cityId = $cityId;
			$this->weatherApiHandler->saveDaysToRepository($weatherReport);
		}

		return $weatherReport;
	}

	public function getFavourites($userId) {

		$geonameIds = $this->userDAL->getUserFavouriteIds($userId);

		$weatherReports = array();

		$cityDataArray = array();

		$cityDataArray = $this->getCitiesFromGeonameIds($geonameIds);

		foreach ($cityDataArray as $key => $city) {

			$cityArray = array();
			$cityArray[0] = $city;

			$weatherReport = $this->getSpecificCityWeather($cityArray);

			array_push($weatherReports, $weatherReport);
		}

		return $weatherReports;
	}


	public function getFavouritesDataUser($user_google_id) {
	
		$userId = $this->getUserIdFromGoogleId($user_google_id);

		$weatherReports = $this->getFavourites($userId);

		return $weatherReports;
	}


	public function deleteFavourite($geonameId, $userId) {
		$this->userDAL->deleteFavourite($geonameId, $userId);
	}


	public function saveAsFavourite($cityId) {

		$userId = $this->getUserIdFromGoogleId($_SESSION['logged_in_user_google_id']);

		$this->userDAL->saveAsFavourite($userId, $cityId);

	}

	public function convertObjectToJson($object) {
		return json_encode($object);
	}

	public function convertArrayWithObjectsToJson($array) {

		$mainArray = array('responseType' => 'multipleResults', 'results' => $array);

		$mainArray = json_encode($mainArray);

		return $mainArray;
	}


	public function convertArrayWithFavouriteObjectsToJson($array) {

		$mainArray = array('responseType' => 'success', 'results' => $array);

		$mainArray = json_encode($mainArray);

		return $mainArray;

	}


	public function getJsonResultNoMatch() {
		return json_encode(array('responseType' => "noresult" ));
	}

	public function logUserIn($loginParam) {

		//Om inte användaren är registrerad på vår databas innan, så registrera.

		$this->userDAL->logUserIn($loginParam);

		$this->userDAL->getUserFavouriteIds($loginParam);

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