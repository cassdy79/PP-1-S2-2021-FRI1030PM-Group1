<?php
session_start();
include($path."/model/database.php");
$errorPath = $path."/view/layouts/errors.php";
$errors = array(); 

//checks for post or get actions and stores name of function required
$action = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
}

//if action was login
if ($action === "register"){
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    
    
  //  if (!preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password_1)) {
   //     array_push($errors, "Password must be at least 8 characters in length and must contain at 
   //     least one number, one upper case letter, one lower case letter and one special character.");
   //     }

    //else
     if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
    } else if (!check_user($email, $db)) {
            array_push($errors, "email already exists");
    } else {
        add_user($fullname, $phone, $email, $password_1, $db);
    }

} else if($action === "login"){
    echo "register";
}