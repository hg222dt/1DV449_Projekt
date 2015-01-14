<?php

require_once("./view/WeatherView.php");
require_once("./model/WeatherModel.php");

/*
 * Controller-klass
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

		try {
			switch($this->weatherView->getUserAction()) {

				case WeatherView::ACTION_USER_STANDARD_SEARCH:

					$userInput = $this->weatherView->getPostedQuery();
					
					$weatherReport = $this->weatherModel->retrieveWeatherData($userInput);
					
					return $this->weatherView->showStartPage($weatherReport);
					break;

				default:
					return $this->weatherView->showStartPage();
					break;
			}	
		} catch (Exception $e) {
			return WeatherView::MESSAGE_ERROR_FATAL;
		}
	}




	
}