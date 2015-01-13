<?php

/*
 * Klass för att visa den omslutande html-sidan i användarens klient
 *
 **/
class HTMLView {

	public function echoHTML($body) {

		if($body === null) {
			throw new Exception();
		}

		echo "
		<!DOCTYPE html>
		<html>
			<head>
				<title>VadfanblirdetförväderPUNKTse</title>
				

			</head>
			<body>
				<div class='container' style='height:100%'>
					$body
				</div>
			</body>
			</html>
		";
	}
}