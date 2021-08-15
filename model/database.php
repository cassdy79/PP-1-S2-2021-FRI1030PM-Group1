<?php
$db = mysqli_connect('localhost', 'root', '', 'carshare');

if (mysqli_connect_errno()) {
    printf(mysqli_connect_error());
    exit();
}
include("users.php");