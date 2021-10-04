<?php

//add into unpaidbookings table
function addUnpaidBooking($carID, $userID, $locationID, $startTime, $endTime, $estimatedCost, $now , $db){
	$query = "INSERT INTO unpaidbookings (carID, userID, locationID, startTime, endTime, estimatedCost, paid, timeOfBooking) 
	VALUES('$carID', '$userID', '$locationID','$startTime','$endTime','$estimatedCost', NULL, '$now')";
	
	return mysqli_query($db, $query);
}

//get unpaid booking by id
function getCurrentUnpaidBooking($id, $db){
	$query = "select * from unpaidbookings where id='".$id."' and paid is NULL";
		$presult = mysqli_query($db, $query);
			 if (mysqli_num_rows($presult) == 1) {
				$book = mysqli_fetch_array($presult);
                $book["car"] = getCarID($book['carID'], $db);
                $book["location"] = getLocationID($book['locationID'], $db);
				return $book;
			}
			return null;
}

//get unpaid booking by time it was made
function getCurrentUnpaidBookingIDs($carID, $userID, $locationID, $time, $db){
	$query = "select * from unpaidbookings where carID='".$carID."'and userID='".$userID."' and locationID='".$locationID."' and
    timeOfBooking='".$time."' and paid is NULL";
		$presult = mysqli_query($db, $query);
			 if (mysqli_num_rows($presult) == 1) {
				$book = mysqli_fetch_array($presult);
				return $book;
			}
			return null;
}

//get unpaid bookings by user
function getUserCurrentUnpaidBooking($userID, $db){
	$query = "select * from unpaidbookings where userID='".$userID."' and paid is NULL";
    $bookings = mysqli_query($db, $query);
    $bookingsArray = [];
    if (mysqli_num_rows($bookings) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($bookings)) {
        $bookingsArray[$count]=$row;
        $count ++;
    }
    } 
    
    if (count($bookingsArray) == 0){
        return null;
    }
    return $bookingsArray;
}

function setBookingPaid($bool, $id, $db){
    $insertQuery = "UPDATE `unpaidbookings` SET `paid` = '$bool' WHERE `unpaidbookings`.`id` = ".$id."";
    mysqli_query($db, $insertQuery);
}