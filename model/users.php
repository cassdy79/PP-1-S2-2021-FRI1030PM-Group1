<?php

//checks for existing users returns false if user exists
    function check_user($userEmail, $db){
        $user_check_query = "SELECT * FROM users WHERE email='$userEmail' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
            return false;
        } 
        return true;
    }

    //adds user to database
    function add_user($fullname, $phone, $email, $password_1, $db){

        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (fullname, phone, email, password, role) 
                VALUES('$fullname', '$phone',  '$email', '$password', 'user')";
        mysqli_query($db, $query);
        $_SESSION['success'] = "Account Creation Successful";
    }

    //checks and returns true if user email and password matches, else returns false
    function login_user($email, $password, $db){
    
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            return $results;
        }
        return false;
    }
	
	//selects all user information ready for display
	function showProfile($db) {
	$profile_query = "select * from users where email='".$_SESSION['email']."'";
	$presult = mysqli_query($db, $profile_query);
	     if (mysqli_num_rows($presult) == 1) {
            $user = mysqli_fetch_array($presult);
            return $user;
        }
        return false;
    }