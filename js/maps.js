var map;
var InforObj = [];
var centerCords = {
  lat: -37.810454,
  lng: 144.962379,
};

window.onload = function () {
  initMap();
  initMap1();
};

function addMarkerInfo() {
  for (var i = 0; i < 50; i++) {
    var markersOnMap = [
      {
        LatLng: [
          {
            lat: getRandomLat(-37.840157, -37.9312, 8),
            lng: getRandomLon(145.074128, 144.964193, 8),
          },
        ],
      },
    ];
    var contentString =
      '<div id="content"><h1>' +
      markersOnMap[0].placeName +
      "</h1><p>Location Info.</p></div>";
    const marker = new google.maps.Marker({
      position: markersOnMap[0].LatLng[0],
      map: map,
    });

    const infowindow = new google.maps.InfoWindow({
      content: contentString,
      maxWidth: 200,
    });

    marker.addListener("click", function () {
      closeOtherInfo();
      infowindow.open(marker.get("map"), marker);
      InforObj[0] = infowindow;
    });
  }
}

function closeOtherInfo() {
  if (InforObj.length > 0) {
    InforObj[0].set("marker", null);
    InforObj[0].close();
    InforObj.length = 0;
  }
}
function getRandomLon(from, to, fixed) {
  return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
}
function getRandomLat(from, to, fixed) {
  return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
}

function initMap1() {
//get current location 
  var infoWindow = new google.maps.InfoWindow;
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);
    }, function () {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    handleLocationError(false, infoWindow, map.getCenter());
  }

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
  }

  // Search location
  var input = document.getElementById('pac-input');

  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.bindTo('bounds', map);

  // Specify just the place data fields that you need.
  autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  var geocoder = new google.maps.Geocoder;

  var marker = new google.maps.Marker({
    map: map
  });
  marker.addListener('click', function () {
    infowindow.open(map, marker);
  });

  autocomplete.addListener('place_changed', function () {
    infowindow.close();
    var place = autocomplete.getPlace();

    if (!place.place_id) {
      return;
    }

    var getPlacdId = place.place_id;
    
    geocoder.geocode({
      'placeId': place.place_id
    }, function (results, status) {
      if (status !== 'OK') {
        window.alert('Geocoder failed due to: ' + status);
        return;
      }

      map.setZoom(11);
      map.setCenter(results[0].geometry.location);

      // Set the position of the marker using the place ID and location.
      marker.setPlace({
        placeId: place.place_id,
        location: results[0].geometry.location
      });

      marker.setVisible(true);

      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-id'].textContent = place.place_id;
      infowindowContent.children['place-address'].textContent =
        results[0].formatted_address;

      infowindow.open(map, marker);
    });
  });
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: centerCords,
  });
  addMarkerInfo();
}

