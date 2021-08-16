<?php include('layouts/header.php') ?>
  <div class="header">
  	<h2>Login</h2>
  </div>

  <form method="post" action="login">
  <input type="hidden" name="post" value="login">
  <?php include($errorPath); ?>
  	<div class="input-group">
  		<label>Email</label>
  		<input type="email" name="email" required>
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password" required>
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login">Login</button>
  	</div>
  </form>
<?php include('layouts/footer.php') ?>