<?php

require_once("./model/WeatherModel.php");

/*
 * Klass som hanterar sitens vy-relaterade data
 *
 **/

class WeatherView {

	//Konstanter för användar-actions
	const ACTION_USER_STANDARD_SEARCH = "citySearch";

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

	public function showStartPage() {

		$ret = "

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

		return $ret;
	}

public function getPostedQuery() {

		return $_POST['searchQueryCity'];
	}

}