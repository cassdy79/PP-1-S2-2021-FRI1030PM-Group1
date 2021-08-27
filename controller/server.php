<?php

include($path . '/model/database.php');
$errorPath = $path . "/view/layouts/errors.php";
$errors = array(); 
if (isset($_SESSION['email'])) {
	$user = showProfile($db);
	$locs = getAllLocs($db);
	$users = getAllUsers($db);
	
    if($user['role'] === "admin"){
        $_SESSION['admin'] = True;
    }
}







//checks for post or get actions and stores name of function required
$action = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
}
//if action was register
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

    //checks for empty entries serversie
    if (empty($fullname)) { array_push($errors, "Full Name is required"); }
    if (empty($phone)) { array_push($errors, "Phone Number is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if (empty($password_2)) { array_push($errors, "Confirm Password is required"); }

    //checks for unmatched passwords
    if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
    } 
    //checks if user exists    
    else if (!check_user($email, $db)) {
            array_push($errors, "Email already exists");
    } 
    //adds if no issues
    else {
        add_user($fullname, $phone, $email, $password_1, $db);
    }

} 

//if action was login
else if($action === "login"){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    
    //checks for empty entries
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    
    //if no errors, login if the details match
    if (count($errors) == 0) {
        $password = md5($password);
        $user = login_user($email, $password, $db);


        if (!$user) {
        array_push($errors, "Wrong username/password combination");
        }else{
            $_SESSION['email'] = $email;
            header('location: /');
        }
    }
} 

//if action was insert
else if($action === "insert"){
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    
    //checks for empty entries
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    
    //if no errors, login if the details match
    if (count($errors) == 0) {
        
        $location = insertAddress($address, $name, $db);

        if (!$location) {
            array_push($errors, "Wrong Location");
            }else{
                header('location: /map');
                
            }

    }
} 

else if($action === "insertcar"){
	$carname = mysqli_real_escape_string($db, $_POST['carname']);
    $cartype = mysqli_real_escape_string($db, $_POST['cartype']);
	$location = mysqli_real_escape_string($db, $_POST['location']);
	
	 //checks for empty entries
    if (empty($carname)) {
        array_push($errors, "Car Name is required");
    }
    if (empty($cartype)) {
        array_push($errors, "Car Type is required");
    }
	if (empty($location)) {
        array_push($errors, "Location is required");
    }
	
	 //if no errors, add car if the details match
    if (count($errors) == 0) {
        
        $car = add_Car($carname, $cartype, $location, $db);
		
		 if (!$car) {
            array_push($errors, "Car not added");
            }else{
                header('location: /addcar');
                
            }
		
	}
}

else if($action === "addadmin"){
	$acc = mysqli_real_escape_string($db, $_POST['account']);
	
	 //checks for empty entries
    if (empty($acc)) {
        array_push($errors, "User is required");
    }
	
	 //if no errors, give admin if the details match
    if (count($errors) == 0) {
		$admin = giveAdmin($acc, $db);	
            }	
			 header('location: /addadmin');
	}
