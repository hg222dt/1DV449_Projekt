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
					break;


				case WeatherView::AJAX_USER_STANDARD_SEARCH:


					//Ska returnera json-resultat från en sökning, till webbläsaren.

					$cityDataArray = $this->weatherModel->checkCityResultFromQuery($this->weatherView->getPostedQuery());

					$cityAmount = count($cityDataArray);

					if($cityAmount>1) {
						//Visa flervalsalternativ

						return $this->weatherModel->convertArrayWithObjectsToJson($cityDataArray); 

					} elseif($cityAmount == 1) {
						try {
							$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);
						} catch (Exception $e) {
							//returnera felmeddelande
							return;
						}

						//Returnera json-resultat från väderrapporten.
						return $this->weatherModel->convertObjectToJson($weatherReport);

					} else {
						//Returnera "No-match"
						return$this->weatherModel->getJsonResultNoMatch();
					}
					break;


				case WeatherView::AJAX_USER_PICK_FROM_MULTIPLE:

					$cityDataArray = array();

					$cityDataArray[0] = $this->weatherModel->getLatestChosenCitySession($this->weatherView->getRequestedId());

					try{
						$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);
					} catch (Exception $e) {
						//returnera felmeddelande
						return;
					}

					//Returnera json-resultat från väderrapporten.

					return $this->weatherModel->convertObjectToJson($weatherReport);
					break;


				case WeatherView::AJAX_USER_ADD_FAVOURITE:

					$this->weatherModel->saveAsFavourite($this->weatherView->getPostedGeonameId());

					$favouritesData = $this->weatherModel->getFavouritesDataUser($this->weatherView->getUserGoogleId());

					$favouritesDataJson = $this->weatherModel->convertArrayWithFavouriteObjectsToJson($favouritesData);

					return $favouritesDataJson;
					break;

				case WeatherView::AJAX_USER_GET_FAVOURITES:

					$favouritesData = $this->weatherModel->getFavouritesDataUser($this->weatherView->getUserGoogleId());

					$favouritesDataJson = $this->weatherModel->convertArrayWithFavouriteObjectsToJson($favouritesData);

					return $favouritesDataJson;
					break;

				case WeatherView::AJAX_USER_SEARCH_GEONAME_ID:

					$geonameId = $this->weatherView->getPostedGeonameId();

					$cityDataArray = $this->weatherModel->getCitiesFromGeonameIds(array(0 => $geonameId));

					try {
						$weatherReport = $this->weatherModel->getSpecificCityWeather($cityDataArray);
					} catch (Exception $e) {
						//returnera felmeddelande
						return;
					}

					return $this->weatherModel->convertObjectToJson($weatherReport);
					break;

				case WeatherView::AJAX_USER_DELETE_FAVOURITE:

					$userId = $this->weatherModel->getUserIdFromGoogleId($this->weatherView->getUserGoogleId());

					$geonameId = $this->weatherView->getPostedGeonameId();

					$this->weatherModel->deleteFavourite($geonameId, $userId);

					return;
					break;

				case WeatherView::AJAX_IS_USER_SIGNED_IN:
					return $this->weatherModel->isUserLoggedInJson();
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