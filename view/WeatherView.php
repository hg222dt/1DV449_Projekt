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
	const AJAX_USER_ADD_FAVOURITE = "AJAX_USER_ADD_FAVOURITE";
	const AJAX_USER_GET_FAVOURITES = "AJAX_USER_GET_FAVOURITES";
	const AJAX_USER_SEARCH_GEONAME_ID = "AJAX_USER_SEARCH_GEONAME_ID";
	const AJAX_USER_DELETE_FAVOURITE = "AJAX_USER_DELETE_FAVOURITE";
	const AJAX_IS_USER_SIGNED_IN = "AJAX_IS_USER_SIGNED_IN";

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

			case WeatherView::AJAX_USER_ADD_FAVOURITE:
				return WeatherView::AJAX_USER_ADD_FAVOURITE;
				break;

			case WeatherView::AJAX_USER_GET_FAVOURITES:
				return WeatherView::AJAX_USER_GET_FAVOURITES;
				break;

			case WeatherView::AJAX_USER_SEARCH_GEONAME_ID:
				return WeatherView::AJAX_USER_SEARCH_GEONAME_ID;
				break;

			case WeatherView::AJAX_USER_DELETE_FAVOURITE:
				return WeatherView::AJAX_USER_DELETE_FAVOURITE;
				break;

			case WeatherView::AJAX_IS_USER_SIGNED_IN:
				return WeatherView::AJAX_IS_USER_SIGNED_IN;
				break;

		}
	}

	public function getUserGoogleId() {
		return $_SESSION['logged_in_user_google_id'];
	}

	public function getPageFoundation($resultData) {

		if($this->weatherModel->isUserLoggedIn()) 
		{
			$startPageChunk = "
<div class='col-sm-3'>
	<div id='favouritesListTitle'>
		<h3>Dina favoriter</h3>
	</div>
	<div id='favouriteList'>
	</div>
	<div id='signInOutTool'>
		Du är inloggad. <a href='logout.php'>Logga ut</a>
	</div>
</div>
<div class='col-sm-1'>
	<div class='rotation'>
		<h1>ViolaVäder</h1>
	</div>
</div>
<div class='col-sm-8' id='midSection'>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
	</div>
	<div id='searchTools'>
		<div id='ajaxSearchTool'>		
			<div class='col-lg-6'>
			    <div class='input-group'>
			      <input type='text' id='cityInput' class='form-control' placeholder='Sök stad' name='searchQueryCity' required autofocus>
			      <input id='csrfToken' value='{$_SESSION['csrfToken']}' hidden>
			      <span class='input-group-btn'>
			        <button class='btn btn-default' id='buttonSendQuery' type='button'>Sök!</button>
			      </span>
			    </div>
			  </div>


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

<div class='col-sm-3'>
	
	<div id='signInOutTool'>
		<a href='{$this->weatherModel->auth->getAuthUrl()}'>Logga in med Google</a>
	</div>
</div>
<div class='col-sm-1'>
	<div class='rotation'>
		<h1>ViolaVäder</h1>
	</div>
</div>
<div class='col-sm-8' id='midSection'>
<div class='centerizedContent'>
	<div id='meny' class='centerizedContent'>
	</div>
	<div id='searchTools'>
		<div id='ajaxSearchTool'>
		
			<div class='col-lg-6'>
			    <div class='input-group'>
			      <input type='text' id='cityInput' class='form-control' placeholder='Sök stad' name='searchQueryCity' required autofocus>
			      <input id='csrfToken' value='{$_SESSION['csrfToken']}' hidden>
			      <span class='input-group-btn'>
			        <button class='btn btn-default' id='buttonSendQuery' type='button'>Sök!</button>
			      </span>
			    </div>
			  </div>

		</div>
		<div id='searchResultArea'>
			$resultData
		</div>
	</div>
</div>

<div id='map-canvas'></div>
</div>
";

		}

		return $startPageChunk;

	}

	public function showStartPage() {
		$_SESSION['csrfToken'] = base64_encode( openssl_random_pseudo_bytes(32));
		// $_SESSION['csrfToken'] = "111";
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

	public function getPostedGeonameId() {
		return $_POST['geonameId'];
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