<?php
  session_start(); // we need start to start the session
  session_unset(); // Unset the session variables that we have in login
  session_destroy(); // Delete or destroy all session variables

  header("location: login.php");
  exit;
?>
