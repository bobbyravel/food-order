<?php 
    // Start Session
    session_start();

    // Create Constants to Store Non Restoring Values
    define("SITEURL", "http://localhost/food-order/");
    define("LOCALHOST", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "food-order");

    // Execute query and save data in database
    // $conn = mysqli_connect("localhost", "username", "password") or die(mysqli_error()); // username and password for DB admin
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    // $db_select = mysqli_select_db($conn, "DBNAME") or die(mysqli_error());  //Selecting Database
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
?>