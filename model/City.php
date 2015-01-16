<?php


class City {
	
	public $geonameId;
	public $cityName;
	public $countryName;
	public $provinceName;
	public $toponymName;
	public $muncipName;
	public $cityId;

	public function __construct($geonameId, $cityName, $toponymName, $muncipName, $provinceName, $countryName) {

		$this->geonameId = $geonameId;
		$this->cityName = $cityName;
		$this->toponymName = $toponymName;
		$this->provinceName = $provinceName;
		$this->countryName = $countryName;
		$this->muncipName = $muncipName;
	}
}