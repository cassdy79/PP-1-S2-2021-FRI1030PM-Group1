let map;
var geocoder
var infoWindow;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -37.8136, lng: 144.9631 },
    zoom: 11,
  });

  infoWindow = new google.maps.InfoWindow({ maxWidth: 300,
  });

  var addresses = JSON.parse(document.getElementById("locdata").innerHTML);
  geocoder = new google.maps.Geocoder();
  if (addresses.length != 0){

    addresses.forEach(
        address => codeAddress(address)
    );
    
  }
  var locations = JSON.parse(document.getElementById("locdata2").innerHTML);
  showMarkers(locations);
  
}

function showMarkers(locations){
  locations.forEach(location => marker(location)
) ;

}

function marker(location) {

  // Create the markers.
    const marker = new google.maps.Marker({
      position: new google.maps.LatLng(location["lat"],location["long"]),
      map: map,
      title: location['name'],
      animation: google.maps.Animation.DROP,
      optimized: false,
      icon: "/view/images/default.png"
    });
    carString = "EMPTY";
    buttondisabled = "";

    if (location["car"]) {
      carString = location["car"]["carName"] + '('+location["car"]["carType"]+')';
    } else {
      carString = "No car available at this moment";
      buttondisabled = "disabled"
      marker.setIcon("/view/images/grey.png")
    }
    
    const contentString =

    '<h3 id="firstHeading" class="firstHeading">'+location["name"]+'</h3>' +
    '<div id="bodyContent"> <br>' +

    '<h4>Available Car: </h4><p>'+ carString+ '</p></br>'+
    '<form method="post" action="#">' +
    '<input type="hidden" name="post" value="booking">' +
    '<input type="hidden" name="bookingID" value='+location["id"]+'>' +
    
    '<div class="input-group">' +
    '<button type="submit" class="btn" name="booking" '+buttondisabled+'>Book</button>'+
    "</div>"+
    "</form>"+
    "</div>";



    marker.addListener("click", () => {
      infoWindow.close();
      infoWindow.setContent(contentString);
      infoWindow.open(marker.getMap(), marker);
    });

}

function codeAddress(address) {
    geocoder.geocode( { 'address': address["address"]}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var cds = {}
        cds.id = address["id"]
        cds.name = address["name"]
        cds.address = address["address"]
        cds.lat = map.getCenter().lat()
        cds.long = map.getCenter().lng()
        updateNull(cds)
        marker(cds)
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

var currentdate = new Date();

function setFirst(){
$('#timepicker1').timepicker({    
    timeFormat: 'HH:mm',
    minTime: currentdate,
    maxTime: '23:59',
    dynamic: false,
    dropdown: true,
    scrollbar: false});
}
    
function setSecond() {

$('#timepicker2').timepicker({    
    timeFormat: 'HH:mm',
    minTime: '00:30',
    maxTime: '12:00',
    defaultTime: "00:30",
    dynamic: false,
    dropdown: true,
    scrollbar: false});
}

