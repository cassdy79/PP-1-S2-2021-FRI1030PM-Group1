<?php
function add_Car($carname, $cartype,  $db){
	$query = "INSERT INTO cars (carName, carType, locationID) 
	VALUES('$carname', '$cartype', NULL)";
	
	mysqli_query($db, $query);
	//setOccupied("True", $location, $db);
        $_SESSION['success'] = "Car Added Successfully";
		return True;
}

function updateCar($car, $location,  $db){
	$query = "UPDATE `cars` SET `locationID` = '$location' WHERE `cars`.`id` = ".$car."";
	
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


function getNullCars($db){

	$query = "SELECT * FROM `cars` WHERE `locationID` is NULL";
    
    $nullcars = mysqli_query($db, $query);
    $cars = [];
    if (mysqli_num_rows($nullcars) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($nullcars)) {
        $cars[$count]=$row;
        $count ++;
    }
    } 
    
    return $cars;
}