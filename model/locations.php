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

function getAllLocs($db){
    $query = "SELECT * FROM locations";
    
    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !==0){
    $count = 0;
    while($row = mysqli_fetch_assoc($allLocations)) {
        $locs[$count]=$row;
        $count ++;
    }

    } 
    return $locs;

}