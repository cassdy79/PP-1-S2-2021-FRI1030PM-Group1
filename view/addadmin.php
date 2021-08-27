<?php include('layouts/header.php') ;

if (!isset($_SESSION['email'])) {
	 header("location: /");
}

?>

<div class="header">
  	<h2>Give User Admin Role</h2>
</div>

<form method="post" action="addadmin">
  <input type="hidden" name="post" value="addadmin">
  <?php include($errorPath); ?> 	
	<div class="input-group">
<label for="account">Select User :</label>
 <select id="account" name="account">>
	<option value="" </option>Select User
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


<?php include('layouts/footer.php') ?>