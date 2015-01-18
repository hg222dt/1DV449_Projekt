<?php

class AppDAL {


	public function shouldWeUseCache($geonameId, $currentTimeUnix) {

		$geonameId = (int) $geonameId;

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}

		$q = "SELECT NextUpdate FROM City WHERE GeonameId = $geonameId";	

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


		//if($nextUpdateUnix < $currentTimeUnix) {
		if($nextUpdateUnix > $currentTimeUnix) {
			return true;
		}

		return false;
	}


	public function retrieveCityRepository($geonameId) {

		$geonameId = (int) $geonameId;

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}

		$q = "SELECT * FROM City WHERE GeonameId = " . $geonameId;

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

		
		if(isset($result[0])) {
			$result = $result[0];
		
			$city = new City($result['GeonameId'], $result['Name'], $result['ToponymName'], $result['MunicipName'], $result['ProvinceName'], $result['CountryName'], $result['NextUpdate']);
			$city->cityId = $result['CityId'];
			return $city;
		} else {
			return null;
		}

	}


	public function retrieveDaysRepository($cityId) {

		$cityId = (int)$cityId;

		$db = null;

		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
			die("Del -> " .$e->getMessage());
		}

		$q = "SELECT * FROM ForecastDay WHERE CityId = " . $cityId;

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


		$dayItems = array();

		foreach ($result as $key => $day) {

			array_push($dayItems, new WeatherDay($day['DateFrom'], $day['SymbolName'], $day['TemperatureValue'], $day['Period'], $day['SymbolVar']));
		}

		return $dayItems;
	}

	public function saveToRepository($weatherReport) {

		$cityId = $weatherReport->city->cityId;

		//var_dump($cityId);

		foreach ($weatherReport->dayItems as $key => $weatherDay) {

			$date = (int)$weatherDay->time;
			$symbolName = $weatherDay->symbolName;
			$temperature = $weatherDay->temperature;
			$period = (int)$weatherDay->period;
			$symbolVar = $weatherDay->symbolVar;

			//var_dump($date, $symbolName, $temperature, $period, $symbolVar, $cityId);

			$db = null;
			
			try {
				$db = new PDO("sqlite:database.db");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOEception $e) {
				die("Something went wrong -> " .$e->getMessage());
			}
			
			$q = "INSERT INTO ForecastDay (CityId, DateFrom, SymbolName, SymbolVar, TemperatureValue, Period) VALUES ($cityId, $date, '$symbolName', '$symbolVar', '$temperature', $period)";

			$result;
			$stm;
			try {
				$stm = $db->prepare($q);
				$stm->execute();
				$result = $stm->fetchAll();
			}
			catch(PDOException $e) {
				echo("Error creating query3: " .$e->getMessage());
				return false;
			}
		}
	}

	public function deleteOldWeatherReportFromRepository($cityId) {
		$db = null;

		$cityId = (int)$cityId;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "DELETE FROM ForecastDay WHERE CityId =" . $cityId;

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
	}

	public function updateNextUpdate($city) {
		$db = null;

		$nextUpdate = (int)$city->nextUpdate;
		$cityId = (int)$city->cityId;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "UPDATE City SET NextUpdate = $nextUpdate WHERE CityId = " . $cityId;

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query4: " .$e->getMessage());
			return false;
		}
	}

	public function saveCityToRepository($city) {

		$nextUpdate = $city->nextUpdate;
		$geonameId = (int) $city->geonameId;
		$cityName = $city->cityName;
		$countryName = $city->countryName;
		$provinceName = $city->provinceName;
		$toponymName = $city->toponymName;
		$muncipName = $city->muncipName;

		$db = null;
			
		try {
			$db = new PDO("sqlite:database.db");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Something went wrong -> " .$e->getMessage());
		}

		$q = "INSERT INTO City (NextUpdate, GeonameID, Name, ToponymName, MunicipName, ProvinceName, CountryName) VALUES ($nextUpdate, $geonameId, '$cityName', '$toponymName', '$muncipName', '$provinceName', '$countryName')";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query6: " .$e->getMessage());
			return false;
		}

		$q = "SELECT last_insert_rowid()";

		$result;
		$stm;
		try {
			$stm = $db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query1: " .$e->getMessage());
			return false;
		}

		$cityId = (int) $result[0][0];
		
		return $cityId;
	}

}





