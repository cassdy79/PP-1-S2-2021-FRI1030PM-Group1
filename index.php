<?php
session_start();

require_once("routes/router.php");


route('/', function(){
    include('view/home.php');
});

route('/login', function(){
    include('view/login.php');
});

route('/register', function(){
    include('view/register.php');
});

route('/profile', function(){
    include('view/profile.php');
});

route('/admin', function(){
    include('view/admin.php');
});

route('/map', function(){
    include('view/map.php');
});


route('/booking\?id=(\d+)', function(){
    include('view/booking.php');
});

route('/booking2\?id=(\d+)', function(){
    include('view/futureBooking.php');
});


route('/logout', function(){
    session_destroy();
    header("location: /");
});

$action = $_SERVER['REQUEST_URI'];
dispatch($action);