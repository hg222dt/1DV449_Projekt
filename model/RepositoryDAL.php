<?php

class RepositoryDAL {

	protected $db;

	public function __construct()
	{
		$this->db = null;

		try {
			$this->db = new PDO("sqlite:database.db");
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {
			die("Del -> " .$e->getMessage());
		}
	}

	public function retrieveCityRepository($geonameId) {

		$geonameId = (int) $geonameId;

		$q = "SELECT * FROM City WHERE GeonameId = " . $geonameId;

		$result = $this->makeDatabaseRequest($q);

		if(isset($result[0])) {
			$result = $result[0];
		
			$city = new City($result['GeonameId'], $result['Name'], $result['ToponymName'], $result['MunicipName'], $result['ProvinceName'], $result['CountryName'], $result['NextUpdate'], null, null);
			$city->cityId = $result['CityId'];
			return $city;
		
		} else {
			return null;
		}
		
	}

	public function retrieveDaysRepository($cityId) {

		$cityId = (int)$cityId;

		$q = "SELECT * FROM ForecastDay WHERE CityId = " . $cityId;

		$result = $this->makeDatabaseRequest($q);

		$dayItems = array();

		foreach ($result as $key => $day) {

			array_push($dayItems, new WeatherDay($day['DateFrom'], $day['SymbolName'], $day['TemperatureValue'], $day['Period'], $day['SymbolVar']));
		}

		return $dayItems;
	}

	public function saveToRepository($weatherReport) {

		$cityId = $weatherReport->city->cityId;

		foreach ($weatherReport->dayItems as $key => $weatherDay) {

			$date = (int)$weatherDay->time;
			$symbolName = $weatherDay->symbolName;
			$temperature = $weatherDay->temperature;
			$period = (int)$weatherDay->period;
			$symbolVar = $weatherDay->symbolVar;

			$q = "INSERT INTO ForecastDay (CityId, DateFrom, SymbolName, SymbolVar, TemperatureValue, Period) VALUES ($cityId, $date, '$symbolName', '$symbolVar', '$temperature', $period)";

			$result = $this->makeDatabaseRequest($q);
		}
	}

	public function deleteOldWeatherReportFromRepository($cityId) {

		$q = "DELETE FROM ForecastDay WHERE CityId =" . $cityId;

		$result = $this->makeDatabaseRequest($q);
	}

	public function updateNextUpdate($city) {

		$nextUpdate = (int)$city->nextUpdate;
		$cityId = (int)$city->cityId;

		$q = "UPDATE City SET NextUpdate = $nextUpdate WHERE CityId = " . $cityId;

		$result = $this->makeDatabaseRequest($q);
	}

	public function saveCityToRepository($city) {

		$nextUpdate = $city->nextUpdate;
		$geonameId = (int) $city->geonameId;
		$cityName = $city->cityName;
		$countryName = $city->countryName;
		$provinceName = $city->provinceName;
		$toponymName = $city->toponymName;
		$muncipName = $city->muncipName;
		$longitude = (string)$city->longitude;
		$latitude = (string)$city->latitude;

//		$q = "INSERT INTO City (NextUpdate, GeonameID, Name, ToponymName, MunicipName, ProvinceName, CountryName) VALUES ($nextUpdate, $geonameId, '$cityName', '$toponymName', '$muncipName', '$provinceName', '$countryName')";
		$q = "INSERT INTO City (NextUpdate, GeonameID, Name, ToponymName, MunicipName, ProvinceName, CountryName, Longitude, Latitude) VALUES ($nextUpdate, $geonameId, '$cityName', '$toponymName', '$muncipName', '$provinceName', '$countryName', '$longitude', '$latitude')";

		$this->makeDatabaseRequest($q);

		$q = "SELECT last_insert_rowid()";

		$result = $this->makeDatabaseRequest($q);		

		$cityId = (int) $result[0][0];
		
		return $cityId;
	}

	public function makeDatabaseRequest($q) {

		$result;
		$stm;
		try {
			$stm = $this->db->prepare($q);
			$stm->execute();
			$result = $stm->fetchAll();
		}
		catch(PDOException $e) {
			echo("Error creating query: " .$e->getMessage());
			return false;
		}

		return $result;
	}
}





