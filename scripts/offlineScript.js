"use strict";

var WESE = WESE || {};

WESE.offlineInit = function() {

  //Gör ajax-anrop till servern, och se om användaren har blivit online.
/*
  WESE.updateOnlineStatus('load');
  document.body.addEventListener('offline', function () { WESE.updateOnlineStatus('offline') }, false);
  document.body.addEventListener('online', function () { WESE.updateOnlineStatus('online') }, false);

  WESE.initializeMap();

  document.getElementById("buttonSendQuery").onclick = function(e) {WESE.postStandardSearch(); return false;}
  WESE.textField = document.getElementById("cityInput");

  WESE.loadFavouritesList();
*/
}


WESE.offlineInit = function() {
  var favouritesObject = localStorage.getItem("userFavourites");

  favouritesObject = JSON.parse(favouritesObject);

  WESE.renderFavouritesList(favouritesObject);


}

WESE.renderFavouritesList = function(favouritesObject) {
  //console.log(favouritesObject.results);

  var favItems = favouritesObject.results;

  var favouriteList = document.getElementById('favouriteList');

  favItems.forEach( function(item) {

    var city = item.city;
    var geonameId = city.geonameId;

    var cityDiv = document.createElement('div');

    var cityName = document.createElement('a');

    cityName.setAttribute('href', '#');

    cityName.onclick = function(e) {
      /*
        WESE.postSearchGeonameId(geonameId, function(data) {

            if (data.responseType === "noresult") {
                WESE.createNoResultResult();
            } else {
                WESE.createWeatherItems(data, true);
            }

        });
*/
    }

    var cityNameText = document.createTextNode(city.toponymName);

    cityName.appendChild(cityNameText);
    cityDiv.appendChild(cityName);
    favouriteList.appendChild(cityDiv);

  });
}


window.onload = WESE.offlineInit();