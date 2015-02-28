"use strict";

var WESE = WESE || {};

// WESE.offlineInit = function() {

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
// }


WESE.offlineInit = function() {

  var userSignedIn;

  if(WESE.supports_html5_storage()) {
    userSignedIn = localStorage.getItem("userSignedIn");
  }

  if (userSignedIn == 1) {
    var signOutLink = document.getElementById("offlineSignoutLink");

    signOutLink.onclick = function(e) {
      localStorage.setItem("userSignedIn", "");
      localStorage.setItem("UserSignedOutInOfflineMode", 1);
      localStorage.setItem("userFavourites", "{}");
      location.reload();
    }


    var favouritesObject = localStorage.getItem("userFavourites");
    favouritesObject = JSON.parse(favouritesObject);
    WESE.renderFavouritesList(favouritesObject);

  } else {
    WESE.renderOfflineSignedOutPage();
  }
}



WESE.supports_html5_storage = function () {
  try {
    return 'localStorage' in window && window['localStorage'] !== null;
  } catch (e) {
    return false;
    }
}


WESE.renderOfflineSignedOutPage = function() {

  var offlineText = document.getElementById('offlineText');

  offlineText.innerHTML = "Du verkar vara offline för tillfället.";


  var div = document.getElementById("favouritesDiv");

  favouritesDiv.innerHTML = "";


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
      WESE.createWeatherItems(item);
    }

    var cityNameText = document.createTextNode(city.toponymName);

    cityName.appendChild(cityNameText);
    cityDiv.appendChild(cityName);
    favouriteList.appendChild(cityDiv);

  });
}



WESE.createWeatherItems = function(data) {
        
    //Drar ut dagarna from vår response

    var dayItems = data['dayItems'];
    var city = data['city'];

    var weatherItemDivs = [];

    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk');

    encapsDiv.appendChild(WESE.createCityDiv(city));


    dayItems.forEach(function(item) {

        if(typeof item.symbolVar === 'object') {
            item.symbolVar = item.symbolVar[0];
        }

        var divItem = document.createElement('div');

        divItem.className = 'weatherReportItem';

        var symbolNameText = document.createTextNode(item.symbolName);

        var symbolImage = document.createElement('img');

        var symbolVarText;

        divItem.appendChild(symbolNameText);

        symbolImage.setAttribute('src', "./images/" + item.symbolVar + ".png");

        divItem.appendChild(symbolImage);

        encapsDiv.appendChild(divItem);

    });

    WESE.pushToDocument(encapsDiv);

}

WESE.pushToDocument = function(element) {
    var divToAppendTo = document.getElementById('searchResultArea');

    divToAppendTo.innerHTML = "";

    divToAppendTo.appendChild(element);

}

WESE.createCityDiv = function(city) {

    var divItem = document.createElement('div');       
    divItem.className = 'weatherTitleReportItem'; 

    var cityName = document.createElement('h3');

    var cityNameText = document.createTextNode(city.toponymName);

    cityName.appendChild(cityNameText);

    divItem.appendChild(cityName);

    return divItem;

}



window.onload = WESE.offlineInit();