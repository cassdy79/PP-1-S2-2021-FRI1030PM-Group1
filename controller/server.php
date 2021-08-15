<?php
session_start();
include($path."/model/database.php");
$errorPath = $path."/view/layouts/errors.php";
$errors = array(); 

//checks for post or get actions and stores name of function required
$action = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
    if (!$action){
        if (isset($_GET['logout'])){
        $action = "logout";}
    }
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
    if (empty($fullname)) { array_push($errors, "Full Name is required"); }
    if (empty($phone)) { array_push($errors, "Phone Number is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if (empty($password_2)) { array_push($errors, "Confirm Password is required"); }

    if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
    } else if (!check_user($email)) {
            array_push($errors, "Email already exists");
    } else {
        add_user($fullname, $phone, $email, $password_1);
    }

} else if($action === "login"){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        #$password = md5($password);
        $user = login_user($email, $password);

        if (!$user) {
        array_push($errors, "Wrong username/password combination");
        }else{
            $_SESSION['email'] = $email;
            header('location: index.php');
        }
    }
} else if ($action === "logout"){
    session_destroy();
    unset($_SESSION['email']);
    header("location: index.php");
}