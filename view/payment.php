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
require($path .'/payment/stripe.php');

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'product_data' => [
        'name' => 'T-shirt',
      ],
      'unit_amount' => 2000,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => 'https://localhost/success',
  'cancel_url' => 'https://localhost/cancel',
]);



?>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
var stripe = Stripe("pk_test_51JhAe3JycQsKUYZJ21F7A3Y1tdVGdKjIq4TASxeSisptAbrQfvuMreFHZ9v2bXPdUpiFqwTv55HzwnML4hsMGAmY00uh3grug6");
var session = "<?php echo $session['id']; ?>"

stripe.redirectToCheckout({sessionId: session})

.then(function(result) {

  if (result.error) {
    alert(result.error.message);
  }
}
).catch(function(error){
  console.error("Error:", error);
}

);

</script>

<div class="header">
	<h2>Payment</h2>

</div>

<form method="post" id="payment-form" action="#">
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

<!-- <div class="input-group">
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
  		<input type="text" name="cardCVC" required> -->

<br>

<button type="submit" class="btn" id="submitStripe" name="book">

<span id="button-text">Pay now</span>

</button>

<br>
        
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php include('layouts/footer.php') ?>