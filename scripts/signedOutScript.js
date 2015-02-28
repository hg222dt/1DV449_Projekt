"use strict";

var WESE = WESE || {};

WESE.signedOutInit = function() {
	WESE.isUserSignedIn();
}

window.onload = WESE.signedOutInit;