<?php
 @include '../Configuration/connect.php';
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
   <title>Welcome</title>
   <link rel="stylesheet" href="../CssFiles/test.css">
   <link rel="stylesheet" href="../css/all.min.css">
 </head>
 <body>
 <?php
require('../Header/header_agent.php')
?>
   <main id="main" style="height: 400px;">
     <div class="ulp">
       <div class="ulpcontent">
         <h2>Welcome<br></h2>
         <h2><span><?php echo $_SESSION['agent_name']?>&nbsp;<?php echo $_SESSION['agent_last_name']?></span></h2>
         <p>What would you like to do next?</p>
         <a href="../AgentSession/properties_agent.php" class="ulpbtn">Browse properties</a>
         <a href="../AgentSession/add-new-property.php" class="ulpbtn">Add new property</a>
         <a href="../AgentSession/add-new-rental_agent.php" class="ulpbtn">Add vacation rental</a>
       </div>
     </div>
   </main>
   
   <?php
require('../Footer/footer_agent.php')
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
   const main = document.getElementById("main");
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