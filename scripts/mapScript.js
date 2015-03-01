"use strict";

var WESE = WESE || {};

WESE.activeMarker;


WESE.initializeMap = function() {
	WESE.createMap();
}

WESE.createMap = function() {

	var myLatlng = new google.maps.LatLng(62.88722932,17.91876062);


  // Create an array of styles.
  var styles = [
    {
      stylers: [
        { hue: "#00ffe6" },
        { saturation: -20 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 100 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];

  // Create a new StyledMapType object, passing it the array of styles,
  // as well as the name to be displayed on the map type control.
  var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});

  // Create a map object, and include the MapTypeId to add
  // to the map type control.
  var mapOptions = {
    zoom: 5,
    center: myLatlng,
    mapTypeControlOptions: {
      	mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'],
      	style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
	    position: google.maps.ControlPosition.BOTTOM_CENTER
    },
    panControl:false,
    mapTypeControl: true,
    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'],
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.SMALL,
        position: google.maps.ControlPosition.RIGHT_TOP
    },
    scaleControl: false,
    streetViewControl: false
  };
  WESE.map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  //Associate the styled map with the MapTypeId and set it to display.
  WESE.map.mapTypes.set('map_style', styledMap);
  WESE.map.setMapTypeId('map_style');
}

WESE.setMapToPosition = function(coordinates) {
    console.log(coordinates);
    console.log(coordinates[0]);
    console.log(coordinates[1]);

    var myLatlng = new google.maps.LatLng( coordinates[0], coordinates[1] );

    WESE.map.setCenter( myLatlng );
    WESE.map.setZoom(8);

    if(WESE.activeMarker != undefined) {    
      WESE.activeMarker.setMap(null);
    }

    WESE.activeMarker = new google.maps.Marker({
        position: myLatlng,
        map: WESE.map,
        title:'',
      draggable:false,
    });
}


//window.onload = MAPSCRIPT.initializeMap;


