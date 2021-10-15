<?php
//development
#$db = mysqli_connect('localhost', 'root', '', 'carshare');

//production
$db = mysqli_connect('us-cdbr-east-04.cleardb.com', 'b290796b602b29', 'aea8cc11', 'heroku_cb3473d4565ce7e');

if (mysqli_connect_errno()) {
    printf(mysqli_connect_error());
    exit();
}

#mysqli_query($db, 'DROP TABLE users');
$check = mysqli_query($db, 'select 1 from `users` LIMIT 1');
$check2 = mysqli_query($db, 'select 1 from `locations` LIMIT 1');
$check3 = mysqli_query($db, 'select 1 from `cars` LIMIT 1');
$check4 = mysqli_query($db, 'select 1 from `bookings` LIMIT 1');
$check5 = mysqli_query($db, 'select 1 from `unpaidbookings` LIMIT 1');



if ($check === FALSE) {
    $query = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `fullname` varchar(100) NOT NULL,
        `phone` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `role` varchar(10) NOT NULL
    )";
    $password = md5("admin123");
    $adminQuery = "INSERT INTO users (fullname, phone, email, password, role)  VALUES
    ('Admin', '0000-000-000', 'admin@admin.com', '$password', 'admin')";
    mysqli_query($db, $query);
    mysqli_query($db, $adminQuery);
}

if ($check2 === FALSE) {
    $query = "CREATE TABLE IF NOT EXISTS `locations` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `address` varchar(200) NOT NULL,
        `name` varchar(100) NOT NULL,
        `lat` float(10.6) NULL,
        `long` float(10.6) NULL,
        `occupied` varchar(10) NOT NULL
    )";
    //$insertQuery = "INSERT INTO `locations`( `address`, `name`, `lat`, `long`, `occupied`) 
    //VALUES ('test','test',NULL,NULL,'False')";
    mysqli_query($db, $query);
    //mysqli_query($db, $insertQuery);
}

if ($check3 === FALSE) {
    $query = "CREATE TABLE IF NOT EXISTS `cars` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `carName` varchar(200) NOT NULL,
        `carType` varchar(100) NOT NULL,
        `locationID` varchar(100) NULL,
        `booked` varchar(50) NULL
    )";

    mysqli_query($db, $query);
}

if ($check4 === FALSE) {
    $query = "CREATE TABLE IF NOT EXISTS `bookings` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `carID` varchar(11) NOT NULL,
        `userID` varchar(11) NOT NULL,
        `locationID` varchar(11) NOT NULL,
        `startTime` varchar(100) NOT NULL,
        `endTime` varchar(100) NOT NULL,
        `estimatedCost` varchar(100) NOT NULL,
        `pastBooking` varchar(100) NULL
    )";

    mysqli_query($db, $query);
}

if ($check5 === FALSE) {
    $query = "CREATE TABLE IF NOT EXISTS `unpaidbookings` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `carID` varchar(11) NOT NULL,
        `userID` varchar(11) NOT NULL,
        `locationID` varchar(11) NOT NULL,
        `startTime` varchar(100) NOT NULL,
        `endTime` varchar(100) NOT NULL,
        `estimatedCost` varchar(100) NOT NULL,
        `paid` varchar(100) NULL,
        `timeOfBooking` varchar(100) NOT NULL
    )";

    mysqli_query($db, $query);
}



include($path . "/model/users.php");
include($path . "/model/locations.php");
include($path . "/model/cars.php");
include($path . "/model/bookings.php");
include($path . "/model/unpaidbookings.php");

function dropTables($db, $table)
{
    if ($table === "cars") {
        $query = "SELECT * FROM locations";
        $allLocations = mysqli_query($db, $query);
        if (mysqli_num_rows($allLocations) !== 0) {
            while ($row = mysqli_fetch_assoc($allLocations)) {
                setOccupied("False", $row["id"], $db);
            }
        }
    }
    mysqli_query($db, 'DROP TABLE ' . $table);
}
