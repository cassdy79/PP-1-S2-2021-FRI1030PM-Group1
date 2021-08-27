<?php
function add_Car($carname, $cartype, $location, $db){
	$query = "INSERT INTO cars (carName, carType, locationID) 
	VALUES('$carname', '$cartype', '$location')";
	
	mysqli_query($db, $query);
        $_SESSION['success'] = "Car Added Successfully";
		return True;
}