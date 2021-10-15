<?php
//Setting default timezone
date_default_timezone_set('Australia/Melbourne');

//Required files for model, payment and mailer
require_once($path . '/mailer/mail.php');
include($path . '/payment/stripe.php');
include($path . '/model/database.php');

//Error storage and retrieval
$errorPath = $path . "/view/layouts/errors.php";
$errors = array();


//If user is currently logged in, stores required user detail in objects along with other
//required data for running the page such as locations
if (isset($_SESSION['email'])) {
    $user = showProfile($db);
    $locs = getAllLocs($db);
    $users = getAllUsers($db);

    //used to refresh any changes to states of bookings by checking time.
    refreshBookings($db);

    //if there is a current active booking for the user, grab it from database
    $currentBooking = getCurrentBooking($user["id"], $db);

    //set session for admin if user is admin
    if ($user['role'] === "admin") {
        $_SESSION['admin'] = True;
    }
}




//checks for post or get actions and stores name of function required
$action = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
}
//if action was register
if ($action === "register") {
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    ////////////////////////////////////////////////
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{6,15}$/", $password_1)) {
        array_push($errors, "Password must be between 6 and 15 characters in length, must contain at 
        least one number, one upper case letter and one lower case letter.");
    }

    //else

    //checks for empty entries serversie
    if (empty($fullname)) {
        array_push($errors, "Full Name is required");
    }
    if (empty($phone)) {
        array_push($errors, "Phone Number is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if (empty($password_2)) {
        array_push($errors, "Confirm Password is required");
    }

    if (!preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/", $email)) {
        array_push($errors, "Invalid Email");
    }


    //checks for unmatched passwords
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    //checks if user exists    
    else if (!check_user($email, $db)) {
        array_push($errors, "Email already exists");
    }
    //adds if no issues
    if (count($errors) == 0) {
        add_user($fullname, $phone, $email, $password_1, $db);
        registeremail($email, $fullname, $mail);
        #registeremail("cassdycc21@ail.com",$fullname, $mail);
    }
}

//if action was login
else if ($action === "login") {
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
        } else {
            $_SESSION['email'] = $email;
            header('location: /');
        }
    }
}

//if action was insert
else if ($action === "insert") {
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
        } else {
            header('location: /map');
        }
    }
}

//if action was to add car 
else if ($action === "insertcar") {
    $carname = mysqli_real_escape_string($db, $_POST['carname']);
    $cartype = mysqli_real_escape_string($db, $_POST['cartype']);

    //checks for empty entries
    if (empty($carname)) {
        array_push($errors, "Car Name is required");
    }
    if (empty($cartype)) {
        array_push($errors, "Car Type is required");
    }


    //if no errors, add car if the details match
    if (count($errors) == 0) {

        $car = add_Car($carname, $cartype, $db);

        if (!$car) {
            array_push($errors, "Car not added");
        } else {
            header('location: /admin');
        }
    }
}

//if action was to assign car to a location
else if ($action === "assignCar") {
    $car = mysqli_real_escape_string($db, $_POST['car']);
    $location = mysqli_real_escape_string($db, $_POST['location']);

    //checks for empty entries
    if (empty($car)) {
        array_push($errors, "Car is required");
    }
    if (empty($location)) {
        array_push($errors, "Location is required");
    }


    //if no errors, add car if the details match
    if (count($errors) == 0) {

        $newLocation = updateCar($car, $location, $db);

        if (!$newLocation) {
            array_push($errors, "Car not added");
        } else {
            header('location: /map');
        }
    }
}

//if action was to create no admin
else if ($action === "addadmin") {
    $acc = mysqli_real_escape_string($db, $_POST['account']);

    //checks for empty entries
    if (empty($acc)) {
        array_push($errors, "User is required");
    }

    //if no errors, give admin if the details match
    if (count($errors) == 0) {
        $admin = giveAdmin($acc, $db);
    }
    header('location: /admin');
}

//if action was to create a normal booking, reroute to booking.php
else if ($action === "booking") {
    $bookingID =  $_POST['bookingID'];

    header('location: /booking?id=' . $bookingID);
}

//if action was to create future booking, reroute to bookin2.php
else if ($action === "booking2") {
    $bookingID =  $_POST['bookingID'];

    header('location: /booking2?id=' . $bookingID);
}


//if submitted a normal booking
else if ($action === "book") {
    $locationID = mysqli_real_escape_string($db, $_POST['locationID']);
    $userID = mysqli_real_escape_string($db, $_POST['userID']);
    $carID = mysqli_real_escape_string($db, $_POST['carID']);
    $startTime = mysqli_real_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($db, $_POST['endTime']);
    $estimatedCost = mysqli_real_escape_string($db, $_POST['cost']);

    //check if post values are empty
    if (empty($locationID)) {
        array_push($errors, "locID is required");
    }
    if (empty($userID)) {
        array_push($errors, "UserID is required");
    }
    if (empty($carID)) {
        array_push($errors, "carID is required");
    }
    if (empty($startTime)) {
        array_push($errors, "start time is required");
    }
    if (empty($endTime)) {
        array_push($errors, "end time is required");
    }
    if (empty($estimatedCost)) {
        array_push($errors, "estimated cost is required");
    }

    //setting start date and end date
    $startDate = strtotime($startTime);
    $times = explode(':', $endTime);
    $increaseFormat = '+' . $times[0] . ' hour +' . $times[1] . 'minutes';

    $startTime = date("Y-m-d H:i", $startDate);
    $endTime = date('Y-m-d H:i', strtotime($increaseFormat, $startDate));


    if (count($errors) == 0) {
        $time = (new DateTime())->format('Y-m-d H:i:s');

        //create unpaid booking
        $newBooking = addUnpaidBooking($carID, $userID, $locationID, $startTime, $endTime, $estimatedCost, $time, $db);
        if (!$newBooking) {
            array_push($errors, "Booking not added");
        } else {
            $unpaidBooking = getCurrentUnpaidBookingIDs($carID, $userID, $locationID, $time, $db);
            header('location: /checkout?id=' . $unpaidBooking['id']);
        }
    }
}

//Same as above but additional changes for a future date
else if ($action === "book2") {
    $locationID = mysqli_real_escape_string($db, $_POST['locationID']);
    $userID = mysqli_real_escape_string($db, $_POST['userID']);
    $carID = mysqli_real_escape_string($db, $_POST['carID']);
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $startTime = mysqli_real_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($db, $_POST['endTime']);
    $estimatedCost = mysqli_real_escape_string($db, $_POST['cost']);

    if (empty($locationID)) {
        array_push($errors, "locID is required");
    }
    if (empty($userID)) {
        array_push($errors, "UserID is required");
    }
    if (empty($carID)) {
        array_push($errors, "carID is required");
    }
    if (empty($date)) {
        array_push($errors, "date is required");
    }
    if ($startTime == "N/A") {
        array_push($errors, "start time is required");
    }
    if (empty($endTime)) {
        array_push($errors, "end time is required");
    }
    if (empty($estimatedCost)) {
        array_push($errors, "estimated cost is required");
    }

    $startDate = strtotime($date . $startTime);

    $times = explode(':', $endTime);

    $increaseFormat = '+' . $times[0] . ' hour +' . $times[1] . 'minutes';

    $startTime = date("Y-m-d H:i", $startDate);
    $endTime = date('Y-m-d H:i', strtotime($increaseFormat, $startDate));

    if (count($errors) == 0) {
        $time = (new DateTime())->format('Y-m-d H:i:s');
        //header('location: /payment?id='.$bookingObject);
        $newBooking = addUnpaidBooking($carID, $userID, $locationID, $startTime, $endTime, $estimatedCost, $time, $db);
        if (!$newBooking) {
            array_push($errors, "Booking not added");
        } else {
            $unpaidBooking = getCurrentUnpaidBookingIDs($carID, $userID, $locationID, $time, $db);
            header('location: /checkout?id=' . $unpaidBooking['id']);
        }
    }
}

//Payment page which redirects you to a stripe page
else if ($action === "payment") {
    $locationID = mysqli_real_escape_string($db, $_POST['locationID']);
    $bookID = mysqli_real_escape_string($db, $_POST['id']);
    $userID = mysqli_real_escape_string($db, $_POST['userID']);
    $carID = mysqli_real_escape_string($db, $_POST['carID']);
    $startTime = mysqli_real_escape_string($db, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($db, $_POST['endTime']);
    $estimatedCost = mysqli_real_escape_string($db, $_POST['estimatedCost']);
    $completed = mysqli_real_escape_string($db, $_POST['completed']);


    if (empty($locationID)) {
        array_push($errors, "locID is required");
    }
    if (empty($userID)) {
        array_push($errors, "UserID is required");
    }
    if (empty($carID)) {
        array_push($errors, "carID is required");
    }
    if (empty($startTime)) {
        array_push($errors, "start time is required");
    }
    if (empty($endTime)) {
        array_push($errors, "end time is required");
    }
    if (empty($estimatedCost)) {
        array_push($errors, "estimated cost is required");
    }
    $invoice = getCurrentUnpaidBooking($bookID, $db);
    if (!$invoice) {
        array_push($errors, "Error Invoice unavailable");
    }



    if (count($errors) == 0) {
        //if payment completed
        if ($completed === "True") {

            $newBooking = addBooking($carID, $userID, $locationID, $startTime, $endTime, $estimatedCost, $db);
            #$newBooking = True;
            if (!$newBooking) {
                array_push($errors, "Booking not added");
            } else {
                setBookingPaid("True", $bookID, $db);
                invoiceEmail($invoice['user']['email'], $invoice, $mail);
                header('location: /profile');
            }

            //else, attempt payment by setting values and redirecting to stripe
        } else {
            echo "<script src='https://js.stripe.com/v3/'></script>";
            $session = paymentMethod($estimatedCost, $invoice);
            $sessionID = $session->id;
            echo "
            <script type='text/javascript'>
    
            var stripe = Stripe('pk_test_51JhAe3JycQsKUYZJ21F7A3Y1tdVGdKjIq4TASxeSisptAbrQfvuMreFHZ9v2bXPdUpiFqwTv55HzwnML4hsMGAmY00uh3grug6');
            
            stripe.redirectToCheckout({sessionId: '{$sessionID}'})
    
            .then(function(result) {
            
            if (result.error) {
                alert(result.error.message);
                }
            }
            ).catch(function(error){
            console.error('Error:', error);
        }
    
        );
    
        </script>";
        }
    }
} else if ($action === "drop") {
    $dropper =  $_POST['action'];
    dropTables($db, $dropper);
    header('location: /');
}
