<?php
session_start();
include("conn.php");
//get admin session variable
$adminstatus = $_SESSION['40150199_adminstatus'];
//Get id
$itemid = $_GET['itemid'];
//Query to delete item
$deleteItemQuery = "DELETE FROM marketplace WHERE marketplaceid = '$itemid'";
$result = $conn->query($deleteItemQuery);

//If the delete has come from an admin redirect them to the marketplace else go to your accountholder
if($adminstatus==1){
header("location:marketplace.php");
} else{
header("Location: youraccount.php");
}
 ?>
