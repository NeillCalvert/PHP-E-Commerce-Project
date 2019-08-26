<?php
session_start();
include('conn.php');
if(isset($_SESSION['40150199_user'])){
  header('location: youraccount.php');
}
//Self processing page!

//Sql for learning institute selection
$instituteQuery = "SELECT * FROM learninginstitute";
$selectInstitute = $conn->query($instituteQuery);


//Number of errors flag for validation
$numberOfErrors = 0;

//Make sure request method is post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  //Make sure confirm password matches password
  if($_POST['password'] == $_POST['confirmpassword']){

    //User details and Prevention of sql injections using real_escape-string
    $firstName = $conn->real_escape_string(trim($_POST['firstname']));
    $lastName = $conn->real_escape_string(trim($_POST['lastname']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $telephone = $conn->real_escape_string(trim($_POST['telephone']));
    $learningInstituteQueryData = $conn->real_escape_string(trim($_POST['instituteOption']));
    $password = $conn->real_escape_string(trim($_POST['password']));

    //Find the correct learning institute
    $learningInstituteQuery = "SELECT learninginstituteid FROM learninginstitute WHERE institutename = '$learningInstituteQueryData'";
    $learningInstituteResult = $conn->query($learningInstituteQuery);

    while($instituterow=$learningInstituteResult->fetch_assoc()){
      $learningInstituteid = $instituterow['learninginstituteid'];
    }
  } else{
    $confirmPasswordMessage = "Passwords do not match";
    $numberOfErrors++;
  }
    //Validate email
    if(isset($email, $firstName, $lastName, $telephone, $learningInstituteid, $password)){

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $emailErrorMessage = "Please use an email";
      $numberOfErrors++;
    } else{
      $usersQuery = "SELECT * FROM users WHERE email = '$email'";
      $findUsers = $conn->query($usersQuery);
      $userCheck = $findUsers->num_rows;
      if($userCheck > 0){
        $emailErrorMessage = "This email has been taken";
        $numberOfErrors++;
      }
      if(strlen($firstName) > 255){
        $firstNameErrorMessage = "First Name Too Long";
        $numberOfErrors++;
      }
      if(strlen($lastName) > 255){
        $lastNameErrorMessage = "Last Name Too Long";
        $numberOfErrors++;
      }
      if($_POST['password'] !== $_POST['confirmpassword']){
          $confirmPasswordMessage = "Passwords do not match";
          $numberOfErrors++;
      }
    }
  }

    if($numberOfErrors == 0){

    //Profile picture
    $ran = rand(10, 1000000);
    $uploadname = $_FILES['profilepicpath']['name'];

    //If the user does not add a profile picture gives them a default one
    if(isset($uploadname) && !empty($uploadname)){
    $uploadname = $ran.$uploadname;
    $temp = $_FILES['profilepicpath']['tmp_name'];

    //Upload the file
    move_uploaded_file($temp, "profilepics/".$uploadname);
  }else{
    $uploadname = "defaultprofilepic.jpg";
  }
    //Sql query
    $query = "INSERT INTO users (firstname, lastname, email, profilepicpath, learninginstituteid, telephone, password) VALUE ('$firstName', '$lastName', '$email', '$uploadname', '$learningInstituteid', '$telephone', AES_ENCRYPT('$password', 'mykey'))";

    $insert = $conn->query($query);

    if($insert){
      $message="Now you have created an account please login";
      header("Location: login.php?message='$message'");
    } else{
      echo "Something went wrong there";
    }
   }
 }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet"href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link rel="stylesheet" href="style/gui.css">
  <title>ElmTree</title>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <!--Start of NavBar-->
  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-danger p-4">
        <h3 class="text-white">What are you looking for?</h3>
      <a class="nav-item nav-link text-light" href="index.php"><h5>Home</h5></a>
      <a class="nav-item nav-link active text-secondary" href="#"><h5>Register</h5><span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link text-light" href="login.php"><h5>Login</h5></a>
      <a class="nav-item nav-link text-light" href="marketplace.php" tabindex="-1" aria-disabled="true"><h5>MarketPlace</h5></a>

      </div>
    </div>
    <nav class="navbar navbar-dark bg-danger navbarheight">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

       <a class="navbar-brand" href="index.php"><h1>E</h1></a>
    </nav>
  </div>
<!--End of Navbar-->

<!--Start of main content-->
<div class="container">

  <hr />
  <div class="row">
    <div class="col-sm">
      <h1 class="text-danger">Create a new account</h1>
      <h4 class="text-danger">It's free and always will be.</h4>
    </div>
  </div>
<!--Start of form-->
  <form class="form" method="POST" action="" enctype="multipart/form-data">
<!--firstname-->
    <div class="form-row">
      <div class="form-group col-sm-6">
        <input type="text" class="form-control form-control-lg" placeholder="First Name" name="firstname" required>
      </div>
      <div class="form-group col-sm-6">
        <input type="text" minlength="0" maxlength="255" max class="form-control form-control-lg" placeholder="Last Name" name="lastname" required>
      </div>
    </div>
<!--Email-->
    <div class="form-row">
      <div class="form-group col-sm-12">
        <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" required>
        <?php
          if(isset($emailErrorMessage)){
            echo"<p class='text-danger'>$emailErrorMessage</p>";
          }
         ?>
      </div>
    </div>
<!--PhoneNumber-->
<div class="form-row">
  <div class="form-group col-sm-12">
    <input type="number" min="00000000000" max="99999999999" class="form-control form-control-lg" placeholder="Telephone" name="telephone" required>
  </div>
</div>
<!--Learning Institute-->
<div class="form-row">
  <div class="form-group col-sm-6">
    <select class="custom-select sm-6" style="width:auto;" name="instituteOption" required>
      <?php
      while($instituteSelect = $selectInstitute->fetch_assoc()){
        $insituteoption = $instituteSelect['institutename'];
        echo"<option>$insituteoption</option>";
      }
      ?>
    </select>
    </div>
  </div>
<!--password-->
    <div class="form-row">
      <div class="form-group col-sm-6 input-group">
        <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password" data-toggle="password" required>
        <div class="input-group-append">
          <span class="input-group-text">
          <i class="fa fa-eye"></i>
          </span>
        </div>
      </div>
    </div>
<!--Confirm Password-->
<div class="form-row">
  <div class="form-group col-sm-6 input-group">
    <input type="password" class="form-control form-control-lg" id="confirmpassword" data-toggle="password" placeholder="Confirm Password" name="confirmpassword" required>
    <div class="input-group-append">
      <span class="input-group-text">
      <i class="fa fa-eye"></i>
      </span>
    </div>
    <?php
      if(isset($confirmPasswordMessage)){
        echo"<br><p class='text-danger'>$confirmPasswordMessage</p>";
      }
     ?>
  </div>
</div>
<!--Profile Picture-->
    <div class="custom-file col-sm-4">
        <input type="file" class="form-control custom-file-input" name="profilepicpath" id="customFile">
        <label class="custom-file-label form-control-lg" for="customFile">Profile Picture</label>
    </div>
<!--Terms and Conditions-->
<br>
<br>
    <div class="form-row">
      <div class="form-group col-sm-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="customCheck1">
          <label class="custom-control-label" for="customCheck1">I Accept Terms and Conditions</label required>
        </div>
      </div>
     </div>

     <div class="form-row">
       <div class="form-group col-sm-4">
         <input type="submit" class="btn btn-danger" value="Register">
       </div>
     </div>

  </form>
  <!--End of form-->
  <div class="row">
    <div class="col-sm">
      <a class="text-danger" href="login.php">Already have an account? Log in</a>
    </div>
  </div>
  <!--Start of footer-->
  <footer class="page-footer font-small bg-light">
    <hr />
    <div class="row">
      <div class="col-sm-4">
        <h4>About Us</h4>
        <p>We are a small company created by students at Queen's University Belfast who are passionate about video games.</p>
        <p>We hope to satisfy the needs of gamers, geeks and nerds across Queen's by providing a common area from which to buy and sell video games</p>
      </div>
      <div class="col-sm-4">
        <h4>Terms of Service</h4>
        <p>All sales are made by the individual and not elmtree</p>
        <p>Elmtree will not take responsibility for loss of possessions or items that did not arrive</p>
      </div>
      <div class="col-sm-4">
        <h4>Help & Contact</h4>
        <p>Telephone: 02892637</p>
        <p>Email: help@elmtree.com</p>
        <p>
      </div>
    </div>
  </footer>
  <!--End of footer-->

</div>
<!--End of main content-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script  src="/path/to/bootstrap-show-password.js"></script>
</body>

</html>
