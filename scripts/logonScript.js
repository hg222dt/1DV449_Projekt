"use strict";

  /**
   * Hanterar när användaren har valt ett konto på google oauth och blivit redirectad till sidan.
   */
  function onSignInCallback(resp) {
    gapi.client.load('plus', 'v1', apiClientLoaded);
  }

  function apiClientLoaded() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
  }

  function handleEmailResponse(resp) {
    var primaryEmail;
    for (var i=0; i < resp.emails.length; i++) {
      if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
    }

    console.log(primaryEmail);

	window.location = "../index.php?logUserIn=" + primaryEmail;

  }
