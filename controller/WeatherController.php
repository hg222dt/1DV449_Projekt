<?php

require_once("./view/WeatherView.php");
require_once("./model/WeatherModel.php");
require_once("./view/LogonView.php");

/*
 * Controller-klass
 *
 **/

class WeatherController {

	private $weatherView;
	public $weatherModel;
	private $logonView;

	public function __construct() {
		$this->weatherModel = new WeatherModel();
		$this->weatherView = new WeatherView($this->weatherModel);
		$this->logonView = new LogonView();
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
						try {
							$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);
						} catch (Exception $e) {
							return $this->weatherView->showErrorMessagePage();
						}
						return $this->weatherView->showStartPageWeatherReport($weatherReport);

					} else {
						return $this->weatherView->showStartPageNoMatch();
					}
					
					break;

				case WeatherView::ACTION_USER_PICK_FROM_MULTIPLE:

					$cityDataArray = array();

					$cityDataArray[0] = $this->weatherModel->getLatestChosenCitySession($this->weatherView->getRequestedId());

						try{
							$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);
						} catch (Exception $e) {
							return $this->weatherView->showErrorMessagePage();
						}

					return $this->weatherView->showStartPageWeatherReport($weatherReport);
					break;

				case WeatherView::ACTION_USER_GOTO_LOGON:

					return $this->logonView->showLoginPage();
					break;

				case WeatherView::ACTION_LOG_USER_IN:

					$loginParam = $this->weatherView->getParam();

					$userLoggedIn = $this->weatherModel->logUserIn($loginParam);

					if($userLoggedIn) {
						return $this->weatherView->showStartPage();
					}

					return $this->weatherView->showCouldNotLoginPage();
					break;

				case WeatherView::ACTION_USER_LOG_OUT:

					$this->weatherModel->logUserOutSession();

					return $this->weatherView->showStartPage();
					break;

				case WeatherView::ACTION_SAVE_AS_FAVOURITE:

					$geonameId = $this->weatherView->getParam();

					$this->weatherModel->saveAsFavourite($geonameId);

					return $this->weatherView->showStartPage();

				default:

					return $this->weatherView->showStartPage();
					break;

			}	
		} catch (Exception $e) {
			return WeatherView::MESSAGE_ERROR_FATAL;
		}
	}
	
}