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
					
					//Check cityId
					$cityIdArray = $this->weatherModel->weatherApiHandler->searchCityId($this->weatherView->getPostedQuery());
						//If cityIdArray = null - noo result found.

					//Checkif use cache or not

					$cityDataArray = array();

					foreach ($cityIdArray as $key => $geonameId) {
						//try get cityData from repository. Returns null if city sere not found in repository.
						$city = $this->weatherModel->weatherApiHandler->tryGetCityDataFromRepository($geonameId);
						
						//if not possible get from Web
						if($city == null) {
//							var_dump("get city from webb");
							$city = $this->weatherModel->weatherApiHandler->getHierarchyToCityObj($geonameId);
						} else {
//							var_dump("city found in repository");
							$city->existsOnDatabse = true;
						}

						array_push($cityDataArray, $city);
						//Spara till sessionen.
					}

					$cityAmount = count($cityDataArray);


					if($cityAmount>1) {
						//Visa flervals alternativ
						return $this->weatherView->showStartPageMultipleResults($cityDataArray);

					} elseif($cityAmount == 1) {

						$weatherReport;

						//Kolla om stad finns på databasen eller inte.
						if($cityDataArray[0]->existsOnDatabse == true) {

							//Ska vi använda cachad data på databasen.
							if($cityDataArray[0]->nextUpdate > time()) {
								//Använd cache. Hämta väderrapporten från databasen. Visa den som resultat.
//								var_dump("Use cache");

								$weatherReport = $this->weatherModel->weatherApiHandler->getWeatherDaysFromRepository($cityDataArray[0]);



							
							} else {
//								var_dump("Dont use cache");

								//Ladda ner nytt från webben.
								//Ta bort tidigare poster på forecastday
								//Ändra nexupdate i databasen på City
								//Lägg till nya nerladdade
								//visa resultat i form av väderrapporten

								$weatherReport = $this->weatherModel->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);

								$weatherReport->city->nextUpdate = time() + 20;

								$this->weatherModel->weatherApiHandler->updateOldWeatherReportFromRepository($cityDataArray[0], $weatherReport);


							}

						} else {
//							var_dump("Dont use cache");

							//Ladda ner nytt från webben.
							//Lägg till stad. Få CityId i return.
							//Lägg till nya poster på databasen. 

							$weatherReport = $this->weatherModel->weatherApiHandler->retrieveWeatherDataFromWeb($cityDataArray);
							$cityId = $this->weatherModel->weatherApiHandler->saveCityToRepository($weatherReport->city);

							$weatherReport->city->cityId = $cityId;

							$this->weatherModel->weatherApiHandler->saveDaysToRepository($weatherReport);
						}

						return $this->weatherView->showStartPageWeatherReport($weatherReport);

					} else {
						return $this->weatherView->showStartPageNoMatch();
					}
					
					break;

				case WeatherView::ACTION_USER_PICK_FROM_MULTIPLE:

					$this->weatherModel->retrieveWeatherDataFromWeb($this->weatherModel->getLatestChosenCitySession($this->weatherView->getRequestedId()));

					return $this->weatherView->showStartPageWeatherReport($this->weatherModel->weatherApiHandler->weatherReport);
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