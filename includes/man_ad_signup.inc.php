<?php

if (isset($_POST['signup-submit'])) {

  require 'config.inc.php';

  $hostel_man_id = $_POST['Hostel_man_id'];
  $username = $_POST['Username'];
  $fname = $_POST['Fname'];
  $lname = $_POST['Lname'];
  $mob_no = $_POST['Mob_no'];
  $hostel_id = $_POST['Hostel_id'];
  $password = $_POST['pwd'];
  $isadmin= $_POST['Isadmin'];


  if(!preg_match("/^[a-zA-Z0-9]*$/",$hostel_man_id)){
    header("Location: ../man_ad_signup.php?error=invaliid");
    exit();
  }
  else {

    $sql = "SELECT Hostel_man_id FROM Hostel_Manager WHERE Hostel_man_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
      header("Location: ../man_ad_signup.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $hostel_man_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        header("Location: ../man_ad_signup.php?error=userexists");
        exit();
      }
      else {
        $sql = "INSERT INTO Hostel_Manager (Hostel_man_id, Username, Fname, Lname, Mob_no, Hostel_id, Pwd, Isadmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
          header("Location: ../man_ad_signup.php?error=sqlerror");
          exit();
        }
        else {

          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

          mysqli_stmt_bind_param($stmt, "ssssssss",$hostel_man_id, $username, $fname, $lname, $mob_no, $hostel_id, $hashedPwd, $isadmin);
          mysqli_stmt_execute($stmt);
          if ($isadmin == 1) {
            header("Location: ../admin/admin_home.php?signup=success");
          } 
          else {
           header("Location: ../home_manager.php?signup=success");
          }
          header("Location: ../admin/admin_home.php?signup=success");
          exit();
        }
      }
    }

  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

}
else {
  header("Location: ../man_ad_signup.php");
  exit();
}
