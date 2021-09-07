<?php include('layouts/header.php') ;



if (!isset($_SESSION['email'])) {
	 header("location: /");
}

$pastBookings = getAllBookingsID($user["id"], $db);

?>

  <div class="header">
  	<h2>User Profile</h2>
  </div>
  <div class="content">

  <h7 class="profile"> Full Name: </h7> <b class="details"><?= $user['fullname'] ?></b>
</br>
  <h7 class="profile"> Email:  </h7><b class="details"><?= $user['email'] ?></b>
</br>
  <h7 class="profile"> Phone Number:  </h7><b class="details"><?= $user['phone'] ?></b>
</br>

<div id="profileButtons">
<button type="submit"  id="current" class="btn" >Current Booking</button>
<button type="submit"  id="past" class="btn" >Past Bookings</button>
</div>
</div>

<div class="header" id="currentContentHeader">
	<h2>Current Booking</h2>
    
</div>
<div class="content" id="currentContent" >

<?php if(!$currentBooking) : ?>
  N/A


<?php else : ?>
  <h7 class="profile"> Booking ID: </h7> <b class="details"><?= $currentBooking['id'] ?></b>
</br>
<h7 class="profile"> Name of pickup:  </h7><b class="details"><?= $currentBooking['location']['name'] ?></b>
</br>
  <h7 class="profile"> Address:  </h7><b class="details"><?= $currentBooking['location']['address'] ?></b>
</br>
  <h7 class="profile"> Car:  </h7><b class="details"><?= $currentBooking['car']['carName'] ?></b>
</br>
<h7 class="profile"> Car Type:  </h7><b class="details"><?= $currentBooking['car']['carType'] ?></b>
</br>
<h7 class="profile"> Start-Time: </h7> <b class="details"><?= $currentBooking['startTime'] ?></b>
</br>
  <h7 class="profile"> End-Time:  </h7><b class="details"><?= $currentBooking['endTime'] ?></b>
</br>
  <h7 class="profile"> Cost:  </h7><b class="details"><?= $currentBooking['estimatedCost'] ?></b>
</br>



<?php endif; ?>


</div>

<div class="header" id="pastContentHeader">
  	<h2>Past Bookings</h2>
</div>

<div class="content" id="pastContent">
<?php if(!$pastBookings) : ?>
  N/A


<?php else : ?>
<?php foreach($pastBookings as $booking): ?>
</br>
  <h7 class="profile"> Booking ID: </h7> <b class="details"><?= $booking['id'] ?></b>
</br>
<h7 class="profile"> Name of pickup:  </h7><b class="details"><?= $booking['location']['name'] ?></b>
</br>
  <h7 class="profile"> Address:  </h7><b class="details"><?= $booking['location']['address'] ?></b>
</br>
  <h7 class="profile"> Car:  </h7><b class="details"><?= $booking['car']['carName'] ?></b>
</br>
<h7 class="profile"> Car Type:  </h7><b class="details"><?= $booking['car']['carType'] ?></b>
</br>
<h7 class="profile"> Start-Time: </h7> <b class="details"><?= $booking['startTime'] ?></b>
</br>
  <h7 class="profile"> End-Time:  </h7><b class="details"><?= $booking['endTime'] ?></b>
</br>
  <h7 class="profile"> Cost:  </h7><b class="details"><?= $booking['estimatedCost'] ?></b>
</br>
</br>
  <hr>
<?php endforeach; ?>
<?php endif; ?>





</div>

<script type="text/javascript">
hiddenButtons()
</script>
<?php include('layouts/footer.php') ?>