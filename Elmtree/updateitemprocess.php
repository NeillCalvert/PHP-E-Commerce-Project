<?php
session_start();
$userid = $_SESSION['40150199_id'];
include('conn.php');
 if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user']))){
   header('location: login.php');
 }

$itemid = $_POST['itemid'];

if(strlen(trim($_POST['itemname'])) > 0 && strlen(trim($_POST['itemname'])) < 256){
  $name = trim($_POST['itemname']);
  } else{
  $errormessage = "Name not between 1 and 255 characters";
  }

if($_POST['itemprice'] > 0 && $_POST['itemprice'] < 1000000){
  $price = trim($_POST['itemprice']);
  } else{
  $errormessage = "Item price must be between 1 and 1000000";
  }

if(strlen(trim($_POST['itemcondition'])) > 0 && strlen(trim($_POST['itemcondition'])) < 256){
  $condition = trim($_POST['itemcondition']);
  } else{
  $errormessage = "Item condition must be between 1 and 255";
  }

if(strlen(trim($_POST['itemdescription'])) > 0 && strlen(trim($_POST['itemdescription'])) < 801){
  $description = trim($_POST['itemdescription']);
  } else{
  $errormessage = "Item description must be between 1 and 800";
  }

if(!isset($errormessage)){
//Item picture
$ran = rand(10, 1000000);
$uploadname = $_FILES['marketplaceimage']['name'];


if(!empty($uploadname) && (pathinfo($uploadname, PATHINFO_EXTENSION)) == "jpg" || pathinfo($uploadname, PATHINFO_EXTENSION) == "png" || pathinfo($uploadname, PATHINFO_EXTENSION) == "jpeg"){
  $uploadname = $ran.$uploadname;
  $temp = $_FILES['marketplaceimage']['tmp_name'];
//Upload the file
move_uploaded_file($temp, "marketplaceimages/".$uploadname);

$updateQuery = "UPDATE marketplace SET name = '$name', price = '$price', itemcondition = '$condition', imagepath = '$uploadname', description = '$description' WHERE marketplaceid = '$itemid'";

$update = $conn->query($updateQuery);
} else{
$updateQuery = "UPDATE marketplace SET name = '$name', price = '$price', itemcondition = '$condition', description = '$description' WHERE marketplaceid = '$itemid'";
}

$update = $conn->query($updateQuery);
if($update){
  header("Location: youraccount.php");
} else{
  echo "Something went wrong there";
  echo $conn->error;
}
} else{
    echo"<h3 style='red'>$errormessage</h3>";
}
?>
