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
		$this->weatherModel = new WeatherModel();
		$this->weatherView = new WeatherView($this->weatherModel);
	}

	public function doControll() {

		try {
			switch($this->weatherView->getUserAction()) {

				case WeatherView::ACTION_USER_STANDARD_SEARCH:
					
					$cityDataArray = $this->weatherModel->checkCityResultFromQuery($this->weatherView->getPostedQuery());

					$cityAmount = count($cityDataArray);

					if($cityAmount>1) {
						//Visa flervalsalternativ
						return $this->weatherView->showStartPageMultipleResults($cityDataArray);

					} elseif($cityAmount == 1) {

						$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);

						return $this->weatherView->showStartPageWeatherReport($weatherReport);

					} else {
						return $this->weatherView->showStartPageNoMatch();
					}
					
					break;

				case WeatherView::ACTION_USER_PICK_FROM_MULTIPLE:

					$cityDataArray = array();

					$cityDataArray[0] = $this->weatherModel->getLatestChosenCitySession($this->weatherView->getRequestedId());

					$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);

					return $this->weatherView->showStartPageWeatherReport($weatherReport);
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