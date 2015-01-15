<?php

class WeatherDay {
	
	public function __construct($time, $symbolName, $temperature, $period) {
		$this->time = $time;
		$this->symbolName = $symbolName;
		$this->temperature = $temperature;
		$this->period = $period;
	}

	public $time;
	public $symbolName;
	public $temperature;
	public $period;

}