<?php

require_once("./model/WeatherModel.php");

/*
 * Klass som hanterar sitens vy-relaterade data
 *
 **/

class WeatherView {

	//Konstanter för användar-actions
	const ACTION_USER_STANDARD_SEARCH = "citySearch";
	const ACTION_USER_PICK_FROM_MULTIPLE = "userPickFromMultiple";

	const MESSAGE_ERROR_FATAL = "Fatal error occured.";

	private $siteModel;

	public function __construct($siteModel) {
		$this->siteModel = $siteModel;
	}

	public function getUserAction() {

		//Hämtar ut vilken användar-action som valts
		switch(key($_GET)) {

			case Self::ACTION_USER_STANDARD_SEARCH:
				return Self::ACTION_USER_STANDARD_SEARCH;
				break;

			case Self::ACTION_USER_PICK_FROM_MULTIPLE:
				return Self::ACTION_USER_PICK_FROM_MULTIPLE;
				break;
		}
	}

	public $startPageFoundation = "
<div class='row'>
	<div id='meny'>
		<h1>VäderKAOS!</h1>
	</div>
	<div>
		<form action='?citySearch' method='POST'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input type='submit' value='Sök'>
		</form>
	</div>
</div>
";

	public function showStartPage() {
		return $this->startPageFoundation;
	}

	public function showStartPageNoMatch() {

		$page = $this->startPageFoundation;

		$page .= "<div>Din sökning matchade inget resultat.</div>";

		return $page;
	}

	public function showStartPageMultipleResults($retrievedCities) {

		$page = $this->startPageFoundation;

		$page .= "Multiple cities matched your search!";

		foreach ($retrievedCities as $city) {
			$page .="<div><a href='?userPickFromMultiple=$city->geonameId'>" . $city->toponymName . " " . $city->muncipName . " " . $city->provinceName . "</a></div>";
		}

		return $page;
	}

	public function showStartPageWeatherReport($weatherReport) {

		//var_dump($weatherReport);


		$dayItems = $weatherReport->dayItems;
		//var_dump($dayItems);

		$page = $this->startPageFoundation;

		foreach ($dayItems as $key => $day) {
			//var_dump($day);
			$page .= "<div>" . $day->time . " " . $day->symbolName . "</div>";
		}

		return $page;
	}

	public function getPostedQuery() {

		return $_POST['searchQueryCity'];
	}

	public function getRequestedId() {
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    	$parts = parse_url($url);
    	parse_str($parts['query'], $query);
    	return $query['userPickFromMultiple'];
	}

}