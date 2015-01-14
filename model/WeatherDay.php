<?php

class WeatherDay {
	
	public function __construct($time, $symbolName, $temperature) {
		$this->time = $time;
		$this->symbolName = $symbolName;
		$this->temperature = $temperature;
	}

	public $time;
	public $symbolName;
	public $temperature;

}