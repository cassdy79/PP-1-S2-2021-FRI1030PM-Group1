<?php include('layouts/header.php') ;

if (!isset($_SESSION['email'])) {
        header("location: /");
}

$array = getNullLocations($db);
$array = json_encode($array, true);
echo '<div id="locdata"> '.$array.' </div>';

$allLocs = getAllLocs($db);
$allLocs = json_encode($allLocs, true);
echo '<div id="locdata2">'.$allLocs.'</div>';

$bookingString = "";

if ($currentBooking) {
        $bookingString="You Already have an ongoing booking";
        echo '<div id="bookingdata">True</div>';
} else {
        echo '<div id="bookingdata">False</div>';
}
?>

<div class="mapHeader">
	<h2>Map</h2>
</div>

<div class="mapcontent">
<?php if($currentBooking) : ?>
<div id="currentlyBooked"><?= $bookingString?></div>
<?php endif; ?>

<div class="map_container">

  <div id="map">

  </div> </div>

</div>

<div class="closestHeader">
  <h2>Closest Available Spots</h2>
</div>

<div class="closestContent">
  <button onclick="getLocation()"  id="locationButtons" class="btn">Find closest locations</button>
  <p id="closest">
    fuck fuck shit fuck
  </p>
</div>


</div>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzdTq4OTYoUN274uw-QC2pHGy52MVNyOo&callback=initMap">
</script>

<script>

var loc = document.getElementById("closest");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  }
   else {
  loc.innerHTML = "Geolocation is not supported by this browser.";
  }
}
function showPosition(position) {
  loc.innerHTML = "Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude;
}
</script>
<?php include('layouts/footer.php') ?>
