<?php
session_start();
include('conn.php');

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
      <a class="nav-item nav-link active text-secondary" href="#"><h5>Home</h5> <span class="sr-only">(current)</span></a>
      <?php
      if(!isset($_SESSION['40150199_user'])){
      echo "<a class='nav-item nav-link text-light' href='register.php'><h5>Register</h5></a>";
      echo "<a class='nav-item nav-link text-light' href='login.php'><h5>Login</h5></a>";
      }
      ?>
      <a class="nav-item nav-link text-light" href="marketplace.php" tabindex="-1" aria-disabled="true"><h5>MarketPlace</h5></a>
      <?php
      if(isset($_SESSION['40150199_user'])){
        echo"<a class='nav-item nav-link text-light' href='youraccount.php'><h5>Your Account</h5></a>
         <a class='nav-item nav-link text-light' href='logout.php'><h5>Logout</h5><span class='sr-only'>(current)</span></a>";
      }
      if(isset($_SESSION['40150199_adminstatus']) && $_SESSION['40150199_adminstatus']==1){
        echo"<a class='nav-item nav-link text-light' href='admin.php'><h5>Admin Page</h5></a>";
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
  <div class="row">
    <div class="col-sm">
      <h2 class=" bg-danger text-light display-3 myfont">ELMTREE</h2>
    </div>
  </div>
<br>
    <div class="row">
      <div class="col-sm">
        <h2 class="text-danger mywordstyle">Welcome to the Hub of Geeks and Gamers</h2>
      </div>
    </div>
    <br>
    <hr />
  <!--Start of Carousel by bootstrap-->
  <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="carousel/queens.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="carousel/play.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="carousel/win.jpg" alt="Third slide">
    </div>
  </div>
</div>
<!--End of carousel-->

<br>
<hr />
<br>
  <div class="row">
    <div class="col-sm">
  <h2 class="mywordstyle text-danger"><a class="mywordstyle text-danger" href="login.php">Login</a> or <a class="mywordstyle text-danger" href="register.php">Register</a> Then Select Your Games Console Below To View Our Video Games For Your Console</h2>
    </div>
  </div>

  <br>
  <hr />
  <div class="row">
    <div class="col-sm imagewidth mywordstyle">
      <img src="img/ps4.jpg">
       <a href="marketplacecategory.php?categoryid=1" class="btn btn-primary btn-lg btn-block">Playstation</a>
    </div>
  </div>

  <div class="row">
    <div class="col-sm imagewidth mywordstyle">
      <img src="img/xbox.jpg">
       <a href="marketplacecategory.php?categoryid=2" class="btn btn-success btn-lg btn-block">XBOX</a>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm imagewidth mywordstyle">
      <img src="img/pc.jpg">
       <a href="marketplacecategory.php?categoryid=3" class="btn btn-secondary btn-lg btn-block">PC</a>
    </div>
  </div>

<br>

<br>
<hr />
<br>
  <div class="row">
    <div class="col-sm">
  <h2 class="mywordstyle text-danger"> Or Visit The <a class="mywordstyle text-danger" href="marketplace.php">MarketPlace</a> to See Our Full Range of Pre-Loved Games</h2>
    </div>
  </div>

  <br>
  <hr />
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
</body>

</html>
