<?php
//initialize database
$db = mysqli_connect('localhost', 'root', '', 'carshare');

//production
#$db = mysqli_connect('us-cdbr-east-04.cleardb.com', 'b290796b602b29', 'aea8cc11', 'heroku_cb3473d4565ce7e');

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

include($path ."/model/users.php");