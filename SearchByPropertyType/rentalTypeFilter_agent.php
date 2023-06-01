<?php
 @include '../Configuration/connect.php';
    require("../Configuration/command.php");
    session_start();
    if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
    {
     header('location:../Register/log-in.php');
    }
?>
<!DOCTYPE html>
<!-- done a 100% -->
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../CssFiles/categories.css">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Italiana">
     <title>Rental type</title>
 </head>
 <body>   
   <?php
     require('../loader.php')
    ?>
     <div class="container">
         <h2 class="heading">What type of short term rental you are looking for ?</h2>
         <a onclick="goBack()"><i id="close" class="fa-solid fa-xmark"></i></a>
         <div class="box-container"> 
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Entire%20place" >
                 <img src="../img/propertiesCategories/entirePlace.jpg" alt="Entire place">
                 <h3>Entire place</h3>
             </a>
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Private%20room">
                 <img src="../img/propertiesCategories/privateRoom.jpg" alt="Private room">
                 <h3>Private room</h3>
             </a>
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Shared%20room">
                 <img src="../img/propertiesCategories/sharedRoom.jpg" alt="Shared room">
                 <h3>Shared room</h3>
             </a>
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Hotel%20room">
                 <img src="../img/propertiesCategories/hotelRoom.jpg" alt="Hotel room">
                 <h3>Hotel room</h3>
             </a>
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Unique%20stays">
                 <img src="../img/propertiesCategories/uniqueStays.jpg" alt="Unique stays">
                 <h3>Unique stays</h3>
             </a>
             <a class="box" href="../AgentSession/rentals_searchByType_agent.php?rentalListingType=Bed%20and%20breakfast">
                 <img src="../img/propertiesCategories/bedAndBreakfast.jpg" alt="Bed and breakfast">
                 <h3>Bed and breakfast</h3>
             </a>
          </div>
     </div>
 </body>
 <script>
     function goBack()
     {
         window.history.back();
     }
 </script>
</html>