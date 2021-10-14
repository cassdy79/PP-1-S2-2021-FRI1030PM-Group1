<?php

//development
$db = mysqli_connect('localhost', 'root', '', 'carshare');


//production
#$db = mysqli_connect('us-cdbr-east-04.cleardb.com', 'b290796b602b29', 'aea8cc11', 'heroku_cb3473d4565ce7e');

if (isset($_REQUEST)) {
    $reqID = $_REQUEST["id"];
    $lat = $val = $_REQUEST["lat"];
    $long = $val = $_REQUEST["long"];

    $insertQuery = "UPDATE `locations` SET `lat` = '$lat', `long` = '$long' WHERE `locations`.`id` = " . $reqID . "";
    mysqli_query($db, $insertQuery);
}
