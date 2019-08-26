<?php
session_start();
include('conn.php');
if(isset($_SESSION['40150199_user'])){
  $user = $_SESSION['40150199_user'];
  $userid = $_SESSION['40150199_id'];
  $adminstatus = $_SESSION['40150199_adminstatus'];
}

$query = "SELECT marketplace.marketplaceid,imagepath, name, price, itemstatus.status, firstname, consolename, postdate FROM marketplace INNER JOIN users ON marketplace.sellerid = users.userid INNER JOIN consoles ON marketplace.consoleid = consoles.consoleid INNER JOIN itemstatus ON marketplace.statusid = itemstatus.itemstatusid WHERE itemstatus.status = 'For Sale' ORDER BY postdate DESC";
$result = $conn->query($query);
$result2 = $conn->query("SELECT * FROM consoles");
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
          <?php
          if(!isset($_SESSION['40150199_user'])){
          echo "<a class='nav-item nav-link text-light' href='register.php'><h5>Register</h5></a>";
          echo "<a class='nav-item nav-link text-light' href='login.php'><h5>Login</h5></a>";
          }
          ?>
          <a class="nav-item nav-link active text-secondary" href="marketplace.php" tabindex="-1" aria-disabled="true"><h5>MarketPlace</h5><span class="sr-only">(current)</span></a>
          <?php
          if(isset($_SESSION['40150199_user'])){
            echo"<a class='nav-item nav-link text-light' href='youraccount.php'><h5>Your Account</h5></a>";
          }
            ?>

          <?php
          if(isset($_SESSION['40150199_user'])){
            echo" <a class='nav-item nav-link text-light' href='logout.php'><h5>Logout</h5><span class='sr-only'>(current)</span></a>";
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
    <!--Title-->
    <div class="row">
      <div class="col-sm">
        <?php
          if(!isset($adminstatus) || $adminstatus == 0){
            echo"<h2 class='bg-danger text-light display-5 myfont'>MarketPlace</h2>";
          } elseif($adminstatus == 1){
            echo"<h2 class='bg-danger text-light display-5 myfont'>Admin Marketplace</h2>";
          }
         ?>

      </div>
    </div>
  <br>
  <div class="row">
    <div class="col-sm">
      <h2 class="text-danger mywordstyle">Welcome to the Digital MarketPlace</h2>
    </div>
  </div>
  <br>
  <!--End of title-->
  <!--Start of Search bar-->
<div class='row'>
  <div class='col-sm-12'>
    <form action="marketplacesearch.php" method="POST">
      <input class='form-control' type='text' placeholder='Search' name='searchinput'>
      <br>
      <input type="submit" class="btn btn-danger btn-lg btn-block" value="Search">
    </form>
  </div>
</div>
  <!--End of search bar-->
  <hr />
  <!--Start of Filter-->
  <div class="dropdown show">
    <a class="btn btn-danger dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filters
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
      <?php
      while ($filterRow = $result2->fetch_assoc()){
        $category=$filterRow['consolename'];
        $categoryid=$filterRow['consoleid'];
      echo "<a class='dropdown-item' href='marketplacecategory.php?categoryid=$categoryid'>$category</a>";
      }
      ?>
    </div>
  </div>
  <!--End of Filter-->
  <!--Start of marketplace content-->
  <?php
     while ($row = $result->fetch_assoc()) {
         $name=$row['name'];
         $price=$row['price'];
         $status=$row['status'];
         $imagepath=$row['imagepath'];
         $olddate=$row['postdate'];
         $postdate=date('d/m/Y', strtotime($olddate));
         $console=$row['consolename'];
         $seller=$row['firstname'];
         $id=$row['marketplaceid'];

          echo "<hr />
                <div class='row text-dark'>
                  <div class='col-sm-6'>
                    <img class='marketplaceimage rounded' src='marketplaceimages/$imagepath'/>
                  </div>
                  <br>
                  <div class='col-sm-4'>
                    <h4 class='text-danger'><u>$name</u></h4>
                    <br>
                    <p><strong class='text-danger'>Console:</strong> $console</p>
                    <p><strong class='text-danger'>Price: </strong> £$price</p>
                    <p><strong class='text-danger'>Status: </strong> $status</p>
                    <p><strong class='text-danger'>Posted: </strong> $postdate</p>
                  </div>
                </div>
                <div class='row'>
                  <div class='col-sm-12'>";
                  if(isset($adminstatus) && $adminstatus == 1){

                    echo"<br><a class='btn btn-danger' style='float-left' href = 'deleteitem.php?itemid=$id'>Delete Item as admin</a>";
                  }
                  echo "<a class='btn btn-danger detailsbutton' href='details.php?item=$id'>Details</a>
                  </div>
                </div>
                <hr />";


     }
       ?>
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
