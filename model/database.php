<?php
    $database = 'mysql:host=localhost;dbname=carshare';
    $username = 'root';

    try {
        $db = new PDO($database, $username);
    } catch (PDOException $e) {
        $error = $e->getMessage();
        #include('view/error.php');
        exit();
    }