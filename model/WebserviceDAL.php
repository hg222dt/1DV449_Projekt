<?php

/*
*	Klass som sköter all hämtning av data från externa api:er
*
*/

class WebserviceDAL {
	
	public function getGeonameIds($userInput) {

		$getGeonameIdUrl = "http://api.geonames.org/search?name_equals=" . str_replace(" ", "%20", $userInput) . "&maxRows=20&username=henkenet&featureClass=P&country=SE&country=NO&country=DK";
		$textSearchData = $this->curlGetRequest($getGeonameIdUrl);

		$textSearchData = simplexml_load_string($textSearchData) or die("Error: Cannot create object");

		$geonameIds = array();

		foreach($textSearchData->geoname as $geonames) { 
			
			if(strlen($geonames) != 0) {
			    array_push($geonameIds, (string)$geonames->geonameId);
			}
		}

		return $geonameIds;
	}

	public function getFullCityDataWeb($geonameId) {

		$getArrayFcode = function($value, $key, $searchTermValue) {

			if($value['fcode'] == $searchTermValue) {

				return $value;
			}
		};

		$getObjFromXml = function($searchKey, $searchTerm, $objects) {
			foreach ($objects as $key => $value) {

				if((string)$value->children()->$searchKey == $searchTerm) {
					return $value;
				}
			}
		};

		$getHierarchyUrl = "http://api.geonames.org/hierarchy?geonameId=" . str_replace(" ", "%20", $geonameId) . "&username=henkenet";

		$data = $this->curlGetRequest($getHierarchyUrl);


		//Vi har hittat ett sökresultat med en stad. Nu pluckar vi ut den data vi vill ha från det vi fått ner, och packar in det i olika objekt.

		$data = simplexml_load_string($data) or die("Error: Cannot create object");

		$hierarchyObjects = $data->children();

		$cityObj = $getObjFromXml("fcl", "P", $hierarchyObjects);
		$muncipObj = $getObjFromXml("fcode", "ADM2", $hierarchyObjects);
		$provinceObj  = $getObjFromXml("fcode", "ADM1", $hierarchyObjects);
		$countryObj = $getObjFromXml("fcode", "PCLI", $hierarchyObjects);

		$countryName = null;

		if($cityObj != null && property_exists($cityObj, 'name') && property_exists($cityObj, 'toponymName')){
			$cityName = (string) $cityObj->name;
			$toponymName = (string) $cityObj->toponymName;
			$latitude = (string) $cityObj->lat;
			$longitude =  (string) $cityObj->lng;
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

		if($countryName == null) {
			$countryName = "No country name found";
		}

		return new City((string)$geonameId, $cityName, $toponymName, $muncipName, $provinceName, $countryName, null, $latitude, $longitude);

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
			   return ($aTime < $bTime) ? -1 : 1;
			
		};		

		if($city->countryName == "Norway") {

			$provinceName = $city->provinceName;

			$pieces = explode(" ", $provinceName);
			$provinceName = $pieces[0];

			$getYrDataUrl = "http://www.yr.no/place/" . str_replace(" ", "%20", $city->countryName) . "/" . str_replace(" ", "%20", $provinceName) . "/" . str_replace(" ", "%20", $city->muncipName) . "/" . str_replace(" ", "%20", $city->toponymName) . "/forecast.xml";

		} else { 

			//Get data from Yr.no api

			$getYrDataUrl = "http://www.yr.no/place/" . str_replace(" ", "%20", $city->countryName) . "/" . str_replace(" ", "%20", $city->provinceName) . "/" . str_replace(" ", "%20", $city->toponymName) . "/forecast.xml";

		}

		$weatherData = $this->curlGetRequest($getYrDataUrl);


		$yrXml = simplexml_load_string($weatherData) or die("Error: Cannot create object");


		if($yrXml->meta->nextupdate == null)
		{
			throw new Exception("Search api error.");
		} 
		else 
		{
			$nextUpdateItem = strtotime((string)$yrXml->meta->nextupdate);

			$city->nextUpdate = $nextUpdateItem;
		}

		$weatherDayItems = array();

		if($yrXml->forecast->tabular != null) {

			foreach ($yrXml->forecast->tabular->children() as $value) {
				array_push($weatherDayItems, new WeatherDay(strtotime((string)$value['from']), (string)$value->symbol['name'], (string)$value->temperature['value'], (string)$value['period'], $value->symbol['var']));
			}
		
		} else {
			throw new Exception("Search api error.");
		} 

		//Dra ut korrekta perioder
		$weatherDays = array_filter($weatherDayItems, $getCorrectPeriod);

		usort($weatherDays, $sortDays);

		$weatherDaysSliced = array_slice($weatherDays, 0, 5, true);

		return new WeatherReport($weatherDaysSliced, $city);
	}


	//Gör curl-request till vald url
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