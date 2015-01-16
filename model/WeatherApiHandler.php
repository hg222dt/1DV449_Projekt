<?php

require_once("WeatherReport.php");
require_once("WeatherDay.php");
require_once("City.php");
require_once("AppDAL.php");
require_once("myDummyXML.php");


class WeatherApiHandler {
	
	const SESSION_KEY_CITY_GEONAME_ID = "cityGeonameId";

	public $weatherReport;
	public $geonameIds;
	public $retrievedCities;
	public $dummyStrXML;
	private $appDAL;


	public function __construct() {

		$this->retrievedCities = array();
		$this->geonameIds = array();
		$myDummyXML = new myDummyXML();
		$this->dummyStrXML = $myDummyXML->xml;
		$this->appDAL = new AppDAL();


		if(isset($_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID]) && !is_array($_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID])) {
			$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID] = array();
		}

	}

	//Gör försök att logga in åt användaren
	public function retrieveWeatherData($userInput) {

		//Nollställer sessions-arrayet som innehåller stadsdata
		$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID] = array();

		//Sök stad enligt användarens sökord. Få tillbaka id.
		$geonameIds = $this->searchCityId($userInput);

		//Om det bara gick att hitta en stad på sökordet - Skapa väderrapport på det.
		if(sizeof($geonameIds) == 1) {

			$geonameId = $geonameIds[0];

			//Skapa väderrapport

			if($this->shouldWeUseCache($geonameId)) {
				//Använd cache och hämta från databasen
				$this->getDataFromRepository($geonameId);

			} else {
				//Hämta city-data från geonames med hjälp av geonameId
				array_push($this->retrievedCities, $this->getHierarchyToCityObj($geonameId));
				
				//Hämta från webbservice
				$this->retrieveWeatherDataFromWeb($this->retrievedCities);
			}
		} elseif(sizeof($geonameIds) > 1) {

			//Hämta flera städer i foreach-loop
			foreach ($geonameIds as $key => $geonameId) {
				array_push($this->retrievedCities, $this->getHierarchyToCityObj($geonameId));
			}

		} 
	}

	public function shouldWeUseCache($geonameId) {
		
		//Check in repositry if city exists, and if cache is expired or not.

		if($this->appDAL->shouldWeUseCache($geonameId, time())) {
			return true;
		} else {
			return false;
		}
	}

	public function searchCityId($userInput) {
		return $this->getGeonameId($userInput);
	}


	public function getDataFromRepository($geonameId) {

		//Hämta data från databasen baserat på uppgifter på city.

		$city = $this->appDAL->retrieveCityRepository($geonameId);
		$forecastDays = $this->appDAL->retrieveDaysRepository($city->cityId);

		$this->weatherReport = new WeatherReport($forecastDays, $city);
	}


	public function getGeonameId($userInput) {

		$getGeonameIdUrl = "http://api.geonames.org/search?name_equals=" . str_replace(" ", "%20", $userInput) . "&maxRows=20&username=henkenet&featureClass=P";
		$textSearchData = $this->curlGetRequest($getGeonameIdUrl);

		$textSearchData = simplexml_load_string($textSearchData) or die("Error: Cannot create object");

		$geonameIds = array();

		foreach($textSearchData->children() as $geonames) { 

			$id = (string)$geonames->geonameId;

			if(strlen($id) != 0) {
			    array_push($geonameIds, $geonames->geonameId);
			}
		} 

		//Om flera id har hittats. Returnera sätt till publict fält. Och returnera array med alla id.
		if(sizeof($geonameIds) > 1) {

			$this->geonameIds = $geonameIds;

			return $geonameIds;
		
		} 
		//Om bara en stad matchar. Skicka till baka det första elementet ut geoname-arrayet.
		elseif (sizeof($geonameIds) == 1){
		
			return $geonameIds;
		} 
		//Om inget har matchat. Returnera bara null.
		else {
		
			return null;
		}
	}


	public function getHierarchyToCityObj($geonameId) {

		$getArrayFcode = function($value, $key, $searchTermValue) {

			if($value['fcode'] == $searchTermValue) {

				return $value;
			}
		};

		$getObjFromXml = function($searchKey, $searchTerm, $objects) {
			foreach ($objects as $key => $value) {

				//var_dump((string)$value->children());

				//var_dump((string)$value->children()->fcode);

				if((string)$value->children()->$searchKey == $searchTerm) {
					//var_dump("Hittade en!");
					return $value;
				}
			}
		};

		//Vi har hittat ett sökresultat med en stad
		$getHierarchyUrl = "http://api.geonames.org/hierarchy?geonameId=" . str_replace(" ", "%20", $geonameId) . "&username=henkenet";

		$data = $this->curlGetRequest($getHierarchyUrl);

		$data = simplexml_load_string($data) or die("Error: Cannot create object");

		$hierarchyObjects = $data->children();


		$cityObj = $getObjFromXml("fcl", "P", $hierarchyObjects);
		$muncipObj = $getObjFromXml("fcode", "ADM2", $hierarchyObjects);
		$provinceObj  = $getObjFromXml("fcode", "ADM1", $hierarchyObjects);
		$countryObj = $getObjFromXml("fcode", "PCLI", $hierarchyObjects);

		if($cityObj != null && property_exists($cityObj, 'name') && property_exists($cityObj, 'toponymName')){
			$cityName = (string) $cityObj->name;
			$toponymName = (string) $cityObj->toponymName;
		}

		if($muncipObj != null && property_exists($muncipObj, 'name')){
			$muncipName = (string) $muncipObj->name;	
		} else {
			$muncipName = null;
		}

		if($provinceObj != null && property_exists($provinceObj, 'name')){
			$provinceName = (string) $provinceObj->name;
		} else {
			$provinceName = null;
		}

		if($countryObj != null && property_exists($countryObj, 'name')){
			$countryName = (string) $countryObj->name;
		}


		$city = new City((string)$geonameId, $cityName, $toponymName, $muncipName, $provinceName, $countryName);
		
		$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID][$city->geonameId] = $city;

		return $city;
	}


	public function retrieveWeatherDataFromWeb($cities) {

		$city = $cities[0];

		$getCorrectPeriod = function($value) {
			if($value->period == "2") {
				return $value;
			}
		};

		$sortDays = function($a, $b) {

			$aTime = $a->time;
			$bTime = $b->time;

			if ($aTime == $bTime) return 0;
			   return ($aTime < $bTime) ? 1 : -1;
			
		};

		//Get data from Yr.no api

		$getYrDataUrl = "http://www.yr.no/place/" . str_replace(" ", "%20", $city->countryName) . "/" . str_replace(" ", "%20", $city->provinceName) . "/" . str_replace(" ", "%20", $city->cityName) . "/forecast.xml";

		$weatherData = $this->curlGetRequest($getYrDataUrl);

		$yrXml = simplexml_load_string($weatherData) or die("Error: Cannot create object");

//		$yrXml=simplexml_load_string($this->dummyStrXML);

		$weatherDayItems = array();
		
		foreach ($yrXml->forecast->tabular->children() as $value) {
			array_push($weatherDayItems, new WeatherDay(strtotime((string)$value['from']), (string)$value->symbol['name'], (string)$value->temperature['value'], (string)$value['period'], null));
		}

		//Dra ut korrekta perioder
		$weatherDays = array_filter($weatherDayItems, $getCorrectPeriod);

		usort($weatherDays, $sortDays);

		$weatherDaysSliced = array_slice($weatherDays, 0, 5, true);

		$this->weatherReport = new WeatherReport($weatherDaysSliced, $city);
	}


	public function curlGetRequest($url) {

		$ch = curl_init();

    	$userAgent = "";

	    $options = array(
			CURLOPT_HTTPHEADER => array('Accept' => 'application/json; charset=utf-8'),
	        CURLOPT_RETURNTRANSFER => TRUE,
	        CURLOPT_AUTOREFERER => TRUE,
	        CURLOPT_USERAGENT => $userAgent,
	        CURLOPT_URL => $url,
	    );
	    
	    curl_setopt_array($ch, $options);

        $data = curl_exec($ch);

        curl_close($ch);

	    return $data;

	}

}