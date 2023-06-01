<!DOCTYPE html>
<!--done a 100%-->
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../CssFiles/categories.css">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Italiana">
     <title>Start your search</title>
 </head>
 <body>   
     <?php
         require('../loader.php')
      ?>
     <div class="container" style="height: 150vh;">
         <h2 class="heading" style="margin-bottom: 50px;">What are you searching for ?</h2>
         <a onclick="goBack()"><i id="close" class="fa-solid fa-xmark"></i></a>
         <div class="box-container"> 
             <a class="box" href="../SearchByPropertyType/propertyTypeFilter_guest.php" >
                 <img src="../img/propertiesCategories/real-estate.jpeg" alt="real estate">
                 <h3>Real estate</h3>
             </a>
             <a class="box" href="../SearchByPropertyType/rentalTypeFilter_guest.php">
                 <img src="../img/propertiesCategories/short-rental.jpg" alt="vacation rentals">
                 <h3>Short term rentals</h3>
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