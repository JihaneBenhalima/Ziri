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
     <title>Property type</title>
 </head>
 <body>   
     <?php
         require('../loader.php')
      ?>
     <div class="container">
         <h2 class="heading">Select a property type to start your search</h2>
         <a onclick="goBack()"><i id="close" class="fa-solid fa-xmark"></i></a>
         <div class="box-container"> 
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Family%20home" >
                 <img src="../img/propertiesCategories/familyhouse.jpg" alt="family house">
                 <h3>Family home</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=apartment">
                 <img src="../img/propertiesCategories/apartment.jpg" alt="apartment">
                 <h3>Apartment</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Duplex">
                 <img src="../img/propertiesCategories/duplex.jpg" alt="duplex">
                 <h3>Duplex</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Villa">
                 <img src="../img/propertiesCategories/villa1.jpg" alt="villa">
                 <h3>Villa</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Farm%20house">
                 <img src="../img/propertiesCategories/Farmhouse.jpg" alt="farmhouse">
                 <h3>Farm house</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Retail%20property">
                 <img src="../img/propertiesCategories/retailProperty.jpg" alt="retail">
                 <h3>Retail property</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Office%20building">
                 <img src="../img/propertiesCategories/Office.jpg" alt="office">
                 <h3>Office building</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Warehouse">
                 <img src="../img/propertiesCategories/Warehouse.jpg" alt="warehouse">
                 <h3>Warehouse</h3>
             </a>
             <a class="box" href="../GuestSession/properties_searchByType_guest.php?propertyType=Land">
                 <img src="../img/propertiesCategories/land.jpg" alt="land">
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