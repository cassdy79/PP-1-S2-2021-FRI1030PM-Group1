<?php include('layouts/header.php') ;

if (!isset($_SESSION['admin'])) {
	header("location: /");
}




?>

<div class="header">
	<h2>Admin Dashboard</h2>
    
</div>
<form method="post" action="admin">
  <input type="hidden" name="post" value="insert">
  <?php include($errorPath); ?>
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


<?php include('layouts/footer.php') ?>