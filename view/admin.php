<?php include('layouts/header.php') ;

if (!isset($_SESSION['admin'])) {
	header("location: /");
}

?>

<div class="header">
	<h2>Admin Dashboard</h2>
    
</div>

<?php include('layouts/footer.php') ?>