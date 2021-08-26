let map;
var geocoder

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -37.8136, lng: 144.9631 },
    zoom: 11,
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

