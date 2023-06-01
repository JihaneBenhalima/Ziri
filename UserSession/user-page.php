<?php
 @include '../Configuration/connect.php';
 session_start();
 if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
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
   <title>Welcome</title>
   <link rel="stylesheet" href="../CssFiles/test.css">
   <link rel="stylesheet" href="../css/all.min.css">
 </head>
 <body>
 <?php
require('../Header/header_user.php')
?>
   <main id="ulp" style="height: 400px;">
     <div class="ulp">
       <div class="ulpcontent">
         <h2>Welcome<br></h2>
         <h2><span><?php echo $_SESSION['user_name']?>&nbsp;<?php echo $_SESSION['user_last_name']?></span></h2>
         <p>What would you like to do next?</p>
         <a href="../Home/home_user.php" class="ulpbtn">Home</a>
         <a href="../UserSession/properties_user.php" class="ulpbtn">Browse properties</a>
         <a href="../UserSession/add-new-rental_user.php" class="ulpbtn">Add vacation rental</a>
       </div>
     </div>
   </main>
   <?php
require('../Footer/footer_user.php')
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
   //to not display the header content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const main = document.getElementById("ulp");
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
 </script>
</html>