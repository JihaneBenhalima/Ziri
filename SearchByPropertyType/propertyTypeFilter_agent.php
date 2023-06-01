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
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../CssFiles/categories.css">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Italiana">
 </head>
 <body>   
     <?php
         require('../loader.php')
      ?>
     <div class="container">
         <h2 class="heading">Select a property type to start your search</h2>
         <a onclick="goBack()"><i id="close" class="fa-solid fa-xmark"></i></a>
         <div class="box-container"> 
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Family%20home" >
                 <img src="../img/propertiesCategories/familyhouse.jpg" alt="">
                 <h3>Family home</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=apartment">
                 <img src="../img/propertiesCategories/apartment.jpg" alt="">
                 <h3>Apartment</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Duplex">
                 <img src="../img/propertiesCategories/duplex.jpg" alt="">
                 <h3>Duplex</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Villa">
                 <img src="../img/propertiesCategories/villa1.jpg" alt="">
                 <h3>Villa</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Farm%20house">
                 <img src="../img/propertiesCategories/Farmhouse.jpg" alt="">
                 <h3>Farm house</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Retail%20property">
                 <img src="../img/propertiesCategories/retailProperty.jpg" alt="">
                 <h3>Retail property</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Office%20building">
                 <img src="../img/propertiesCategories/Office.jpg" alt="">
                 <h3>Office building</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Warehouse">
                 <img src="../img/propertiesCategories/Warehouse.jpg" alt="">
                 <h3>Warehouse</h3>
             </a>
             <a class="box" href="../AgentSession/properties_searchByType_agent.php?propertyType=Land">
                 <img src="../img/propertiesCategories/land.jpg" alt="">
                 <h3>Land</h3>
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