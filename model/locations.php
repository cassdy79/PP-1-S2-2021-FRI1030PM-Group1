<?php

//insert address into table without lat and long
function insertAddress($address, $name,  $db)
{

    $query = "INSERT INTO `locations`( `address`, `name`, `lat`, `long`, `occupied`) 
            VALUES('$address', '$name',NULL,NULL,'False')";
    mysqli_query($db, $query);
    return True;
}

//get locations with null lat and long
function getNullLocations($db)
{
    $query = "SELECT * FROM `locations` WHERE `lat` is NULL AND `long` is NULL";

    $nullLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($nullLocations) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($nullLocations)) {
            $locs[$count] = $row;
            $count++;
        }
    }

    return $locs;
}

//set location as occupied by car
function setOccupied($value, $id, $db)
{

    $insertQuery = "UPDATE `locations` SET `occupied` = '$value' WHERE `locations`.`id` = " . $id . "";
    mysqli_query($db, $insertQuery);
}

//get all locations in table
function getAllLocs($db)
{
    $query = "SELECT * FROM locations";

    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($allLocations)) {
            $locs[$count] = $row;
            $locs[$count]["car"] = getCarLocID($row['id'], $db);
            $count++;
        }
    }
    return $locs;
}

//get all locations that are not occupied
function getAllEmptyLocs($db)
{
    $query = "select * from locations where occupied='False'";
    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($allLocations)) {
            $locs[$count] = $row;
            $locs[$count]["car"] = getCarLocID($row['id'], $db);
            $count++;
        }
    }
    return $locs;
}

//check if location is empty and return if empty
function isLocEmpty($locID, $db)
{
    $query = "select * from locations where id='" . $locID . "' and occupied='False'";
    $allLocations = mysqli_query($db, $query);
    $locs = [];
    if (mysqli_num_rows($allLocations) !== 0) {
        $count = 0;
        while ($row = mysqli_fetch_assoc($allLocations)) {
            $locs[$count] = $row;
            $count++;
        }
    }
    if (count($locs) == 0)
        return false;
    else {
        return $locs;
    }
}

//get location by ID and any cars in location
function getLocationbyID($db, $id)
{
    $query = "select * from locations where id='" . $id . "'";

    $presult = mysqli_query($db, $query);
    if (mysqli_num_rows($presult) == 1) {
        $location = mysqli_fetch_array($presult);
        $location["car"] = getCarLocID($id, $db);
        return $location;
    }
    return false;
}

//get location by id without any extra information
function getLocationID($id, $db)
{
    $query = "select * from locations where id='" . $id . "'";
    $presult = mysqli_query($db, $query);
    if (mysqli_num_rows($presult) == 1) {
        $location = mysqli_fetch_array($presult);
        return $location;
    }
    return null;
}
