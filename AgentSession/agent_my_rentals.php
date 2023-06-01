<?php 
 @include '../Website/Configuration/connect.php';
 session_start();
 if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
 {
   header('location:../website/log-in.php');
 }
 // Create connection
 // all that is to get the poster
 $connect = mysqli_connect($servername, $username, $password, $dbname); // i declared it again so i wouldnt have the restart the work without pdo 
 $sql = "SELECT * FROM property";
 $result = mysqli_query($connect, $sql);
 // Check if there are any results
 if (mysqli_num_rows($result) > 0)
 {
    // Loop through each row and get the value of the posterName column
    while ($row = mysqli_fetch_assoc($result))
    {
      $posterName = $row['posterName'];
      $posterLastName = $row['posterLastName'];
      if ($_SESSION['agent_name'] == $posterName AND $_SESSION['agent_last_name'] == $posterLastName)
      {
        require("../Website/Configuration/command.php");
        $myProperties = myProperties();
      }
    }
  } 
  else
  {
    echo "fail";
  }
  
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Website/test.css">
    <link rel="stylesheet" href="../Website/css/all.min.css">
    <title>My properties</title>
 </head>
 <body>
 <?php
require('../Website/Header/header_agent.php')
?>
    <h1 style="margin: 20px;display: flex; justify-content: center;">My listed properties</h1>
   <section id="mp" style="background-color: #eee; margin-top:50px; margin-bottom:50px; ">
     <div class="py-5">
       <div class="row justify-content-center">
         <div class="col-md-12 col-xl-10">
         <?php foreach($myProperties as $myProperty):?>
            <div class="card">
              <div class="card-body">
                <h2><?= $myProperty->id?></h2>
                <div class="row">
                 <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                   <div class="mpi">
                     <img src="../Website/uploads/<?= $myProperty->propertyMain_image?>" class="w-100" name="propertyMain_image"/>
                     <div>
                       <div style="background-color: rgba(253, 253, 253, 0.15);"></div>
                     </div>
                   </div>
                 </div>
                 <div class="cold-md-6 col-lg-6 col-xl-6">
                   <h4 class="mpt" name="propertyTitle"><?= $myProperty->propertyTitle?></h4>
                 <div>
                 <span class="mpa" name="propertyAddress"><?= $myProperty->propertyAddress?></span>
                </div>
                <div>
                  <span name="propertyCity"><?= $myProperty->propertyCity?></span>
                  <span style="color: #0073b1;"> , </span>
                  <span name="propertyCountry"><?= $myProperty->propertyCountry?><br></span>
                </div>
                <div style="color: grey;" class="mpd1">
                  <span name="propertySize"><?= $myProperty->propertySize?></span>
                  <span style="color: #0073b1;"> • </span>
                  <span name="propertyFloors"><?= $myProperty->propertyFloors?></span>
                  <span style="color: #0073b1;"> • </span>
                  <span name="propertyNumber_of_bathrooms"><?= $myProperty->propertyNumber_of_bathrooms?><br /></span>
                </div>
                <div style="color: grey;" class="mpd2">
                  <span name="propertyNumber_of_bedrooms"><?= $myProperty->propertyNumber_of_bedrooms?></span>
                  <span style="color: #0073b1;"> • </span>
                  <span name="propertyGarage"><?= $myProperty->propertyGarage?></span>
                  <span style="color: #0073b1;"> • </span>
                  <span name="propertyOutdoors"><?= $myProperty->propertyOutdoors?><br /></span>
                </div>
                <p class="mpdp text-truncate" name="propertyDescription">
                  <?= $myProperty->propertyDescription?>
                </p>
              </div>
              <div class="col-md-6 col-lg-3 col-xl-3">
                <div>
                  <h5 class="mppt" name="propertyType"><?= $myProperty->propertyType?></h5>
                  <span class="mps" name="propertyStatus"><?= $myProperty->propertyStatus?></span>
                </div>
                <span class="mpp" name="propertyPrice"><?= $myProperty->propertyPrice?></span>
                <div class="d-flex flex-column ">
                  <button class="btn btn-primary " style="margin-bottom: 7px;" type="button" ><a style="color: white;" href="../Website/editProperty.php?prt=<?= $myProperty->id ?>">Edit</a></button>
                  <button style="border: 1px solid;" class="btn btn-outline-primary  mt-2" type="button" onclick="showAlert()">
                    Delete
                  </button>
                </div>
              </div>
            </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
     </div>
     </div>
   </section>
   <?php
require('../Website/Footer/footer_agent.php')
?>
 </body>
 <script>
   let subMenu = document.getElementById("subMenu");
   function ToggleMenu()
   {
     subMenu.classList.toggle("open-menu");
   }
   //for mobile view menu
   const menuHamburger = document.querySelector("#menu-hamburger")
   const navLinks = document.querySelector(".navlinks")
   menuHamburger.addEventListener('click',()=>
   {
     navLinks.classList.toggle('mobile-menu')
   }
   )
   // change menu icon to close icon while open
   let changeIcon = function(close)
   {
     icon.classList.toggle('fa-xmark')
   }
   // end of this part
   //to not display the header content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const main = document.getElementById("mp");
   const footer = document.getElementById("footer");
   icon.addEventListener('click', function() 
   {
     if (main.style.display === 'none')
      {
        main.style.display = 'block';
        footer.style.display = 'block';
      } else 
      {
        main.style.display = 'none';
        footer.style.display = 'none';
      }
   }
   );
   function showAlert()
   {
     alert("For security reasons, you can't delete the property. For further questions, contact our customer service.", "Ziri");
   }
 </script>
</html>