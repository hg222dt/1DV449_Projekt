<?php

require_once 'init.php';
require_once 'model/WeatherModel.php';

$weatherModel = new WeatherModel();

$loggedIncongratts = "";



if($weatherModel->auth->checkRedirectCode()) 
{
	header('Location: signinPage.php');
}

if($weatherModel->isUserLoggedIn()) 
{
	$loggedIncongratts = "<div id='congrattsDiv'>Congratts! Youre Signed in!</div>";
}


?>


<!DOCTYPE html>
<html>
	<head>
		<title>VadfanblirdetförväderPUNKTse</title>
		<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
		<link rel='stylesheet' type='text/css' href='./css/styles.css'>
	</head>
	<body>
		<div class='container' style='height:100%'>
			<a href=' <?php echo $weatherModel->auth->getAuthUrl() ?> '>Sign in with Google</a>
			<?php echo $loggedIncongratts ?>
		</div>
	</body>
  <script src='scripts/signinPageScript.js'></script>
  <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
  <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
 </html>