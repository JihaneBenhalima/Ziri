<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="../CssFiles/header.css">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>
 <body>
      <!-- loader -->
      <?php
         require('../loader.php')
      ?>
      <!-- the header -->
      <section class="second-header" id="second-header" style="background-color: #1a1a1a;height: 20vh;">
         <nav class="navbar">
             <a href="../Home/home.php">
                 <img class="logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
             </a>
             <div class="navlinks" id="second-navlinks">
                 <ul class="menu">
                     <li><a href="../Search/search_guest.php">Search</a></li>
                     <li><a href="#">Our properties</a>
                         <ul class="sousmenu" id="second-header-sousmenu">
                             <li><a href="../GuestSession/properties_guest.php" id="second-header-link">See all properties</a></li>
                             <li><a href="../GuestSession/propertiesForSale_guest.php?propertyStatus='For sale'" id="second-header-link">Buy</a></li>
                             <li><a href="../GuestSession/propertiesForRent_guest.php?propertyStatus='For rent'" id="second-header-link">Rent</a></li>
                         </ul>
                     </li>
                     <li><a href="../GuestSession/vacationRentals_guest.php">Vacations rentals</a></li>
                     <li><a href="#">Work with us</a>
                         <ul class="sousmenu" id="second-header-sousmenu">
                             <li><a href="../contact-us.php" id="second-header-link">Find an agent</a></li>
                             <li><a href="../Register/sign-up.php" id="second-header-link">Sign up as an agent</a></li>
                             <li><a href="../GuestSession/agents_guest.php" id="second-header-link">See all our agents</a></li>
                         </ul>
                     </li>
                     <li><a href="../Register/log-in.php" id="log-in-btn">Log in</a></li>
                  </ul>
              </div>    
              <i class="fa-solid fa-bars" id="menu-hamburger" onclick="changeIcon(this)"></i>  
         </nav>
      </section>

      <!-- FAQ chatbot -->
      <script>(function(){var js,fs,d=document,id="tars-widget-script",b="https://tars-file-upload.s3.amazonaws.com/bulb/";if(!d.getElementById(id)){js=d.createElement("script");js.id=id;js.type="text/javascript";js.src=b+"js/widget.js";fs=d.getElementsByTagName("script")[0];fs.parentNode.insertBefore(js,fs)}})();window.tarsSettings = {"convid":"MvUiq5"};</script>
 </body>
</html>
     