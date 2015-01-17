<?php

require_once("WeatherDay.php");
require_once("City.php");

class WeatherReport {

	public $dayItems;
	public $city;


	public function __construct($dayItems, $city) {

		$this->dayItems = $dayItems;
		$this->city = $city;
		
	}
}