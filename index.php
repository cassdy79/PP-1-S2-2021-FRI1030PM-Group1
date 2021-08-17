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

route('/logout', function(){
    session_destroy();
    header("location: /");
});

$action = $_SERVER['REQUEST_URI'];
dispatch($action);