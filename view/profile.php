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

    </div>

<div class="header" id="pastContentHeader">
  	<h2>Past Bookings</h2>
</div>

<div class="content" id="pastContent">


 <?php foreach($pastBookings as $booking): ?>
  <h7 class="profile"> Booking ID: </h7> <b class="details"><?= $booking['id'] ?></b>
  
</br>
<hr>
  <?php endforeach; ?>



</div>

<script type="text/javascript">
hiddenButtons()
</script>
<?php include('layouts/footer.php') ?>