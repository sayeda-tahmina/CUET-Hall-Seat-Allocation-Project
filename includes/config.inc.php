<?php
  session_start();
  $servername = "localhost:3306"; //change this  accordingly
  $dBUsername = "";
  $dBPassword = "";
  $dBName = "hostel_management_system";
 // session_start();
  $conn=mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

  if (!$conn) {
    die("Connection Failed: ".mysqli_connect_error());
  }
?>
