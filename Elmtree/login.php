<?php
session_start();
include('conn.php');
if(isset($_SESSION['40150199_user'])){
  header('location: youraccount.php');
}

// If an error message has been sent from the authorisation page then echo this out to the user
if(isset($_GET['message'])){
  $message = $_GET['message'];
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
      <a class="nav-item nav-link text-light" href="register.php"><h5>Register</h5></a>
      <a class="nav-item nav-link active text-secondary" href="login.php"><h5>Login</h5><span class="sr-only">(current)</span></a>
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
      <h2 class="text-danger">Log in to Elmtree</h2>
    </div>
  </div>
  <br>

  <?php
    //If the error message is set display to the user
    if(isset($message)){
      echo"<h4 class='text-danger'>$message</h4>";
    }
   ?>
  <!--Start of form-->
  <form action='authprocess.php' method='POST'>
    <!--email-->
    <div class="form-row">
      <div class="form-group col-sm-6">
        <input type="text" class="form-control form-control-lg" placeholder="Email" name="loginemail" required>
      </div>
    </div>

    <!--password-->
    <div class="form-row">
      <div class="form-group col-sm-6">
        <input type="password" class="form-control form-control-lg" data-toggle="password" placeholder="Password" name="loginpassword" required>
      </div>
    </div>

    <!--Submit button-->
    <div class="form-row">
      <div class="form-group col-sm-6">
          <input type="submit" class="btn btn-danger" value="Login">
      </div>
    </div>
  </form>


<!--End of form-->
<div class="row">
  <div class="col-sm">
    <a class="text-danger" href="register.php">Sign up for Elmtree</a>
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
