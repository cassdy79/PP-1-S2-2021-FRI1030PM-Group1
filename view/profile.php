<?php include('layouts/header.php') ;



if (!isset($_SESSION['email'])) {
	 header("location: /");
}

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
</div>
<?php include('layouts/footer.php') ?>