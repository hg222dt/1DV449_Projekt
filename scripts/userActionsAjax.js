"use strict";

var WESE = WESE || {};


WESE.isUserSignedIn = function(callback) {
    $.ajax({
        type: "GET",
        url: "ajaxHandler.php",
        data: "AJAX_IS_USER_SIGNED_IN",
        dataType : "json"
        }).done(function(data) {
            data = JSON.parse(data);
            callback(data.isUserLoggedIn);
    }).fail(function (jqXHR, textStatus) {
        console.log("Faail: " + textStatus);
    });
}



WESE.postStandardSearch = function() {
    
    $.ajax({
        type: "POST",
        url: "ajaxHandler.php",
        contentType : "application/x-www-form-urlencoded; charset=utf-8",
        data: { action: "AJAX_USER_STANDARD_SEARCH", searchQueryCity: WESE.textField.value },
        }).done(function(returnedData) {
            
            var data = JSON.parse(returnedData);

            if(data.responseType === "multipleResults") {
                WESE.createMultipleResultsDiv(data.results);
            } else if (data.responseType === "noresult") {
                WESE.createNoResultResult();
            } else {
                 WESE.createWeatherItems(data, false);
             }

    }).fail(function (jqXHR, textStatus) {
        console.log("Faail: " + textStatus);
    });

}

WESE.postSearchGeonameId = function(geonameId, callback) {
    
    $.post('ajaxHandler.php', { action: "AJAX_USER_SEARCH_GEONAME_ID", geonameId: geonameId}, 
        function(returnedData){
             //Skapa väderrapports-taggar
             //Sätt in dem i dokumentet.
            var data = JSON.parse(returnedData);

            callback(data);
    });
}

//Skapar resultat för att "inget kunde hittas"
WESE.createNoResultResult = function() {

    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk')

    var divItem = document.createElement('div');       
    divItem.className = 'weatherTitleReportItem'; 

    var hTag = document.createElement('h3');
    var hNode = document.createTextNode("Fel fel fel fel fel!");

    var textTag = document.createElement('p');
    var textNode = document.createTextNode('Vi hittade inget.');

    textTag.appendChild(textNode);
    hTag.appendChild(hNode);

    divItem.appendChild(hTag);
    divItem.appendChild(textTag);

    encapsDiv.appendChild(divItem);

    WESE.pushToDocument(encapsDiv);

}

//Funktion för att skicka sökning när användaren valt stad från flervalsalternativ
WESE.sendPickOneCityForm = function(geonameId) {
    
    $.get('ajaxHandler.php', { AJAX_USER_PICK_FROM_MULTIPLE: "", userPickFromMultiple: geonameId}, 
        function(returnedData){
             //Skapa väderrapports-taggar
             //Sätt in dem i dokumentet.

            var data = JSON.parse(returnedData);

            if(data.responseType === "multipleResults") {
                WESE.createMultipleResultsDiv(data.results);
            } else {
                 WESE.createWeatherItems(data, false);
             }
    });
}

//Skapar felrvalsalternativ
WESE.createMultipleResultsDiv = function(resultsData) {

    //Drar ut dagarna from vår response

    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk')

    var divItem = document.createElement('div');

    divItem.className = 'weatherReportItem';


    resultsData.forEach(function(item) {

        var cityName = document.createElement('a');
        cityName.setAttribute('href', '#');

        cityName.onclick = function() {
            var geonameId = item.geonameId;

            WESE.sendPickOneCityForm(geonameId);
        }

        var cityNameText = document.createTextNode(item.toponymName);

        var municipName = document.createElement('p');
        var municipNameText = document.createTextNode(item.muncipName);

        municipName.appendChild(municipNameText);
        cityName.appendChild(cityNameText);
        divItem.appendChild(cityName);
        divItem.appendChild(municipName);
        
    });

    encapsDiv.appendChild(divItem);

    WESE.pushToDocument(encapsDiv);
}


//Skapar väder-items för väderleksrapporten
WESE.createWeatherItems = function(data, isFavourite) {
        
    //Drar ut dagarna from vår response

    var coordinates = [parseFloat(data.city.latitude), parseFloat(data.city.longitude)];

    WESE.setMapToPosition(coordinates);


    var dayItems = data['dayItems'];
    var city = data['city'];

    var weatherItemDivs = [];

    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk');

    encapsDiv.appendChild(WESE.createCityDiv(city, isFavourite));


    dayItems.forEach(function(item) {

        if(typeof item.symbolVar === 'object') {
            item.symbolVar = item.symbolVar[0];
        }

        var dayNameItem = document.createElement('span');
        dayNameItem.innerHTML = item.dayName;

        var divItem = document.createElement('div');

        divItem.className = 'weatherReportItem';

        var symbolNameText = document.createTextNode(item.symbolName);

        var symbolImage = document.createElement('img');

        symbolImage.setAttribute('class', 'weatherSymbolImage');

        var symbolVarText;

        divItem.appendChild(dayNameItem);

        // divItem.appendChild(symbolNameText);

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

//Skapar stads-item för väderleksrapporten
WESE.createCityDiv = function(city, isFavourite) {

    var divItem = document.createElement('div');       
    divItem.className = 'weatherTitleReportItem'; 

    var cityName = document.createElement('h3');

    var cityNameText = document.createTextNode(city.toponymName);

    cityName.appendChild(cityNameText);

    divItem.appendChild(cityName);


    var favToolLink = document.createElement('a');

    favToolLink.setAttribute('id', 'favLinkTool');


    favToolLink = WESE.createFavToolLink(city, isFavourite, favToolLink);

    divItem.appendChild(favToolLink);

    return divItem;

}

//Skapar länk för att lägga till eller ta bort som favorit, beroende på om den redan är användarens favorit eller inte.
WESE.createFavToolLink = function(city, isFavourite, favToolLink) {
    if(isFavourite) {

        var deleteNameText = document.createTextNode("Ta bort som favorit");

        favToolLink.appendChild(deleteNameText);

        favToolLink.onclick = function () {

            WESE.deleteCityFromFavourites(city.geonameId, function() {
                WESE.loadFavouritesList();
                document.getElementById('favLinkTool').innerHTML = "";
                WESE.createFavToolLink(city, false, favToolLink);
            });
        };

    } else {

        var saveNameText = document.createTextNode("Spara som favorit");

        favToolLink.appendChild(saveNameText);

        favToolLink.onclick = function () {
            WESE.saveCityToFavourite(city.geonameId);
            document.getElementById('favLinkTool').innerHTML = "";
            WESE.createFavToolLink(city, true, favToolLink);
        };
    }

    return favToolLink;
}

//Tar bort stad från favoriter, på servern.
WESE.deleteCityFromFavourites = function(geonameId, callback) {

    $.post('ajaxHandler.php', { action: "AJAX_USER_DELETE_FAVOURITE", geonameId: geonameId}, 
        function(result){
            callback();
    });

}



WESE.setTopNotice = function(noticeText) {


}

//Sparar stad till favoriter på server.
WESE.saveCityToFavourite = function (geonameId) {

    WESE.saveNewCityToFavourites(geonameId, function(returnedFavourites) {
        WESE.updateFavouritesList(returnedFavourites);
    });
}


WESE.saveNewCityToFavourites = function (geonameId, updateFavouritesList) {

    //Make ajax-call to server to add favourite.

    $.post('ajaxHandler.php', { action: "AJAX_USER_ADD_FAVOURITE", geonameId: geonameId}, 

        function(returnedFavourites){
             //Skapa väderrapports-taggar
             //Sätt in dem i dokumentet.
            var report = returnedFavourites.results;

            var data = JSON.parse(returnedFavourites);

            if(data.responseType === "error_favourites_max_limit") {
                WESE.setTopNotice("Max antal favoriter är uppnått! ta bort en för att lägga till en, vetja :)");
            } else {
                updateFavouritesList(data);
             }
    });

}


//Laddar lista med favoriter från server.
WESE.loadFavouritesList = function() {

    $.post('ajaxHandler.php', { action: "AJAX_USER_GET_FAVOURITES"}, 

        function(returnedFavourites){

            var report = returnedFavourites.results;

            var data = JSON.parse(returnedFavourites);

            WESE.updateFavouritesList(data);
    });
}


//Uppdaterar listan i klienten med favoriter.
WESE.updateFavouritesList = function(favourites) {

    //Update faveoiters list in DOM

    WESE.saveFavouritesToLocalStorage(favourites);

    var cities = favourites.results;

    var favouriteList = document.getElementById('favouriteList');

    favouriteList.innerHTML = "";

    cities.forEach(function(item) {

        var city = item.city;
        var geonameId = city.geonameId;

        var cityDiv = document.createElement('div');

        var cityName = document.createElement('a');

        cityName.setAttribute('href', '#');

        cityName.onclick = function(e) {
            WESE.postSearchGeonameId(geonameId, function(data) {

                if (data.responseType === "noresult") {
                    WESE.createNoResultResult();
                } else {
                    WESE.createWeatherItems(data, true);
                }

            });
        }

        var cityNameText = document.createTextNode(city.toponymName);

        cityName.appendChild(cityNameText);
        cityDiv.appendChild(cityName);
        favouriteList.appendChild(cityDiv);
    });

}

//Sparar favortier till local storage
WESE.saveFavouritesToLocalStorage = function(favourites) {
    //Save to Local storage

    if(WESE.supports_html5_storage()) {

        localStorage.setItem("userFavourites", JSON.stringify(favourites));

        var favouritesObject = localStorage.getItem("userFavourites");
    }
}

//Tar bort alla favoriter från localstorage
WESE.deleteFavourites = function() {
    if(WESE.supports_html5_storage()) {
        localStorage.setItem("userFavourites", JSON.stringify({}));
    }
}


//Funktion för att se om användarens webbläsare har stöd för local storage
WESE.supports_html5_storage = function () {
      try {
        return 'localStorage' in window && window['localStorage'] !== null;
      } catch (e) {
        return false;
      }
}


WESE.dayItem = function (time, symbolName, temperature, period, symbolVar){

    this.getTime = function() {
        return time;
    }

    this.setText = function(_time) {
        time = time;
    }

    this.getSymbolName = function() {
        return symbolName;
    }

    this.setSymbolName = function(_symbolName) {
        symbolName = symbolName;
    }

    this.getTemperature = function() {
        return temperature;
    }

    this.setTemperature = function(_temperature) {
        temperature = temperature;
    }

    this.getPeriod = function() {
        return period;
    }

    this.setPeriod = function(_period) {
        period = period;
    }

    this.getSymbolVar = function() {
        return symbolVar;
    }

    this.setSymbolVar = function(_symbolVar) {
        symbolVar = symbolVar;
    }

}
