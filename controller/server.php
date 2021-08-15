<?php
session_start();


$action = filter_input(INPUT_POST, 'post', FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
}


if ($action === "login"){
    echo "else";
} else if($action === "register"){
    echo "register";
}