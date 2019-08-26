<?php
session_start();
include('conn.php');
$userid = $_SESSION['40150199_id'];


//Add an item
if(strlen($_POST['itemname']) > 0 && strlen($_POST['itemname']) < 256){
$itemname = $conn->real_escape_string(trim($_POST['itemname']));
} else{
  $errormessage = "Item Name not between 1 and 255 characters";
}


$itemprice = $conn->real_escape_string(trim($_POST['itemprice']));


if(strlen($_POST['itemcondition']) > 0 && strlen($_POST['itemcondition']) < 256){
$itemcondition = $conn->real_escape_string(trim($_POST['itemcondition']));
} else{
  $errormessage = "Item condition not between 1 and 255 ";
}

if(strlen($_POST['itemdescription']) > 0 && strlen($_POST['itemdescription']) < 801){
$itemdescription = $conn->real_escape_string(trim($_POST['itemdescription']));
} else{
  $errormessage = "Item description not between 1 and 800";
}

if(!isset($errormessage)){

$date = date('Y-m-d H:i:s');

$console = $_POST['itemconsole'];

$consoleidquery = "SELECT consoleid FROM consoles WHERE consolename = '$console'";
$result = $conn->query($consoleidquery);

while($row=$result->fetch_assoc()){
  $consoleid = $row['consoleid'];
}
//Item picture
$ran = rand(10, 1000000);
$uploadname = $_FILES['marketplaceimage']['name'];

//If photo is uploaded add this to the file else then use default photo
if(isset($uploadname) && !empty($uploadname) && (pathinfo($uploadname, PATHINFO_EXTENSION)) == "jpg" || pathinfo($uploadname, PATHINFO_EXTENSION) == "png" || pathinfo($uploadname, PATHINFO_EXTENSION) == "jpeg"){
$uploadname = $ran.$uploadname;
$temp = $_FILES['marketplaceimage']['tmp_name'];

//Upload the file
move_uploaded_file($temp, "marketplaceimages/".$uploadname);
} else{
$uploadname = "defaultmarketplaceimg.png";
}
//Sql query
$query = "INSERT INTO marketplace (name, consoleid, price, itemcondition, description, statusid, imagepath, postdate, sellerid) VALUES ('$itemname', '$consoleid', '$itemprice', '$itemcondition', '$itemdescription', '1', '$uploadname', '$date', '$userid')";

$insert = $conn->query($query);

if($insert){
  header("Location: login.php");
} else{
 echo $conn->error;
}
} else{
  header("Location: youraccount.php?errormessage=$errormessage");
}
?>
