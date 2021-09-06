<?php


function insertAddress($address, $name,  $db){

    $query = "INSERT INTO `locations`( `address`, `name`, `lat`, `long`, `occupied`) 
            VALUES('$address', '$name',NULL,NULL,'False')";
    mysqli_query($db, $query);
    return True;
}

function getNullLocations($db){
    $query = "SELECT * FROM `locations` WHERE `lat` is NULL AND `long` is NULL";

    $nullLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($nullLocations) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($nullLocations)) {
        $locs[$count]=$row;
        $count ++;
    }
    } 
    
    return $locs;
}

function setOccupied($value, $id, $db){

    $insertQuery = "UPDATE `locations` SET `occupied` = '$value' WHERE `locations`.`id` = ".$id."";
    mysqli_query($db, $insertQuery);
}

function getAllLocs($db){
    $query = "SELECT * FROM locations";
    
    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($allLocations)) {
        $locs[$count]=$row;
        $locs[$count]["car"] = get_car($row['id'], $db);
        $count ++;
    }

    } 
    return $locs;

}

function getAllEmptyLocs($db){
    $query = "select * from locations where occupied='False'";
    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($allLocations)) {
        $locs[$count]=$row;
        $locs[$count]["car"] = get_car($row['id'], $db);
        $count ++;
    }

    } 
    return $locs;

}

function getLocationbyID($db, $id){
    $query = "select * from locations where id='".$id."'";
    
	$presult = mysqli_query($db, $query);
	     if (mysqli_num_rows($presult) == 1) {
            $location = mysqli_fetch_array($presult);
            return $location;
        }
        return false;


}