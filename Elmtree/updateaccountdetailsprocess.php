<?php
session_start();
$userid = $_SESSION['40150199_id'];
include('conn.php');
 if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user']))){
   header('location: login.php');
 }

if(strlen(trim($_POST['firstname'])) > 0 && strlen(trim($_POST['firstname'])) < 256){
  $firstName = $conn->real_escape_string($_POST['firstname']);
  } else{
  $errormessage = "First Name must be between 1 and 255 characters";
  }

if(strlen(trim($_POST['lastname'])) > 0 && strlen(trim($_POST['lastname'])) < 256){
  $lastName = $conn->real_escape_string($_POST['lastname']);
} else{
  $errormessage = "Last Name must be between 1 and 255 characters";
}

$phoneNumber = $conn->real_escape_string($_POST['telephone']);

$accountholderid = $_POST['accountholderid'];

if(!isset($errormessage)){
$uploadname = $_FILES['profilepicpath']['name'];
$temp = $_FILES['profilepicpath']['tmp_name'];

if(!empty($uploadname) && (pathinfo($uploadname, PATHINFO_EXTENSION)) == "jpg" || pathinfo($uploadname, PATHINFO_EXTENSION) == "png" || pathinfo($uploadname, PATHINFO_EXTENSION) == "jpeg"){

  //Upload the file
  move_uploaded_file($temp, "profilepics/".$uploadname);

$updateQuery = "UPDATE users SET firstname = '$firstName', lastName = '$lastName', telephone = '$phoneNumber', profilepicpath='$uploadname' WHERE userid = '$accountholderid'";

} else{
  $updateQuery = "UPDATE users SET firstname = '$firstName', lastName = '$lastName', telephone = '$phoneNumber' WHERE userid = '$accountholderid'";
}

$update = $conn->query($updateQuery);

if($update){
  header("Location: youraccount.php");
} else{
  echo "Something went wrong there";
}
} else{
  echo"<h1>$errormessage</h1>";
}
 ?>
