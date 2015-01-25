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

				<script>
					function updateOnlineStatus(msg) {
					  var offlineMessage = 'Ouups! Någon har klippt linan. Eftersom att du inte har internet kan vi inte göra sökningar åt sig för tillfället.';
					  var status = document.getElementById('status');
					  var submitButton = document.getElementById('submitButton');
					  var cityInput = document.getElementById('cityInput');
					  var loginLink = document.getElementById('loginLink');
					  var condition = navigator.onLine ? 'ONLINE' : 'OFFLINE';

					  if(condition === 'OFFLINE') {
						  status.setAttribute('class', condition);
						  status.innerHTML = offlineMessage;
						  submitButton.setAttribute('disabled', true)
						  cityInput.setAttribute('disabled', true);
						  loginLink.remove();
					  }
					}

					function loaded() {
					  updateOnlineStatus('load');
					  document.body.addEventListener('offline', function () { updateOnlineStatus('offline') }, false);
					  document.body.addEventListener('online', function () { updateOnlineStatus('online') }, false);
					}
				</script>
			</head>
			<body>
				<div id='status'></div>
				<div class='container' style='height:100%'>
					<div class='col-sm-4'></div>
						<div class='col-sm-4'>
							$body
						</div>
					<div class='col-sm-4'></div>
				</div>
			</body>
			<script type='text/javascript'>
			  /**
			   * Handler for the signin callback triggered after the user selects an account.
			   */
			  function onSignInCallback(resp) {
			    gapi.client.load('plus', 'v1', apiClientLoaded);
			  }

			  /**
			   * Sets up an API call after the Google API client loads.
			   */
			  function apiClientLoaded() {
			    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
			  }

			  /**
			   * Response callback for when the API client receives a response.
			   *
			   * @param resp The API response object with the user email and profile information.
			   */
			  function handleEmailResponse(resp) {
			    var primaryEmail;
			    for (var i=0; i < resp.emails.length; i++) {
			      if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
			    }

			    console.log(primaryEmail);
			  }

			  </script>
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

					loaded();

				}, false);
			  </script>
			  <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
		      <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
			  <!--<script src='scripts/script.js'></script>-->
			</html>
		";
	}
}