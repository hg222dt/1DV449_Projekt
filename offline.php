<?php


?>

<!DOCTYPE html>
<html>
	<head>
		<title>ViolaVäder</title>
		<link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
		<link rel='stylesheet' type='text/css' href='./css/styles.css'>
		<script type='text/javascript'src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBRAo9RNuLIHeS0XT9N0qbLOJbeF3PeIA0'></script>
		<meta charset='utf-8'>
	</head>
	<body>
		<div id='offlineNotice'> 
			<h3 id='offlineText'>Du verkar vara offline för tillfället. Men bara lugn! Vi har kvar dina senast laddade favoriter för dig. :)</h3>
		</div>
		<div class='container'>

			<div class='col-sm-3' id='favouritesDiv'>
	
				<div id='favouritesListTitle'>
					<h3>Dina favoriter</h3>
				</div>
				<div id='favouriteList'>
				</div>
				<div id='signInOutTool'>
					<a href='#' id='offlineSignoutLink'>Logga ut</a>
				</div>
			</div>
			<div class='col-sm-1'>
				<div class='rotationOffline'>
					<h1>ViolaVäder</h1>
				</div>
			</div>
			<div class='col-sm-8' id='midSectionOffline'>
				<div class='centerizedContent'>
					<div id='meny' class='centerizedContent'>
					</div>
					<div id='searchTools'>
						<div id='ajaxSearchTool'>
						
							<div class='col-lg-6'>
							    <div class='input-group'>
							      <input type='text' id='cityInput' class='form-control' placeholder='' name='searchQueryCity' disabled>
							      <span class='input-group-btn'>
							        <button class='btn btn-default' id='buttonSendQuery' type='button' disabled>Sök!</button>
							      </span>
							    </div>
							  </div>
						</div>
						<div id='searchResultArea'>
						</div>
					</div>
				</div>
			</div>
		</div>


<!--
			<div class='col-sm-4' id='favouritesDiv'>
				<h3>Dina favoriter</h3>
				<div id='favouriteList'>
				</div>
				<div id='signInOutTool'>
					<a href='#' id='offlineSignoutLink'>Logga ut</a>
				</div>
			</div>
			<div class='col-sm-8' id='midSectionOffline'>
				<div class='centerizedContent'>
					<div id='meny' class='centerizedContent'>
					</div>
					<div id='searchTools'>
						<div id='ajaxSearchTool'>
							<input type='text' id='cityInput' name='searchQueryCity' disabled>
							<input class='btn btn-primary' type='button' id='buttonSendQuery' value='Search'  disabled/>
						</div>
						<div id='searchResultArea'>
						</div>
					</div>
				</div>
			</div>
		</div>

-->
		<iframe id='manifest_iframe_hack' 
		  style='display: none;' 
		  src='manifest_iframe_hack.html'>
		</iframe>

		<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
		<script src='scripts/offlineScript.js'></script>
		<script src='scripts/userActionsAjax.js'></script>
	</body>
</html>