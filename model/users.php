<?php
    function check_user($userEmail , $db){
        $user_check_query = "SELECT * FROM users WHERE email='$userEmail' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        
        if ($user) { // if user exists
            return false;
        } 
        return true;
    }

    function add_user($fullname, $phone, $email, $password_1, $db){
        //$password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (fullname, phone, email, password) 
                  VALUES('$fullname', '$phone',  '$email', '$password_1')";
        mysqli_query($db, $query);
        $_SESSION['success'] = "Account Creation Successful";
    }