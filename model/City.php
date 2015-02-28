<?php


class City {
	
	public $geonameId;
	public $cityName;
	public $countryName;
	public $provinceName;
	public $toponymName;
	public $muncipName;
	public $cityId;
	public $nextUpdate;
	public $existsOnDatabse;
	public $latitude;
	public $longitude;


	public function __construct($geonameId, $cityName, $toponymName, $muncipName, $provinceName, $countryName, $nextUpdate, $latitude, $longitude) {

		$this->geonameId = $geonameId;
		$this->cityName = $cityName;
		$this->toponymName = $toponymName;
		$this->provinceName = $provinceName;
		$this->countryName = $countryName;
		$this->muncipName = $muncipName;
		$this->nextUpdate = $nextUpdate;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}
}