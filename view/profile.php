<?php include('layouts/header.php') ;

if (isset($_SESSION['email'])) {
	$presult = showProfile($db);
}

if (!isset($_SESSION['email'])) {
	 header("location: /");
}

?>

<body>
  <div class="header">
  	<h2>User Profile</h2>
  </div>

  <center>
  <table align="center" border="1px" style="width:850px; line-height:40px;">
  <t>
  <th> Full Name </th>
  <th> Email </th>
  <th> Phone Number </th>
  </t>
 
  <?php 
					 while ($row = mysqli_fetch_array($presult)) {
						echo "<tr>";
					 	echo "<td>" .$row['fullname']. "</td>";
						echo "<td>" .$row['email']. "</td>";
						echo "<td>" .$row['phone']. "</td>";
						echo "</tr>";
					 }	
					?>
						
		 </table>
		 </center>
		</body>
<?php include('layouts/footer.php') ?>