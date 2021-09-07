<?php
function addBooking($carID, $userID, $locationID, $startTime, $endTime, $estimatedCost , $db){
	$query = "INSERT INTO bookings (carID, userID, locationID, startTime, endTime, estimatedCost, pastBooking) 
	VALUES('$carID', '$userID', '$locationID','$startTime','$endTime','$estimatedCost', NULL)";
	
	mysqli_query($db, $query);
    
    setBookedCar($carID, $db);
	return True;
}


function getBooking($id, $db){
	$query = "select * from bookings where id='".$id."'";
		$presult = mysqli_query($db, $query);
			 if (mysqli_num_rows($presult) == 1) {
				$book = mysqli_fetch_array($presult);
				return $book;
			}
			return null;
}


function getAllBookingsID($id, $db){

	$query = "select * from bookings where userID='".$id."'";
    
    $bookings = mysqli_query($db, $query);
    $bookingsArray = [];
    if (mysqli_num_rows($bookings) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($bookings)) {
        $bookingsArray[$count]=$row;
        $count ++;
    }
    } 
    
    return $bookingsArray;
}

function getAllActiveBookings($db){

	$query = "SELECT * FROM `bookings` WHERE `pastBooking` is NULL";
    $bookings = mysqli_query($db, $query);
    $bookingsArray = [];
    if (mysqli_num_rows($bookings) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($bookings)) {
        $bookingsArray[$count]=$row;
        $count ++;
    }
    } 
    
    return $bookingsArray;
}

function bookingComplete($id, $db) {
    $insertQuery = "UPDATE `bookings` SET `pastBooking` = 'True' WHERE `bookings`.`id` = ".$id."";
    mysqli_query($db, $insertQuery);

}

function refreshBookings($db) {
    $bookings = getAllActiveBookings($db);
    if($bookings){
        foreach ($bookings as $booking) {
            $endDate =  new DateTime($booking["endTime"]);
            $startDate = new DateTime($booking["startTime"]);
            $now = new DateTime();
            
            if($startDate < $now) {
                setOccupied("False", $booking["locationID"], $db);
            }
            if($endDate < $now) {
                unsetBookedCar($booking["carID"], $db);
                bookingComplete($booking['id'] ,$db);
            }
        } 


    } 

}