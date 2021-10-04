<?php include('layouts/header.php') ;

if (!isset($_SESSION['email'])) {
        header("location: /");
}


$url= parse_url($_SERVER['REQUEST_URI']);

parse_str($url['query'], $params);

$unpaidBookingDetails = getCurrentUnpaidBooking($params["id"], $db);

if($unpaidBookingDetails) {
    $previousBookings = getUserCurrentUnpaidBooking($user['id'], $db);
    if($previousBookings){
        foreach ($previousBookings as $book) {
        if ($book['id'] != $params["id"]){
            setBookingPaid("False",$book['id'], $db);
        }
        } 
    }

    $startDate = new DateTime($unpaidBookingDetails["startTime"]);
    $now = new DateTime();
    if($startDate < $now) {
        setBookingPaid("False",$unpaidBookingDetails['id'], $db);
        $unpaidBookingDetails = null;
    }
}


if (!$unpaidBookingDetails) {
        header("location: /map");
} else if($currentBooking){
        header("location: /map");
}

?>

<div class="header">
	<h2>Payment</h2>

</div>

<form method="post" action="#">
<?php include($errorPath); ?>
<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
<?php endif ?>

<h7 class="profile"> Booking ID: </h7> <b class="details"><?= $unpaidBookingDetails['id'] ?></b>
</br>
<h7 class="profile"> Name of pickup:  </h7><b class="details"><?= $unpaidBookingDetails['location']['name'] ?></b>
</br>
  <h7 class="profile"> Address:  </h7><b class="details"><?= $unpaidBookingDetails['location']['address'] ?></b>
</br>
</br>
  <h7 class="profile"> Car:  </h7><b class="details"><?= $unpaidBookingDetails['car']['carName']." (".$unpaidBookingDetails['car']['carType'].")" ?></b>
</br>
<h7 class="profile"> Start-Time: </h7> <b class="details"><?= $unpaidBookingDetails['startTime'] ?></b>
</br>
  <h7 class="profile"> End-Time:  </h7><b class="details"><?= $unpaidBookingDetails['endTime'] ?></b>
</br>
  <h7 class="profile"> Cost:  </h7><b class="details"><?= $unpaidBookingDetails['estimatedCost'] ?></b>
</br>

<input type="hidden" name="post" value="payment">
<input type="hidden" name="id" value=<?=$unpaidBookingDetails["id"]?>>
<input type="hidden" name="locationID" value=<?=$unpaidBookingDetails["locationID"]?>>
<input type="hidden" name="userID" value=<?=$unpaidBookingDetails["userID"]?>>
<input type="hidden" name="carID" value=<?=$unpaidBookingDetails["carID"]?>>
<input type="hidden" name="startTime" value='<?=$unpaidBookingDetails["startTime"]?>'>
<input type="hidden" name="endTime" value='<?=$unpaidBookingDetails["endTime"]?>'>
<input type="hidden" name="estimatedCost" value=<?=$unpaidBookingDetails["estimatedCost"]?>>
<br>

<div class="input-group">
  		<label>Full Name</label>
  		<input type="text" name="cardName" required>
  	</div>
  	<div class="input-group">
  		<label>Card Number</label>
  		<input type="text" name="cardNum" required>
  	</div>
  	<div class="input-group">
  		<label>Expiry Date</label>
  		<input type="text" name="cardExpiry" required>
  	</div>
  	<div class="input-group">
  		<label>CVC</label>
  		<input type="text" name="cardCVC" required>
  	</div>
      <div id="card-element" class="form-control">
          <!-- a Stripe Element will be inserted here. -->
    </div>
<br>
<div class="input-group">
        <button type="submit" class="btn" name="book">Confirm Payment</button>
</div>
        
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="./js/charge.js"></script>
<?php include('layouts/footer.php') ?>