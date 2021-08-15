<?php
//initialize database
$db = mysqli_connect('localhost', 'root', '', 'carshare');

if (mysqli_connect_errno()) {
    printf(mysqli_connect_error());
    exit();
}

$check = mysqli_query($db, 'select 1 from `users` LIMIT 1');

if($check === FALSE)
{
    $query = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        `fullname` varchar(100) NOT NULL,
        `phone` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL
      )";

     mysqli_query($db, $query);
}

include("users.php");