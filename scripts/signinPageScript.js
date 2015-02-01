"use strict";

var WESE = WESE || {};



WESE.init = function() {

  WESE.updateOnlineStatus('load');
  document.body.addEventListener('offline', function () { WESE.updateOnlineStatus('offline') }, false);
  document.body.addEventListener('online', function () { WESE.updateOnlineStatus('online') }, false);


}


window.onload = WESE.init;
