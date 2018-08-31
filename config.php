<?php

function OpenCon() {
    $servername = "localhost";
    $username = "techmarb_student";
    $password = "c[7G}V+CKaye";
    $dbname = "techmarb_student";

// Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
