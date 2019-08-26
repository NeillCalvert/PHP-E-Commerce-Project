<?php
session_start();
include('conn.php');
$adminstatus = $_SESSION['40150199_adminstatus'];
$user = $_SESSION['40150199_user'];
$userid = $_SESSION['40150199_id'];

//If session variables don't exist and adminstatus is not correct kick them out
if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user'])) || $adminstatus ==0){
  header('location: login.php');
}

//Self processing page
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Validation that if certain form elements are completed then assign them to a variable
    if(!empty($_POST['learninginstituteaddition'])){
      $newInstitute = $conn->real_escape_string(trim($_POST['learninginstituteaddition']));
    }
    if(!empty($_POST['consoleaddition'])){
      $newConsole = $conn->real_escape_string(trim($_POST['consoleaddition']));
    }
    if(!empty($_POST['newadmin'])){
      $newAdmin = $conn->real_escape_string(trim($_POST['newadmin']));
    }
//New Institute is correct
  if(isset($newInstitute) && !empty($newInstitute)){
    $addInstituteQuery = "INSERT INTO learninginstitute (institutename) value ('$newInstitute')";
    $addInstitute = $conn->query($addInstituteQuery);
    //Validation that new institute is with 255 characters
    if($addInstitute && strlen($newInstitute) < 255 && strlen($newInstitute) > 0){
    $completemessage = "Institute Addition Complete";
  } else{
    $errormessage = "Institute Name Not Within Character Boundaries";
  }
}

  if(isset($newConsole) && !empty($newConsole)){

    $addConsoleQuery = "INSERT INTO consoles (consolename) value ('$newConsole')";
    $addConsole = $conn->query($addConsoleQuery);
    //Validation console name is within 255 characters
    if($addConsole && strlen($newConsole) < 255 && strlen($newConsole) > 0 ){
    $completemessage = "Console Addition Complete";
  } else{
    $errormessage = "Console Name Not Within Character Boundaries";
  }
}

if(isset($newAdmin) && !empty($newAdmin)){
  $findAllUserEmailsQuery = "SELECT * FROM users WHERE email = '$newAdmin'";
  $findEmails = $conn->query($findAllUserEmailsQuery);
  if($findEmails->num_rows > 0){
  $newAdminQuery = "UPDATE users SET adminstatus = '1' WHERE email = '$newAdmin'";
  $addNewAdmin = $conn->query($newAdminQuery);
  if($addNewAdmin){
  $completemessage = "Admin privileges granted to $newAdmin";
    }
   }else {
     $errormessage = "Email does not exist on system or admin privileges already granted";
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
      <a class="nav-item nav-link text-light" href="marketplace.php" tabindex="-1" aria-disabled="true"><h5>MarketPlace</h5></a>
      <a class="nav-item nav-link text-light" href="youraccount.php"><h5>Your Account</h5></a>
      <?php
      if(isset($_SESSION['40150199_user'])){
        echo" <a class='nav-item nav-link text-light' href='logout.php'><h5>Logout</h5><span class='sr-only'>(current)</span></a>";
      }
       ?>
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
  <br>
  <hr />
  <div class="row">
    <div class="col-sm">
  <?php
    echo"<h2 class='text-danger'>Welcome Admin: $user</h1>";
   ?>
    </div>
</div>
<!--Start of edit item form -->
<form class="form" method="POST" action="" enctype="multipart/form-data">
  <!-- Add a learning institute -->

      <div class="form-row">
        <div class="form-group col-sm-12">
          <input type="text" minlength="1" maxlength="255" class="form-control form-control-lg" placeholder="Learning Institute To Add" name="learninginstituteaddition" required>
        </div>
      </div>

  <input type="submit" class="btn btn-danger" value="Add Learning Institute">
</form>

<br>

<!--Add new console-->
<form class="form" method="POST" action="" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-sm-12">
      <input type="text" minlength="1" maxlength="255" class="form-control form-control-lg" placeholder="Console To Add" name="consoleaddition" required>
    </div>
  </div>
  <input type="submit" class="btn btn-danger" value="Add Console">
</form>

<br>

<!--Add new admin-->
<form class="form" method="POST" action="" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-sm-12">
      <input type="email" maxlength="255" class="form-control form-control-lg" placeholder="Add new Admin" name="newadmin" required>
    </div>
  </div>
  <input type="submit" class="btn btn-danger" value="Add new Admin">
</form>
  <!--End of form-->
<?php
  if(isset($errormessage)){
    echo"<h3 class='text-danger'>$errormessage</h3>";
  } elseif(isset($completemessage)){
    echo"<h3 class='text-success'>$completemessage</h3>";
  }
 ?>

</div>
<!--End of main content-->
</body>

</html>
