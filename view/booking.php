<?php include('layouts/header.php') ;

if (!isset($_SESSION['email'])) {
        header("location: /");
}




$url= parse_url($_SERVER['REQUEST_URI']);

parse_str($url['query'], $params);

$locationDetails = getLocationbyID($db, $params["id"]);
if (!$locationDetails) {
        header("location: /map");
}
?>



<div class="header">
	<h2>Bookings</h2>

</div>

<?php include('layouts/footer.php') ?>