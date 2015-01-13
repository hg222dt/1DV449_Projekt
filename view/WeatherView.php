<?php

require_once("./model/WeatherModel.php");

/*
 * Klass som hanterar sitens vy-relaterade data
 *
 **/

class WeatherView {

	public function showStartPage() {

		$ret = "

<div class='row'>
	<div id='meny'>
		<h1>VäderKAOS!</h1>
	</div>
</div>

		";

		return $ret;
	}
}