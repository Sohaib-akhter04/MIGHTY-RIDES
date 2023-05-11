<?php

//this is the session check for this page
session_start();

if (!isset($_SESSION['logged_in']) || (isset($_SESSION['logged_in']) && $_SESSION['usertype'] === "dealer")) //user not logged in or user logged in is a dealer
{
  header('location:index.php');
}

include("dbconnect.php");

$cusid = $_SESSION['userid']; //getting the customer id
$cusname = $_SESSION['username'];

$query1 = " select      c.*, i.images, n.price as nprice,
                        n.discount as ndiscount, p.discount as pdiscount,
                        p.resaleprice as pprice, r.rentamount as rprice
            from car c 
            left join images i on c.carid = i.carid
            left join newcar n on n.newcarid = c.carid
            left join preownedcar p on p.preownedcarid = c.carid
            left join rentalcar r on r.rentalcarid = c.carid
        ";  //getting the customer id // ,car.dealerid 
$result1 = mysqli_query($conn, $query1);

?>

<!DOCTYPE html>
<html>

<head>
  <title><?php echo $cusname . "'s " ?> Dashboard - MightyRides</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="icon" href="./icon1.ico">
  <!--Google Fonts-->
  <link rel="stylesheet" href="./assets/css/cus_index.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
  <!--BOOTSTRAP CDN-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>


<body onload="getcardetails(<?php echo $cusid ?>)">

  <div id="list">
    <div id="closelist" onclick="openlist()">
      <svg class="bi bi-chevron-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 010 .708L5.707 8l5.647 5.646a.5.5 0 01-.708.708l-6-6a.5.5 0 010-.708l6-6a.5.5 0 01.708 0z" clip-rule="evenodd" />
      </svg>
    </div>

    <a id="active">Home</a>
    <a href="cus_profile.php">Profile</a>
    <a href="cus_purchased.php">My Purchases</a>
    <a href="cus_rented.php">Rented cars</a>

  </div>

  <div class="container-fluid text-white py-3" id="header" style="background-color:black;position:fixed;z-index:5;top:0;display:flex;align-items:center">

    <div id="listicon" onclick="openlist()">
      <svg class="bi bi-list" width="2em" height="2em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 013 11h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4A.5.5 0 013 7h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4A.5.5 0 013 3h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5z" clip-rule="evenodd" />
      </svg>
    </div>

    <a id="logout" href="logout.php">
      <svg class="bi bi-x-square" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd" />
        <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z" clip-rule="evenodd" />
        <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z" clip-rule="evenodd" />
      </svg>
    </a>

    <!--<h3 id="title">MightyRides</h3>-->

    <img src="logow.png" height="50px" style="margin:auto">

  </div>

  <div class="container" style="width:80%;margin:auto;margin-top:135px">
    <h2 id="carname" class="display-4 text-center"><?php echo "Welcome " . $cusname . "!" ?></h2>
  </div>


  <div class="input-group mb-3" style="width:80%;margin:auto;margin-top:65px">

    <span class="input-group-text" id="basic-addon1" style="position:relative;margin-right:0;background-color:#C39BD3;border:none;border-radius:0">

      <svg class="bi bi-search" width="1em" height="1em" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd" />
        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd" />
      </svg>

    </span>
    <input type="text" id="query" class="form-control shadow-none" placeholder="Search for cars, manufacturers and car types..." onkeyup="searchcars()" onclick="searchcars()" style="border-color:#C39BD3;border-radius:0;border-left:none">
  </div>


  <div class="searchbox container-fluid py-3">

  </div>


  <div class="container-fluid py-3" style="width:80%">

    <?php if (isset($_SESSION['boughtnewcar']) && $_SESSION['boughtnewcar'] === true) {
    ?>

      <div class="alert alert-primary" role="alert">
        Congratulations! You just bought a new car! Go to <a href="cus_purchased.php">My Purchases</a>!
      </div>

    <?php
      unset($_SESSION['boughtnewcar']);
    } ?>

    <?php if (isset($_SESSION['rentedcar']) && $_SESSION['rentedcar'] === true) {
    ?>

      <div class="alert alert-primary" role="alert">
        Congratulations! You just rented a new car! Go to <a href="cus_rented.php">My Rents</a>!
      </div>

    <?php
      unset($_SESSION['rentedcar']);
    } ?>
  </div>

  <h3 id="explore" style="font-weight:lighter; padding: 10px; text-align: center"><b> Explore Listed Cars </b></h3>

  <div class="container" style="display:flex; flex-direction:column; align-items:left">
    <?php

    if (mysqli_num_rows($result1) === 0) {
    ?>

      <div style=" width:50%; margin-top:15px; padding:10px 0; text-align:center; font-size:1rem; font-weight:350; color:black">
        No cars have been added yet!
      </div>

    <?php
    }
    
    while ($row = mysqli_fetch_assoc($result1)) {
    ?>

      <!-- Card Start -->

      <div style="float: left;" class="card">
        <div class="row" style="border-radius: 25px">

          <div class="col-md-5" style="padding-left: 0px;border-radius: 25px;">
            <img class="d-block w-100" src="<?php echo $row["images"] ?>" height="275px" width="100" style="border-radius: 25px" alt="First slide">
          </div>

          <div>
            <h4 class="card-title"><?php echo $row["name"] ?></h4>
            <hr style="margin-top:10px;min-width:90%">

            <div style="float:left">

              <p class="card-text">
                <b>Car Type - </b> <?php echo $row["carType"]; ?>
              </p>

              <p class="card-text">
                <b>Availability - </b>
                <?php if ($row["Status"] === "available") { ?>

                  <span style="color:#2ECC71"><?php echo $row["Status"]; ?></span>

                <?php } else {
                ?>

                  <span style="color:#E74C3C"><?php echo $row["Status"]; ?></span>

                <?php
                }
                ?>
              </p>

              <p class="card-text">
                <?php if ($row["carType"] === "new") { ?>

                  <b> Price - </b> <?php echo $row["nprice"]; ?> PKR

                <?php
                } else if ($row["carType"] === "resale") { ?>

                  <b> Price - </b> <?php echo $row["pprice"]; ?> PKR

                <?php
                } else { ?>

                  <b> Rent (per hour) - </b> <?php echo $row["rprice"];?> PKR
                <?php
                }
                ?>
              </p>

              <p class="card-text">
                <?php if ($row["carType"] === "new") 
                      { ?>

                        <?php if($row["ndiscount"] !== null){ ?>
                          <b> Discount - </b> <span style="color:#2ECC71"><?php echo $row["ndiscount"]; ?>% </span> 
                          
                        <?php } else{ 
                          $row["ndiscount"] = 0; ?>
                          <b> Discount - </b> <?php echo $row["ndiscount"]; ?>%
                        <?php
                        }
                      }
                ?>

                  <?php if ($row["carType"] === "resale") 
                  { ?>

                    <?php if($row["pdiscount"] !== null){ ?>
                      <b> Discount - </b>  <span style="color:#2ECC71"><?php echo $row["pdiscount"]; ?>% </span> 
                      
                    <?php } else{ 
                      $row["pdiscount"] = 0; ?>
                      <b> Discount - </b> <?php echo $row["pdiscount"]; ?>%
                    <?php
                    }
                  }
                  ?>
              </p>

              <p class="card-text">
                <?php if ($row["carType"] === "new") { ?>

                  <a href="<?php echo "newcar.php?carid=" . $row["carid"] ?>">More details</a>

                <?php
                } else if ($row["carType"] === "resale") { ?>

                  <a href="<?php echo "resalecar.php?carid=" . $row["carid"] ?>">More details</a>

                <?php
                } else { ?>

                  <a href="<?php echo "rentalcar.php?carid=" . $row["carid"] ?>">More details</a>
                <?php
                }
                ?>
              </p>
            </div>

          </div>

        </div>
      </div>

    <?php
    }
    ?>
  </div>
  <!-- </div> -->

  <!-- End of card -->

</body>

<script type="text/javascript" src="JS/home.js"></script>
<script type="text/javascript" src="JS/list.js"></script>

</html>