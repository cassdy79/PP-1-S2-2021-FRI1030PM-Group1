<?php include('layouts/header.php') ;

if (!isset($_SESSION['email'])) {
	 header("location: /");
}

$emptyLocs = getAllEmptyLocs($db);

?>

<div class="header">
  	<h2>Add Car</h2>
</div>

<form method="post" action="addcar">
  <input type="hidden" name="post" value="insertcar">
  <?php include($errorPath); ?>
  	<div class="input-group">
  		<label>Car Name</label>
  		<input  name="carname" required>
  	</div>
  	<div class="input-group">
  		<label>Car Type</label>
  		<input name="cartype" required>
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


<?php include('layouts/footer.php') ?>