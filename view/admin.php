<?php include('layouts/header.php') ;

if (!isset($_SESSION['admin'])) {
	header("location: /");
}

$emptyLocs = getAllEmptyLocs($db);
$emptyCars = getNullCars($db);


?>
<br>

<div id="buttons1">
<button type="submit"  id="locButton" class="btn" >Add Location</button>
<button type="submit"  id="carButton" class="btn" >Add Car</button>
<button type="submit"  id="assignButton" class="btn" >Assign Car</button>
<button type="submit"  id="adminButton" class="btn" >Assign Admin</button>
<button type="submit"  id="hiddenButton" class="btn" >Admin Table controls</button>
<?php include($errorPath); ?>
</div>
<div class="header" id="locFormHeader">
	<h2>Add Location</h2>
    
</div>

<form method="post" action="" id="locForm">
  <input type="hidden" name="post" value="insert">
  	<div class="input-group">
  		<label>Address</label>
  		<input  name="address" required>
  	</div>
  	<div class="input-group">
  		<label>Name</label>
  		<input name="name" required>
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="insert">Insert</button>
  	</div>
  </form>

<div class="header" id="carFormHeader">
  	<h2>Add Car</h2>
</div>

<form method="post" action="" id="carForm">

  <input type="hidden" name="post" value="insertcar">
  	<div class="input-group">
  		<label>Car Name</label>
  		<input  name="carname" required >
  	</div>
  	<div class="input-group">
  		<label>Car Type</label>
  		<input name="cartype" required>
  	</div>

				<div class="input-group">
  		<button type="submit" class="btn" name="insertcar">Add Car</button>
  	</div>
  </form>

  <div class="header" id="assignFormHeader">
  	<h2>Assign Car</h2>
</div>

  <form method="post" action="" id="assignForm"> 

  <input type="hidden" name="post" value="assignCar">

  <div class="input-group">
<label for="location">Select car :</label>
 <select id="car" name="car">>
	<option value=""> </option>Select Location
				<?php 
				foreach ($emptyCars as $car) {
						echo '<option value ='.$car['id'].'>Name: '.$car['carName'].'('.$car['carType'].')</option>' ;	
				}
					?>
				</select>
				</div>
  	
	<div class="input-group">
<label for="location">Select Location :</label>
 <select id="location" name="location">>
	<option value=""> </option>Select Location
				<?php 
				foreach ($emptyLocs as $loc) {
						echo '<option value ='.$loc['id'].'>Address: '.$loc['address'].'</option>' ;	
				}
					?>
				</select>
				</div>
				<div class="input-group">
  		<button type="submit" class="btn" name="insertcar">Add Car</button>
  	</div>
  </form>

  <div class="header" id="adminFormHeader">
  	<h2>Give User Admin Role</h2>
</div>

<form method="post" action="" id="adminForm">
  <input type="hidden" name="post" value="addadmin">
	<div class="input-group">
<label for="account">Select User :</label>
 <select id="account" name="account">>
	<option value="" ></option>Select User
				<?php 
				foreach ($users as $account) {
						echo '<option value ='.$account['id'].'>User: '.$account['fullname'].' - '.$account['email'].'</option>' ;	
				}
					?>
				</select>
				</div>
				<div class="input-group">
  		<button type="submit" class="btn" name="insertcar">Give Admin</button>
  	</div>
  </form>
<br>
  <div id="hiddenControls" >

<form method="post" action="" >
<input type="hidden" name="post" value="drop">

<input type="radio" id="carsdrop" name="action" value="cars">
<label for="carsdrop">Cars</label><br>
<input type="radio" id="bookingsdrop" name="action" value="bookings">
<label for="bookingsdrop">Bookings</label><br>
<input type="radio" id="locationsdrop" name="action" value="locations">
<label for="locationsdrop">Locations</label> 
<br>
<button type="submit" class="btn" name="insert">Drop</button>
</form>


</div>
<script type="text/javascript">
hiddenButtons()
</script>
<?php include('layouts/footer.php') ?>