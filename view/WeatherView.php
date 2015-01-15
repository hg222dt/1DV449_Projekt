<?php

require_once("./model/WeatherModel.php");

/*
 * Klass som hanterar sitens vy-relaterade data
 *
 **/

class WeatherView {

	//Konstanter för användar-actions
	const ACTION_USER_STANDARD_SEARCH = "citySearch";
	const ACTION_USER_CHOSE_ALTERNATIVE = "userChoseAlternative";

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

	public function showStartPageMultipleResults() {
		return "multipleresults";
	}

	public function showStartPageWeatherReport($weatherReport) {

		$page = $this->startPageFoundation;

		foreach ($weatherReport->dayItems as $key => $day) {
			$page .= "<div>" . $day->time . " " . $day->symbolName . "</div>";
		}

		return $page;
	}

public function getPostedQuery() {

		return $_POST['searchQueryCity'];
	}

}