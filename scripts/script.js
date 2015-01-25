"use strict";

var WESE = WESE || {};


			



WESE.updateOnlineStatus = function(msg) {
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

WESE.loaded = function() {
  WESE.updateOnlineStatus('load');
  document.body.addEventListener('offline', function () { WESE.updateOnlineStatus('offline') }, false);
  document.body.addEventListener('online', function () { WESE.updateOnlineStatus('online') }, false);
}


window.onload = WESE.loaded;
