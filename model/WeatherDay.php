<?php

class WeatherDay {
	
	public $time;
	public $symbolName;
	public $temperature;
	public $period;
	public $symbolVar;

	public function __construct($time, $symbolName, $temperature, $period, $symbolVar) {
		$this->time = $time;
		$this->symbolName = $symbolName;
		$this->temperature = $temperature;
		$this->period = $period;
		$this->symbolVar = $symbolVar;
	}

}