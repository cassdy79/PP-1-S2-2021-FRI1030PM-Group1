<?php

//add car into database table
function add_Car($carname, $cartype,  $db)
{
    $query = "INSERT INTO cars (carName, carType, locationID, booked) 
	VALUES('$carname', '$cartype', NULL, NULL)";

    mysqli_query($db, $query);
    return True;
}

//use car information to update location as occupied
function updateCar($car, $location,  $db)
{
    $query = "UPDATE `cars` SET `locationID` = '$location' WHERE `cars`.`id` = " . $car . "";

    mysqli_query($db, $query);
    setOccupied("True", $location, $db);
    //$_SESSION['success'] = "Car Added Successfully";
    return True;
}


//get location id where car is assigned 
function getCarLocID($locID, $db)
{
    $query = "select * from cars where locationID='" . $locID . "'";
    $presult = mysqli_query($db, $query);
    if (mysqli_num_rows($presult) == 1) {
        $car = mysqli_fetch_array($presult);
        return $car;
    }
    return null;
}


//get car from table using car id
function getCarID($id, $db)
{
    $query = "select * from cars where id='" . $id . "'";
    $presult = mysqli_query($db, $query);
    if (mysqli_num_rows($presult) == 1) {
        $car = mysqli_fetch_array($presult);
        return $car;
    }
    return null;
}


//set car as booked in table
function setBookedCar($id, $db)
{

    $insertQuery = "UPDATE `cars` SET `locationID` = NULL, `booked` = 'True' WHERE `cars`.`id` = " . $id . "";
    mysqli_query($db, $insertQuery);
}

//unset car as booked in table
function unsetBookedCar($id, $db)
{
    $insertQuery = "UPDATE `cars` SET  `booked` = NULL WHERE `cars`.`id` = " . $id . "";
    mysqli_query($db, $insertQuery);
}

//get all cars that are not booked
function getNullCars($db)
{

    $query = "SELECT * FROM `cars` WHERE `locationID` is NULL AND `booked` is NULL";

    $nullcars = mysqli_query($db, $query);
    $cars = [];
    if (mysqli_num_rows($nullcars) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($nullcars)) {
            $cars[$count] = $row;
            $count++;
        }
    }

    return $cars;
}

//get cars that are not booked but assigned to a location
function getLocationButNullCars($db)
{

    $query = "SELECT * FROM `cars` WHERE `locationID` is NOT NULL AND `booked` is NULL";

    $nullcars = mysqli_query($db, $query);
    $cars = [];
    if (mysqli_num_rows($nullcars) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($nullcars)) {
            $cars[$count] = $row;
            $count++;
        }
    }

    return $cars;
}
