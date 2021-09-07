let map;
var geocoder
var infoWindow;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -37.8136, lng: 144.9631 },
    zoom: 11,
    styles: [
          { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
          { elementType: "labels.text.stroke", stylers: [{ color: "#131820" }] },
          { elementType: "labels.text.fill", stylers: [{ color: "#a2112e" }] },
          {
            featureType: "administrative.locality",
            elementType: "labels.text.fill",
            stylers: [{ color: "#e71842" }],
          },
          {
            featureType: "poi",
            elementType: "labels.text.fill",
            stylers: [{ color: "#c31437" }],
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
            stylers: [{ color: "#c31437" }],
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
            stylers: [{ color: "#c31437" }],
          },
          {
            featureType: "road",
            elementType: "labels.text.stroke",
            stylers: [{ color: "#131820" }],
          },
          {
            featureType: "road.highway",
            elementType: "geometry",
            stylers: [{ color: "#730c21" }],
          },
          {
            featureType: "road.highway",
            elementType: "geometry.stroke",
            stylers: [{ color: "#1c2530" }],
          },
          {
            featureType: "road.highway",
            elementType: "labels.text.fill",
            stylers: [{ color: "#c31437" }],
          },
          {
            featureType: "transit",
            elementType: "geometry",
            stylers: [{ color: "#2f3948" }],
          },
          {
            featureType: "transit.station",
            elementType: "labels.text.fill",
            stylers: [{ color: "#c31437" }],
          },
          {
            featureType: "water",
            elementType: "geometry",
            stylers: [{ color: "#17263c" }],
          },
          {
            featureType: "water",
            elementType: "labels.text.fill",
            stylers: [{ color: "#c31437" }],
          },
          {
            featureType: "water",
            elementType: "labels.text.stroke",
            stylers: [{ color: "#17263c" }],
          },
        ],


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
  var ongoingBooking = document.getElementById("bookingdata").innerHTML
  showMarkers(locations, ongoingBooking);
  
}

function showMarkers(locations, ongoingBooking){
  locations.forEach(location => marker(location, ongoingBooking)
);

}

function marker(location, ongoingBooking) {

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
    if (ongoingBooking == "True"){
      carString = "Bookings unavailable";
      buttondisabled = "disabled"
      marker.setIcon("/view/images/grey.png")
    }
    else if (location["car"] && location["occupied"] != "False") {
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
        marker(cds, "False")
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



function setFirst(){
var currentdate = new Date();
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
    scrollbar: false,
    change: function(time) {
      var hours = time.getHours()
      var minutes = time.getMinutes()/30

      var totalCost = (hours*10) + (minutes*5)

      document.getElementById("cost").value = "$"+totalCost+".00"
    

  }});
}

function hiddenButtons() {
  function setEmpty(){
    $("#locForm").css("display","none")
    $("#locFormHeader").css("display","none")
    $("#carForm").css("display","none")
    $("#carFormHeader").css("display","none")
    $("#assignForm").css("display","none")
    $("#assignFormHeader").css("display","none")
    $("#adminForm").css("display","none")
    $("#adminFormHeader").css("display","none")
    $("#pastContent").css("display","none")
    $("#pastContentHeader").css("display","none")
    $("#currentContent").css("display","none")
    $("#currentContentHeader").css("display","none")
    $("#hiddenControls").css("display","none")
    }
    
    $("#locButton").click(function () {
      setEmpty()
    $("#locForm").css("display","block")
    $("#locFormHeader").css("display","block")
    });
    
    $("#carButton").click(function () {
      setEmpty()
    $("#carForm").css("display","block")
    $("#carFormHeader").css("display","block")
    });
    
    $("#assignButton").click(function () {
      setEmpty()
    $("#assignForm").css("display","block")
    $("#assignFormHeader").css("display","block")
    });
    
    $("#adminButton").click(function () {
      setEmpty()
    $("#adminForm").css("display","block")
    $("#adminFormHeader").css("display","block")
    });

    $("#current").click(function () {
      setEmpty()
    $("#currentContent").css("display","block")
    $("#currentContentHeader").css("display","block")
    });

    $("#past").click(function () {
      setEmpty()
    $("#pastContent").css("display","block")
    $("#pastContentHeader").css("display","block")
    });

    $("#hiddenButton").click(function () {
      setEmpty()
    $("#hiddenControls").css("display","block")
    });
}
