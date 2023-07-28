<?php
  function connection() {
    $server_name = "localhost"; // MAMP or XAMPP
    $username = "root"; // Default root
    $password = ""; // Default is empty in XAMPP, in MAMP: 'root'
    $db_name = "minimart_catalog";

    // create the connection
    $conn = new mysqli($server_name, $username, $password, $db_name);
    // $conn - holds the connection
    // $conn - is a object
    // mysqli - is a class file (it contains different functions and variables inside)
  
    // check the connection
    if ($conn->connect_error) {
      // There is an error
      die("Connection failed: " . $conn->connect_error);
      // die() -> will terminate the current script
    } else {
      // No Error in the connection
      return $conn;
    }
    // -> the arrow is what we call an object operator, the object is on the left
    // connect_error contains the string value of the error
  }
?>