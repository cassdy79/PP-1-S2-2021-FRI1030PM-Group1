<?php include('layouts/header.php') ;

?>

<div class="header">
	<?php if(isset($_SESSION['email'])) : ?>
		<h2>Welcome, <?= $user['fullname'] ?></h2>
	<?php else : ?>
	<h2>Home Page</h2>
	<?php endif; ?>
	<img class="homeLogo";
	src="/view/images/logo.png" alt="TSB Logo">

</div>

<?php include('layouts/footer.php') ?>
