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
	const ACTION_SAVE_AS_FAVOURITE = "saveAsFavourite";

	const AJAX_USER_STANDARD_SEARCH = "AJAX_USER_STANDARD_SEARCH";
	const AJAX_USER_PICK_FROM_MULTIPLE = "AJAX_USER_PICK_FROM_MULTIPLE";
	const AJAX_TEST = "AJAX_TEST";

	const MESSAGE_ERROR_FATAL = "Fatal error occured.";

	private $weatherModel;

	public function __construct($weatherModel) {
		$this->weatherModel = $weatherModel;
	}

	public function getUserAction() {

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

			case WeatherView::ACTION_SAVE_AS_FAVOURITE:
				return WeatherView::ACTION_SAVE_AS_FAVOURITE;
				break;

			case WeatherView::ACTION_USER_LOG_OUT:
				return WeatherView::ACTION_USER_LOG_OUT;
				break;

			case WeatherView::AJAX_USER_STANDARD_SEARCH:
				return WeatherView::AJAX_USER_STANDARD_SEARCH;
				break;

			case WeatherView::AJAX_USER_PICK_FROM_MULTIPLE:
				return WeatherView::AJAX_USER_PICK_FROM_MULTIPLE;
				break;

			case WeatherView::AJAX_TEST:
				return WeatherView::AJAX_TEST;
				break;
		}
	}

	public function getUserFavouriteMarkup() 
	{
		$user_google_id = $_SESSION['logged_in_user_google_id'];
			
		$userId = $this->weatherModel->getUserIdFromGoogleId($user_google_id);

		$weatherReports = $this->weatherModel->getFavourites($userId);
		
		$favouriteChunk = "<h3>Dina favoriter</h3>";

		foreach ($weatherReports as $key => $weatherReport) {

			$city = $weatherReport->city;

			$name = $city->toponymName;

			$favouriteChunk .= "<div>" . $name . "</div>";
		}

		return $favouriteChunk;
	}

	public function getPageFoundation($resultData) {

		if($this->weatherModel->isUserLoggedIn()) 
		{
			$startPageChunk = "
<div class='col-sm-4'>
	{$this->getUserFavouriteMarkup()}
	<div id='signInOutTool'>
		You are signed in. <a href='logout.php'>Sign Out</a>
	</div>
</div>
<div class='col-sm-8' id='midSection'>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
	</div>
	<div id='searchTools'>
		<!--
		<form action='?citySearch' method='POST'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input type='submit' value='Sök' id='submitButton'>
		</form>
		-->

		<div id='ajaxSearchTool'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input class='btn btn-primary' type='button' id='buttonSendQuery' value='Search' />
		</div>
		<div id='searchResultArea'>
			$resultData
		</div>
	</div>
</div>

<div id='map-canvas'></div>
</div>
";
		} else {

			$startPageChunk = "
<div class='col-sm-4'>
<div id='signInOutTool'>
	<a href='{$this->weatherModel->auth->getAuthUrl()}'>Sign in with Google</a>
</div>
</div>
<div class='col-sm-4'>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
		<h1>!!!</h1>
	</div>
	<div>

		<!--
		<form action='?citySearch' method='POST'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input type='submit' value='Sök' id='submitButton'>
		</form>
		-->

		<div id='ajaxSearchTool'>
			<input type='text' id='cityInput' name='searchQueryCity'>
			<input class='btn btn-primary' type='button' id='buttonSend' value='Search' />
		</div>
	</div>
</div>
$resultData
</div>
<div class='col-sm-4' id='right_wing'>
	<div id='map-canvas'></div>
</div>";

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

	public function showErrorMessagePage()
	{
		$markup = "<div>Något blev fel när sökningen gjordes.</div>";

		return $this->getPageFoundation($markup);
	}

	public function showStartPageMultipleResults($retrievedCities) {

				$markup = "
<div id='searchResultChunk'>
<div class='weatherReportItem'>";

		$markup .= "<div>Multiple cities matched your search!</div>";

		foreach ($retrievedCities as $city) {
			$markup .="<div><a href='?userPickFromMultiple=$city->geonameId'>" . $city->toponymName . " " . $city->muncipName . " " . $city->provinceName . "</a></div>";
		}

		$markup .= "</div></div>";

		return $this->getPageFoundation($markup);
	}

	public function showStartPageWeatherReport($weatherReport) {

		$dayItems = $weatherReport->dayItems;
		$geonameId = $weatherReport->city->geonameId;

		
		$markup = "
<div id='searchResultChunk'>
	<!--<div>Here you go!</div>-->";


		//Lägg in stadsInfo och spara favorit

		if($this->weatherModel->isUserLoggedIn()) {
			$markup .= "<div class='weatherTitleReportItem'><h3>{$weatherReport->city->toponymName}</h3> <a href='?saveAsFavourite=$geonameId' id='save_fav_link'>Spara som favorit!</a></div>";
		} else {
			$markup .= "<div class='weatherTitleReportItem'>{$weatherReport->city->toponymName}</div>";
		}

		foreach ($dayItems as $key => $day) {
			//$markup .= "<div>" . gmdate("Y-m-d\TH:i:s\Z", $day->time) . " " . $day->symbolName . " " . $day->temperature . "<img src='http://symbol.yr.no/grafikk/sym/b38/" . $day->symbolVar . ".png'></div>";
			$markup .= "<div class='weatherReportItem'>" . gmdate("Y-m-d\TH:i:s\Z", $day->time) . " " . $day->symbolName . " " . $day->temperature . "<img src='./images/" . $day->symbolVar . ".png'></div>";
		}

		$markup .= "</div>";

		return $this->getPageFoundation($markup);

	}

	public function getPostedQuery() {

		return $_POST['searchQueryCity'];
	}

	public function getParam() {
		return $_GET[key($_GET)];
	}

	public function getRequestedId() {
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    	$parts = parse_url($url);
    	parse_str($parts['query'], $query);
    	return $query['userPickFromMultiple'];
	}

}