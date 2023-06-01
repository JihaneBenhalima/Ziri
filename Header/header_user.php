<?php 
 @include '../Configuration/connect.php';
 if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
 {
     header('location:../Register/log-in.php');
 }
 // Create connection
 // all that is to get the poster
 $connect = mysqli_connect($servername, $username, $password, $dbname); // i declared it again so i wouldnt have the restart the work without pdo 
 $sql = "SELECT * FROM user";
 $result = mysqli_query($connect, $sql);
 // Check if there are any results
 if (mysqli_num_rows($result) > 0)
 {
    // Loop through each row and get the value of the posterName column
    while ($row = mysqli_fetch_assoc($result))
    {
      $agentName = $row['name'];
      $agentLastName = $row['last_name'];
      if ($_SESSION['user_name'] == $agentName AND $_SESSION['user_last_name'] == $agentLastName )
      {
        require_once("../Configuration/command.php");
        $getIdAgentProfile = getIdUser();
      }
    }
  } 
  else
  {
    echo "fail";
  }
  $query = "SELECT * FROM review WHERE reviewerName = ? AND reviewerLastName = ?";
  $stmt = $connect->prepare($query);
  $stmt->bind_param('ss', $_SESSION['user_name'], $_SESSION['user_last_name']);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $style = "display: none;";
  } else {
    $style = "";
  }
 $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="../CssFiles/header.css">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--done-->
 </head>
 <body>
     <!-- loader -->
     <?php
         require('../loader.php')
      ?>
      <section style="height:20vh;" class="second-header"   id="second-header" >
         <nav class="navbar" style="background: #1A1A1A;">
             <a href="../Home/home_user.php">
                 <img class="logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
             </a>
             <div class="navlinks" id="second-navlinks">
                 <ul class="menu">
                     <li><a href="../Search/search_user.php">Search</a></li>
                     <li><a href="#">Ziri properties</a>
                         <ul class="sousmenu">
                             <li><a href="../UserSession/properties_user.php">See all properties</a></li>
                             <li><a href="../UserSession/propertiesForSale_user.php?propertyStatus='For sale'">Buy</a></li>
                             <li><a href="../UserSession/propertiesForRent_user.php?propertyStatus='For rent'">Rent</a></li>
                         </ul>
                     </li>
                     <li><a href="../UserSession/vacationRentals_user.php">Vacation rentals</a></li>
                     <li><a href="../UserSession/add-new-rental_user.php">Add rental</a></li>
                     <?php
                         // Assuming $profilePicture contains the value fetched from the database
                         $profilePicture = $_SESSION['profilePicture'];
                         // Check if $profilePicture is empty or not
                         if (!empty($profilePicture)) {
                             // If $profilePicture is not empty, display the profile picture
                              echo '<img class="user-pic"   style="height: 40px; width:40px;" onclick="ToggleMenu()" src="../agents/' . $profilePicture . '" alt="Profile Picture">';
                         } else {
                           // If $profilePicture is empty, display the default image
                            echo '<img class="user-pic" style="height: 40px; width:40px;" onclick="ToggleMenu()" src="../img/png-transparent-profile-logo-computer-icons-user-user-blue-heroes-logo-thumbnail.png" alt="Default Image">';
                         }
                       ?>
                     <div class="sub-menu-wrap" id="subMenu">
                         <sub-menu>
                             <div class="user-info">
                             <?php
                         // Assuming $profilePicture contains the value fetched from the database
                         $profilePicture = $_SESSION['profilePicture'];
                         // Check if $profilePicture is empty or not
                         if (!empty($profilePicture)) {
                             // If $profilePicture is not empty, display the profile picture
                              echo '<img class="user-pic"   style="height: 40px; width:40px;" onclick="ToggleMenu()" src="../agents/' . $profilePicture . '" alt="Profile Picture">';
                         } else {
                           // If $profilePicture is empty, display the default image
                            echo '<img class="user-pic" style="height: 40px; width:40px;" onclick="ToggleMenu()" src="../img/png-transparent-profile-logo-computer-icons-user-user-blue-heroes-logo-thumbnail.png" alt="Default Image">';
                         }
                       ?>
                                 <h3><?php echo $_SESSION['user_name']?><br><?php echo $_SESSION['user_last_name']?></h3>
                             </div>
                             <hr>
                             <?php foreach($getIdAgentProfile as $newProfile):?>
                                     <a href="../UserSession/profile_user.php?profile=<?= $newProfile->id ?>" class="sub-menu-link">
                                         <i id="icon" class="fa-regular fa-user"></i>
                                         <p>My profile</p>
                                         <span><i class="fa-solid fa-chevron-right"></i></span>
                                      </a>
                             <?php endforeach;?>
                             <a href="../UserSession/MyRentals_user.php" class="sub-menu-link">
                                 <i id="icon" class="fa-solid fa-house-flood-water"></i>
                                 <p>My rentals</p>
                                 <span><i class="fa-solid fa-chevron-right"></i></span>
                             </a>
                             <a style="<?= $style ?>" href="../UserSession/review_user.php" class="sub-menu-link">
                                 <i id="icon" class="fa-regular fa-comment"></i>
                                 <p>Review &nbsp;<i style="color: red; font-size:6px;position:relative;top:-3px;" class="fa-solid fa-circle"></i></p>
                                 <span><i class="fa-solid fa-chevron-right"></i></i></span>
                             </a>
                             <a href="../Register/logout.php" class="sub-menu-link">
                                 <i id="icon" class="fa-solid fa-arrow-right-from-bracket"></i>
                                 <p>Log out</p>
                                 <span><i class="fa-solid fa-chevron-right"></i></span>
                             </a>
                         </sub-menu>
                     </div>
                  </ul>  
             </div>    
             <i class="fa-solid fa-bars" id="menu-hamburger" onclick="changeIcon(this)"></i>  
         </nav>
     </section>
     <!-- FAQ chatbot -->
     <script>(function(){var js,fs,d=document,id="tars-widget-script",b="https://tars-file-upload.s3.amazonaws.com/bulb/";if(!d.getElementById(id)){js=d.createElement("script");js.id=id;js.type="text/javascript";js.src=b+"js/widget.js";fs=d.getElementsByTagName("script")[0];fs.parentNode.insertBefore(js,fs)}})();window.tarsSettings = {"convid":"MvUiq5"};</script>
  </body>
</html>
     




















