<?php include('layouts/header.php') ;

?>

<div class="homeHeader">
	<?php if(isset($_SESSION['email'])) : ?>
		<h2>Welcome, <?= $user['fullname'] ?></h2>
	<?php else : ?>
	<h2>TSB Car Share</h2>
	<?php endif; ?>
</div>

<div class="home1">
	
</div>
<?php include('layouts/footer.php') ?>
