<?php
session_start();
include('conn.php');
if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user']))){
  header('location: login.php');
}
$itemid = $_GET['itemid'];

//Query for details
$itemQuery = "SELECT * FROM marketplace WHERE marketplaceid = '$itemid'";
$yourItem = $conn->query($itemQuery);
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
      <a class="nav-item nav-link text-light" href="logout.php"><h5>Logout</h5><span class="sr-only">(current)</span></a>
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
      <h1 class="text-danger">Edit Item Details</h1>
    </div>
  </div>

  <?php
    while($row=$yourItem->fetch_assoc()){
      $name = $row['name'];
      $price = $row['price'];
      $itemCondition = $row['itemcondition'];
      $description = $row['description'];
      $imagePath = $row['imagepath'];
    }
   ?>

<!--Start of edit item form -->
<form class="form" method="POST" action="updateitemprocess.php" enctype="multipart/form-data">
  <!-- Item name -->
  <div class="form-row">
    <div class="form-group col-sm-6">

      <?php
      echo"<input type='text' class='form-control form-control-lg' placeholder='Item Name' name='itemname' value='$name' required>";
      ?>

    </div>

    <!--Price-->
    <div class="form-group col-sm-6">

      <?php
      echo"<input type='number' step='0.01' min='0.01' class='form-control form-control-lg' placeholder='Price in £' name='itemprice' value='$price' required>";
      ?>

    </div>
  </div>

  <!--Item condition-->
  <div class="form-row">
    <div class="form-group col-sm-6">

      <?php
      echo"<textarea type='text' class='form-control form-control-lg' placeholder='Item Condition' name='itemcondition' required>$itemCondition</textarea>";
      ?>

    </div>

  <!--Item picture -->
  <div class="form-group col-sm-6">

      <?php
        echo"<input type='file' class='form-control custom-file-input' placeholder='Item Picture' name='marketplaceimage' accept='image/jpg, image/jpeg, image/png' id='customFile' >";
      ?>

      <label class="custom-file-label form-control-lg" for="customFile">Item Picture</label>
      </div>
  </div>

  <!--Item description-->
  <div class="form-row">
    <div class="form-group col-sm-6">

      <?php
      echo"<textarea type='text' class='form-control form-control-lg' placeholder='Item Description' name='itemdescription' required>$description</textarea>";
      ?>

    </div>
  </div>

  <?php
    echo"<input type='hidden' value='$itemid' name='itemid'>";
   ?>

  <input type="submit" class="btn btn-danger" value="Update Item">
</form>

  <!--End of form-->

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
