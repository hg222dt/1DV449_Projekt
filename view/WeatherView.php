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
	const ACTION_USER_GOTO_LOGON = "logOn";
	const ACTION_LOG_USER_IN = "logUserIn";
	const ACTION_USER_LOG_OUT = "userLogOut";

	const MESSAGE_ERROR_FATAL = "Fatal error occured.";

	private $siteModel;

	public function __construct($siteModel) {
		$this->siteModel = $siteModel;
	}

	public function getUserAction() {

		//var_dump(key($_GET));

		//Hämtar ut vilken användar-action som valts
		switch(key($_GET)) {

			case WeatherView::ACTION_USER_STANDARD_SEARCH:
				return WeatherView::ACTION_USER_STANDARD_SEARCH;
				break;

			case WeatherView::ACTION_USER_PICK_FROM_MULTIPLE:
				return WeatherView::ACTION_USER_PICK_FROM_MULTIPLE;
				break;

			case WeatherView::ACTION_USER_GOTO_LOGON:
				return WeatherView::ACTION_USER_GOTO_LOGON;
				break;

			case WeatherView::ACTION_LOG_USER_IN:
				return WeatherView::ACTION_LOG_USER_IN;
				break;

			case WeatherView::ACTION_USER_LOG_OUT:
				return WeatherView::ACTION_USER_LOG_OUT;
				break;
		}
	}

	public function getPageFoundation($textData) {

		if($_SESSION['userLoggedIn']) {

			$startPageChunk = "
USER LOGGED IN
<a href='?userLogOut' id='loginLink'>Logga ut!</a>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
		<h1>!!!</h1>
	</div>
	<div>
		<form action='?citySearch' method='POST'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input type='submit' value='Sök' id='submitButton'>
		</form>
	</div>
</div>
$textData
		";

		} else {

		$startPageChunk = "
<a href='view/LogonView.html' id='loginLink'>Logga in!</a>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
		<h1>!!!</h1>
	</div>
	<div>
		<form action='?citySearch' method='POST'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input type='submit' value='Sök' id='submitButton'>
		</form>
	</div>
</div>
$textData
		";

		}

		return $startPageChunk;

	}

	public function showStartPage() {
		return $this->getPageFoundation("");
	}

	public function showLoggedInStartPage($loginParam) {

		$ret = $this->showStartPage();		

		echo $loginParam;
		return "LoggedInStartPage";
	}

	public function showCouldNotLoginPage() {
		return "CouldNotLoginPage";
	}

	public function showStartPageNoMatch() {

		$markup = "<div>Din sökning matchade inget resultat.</div>";

		return $this->getPageFoundation($markup);
	}

	public function showStartPageMultipleResults($retrievedCities) {

		$markup = "<div>Multiple cities matched your search!</div>";

		foreach ($retrievedCities as $city) {
			$markup .="<div><a href='?userPickFromMultiple=$city->geonameId'>" . $city->toponymName . " " . $city->muncipName . " " . $city->provinceName . "</a></div>";
		}

		return $this->getPageFoundation($markup);
	}

	public function showStartPageWeatherReport($weatherReport) {

		$dayItems = $weatherReport->dayItems;

		
		$markup = "<div>Here you go!</div>";

		foreach ($dayItems as $key => $day) {
			//$markup .= "<div>" . gmdate("Y-m-d\TH:i:s\Z", $day->time) . " " . $day->symbolName . " " . $day->temperature . "<img src='http://symbol.yr.no/grafikk/sym/b38/" . $day->symbolVar . ".png'></div>";
			$markup .= "<div class='weatherReportItem'>" . gmdate("Y-m-d\TH:i:s\Z", $day->time) . " " . $day->symbolName . " " . $day->temperature . "<img src='./images/" . $day->symbolVar . ".png'></div>";
		}

		return $this->getPageFoundation($markup);

	}

	public function getPostedQuery() {

		return $_POST['searchQueryCity'];
	}

	public function getLoginParam() {
		return $_GET[key($_GET)];
	}

	public function getRequestedId() {
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    	$parts = parse_url($url);
    	parse_str($parts['query'], $query);
    	return $query['userPickFromMultiple'];
	}

}