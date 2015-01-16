<?php

class AppDAL {


	public function shouldWeUseCache($geonameId, $currentTimeUnix) {

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}

//		$q = "SELECT `NextUpdate` FROM City WHERE `GeonameId` = $geonameId";
		$q = "SELECT NextUpdate FROM City WHERE GeonameId = 1";
	

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query: " .$e->getMessage());
			return false;
		}

		if(count($result) < 1) {
			return false;
		}

		$nextUpdateUnix = $result[0]['NextUpdate'];


		if($nextUpdateUnix < $currentTimeUnix) {
		//if($nextUpdateUnix > $currentTimeUnix) {
			return true;
		}

		return false;
	}


	public function retrieveCityRepository($geonameId) {

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}

//		$q = "SELECT * FROM City WHERE GeonameId = $geonameId";
		$q = "SELECT * FROM City WHERE GeonameId = 1";
	

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query: " .$e->getMessage());
			return false;
		}

		$result = $result[0];

		$city = new City($result['GeonameId'], $result['Name'], $result['ToponymName'], $result['MunicipName'], $result['ProvinceName'], $result['CountryName']);
		$city->cityId = $result['CityId'];

		return $city;
	}


	public function retrieveDaysRepository($cityId) {

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}

//		$q = "SELECT * FROM ForecastDay WHERE CityId = $cityId";
		$q = "SELECT * FROM ForecastDay WHERE CityId = 1";	

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query: " .$e->getMessage());
			return false;
		}

		$result = $result[0];

		$weatherDay = new WeatherDay($result['DateFrom'], $result['SymbolName'], $result['TemperatureValue'], $result['Period'], $result['SymbolVar']);

		return $weatherDay;
	}

}