<?php
session_start();
include('conn.php');
$itemid = $_GET['item'];
$query = "SELECT * FROM marketplace INNER JOIN users ON marketplace.sellerid = users.userid INNER JOIN consoles ON marketplace.consoleid = consoles.consoleid INNER JOIN itemstatus ON marketplace.statusid = itemstatus.itemstatusid WHERE marketplaceid = '$itemid'";
$result = $conn->query($query);


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
      <a class="nav-item nav-link text-light" href="login.php"><h5>Login</h5></a>
      <a class="nav-item nav-link active text-secondary" href="marketplace.php" tabindex="-1" aria-disabled="true"><h5>MarketPlace</h5><span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link text-light" href="youraccount.php"><h5>Your Account</h5></a>
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

<div class="container text-dark">
    <br>

  <!--Start of marketplace content-->
  <?php
     while ($row = $result->fetch_assoc()) {
         $name=$row['name'];
         $price=$row['price'];
         $itemcondition=$row['itemcondition'];
         $status=$row['status'];
         $imagepath=$row['imagepath'];
         $olddate=$row['postdate'];
         $postdate=date('d/m/Y', strtotime($olddate));
         $console=$row['consolename'];
         $seller=$row['firstname'];
         $sellerlastname=$row['lastname'];
         $id=$row['marketplaceid'];
         $description=$row['description'];
         $sellerphone=$row['telephone'];
         $sellerimage=$row['profilepicpath'];
         $sellerid=$row['sellerid'];

//Query to get seller Rating
        $ratingQuery = "SELECT COUNT(marketplaceid) as total FROM marketplace WHERE statusid = '2' AND sellerid = '$sellerid'";
        $numberOfSales = $conn->query($ratingQuery);
         echo "<div class='row'>
           <div class='col-sm'>
             <h2 class='bg-danger text-light display-5 myfont'>$name</h2>
           </div>
         </div>
       <br>
       <hr />";

        echo  "
               <div class='row text-dark'>
                 <div class='col-sm-7'>
                   <img class='detailsimage rounded' src='marketplaceimages/$imagepath'/>
                </div>

                <div class='col-sm-5'>
                   <hr />
                   <h4><strong class='text-danger'>Price: </strong>£$price</h4>
                   <h4><strong class='text-danger'>Status: </strong>$status</h4>
                   <h4><strong class='text-danger'>Console: </strong>$console</h4>
                   <h4><strong class='text-danger'>Posted: </strong>$postdate</h4>";

              echo"<hr />
                 </div>
               </div>";

          echo  "<div class='row text-danger'>
                  <div class='col-sm-12'>
                    <a class='btn btn-danger detailsbutton' href='marketplace.php'>Back</a>
                  </div>
                 </div>";

          echo "<div class='row text-danger'>
                    <div class='col-sm-12'><nav>
                  <div class='nav nav-tabs' id='nav-tab' role='tablist'>
                    <a class='nav-item nav-link active text-danger' id='nav-home-tab' data-toggle='tab' href='#nav-home' role='tab' aria-controls='nav-home' aria-selected='true'>Description</a>
                    <a class='nav-item nav-link text-danger' id='nav-profile-tab' data-toggle='tab' href='#nav-profile' role='tab' aria-controls='nav-profile' aria-selected='false'>Condition</a>
                    <a class='nav-item nav-link text-danger' id='nav-contact-tab' data-toggle='tab' href='#nav-contact' role='tab' aria-controls='nav-contact' aria-selected='false'>Seller</a>
                  </div>
                </nav>
                  <div class='tab-content' id='nav-tabContent'>
                    <div class='text-dark tab-pane fade show active' id='nav-home' role='tabpanel' aria-labelledby='nav-home-tab'>$description</div>
                    <div class='text-dark tab-pane fade' id='nav-profile' role='tabpanel' aria-labelledby='nav-profile-tab'>$itemcondition</div>
                    <div class='text-dark tab-pane fade' id='nav-contact' role='tabpanel' aria-labelledby='nav-contact-tab'>
                    <div class='container-fluid'>
                        <div class='row flex-row flex-nowrap'>
                          <div class='col-sm-8'>
                            <br>
                            <img id='sellerimage' src='profilepics/$sellerimage'/>
                          </div>
                        </div>
                            <div class='row flex-row flex-nowrap'>
                              <div class='col-sm-8'>
                                <p><strong class='text-danger'>Seller:</strong> $seller $sellerlastname</p>
                                <p><strong class='text-danger'>Telepone/sms:</strong> $sellerphone</p>";
                                $salesalias = $numberOfSales->fetch_assoc();
                                $sales = $salesalias['total'];
                                if($sales <= 5){
                                  $sellerstatus = "Beginner Trader";
                                } elseif($sales > 5 && $sales < 10 ){
                                  $sellerstatus = "Experienced Trader";
                                } else{
                                  $sellerstatus = "Master Trader";
                                }
                           echo"<p><strong class='text-danger'>Rating: </strong>$sellerstatus</p>";
                            echo"</div>
                            </div>
                      </div>
                    </div>
                  </div>
                  </div>";
     }
       ?>

  <!--Start of footer-->
  <footer class="page-footer font-small bg-light text-dark">
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
