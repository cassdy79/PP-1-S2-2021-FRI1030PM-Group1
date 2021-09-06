<?php
function add_Car($carname, $cartype, $location, $db){
	$query = "INSERT INTO cars (carName, carType, locationID) 
	VALUES('$carname', '$cartype', '$location')";
	
	mysqli_query($db, $query);
	setOccupied("True", $location, $db);
        $_SESSION['success'] = "Car Added Successfully";
		return True;
}

function get_car($locID, $db){
	$query = "select * from cars where locationID='".$locID."'";
		$presult = mysqli_query($db, $query);
			 if (mysqli_num_rows($presult) == 1) {
				$car = mysqli_fetch_array($presult);
				return $car;
			}
			return null;
}