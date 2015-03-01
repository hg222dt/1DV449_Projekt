<?php

class WeatherDay {
	
	public $time;
	public $dayName;
	public $symbolName;
	public $temperature;
	public $period;
	public $symbolVar;

	public function __construct($time, $symbolName, $temperature, $period, $symbolVar) {
		$this->time = $time;
		$this->dayName = $this->getDayName($time);
		$this->symbolName = $symbolName;
		$this->temperature = $temperature;
		$this->period = $period;
		$this->symbolVar = $symbolVar;
	}

	public function getDayName($time) {
		setlocale (LC_ALL, "sv");

		$dayName = utf8_encode(ucfirst(strftime("%A", $time)));
		$swedishDayNames = array('Monday' => 'Måndag', 'Tuesday' => 'Tisdag', 'Wednesday' => 'Onsdag', 'Thursday' => 'Torsdag', 'Friday' => 'Fredag', 'Saturday' => 'Lördag', 'Sunday' => 'Söndag');
		return $swedishDayNames[$dayName];
	}
}