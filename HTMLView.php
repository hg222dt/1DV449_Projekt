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
		<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
		<link rel='stylesheet' type='text/css' href='./css/styles.css'>
		<script type='text/javascript'src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBRAo9RNuLIHeS0XT9N0qbLOJbeF3PeIA0'></script>
		<meta charset='utf-8'>
	</head>
	<body>
		<div id='status'></div>
		<div class='container' style='height:100%'>
			$body
		</div>
		<iframe id='manifest_iframe_hack' 
		  style='display: none;' 
		  src='manifest_iframe_hack.html'>
		</iframe> 
	</body>
	  <script>
	  	// Check if a new cache is available on page load.
		window.addEventListener('load', function(e) {

		  window.applicationCache.addEventListener('updateready', function(e) {
		    if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
		      // Browser downloaded a new app cache.
		        window.location.reload();			      
		    } else {
		      // Manifest didn't changed. Nothing new to server.
		    }
		  }, false);

		}, false);
	  </script>
	  <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
      <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
      <script src='scripts/userActionsAjax.js'></script>
      <script src='scripts/mapScript.js'></script>
      <script src='scripts/script.js'></script>
	</html>
		";
	}
}