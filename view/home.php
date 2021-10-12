<?php include('layouts/header.php') ;

?>

<div class="homeHeader">
	<?php if(isset($_SESSION['email'])) : ?>
		<h2>Welcome, <?= $user['fullname'] ?></h2>
	<?php else : ?>
	<h2>TSB Car Share</h2>
	<?php endif; ?>
</div>

<div class="homeContent">
<div class="homeBack" id="home1">
	<h1 class="homeTitle">Get to where you need to go</h1>
</div>

<div>
	<h3 class="homeText"> With our wide range of cars, getting from A to B has
		never been simpler! Just log in, pick a spot and a car, and away you go!</h3>
</div>

<div class="homeBack" id="home2">
	<h1 class="homeTitle">Never worry about parking again</h1>
</div>

<div>
	<h3 class="homeText"> Thanks to our large selection of car-parking spots,
	you'll never have to waste time searching for a spot to park your car.
	All you need to do is find the closest TSB parking spot to your location, and
	our friendly staff will make sure there is space for you.</h3>
</div>

<div class="homeBack" id="home3">
	<h1 class="homeTitle">Just get in and drive</h1>
</div>

<div>
	<h3 class="homeText">Don't worry about oil changes, car servicing and check
	engine lights, at TSB our cars are regularly serviced so all that you need to
	think about is the destination.</h3>
</div>

<div class="homeBack" id="home4">
	<h1 class="homeTitle">Plan ahead</h1>
</div>

<div>
	<h3 class="homeText">When using our booking system, you can be sure that there
		 will always be a car ready and waiting for you to start your journey. With
		 bookings available up to 2 weeks in advance, we make planning a journey even
	 easier, even if traffic never helps.</h3>
</div>
</div>
<?php include('layouts/footer.php') ?>
