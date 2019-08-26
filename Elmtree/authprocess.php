<?php
session_start();

include('conn.php');

// Sanitise the data from sql injections
$loginPassword = $conn->real_escape_string($_POST['loginpassword']);
$loginEmail = $conn->real_escape_string(trim($_POST['loginemail']));

//This query is case sensitive in the database meaning the user input password must be exactly the same as the database
$checkuser = "SELECT * FROM users WHERE email = '$loginEmail' AND password = AES_ENCRYPT('$loginPassword', 'mykey')";

$result = $conn->query($checkuser);

if($result->num_rows > 0){

  while($row = $result->fetch_assoc()){

    $myuser = $row['firstname'];
    $myid = $row['userid'];
    $myfirstname = $row['firstname'];
    $mylastname = $row['lastname'];
    $mytelephone = $row['telephone'];
    $adminstatus = $row['adminstatus'];

// Creation of session data from the database that gives the page state
    $_SESSION['40150199_user'] = $myuser;
    $_SESSION['40150199_id'] = $myid;
    $_SESSION['40150199_firstname'] = $myfirstname;
    $_SESSION['40150199_lastname'] = $mylastname;
    $_SESSION['40150199_adminstatus'] = $adminstatus;
  }

//Redirect to the account page that requires the session data
  header('location: youraccount.php');

} else{

//else redirect to the login page with a suitable error message
  $message = "Username or Password Incorrect";
  header("location: login.php?message='$message'");

}
 ?>
