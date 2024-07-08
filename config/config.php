<?php

// if (!isset($_SERVER['HTTP_REFERER'])) {
//     //redirect them to your desired location
//     header('location: http://localhost/freshcery/index.php');
//     exit;
// }

$servername = "localhost";
$username = "root";
$password = "ranielle25";

try {
    //connect db
    $conn = new PDO("mysql:host=" . $servername . ";port=3307;dbname=freshcery", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
