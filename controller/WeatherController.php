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
					
					$this->weatherModel->retrieveWeatherData($userInput);
					
					if(sizeof($this->weatherModel->weatherApiHandler->retrievedCities)>1) {


						return $this->weatherView->showStartPageMultipleResults($this->weatherModel->retrievedCities);
					
					} elseif(sizeof($this->weatherModel->weatherApiHandler->retrievedCities)<1) {
					

						return $this->weatherView->showStartPageNoMatch();
					
					} else {

						//Sök upp väderdata


						return $this->weatherView->showStartPageResult($this->weatherModel->weatherApiHandler->weatherReport);
					}

					
					return $this->weatherView->showStartPage($weatherData);
					break;

				default:
					return $this->weatherView->showStartPage();
					break;

				case WeatherView::ACTION_USER_CHOSE_ALTERNATIVE:


					break;
			}	
		} catch (Exception $e) {
			return WeatherView::MESSAGE_ERROR_FATAL;
		}
	}




	
}