<?php include('layouts/header.php');

?>

<div class="header">
    <h2>Create Account</h2>
</div>
	
  <form method="post" action="register.php">
  <input type="hidden" name="post" value="register">
	
<div class="input-group">
  	    <label>Full Name</label>
  	    <input type="text" name="fullname">
  	</div>

	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email">
  	</div>

	<div class="input-group">
	<label>Phone Number</label>
	<input type="tel" id="phone" name="phone" placeholder="0000-000-000" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}">
	</div>

  	<div class="input-group">
  	  <label>Password (8 Characters)</label>
  	  <input type="password" name="password_1" maxlength="8">
  	</div>

  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2" maxlength="8">
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="register">Register</button>
  	</div>

  </form>
  <?php include('layouts/footer.php') ?>