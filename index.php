<?php

	require_once 'init.php';

	require_once("HTMLView.php");
	require_once("controller/WeatherController.php");


	$googleClient = new Google_Client;

	$auth = new GoogleAuth($googleClient);


	$weatherController = new WeatherController();

	$htmlBody = $weatherController->doControll();

	if($auth->checkRedirectCode()) 
	{
		header('Location: index.php');
	}


	$loggedInChunk = function($auth) {
		if(!$auth->isLoggedIn()) 
		{
			$authUrl = $auth->getAuthUrl();
			return "<a href='$authUrl'>Sign in with Google</a>";
		} else {
			return "You are signed in. <a href='logout.php'>Sign Out</a>";
		}
	};



/*
	$view = new HTMLView();
	$view->echoHTML($htmlBody);*/

?>

<!DOCTYPE html>
<html>
	<head>
		<title>VadfanblirdetförväderPUNKTse</title>

		<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
		<link rel='stylesheet' type='text/css' href='./css/styles.css'>

		<script>
			
		</script>
	</head>
	<body>
		<div id='status'></div>
		<div class='container' style='height:100%'>
			<?php echo $loggedInChunk($auth) ?>
			<?php echo $htmlBody ?>
		</div>
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
	  <script src='scripts/script.js'></script>
	  <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
      <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
	  
	</html>



