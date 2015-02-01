"use strict";

var WESE = WESE || {};


			



WESE.updateOnlineStatus = function(msg) {
  var offlineMessage = 'Ouups! Någon har klippt linan. Eftersom att du inte har internet kan vi inte göra sökningar åt sig för tillfället.';
  var status = document.getElementById('status');
  var midSection = document.getElementById('midSection');

  var submitButton = document.getElementById('submitButton');
  var cityInput = document.getElementById('cityInput');
  var logindiv = document.getElementById('signInOutTool');
  var condition = navigator.onLine ? 'ONLINE' : 'OFFLINE';

  if(condition === 'OFFLINE') {
    logindiv.innerHTML = "";

    var youreOfflineDiv = document.createElement('div');
    youreOfflineDiv.setAttribute('class', 'offlineMessage');
    youreOfflineDiv.innerHTML = offlineMessage;

    logindiv.appendChild(youreOfflineDiv);

	  submitButton.setAttribute('disabled', true)
	  cityInput.setAttribute('disabled', true);
	  
  }
}


WESE.loaded = function() {

  //Gör ajax-anrop till servern, och se om användaren har blivit online.

  WESE.updateOnlineStatus('load');
  document.body.addEventListener('offline', function () { WESE.updateOnlineStatus('offline') }, false);
  document.body.addEventListener('online', function () { WESE.updateOnlineStatus('online') }, false);


}


window.onload = WESE.loaded;
