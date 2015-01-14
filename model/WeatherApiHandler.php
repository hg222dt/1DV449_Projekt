<?php

require_once("WeatherReport.php");
require_once("HierarchyData.php");

class WeatherApiHandler {
	
	public $weatherReport;

	public $foundCities;

	public $geonameIds;

	public $retrievedCities;


	public function __construct() {
		$weatherReport = new WeatherReport();
		$retrievedCities = array();
		$geonameIds = array();
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

				//Konvertera data till WeatherReport


			} else {
				//Hämta från webbservice
				$data = $retrieveWeatherDataFromWeb($cityResult);

				//Konvertera data till WeatherReport

			}
		}
	}


	public function shouldWeUseCache($city) {
		
		//Check in repositry if sity exists, and if cache is expired or not.
		return false;

	}


	public function searchcity($userInput) {

		$geonameId = $this->getGeonameId($userInput);

		//Flera städer matchar
		if(is_array($geonameId)) {

			foreach ($geonameId as $value) {

				array_push($this->retrievedCities, $this->getHierarchyToCityObj($value));
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

		$getGeonameIdUrl = "http://api.geonames.org/searchJSON?name_equals=" . $userInput . "&maxRows=20&username=henkenet&featureClass=P";
		$textSearchData = $this->curlGetRequest($getGeonameIdUrl);
		$textSearchData = json_decode($textSearchData, true);
		$geonameIds = array();
		$geonameIds = $textSearchData["geonames"]['geonameId'];

		//Om flera id har hittats. Returnera sätt till publict fält. Och returnera array med alla id.
		if(sizeof($geonameIds) > 1) {

			$this->geonameIds = $geonameIds;


			return $geonameIds;
		
		} 
		//Om bara en stad matchar. Skicka till baka det första elementet ut geoname-arrayet.
		elseif (sizeof($geonameIds) == 1){
		
			return $geonameId[0];
		
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

		//Vi har hittat ett sökresultat med en stad
		$getHierarchyUrl = "http://api.geonames.org/hierarchyJSON?geonameId=" . $geonameId . "&username=henkenet";

		$data = $curlGetRequest($getHierarchyUrl);

		$data = json_decode($data, true);

		$hierarchyObjects = $data['geonames'];

		$cityObj = array_walk($hierarchyObjects, $getArrayFcode, "P");
		$muncipObj = array_walk($hierarchyObjects, $getArrayFcode, "ADM2");
		$provinceObj  = array_walk($hierarchyObjects, $getArrayFcode, "ADM1");
		$countryObj = array_walk($hierarchyObjects, $getArrayFcode, "PCLI");

		$cityName = $cityObj['name'];
		$topononymName = $cityObj['toponymName'];
		$muncipName = $muncipObj['name'];
		$provinceName = $provinceObj['name'];
		$countryName = $countryObj['name'];

		return new City($geonameId, $cityName, $provinceName, $countryName);

	}



	public function retrieveWeatherDataFromWeb($city) {

		//Get data from Yr.no api

		$getYrDataUrl = "http://www.yr.no/place/" . $city->countryName . "/" . $city->provinceName . "/" . $city->cityName . "/forecast.xml";

		$weaterData = $this->curlGetRequest($getYrDataUrl);

		$yrXml = simplexml_load_string($weaterData) or die("Error: Cannot create object");

		$weatherDays = $yrXml->tabular;

				



		//Hämta rätt väderdagar. Sortera och hämta de fem senaste.




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