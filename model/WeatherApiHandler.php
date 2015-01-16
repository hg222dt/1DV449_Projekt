<?php

require_once("WeatherReport.php");
require_once("WeatherDay.php");
require_once("City.php");
require_once("myDummyXML.php");


class WeatherApiHandler {
	
	const SESSION_KEY_CITY_GEONAME_ID = "cityGeonameId";

	public $weatherReport;
	public $geonameIds;
	public $retrievedCities;
	public $dummyStrXML;


	public function __construct() {

		$this->retrievedCities = array();
		$this->geonameIds = array();
		$myDummyXML = new myDummyXML();
		$this->dummyStrXML = $myDummyXML->xml;
	}

	//Gör försök att logga in åt användaren
	public function retrieveWeatherData($userInput) {

		//Sök stad enligt användarens sökord
		$cityResult = $this->searchcity($userInput);

		//Om det bara gick att hitta en stad på sökordet - Skapa väderrapport på det.
		if(sizeof($cityResult) == 1) {

			//Skapa väderrapport

			if($this->shouldWeUseCache($cityResult)) {
				//Använd cache och hämta från databasen
				$data = $getDataFromRepository($cityResult);

			} else {

				//Hämta från webbservice
				$this->retrieveWeatherDataFromWeb($cityResult);
			}
		}
	}

	public function retrieveWeatherFromGeonameId($geonameId) {

		$cities = array();

		$cities[0] = $this->getHierarchyToCityObj($geonameId);

		$this->retrieveWeatherDataFromWeb($cities);
	}

	public function shouldWeUseCache($city) {
		
		//Check in repositry if sity exists, and if cache is expired or not.
		return false;

	}

	public function searchcity($userInput) {

		$geonameId = $this->getGeonameId($userInput);

//var_dump($geonameId);

		//Flera städer matchar
		if(is_array($geonameId)) {


			foreach ($geonameId as $value) {
				$city = $this->getHierarchyToCityObj((string)$value);
				array_push($this->retrievedCities, $city);
			}	
		} 
		//En stad matchar
		elseif ($geonameId != null) {
			array_push($this->retrievedCities, $this->getHierarchyToCityObj($geonameId));		
			return $this->retrievedCities;
		}
	}


	public function getDataFromRepository($city) {

		//Hämta data från databasen baserat på uppgifter på city.

	}


	public function getGeonameId($userInput) {

		$getGeonameIdUrl = "http://api.geonames.org/search?name_equals=" . $userInput . "&maxRows=20&username=henkenet&featureClass=P";
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
		
			return $geonameIds[0];
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
		$getHierarchyUrl = "http://api.geonames.org/hierarchy?geonameId=" . $geonameId . "&username=henkenet";

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
		
		$_SESSION[Self::SESSION_KEY_CITY_GEONAME_ID . '=' . $city->geonameId]=$city;

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
			array_push($weatherDayItems, new WeatherDay(strtotime((string)$value['from']), (string)$value->symbol['name'], (string)$value->temperature['value'], (string)$value['period']));
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