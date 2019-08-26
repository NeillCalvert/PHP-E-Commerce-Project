<?php
session_start();
include('conn.php');
$user = $_SESSION['40150199_user'];
$userid = $_SESSION['40150199_id'];
$adminstatus = $_SESSION['40150199_adminstatus'];
if(!isset($_SESSION['40150199_user']) || (empty($_SESSION['40150199_user']))){
  header('location: login.php');
}
//Query for user purchased items
$purchasedItemsQuery = "SELECT * FROM marketplace INNER JOIN consoles ON marketplace.consoleid = consoles.consoleid INNER JOIN itemstatus ON marketplace.statusid = itemstatus.itemstatusid INNER JOIN users ON marketplace.buyeremail = users.email WHERE userid  = '$userid' ORDER BY postdate DESC";
$yourPurchasedItems = $conn->query($purchasedItemsQuery);

//Query for user sale items
$yourItemsQuery = "SELECT * FROM marketplace INNER JOIN consoles ON marketplace.consoleid = consoles.consoleid INNER JOIN itemstatus ON marketplace.statusid = itemstatus.itemstatusid WHERE sellerid = '$userid' ORDER BY postdate DESC";
$yourItems = $conn->query($yourItemsQuery);

//Query for details
$yourDetailsQuery = "SELECT * FROM users INNER JOIN learninginstitute ON users.learninginstituteid = learninginstitute.learninginstituteid WHERE userid = '$userid'";
$yourDetails = $conn->query($yourDetailsQuery);

//Query for console selection form element
$consolequery = "SELECT * FROM consoles";
$selectconsole = $conn->query($consolequery);

//Query for Seller rating
$ratingQuery = "SELECT COUNT(marketplaceid) as total FROM marketplace WHERE statusid = '2' AND sellerid = '$userid'";
$numberOfSales = $conn->query($ratingQuery);

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
      <a class="nav-item nav-link active text-secondary" href="#"><h5>Your Account</h5><span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link text-light" href="logout.php"><h5>Logout</h5><span class="sr-only">(current)</span></a>
      <?php
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
    <hr />
    <div class="row">
      <div class="col-sm">
        <h2 class="text-danger">Your Account</h2>
      </div>
    </div>
    <br>
  <div class='row text-danger'>
      <div class='col-sm-12'>
        <nav>
          <div class='nav nav-tabs' id='nav-tab' role='tablist'>
            <a class='nav-item nav-link text-danger' id='nav-purchased-tab' data-toggle='tab' href='#nav-purchased' role='tab' aria-controls='nav-purchased' aria-selected='true'>Your Purchased Items</a>
            <a class='nav-item nav-link active text-danger' id='nav-home-tab' data-toggle='tab' href='#nav-home' role='tab' aria-controls='nav-home' aria-selected='true'>Your Sale Items</a>
            <a class='nav-item nav-link text-danger' id='nav-profile-tab' data-toggle='tab' href='#nav-profile' role='tab' aria-controls='nav-profile' aria-selected='false'>Your Details</a>
            <a class='nav-item nav-link text-danger' id='nav-contact-tab' data-toggle='tab' href='#nav-contact' role='tab' aria-controls='nav-contact' aria-selected='false'>Add an Item</a>
          </div>
        </nav>
          <div class='tab-content' id='nav-tabContent'>
            <div class='tab-pane fade' id='nav-purchased' role='tabpanel' aria-labelledby='nav-purchased-tab'>
              <?php
              if($yourPurchasedItems->num_rows > 0){
              while($row=$yourPurchasedItems->fetch_assoc()){
                $itemname=$row['name'];
                $price=$row['price'];
                $itemcondition=$row['itemcondition'];
                $status=$row['status'];
                $imagepath=$row['imagepath'];
                $console=$row['consolename'];
                $description=$row['description'];
                $itemid=$row['marketplaceid'];
                $olddatesold=$row['datesold'];
                $datesold = date('d/m/Y', strtotime($olddatesold));

                echo  "<br>
                      <hr />
                       <div class='row text-dark'>
                         <div class='col-sm-7'>
                           <img class='detailsimage rounded' src='marketplaceimages/$imagepath'/>
                        </div>

                        <div class='col-sm-5'>
                           <hr />
                           <h4><strong class='text-danger'>Name: </strong>$itemname</h4>
                           <h4><strong class='text-danger'>Price: </strong>£$price</h4>
                           <h4><strong class='text-danger'>Status: </strong>$status</h4>
                           <h4><strong class='text-danger'>Console: </strong>$console</h4>
                           <h4><strong class='text-danger'>Date Purchased: </strong>$datesold</h4>
                           <hr />

                         </div>
                       </div>
                       <br>
                       <hr />
                       <div class='row'>
                        <div class='col-sm-7 text-dark'>
                          <h4 class='text-danger'>Item Description: </h4>$description
                          <br>
                          <br>
                          <h4 class='text-danger'>Item Condition: </h4>$itemcondition
                        </hr>
                        </div>
                        </div>";


              }
            } else{
            echo "<br>
                  <br>
                  <h4>Looks like you haven't bought anything</h4>";
            }
              ?>
            </div>
            <div class='tab-pane fade show active' id='nav-home' role='tabpanel' aria-labelledby='nav-home-tab'>
              <?php
              if($yourItems->num_rows > 0){
              while($row=$yourItems->fetch_assoc()){
                $itemname=$row['name'];
                $price=$row['price'];
                $itemcondition=$row['itemcondition'];
                $status=$row['status'];
                $imagepath=$row['imagepath'];
                $olddate=$row['postdate'];
                $postdate=date('d/m/Y', strtotime($olddate));
                $console=$row['consolename'];
                $description=$row['description'];
                $itemid=$row['marketplaceid'];

                echo  "<br>
                      <hr />
                       <div class='row text-dark'>
                         <div class='col-sm-7'>
                           <img class='detailsimage rounded' src='marketplaceimages/$imagepath'/>
                        </div>

                        <div class='col-sm-5'>
                           <hr />
                           <h4><strong class='text-danger'>Name: </strong>$itemname</h4>
                           <h4><strong class='text-danger'>Price: </strong>£$price</h4>
                           <h4><strong class='text-danger'>Status: </strong>$status</h4>
                           <h4><strong class='text-danger'>Console: </strong>$console</h4>
                           <h4><strong class='text-danger'>Posted: </strong>$postdate</h4>
                           <hr />";
                        if($status == 'For Sale'){
                      echo"
                           <a class='btn btn-danger' href = 'deleteitem.php?itemid=$itemid'>Delete Item</a>
                           <a class='btn btn-danger' href = 'updateitem.php?itemid=$itemid'>Edit Item</a>
                           <a class='btn btn-danger' href = 'sellitem.php?itemid=$itemid'>Mark As Sold</a>";
                         }
          echo         "</div>
                       </div>
                       <br>
                       <hr />
                       <div class='row'>
                        <div class='col-sm-7 text-dark'>
                          <h4 class='text-danger'>Item Description: </h4>$description
                          <br>
                          <br>
                          <h4 class='text-danger'>Item Condition: </h4>$itemcondition
                        </hr>
                        </div>
                      </div>";

              }
            } else{
              echo "<br>
                    <br>
                    <h4>Looks like you haven't put anything up for sale</h4>";
            }
              ?>
            </div>
            <div class='tab-pane fade' id='nav-profile' role='tabpanel' aria-labelledby='nav-profile-tab'>
              <?php
                while($row=$yourDetails->fetch_assoc()){
                  $firstname = $row['firstname'];
                  $lastname = $row['lastname'];
                  $email = $row['email'];
                  $telephone = $row['telephone'];
                  $profpic = $row['profilepicpath'];
                  $learningInstitute = $row['institutename'];

                  echo"<br>

                         <div class='row text-dark'>
                          <div class='col-sm-6'>
                             <hr />
                             <h4><strong class='text-danger'>Name: </strong>$firstname $lastname</h4>
                             <h4><strong class='text-danger'>Email: </strong>$email</h4>
                             <h4><strong class='text-danger'>Telephone: </strong>$telephone</h4>
                             <h4><strong class='text-danger'>LearningInstitute: </strong>$learningInstitute</h4>";
                             $salesalias = $numberOfSales->fetch_assoc();
                             $sales = $salesalias['total'];
                             if($sales <= 5){
                               $sellerstatus = "Beginner Trader";
                             } elseif($sales > 5 && $sales < 10 ){
                               $sellerstatus = "Experienced Trader";
                             } else{
                               $sellerstatus = "Master Trader";
                             }
                               echo"<h4><strong class='text-danger'>Total Sales: </strong>$sales</h4>
                                    <h4><strong class='text-danger'>Rating: </strong>$sellerstatus</h4>";

                      echo"</div>
                           <div class='col-sm-6'>
                             <img class='detailsimage rounded' src='profilepics/$profpic'/>
                          </div>
                         </div>";


                 echo"<br>
                        <a class='btn btn-danger' href='updateaccountdetails.php?accountholderid=$userid'>Update Details</a>";
                }

               ?>
            </div>
            <div class='tab-pane fade' id='nav-contact' role='tabpanel' aria-labelledby='nav-contact-tab'>
              <h3 class="text-danger">Add an Item</h1>
                <!--Start of add item form -->
                <form class="form" method="POST" action="processitem.php" enctype="multipart/form-data">
                  <!-- Item name -->
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <input type="text" maxlength="255" minlength="1" class="form-control form-control-lg" placeholder="Item Name (255 characters max)" name="itemname" required>
                    </div>
                  <!--Console-->
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <select class="custom-select sm-6" style="width:auto;" name="itemconsole" required>
                        <?php
                        while($consoleselect = $selectconsole->fetch_assoc()){
                          $consoleoption = $consoleselect['consolename'];
                          echo"<option>$consoleoption</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                    <!--Price-->
                    <div class="form-group col-sm-6">
                      <input type="number" step="0.01" min="0.01" class="form-control form-control-lg" placeholder="Price in £" name="itemprice" required>
                    </div>
                  </div>
                  <!--Item condition-->
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <textarea type="text" maxlength="255" minlength="1" class="form-control form-control-lg" placeholder="Item Condition (255 characters max)" name="itemcondition" required></textarea>
                    </div>
                  <!--Item picture -->
                  <div class="form-group col-sm-6">
                        <input type="file" class="form-control custom-file-input" placeholder="Item Picture" name="marketplaceimage" accept="image/jpg, image/jpeg, image/png" id="customFile">
                        <label class="custom-file-label form-control-lg" for="customFile">Item Picture</label>
                      </div>
                    </div>
                  <!--Item description-->
                  <div class="form-row">
                    <div class="form-group col-sm-6">
                      <textarea type="text" maxlength="800" minlength="1" class="form-control form-control-lg" placeholder="Item Description (800 characters max)" name="itemdescription" required></textarea>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-danger" value="Add Item">
                </form>
              </div>
            </div>
          </div>
        </div>
<br>

<?php
  if(isset($_GET['errormessage'])){
    $errormessage=$_GET['errormessage'];
    echo"<h2 class='text-danger'>$errormessage</h2>";
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
