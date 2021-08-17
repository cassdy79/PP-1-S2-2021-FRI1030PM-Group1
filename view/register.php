<?php include('layouts/header.php');

?>

<div class="header">
    <h2>Create Account</h2>
</div>
	
  <form method="post" action="register">
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
	  
  <input type="hidden" name="post" value="register">
	
<div class="input-group">
  	    <label>Full Name</label>
  	    <input type="text" name="fullname" required>
  	</div>

	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" required>
  	</div>

	<div class="input-group">
	<label>Phone Number</label>
	<input type="tel" id="phone" name="phone" placeholder="0000-000-000" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" required>
	</div>

  	<div class="input-group">
  	  <label>Password (8 Characters)</label>
  	  <input type="password" name="password_1"  required>
  	</div>

  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2"  required>
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="register">Register</button>
  	</div>

  </form>
  <?php include('layouts/footer.php') ?>