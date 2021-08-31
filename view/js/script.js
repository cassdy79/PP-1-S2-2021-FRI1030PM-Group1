let map;
var geocoder

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -37.8136, lng: 144.9631 },
    zoom: 11,
    styles: [
          { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
          { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
          { elementType: "labels.text.fill", stylers: [{ color: "#a2112e" }] },
          {
            featureType: "administrative.locality",
            elementType: "labels.text.fill",
            stylers: [{ color: "#c31437" }],
          },
          {
            featureType: "poi",
            elementType: "labels.text.fill",
            stylers: [{ color: "#8a0f27" }],
          },
          {
            featureType: "poi",
            elementType: "labels.icon",
            stylers: [{ color: "#2e050d" }],
          },
          {
            featureType: "transit",
            elementType: "labels.icon",
            stylers: [{ color: "#2e050d" }],
          },
          {
            featureType: "poi.park",
            elementType: "geometry",
            stylers: [{ color: "#263c3f" }],
          },
          {
            featureType: "poi.park",
            elementType: "labels.text.fill",
            stylers: [{ color: "#a2112e" }],
          },
          {
            featureType: "road",
            elementType: "geometry",
            stylers: [{ color: "#38414e" }],
          },
          {
            featureType: "road",
            elementType: "geometry.stroke",
            stylers: [{ color: "#212a37" }],
          },
          {
            featureType: "road",
            elementType: "labels.text.fill",
            stylers: [{ color: "#9ca5b3" }],
          },
          {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [{ color: "#730c21" }],
          },
          {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [{ color: "#1f2835" }],
          },
          {
            featureType: "road.highway",
            elementType: "labels.text.fill",
            stylers: [{ color: "#8a0f27" }],
          },
          {
            featureType: "transit",
            elementType: "geometry",
            stylers: [{ color: "#2f3948" }],
          },
          {
            featureType: "transit.station",
            elementType: "labels.text.fill",
            stylers: [{ color: "#8a0f27" }],
          },
          {
            featureType: "water",
            elementType: "geometry",
            stylers: [{ color: "#17263c" }],
          },
          {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [{ color: "#515c6d" }],
          },
          {
            featureType: "water",
            elementType: "labels.text.stroke",
            stylers: [{ color: "#17263c" }],
          },
        ],


  });



  var addresses = JSON.parse(document.getElementById("locdata").innerHTML);
  geocoder = new google.maps.Geocoder();
  if (addresses.length != 0){

    addresses.forEach(
        address => codeAddress(address)
    );

  }
  var locations = JSON.parse(document.getElementById("locdata2").innerHTML);
  console.log(locations)
  showMarkers(locations);

}

function showMarkers(locations){
  locations.forEach(location => marker(location)
) ;

}

function marker(location) {
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(location["lat"],location["long"]),
    map: map
  });
}

function codeAddress(address) {
    geocoder.geocode( { 'address': address["address"]}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var cds = {}
        cds.id = address["id"]
        cds.lat = map.getCenter().lat();
        cds.long = map.getCenter().lng()
        updateNull(cds);

      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

function updateNull(cds) {

    $.ajax({
        url: "model/coordinates.php",
        data: cds,
        success: function(res) {
            console.log(res)
        }
    })
}
