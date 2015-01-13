<?php

require_once("./view/WeatherView.php");
require_once("./model/WeatherModel.php");

/*
 * Kontroller-klass
 *
 **/

class WeatherController {

	private $weatherView;
	private $weatherModel;

	public function __construct() {
		//$this->trafficModel = new TrafficModel();
		$this->weatherView = new WeatherView($this->weatherModel);
	}

	public function doControll() {

		return $this->weatherView->showStartPage();

	}
}