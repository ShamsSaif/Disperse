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

function addMarkerInfo(placeLat, placeLon) {
  for (var i = 0; i < 200; i++) {
    var markersOnMap = [
      {
        LatLng: [
          {
            lat: getRandomLat(-37.566351, -38.220920, 8),
            lng: getRandomLon(144.561673, 145.292741, 8),
          },
        ],
      },
    ];
    var count = 0;
if((placeLat - 1.1) < markersOnMap[0].LatLng[0].lat < (placeLat + 1.1) && (placeLon - 1.1) < markersOnMap[0].LatLng[0].lng < (placeLon + 1.1)){
count += 1;
 return count;}
    const marker = new google.maps.Marker({
      position: markersOnMap[0].LatLng[0],
      map: map,
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
      var request = {
        placeId: place.place_id,
        fields: ['name', 'formatted_address', 'place_id', 'geometry']
      };
      var service = new google.maps.places.PlacesService(map);
      service.getDetails(request, function(place, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
      marker.setVisible(true);
			var	count = addMarkerInfo(place.geometry.location.lat(),place.geometry.location.lng());
      infowindowContent.children['place-name'].textContent = results[0].name;
      infowindowContent.children['place-address'].textContent =
        results[0].formatted_address;
        infowindowContent.children['total-people'].textContent = count;

      infowindow.open(map, marker);
    }});
    });
  });
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: centerCords,
  });
  
}