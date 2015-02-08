"use strict";

var WESE = WESE || {};


WESE.ajaxTest = function() {
    $.ajax({
        type: "GET",
        url: "ajaxHandler.php",
        data: "AJAX_TEST",
        dataType : "json"
        }).done(function(data) {
            console.log(data);
    }).fail(function (jqXHR, textStatus) {
        console.log("Faail: " + textStatus);
    });
}



WESE.sendForm = function() {
    
    $.post('ajaxHandler.php', { action: "AJAX_USER_STANDARD_SEARCH", searchQueryCity: WESE.textField.value}, 
        function(returnedData){
             //Skapa väderrapports-taggar
             //Sätt in dem i dokumentet.

            console.log(returnedData);

            var data = JSON.parse(returnedData);

            if(data.responseType === "multipleResults") {
                WESE.createMultipleResultsDiv(data.results);
            } else if (data.responseType === "noresult") {
                WESE.createNoResultResult();
            } else {
                 WESE.createWeatherItems(data);
             }
    });
}


WESE.createNoResultResult = function() {



    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk')


    var divItem = document.createElement('div');       
    divItem.className = 'weatherTitleReportItem'; 

    var textTag = document.createElement('h3');

    var textNode = document.createTextNode("Oooups, vi hittade inget på din sökning.");

    textTag.appendChild(textNode);
    divItem.appendChild(textTag);


    encapsDiv.appendChild(divItem);

    WESE.pushToDocument(encapsDiv);

}


WESE.sendPickOneCityForm = function(geonameId) {
    


    $.get('ajaxHandler.php', { AJAX_USER_PICK_FROM_MULTIPLE: "", userPickFromMultiple: geonameId}, 
        function(returnedData){
             //Skapa väderrapports-taggar
             //Sätt in dem i dokumentet.

             console.log(returnedData);

            var data = JSON.parse(returnedData);

            if(data.responseType === "multipleResults") {
                WESE.createMultipleResultsDiv(data.results);
            } else {
                 WESE.createWeatherItems(data);
             }
    });
}



WESE.createMultipleResultsDiv = function(resultsData) {

    //Drar ut dagarna from vår response

    console.log(resultsData);

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


WESE.createWeatherItems = function(data) {
        
    //Drar ut dagarna from vår response

    var dayItems = data['dayItems'];
    var city = data['city'];

    var weatherItemDivs = [];


    var encapsDiv = document.createElement('div');

    encapsDiv.setAttribute('id', 'searchResultChunk')

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

        symbolImage.setAttribute('src', "./images/" + item.symbolVar + ".png");        

        divItem.appendChild(symbolNameText);

        divItem.appendChild(symbolImage);

        encapsDiv.appendChild(divItem);

/*
            $markup .= "<div class='weatherReportItem'>" . gmdate("Y-m-d\TH:i:s\Z", $day->time) . " " . $day->symbolName . " " . $day->temperature . "<img src='./images/" . $day->symbolVar . ".png'></div>";
*/

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

/*
Message.prototype.toString = function(){
    return this.getText()+" ("+this.getDate()+")";
}

Message.prototype.getHTMLText = function() {
      
    return this.getText().replace(/[\n\r]/g, "<br />");
}

Message.prototype.getDateText = function() {
    return this.getDate().toLocaleTimeString();
}
*/
