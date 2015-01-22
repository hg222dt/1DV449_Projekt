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
		<html manifest='cache.manifest'>
			<head>
				<title>VadfanblirdetförväderPUNKTse</title>
				<script src='https://apis.google.com/js/client:platform.js' async defer></script>
				<script src = 'https://plus.google.com/js/client:plusone.js'></script>

			</head>
			<body>
				<div id='gConnect' class='button'>
				    <button class='g-signin'
			          data-scope='email'
			          data-clientid='1007777563828-qf7sfjkv028b4ir0e3sk6slc1kji3m9q.apps.googleusercontent.com'
			          data-callback='onSignInCallback'
			          data-theme='dark'
			          data-cookiepolicy='single_host_origin'>
			        </button>
			    </div>

				<div class='container' style='height:100%'>
					$body
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

				}, false);
			  </script>
			</html>
		";
	}
}