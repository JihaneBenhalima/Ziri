<?php
  /**done a 100% */
  @include '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
  {
   header('location:../Register/log-in.php');
  }
  $id = $_GET['PropertyMoreDetails'] ?? '';
    require("../Configuration/command.php");
    $PropertiesDetails = getProperty($id);
    if (!$PropertiesDetails) {
        // Handle error case
        die("Failed to retrieve property details");
    }
    foreach ($PropertiesDetails as $PropertyDetails)
     {
        $id = $PropertyDetails->id;
        $propertyTitle = $PropertyDetails->propertyTitle;
        $propertyAddress = $PropertyDetails->propertyAddress;
        $propertyCity = $PropertyDetails->propertyCity;
        $propertyCountry = $PropertyDetails->propertyCountry;
        $propertyType = $PropertyDetails->propertyType;
        $propertyStatus = $PropertyDetails->propertyStatus;
        $propertyPrice = $PropertyDetails->propertyPrice;
        $propertyCurrency = $PropertyDetails->propertyCurrency;
        $propertyMain_image = $PropertyDetails->propertyMain_image;
        $propertyFirst_image = $PropertyDetails->propertyFirst_image;
        $propertySecond_image = $PropertyDetails->propertySecond_image;
        $propertyThird_image = $PropertyDetails->propertyThird_image;
        $propertyFourth_image = $PropertyDetails->propertyFourth_image;
        $propertyFifth_image = $PropertyDetails->propertyFifth_image;
        $propertySixth_image = $PropertyDetails->propertySixth_image;
        $propertySize = $PropertyDetails->propertySize;
        $propertyFloors = $PropertyDetails->propertyFloors;
        $propertyNumber_of_bedrooms = $PropertyDetails->propertyNumber_of_bedrooms;
        $propertyNumber_of_bathrooms = $PropertyDetails->propertyNumber_of_bathrooms;
        $propertyGarage = $PropertyDetails->propertyGarage;
        $propertyOutdoors = $PropertyDetails->propertyOutdoors;
        $propertyDescription = $PropertyDetails->propertyDescription;
        $posterName = $PropertyDetails->posterName;
        $posterLastName = $PropertyDetails->posterLastName;
        require("../Configuration/connect.php");
        // Prepare and execute the SQL query
        $query = "SELECT phoneNumber, email FROM user WHERE name = ? AND last_name = ?";
        $stmt = $connect->prepare($query);
        $stmt->execute([$posterName, $posterLastName]);
        // Fetch the results
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
        $phoneNumber = $result['phoneNumber'];
        $emailAddress = $result['email'];
        }else{
        echo "User not found";
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="../CssFiles/style.css">
    <title>Property Details | Ziri</title>
 </head>
 <body>
   <?php
     require('../Header/header_user.php')
   ?>
   <div class="goBack" >
      <a onclick="goBack()" style="color: black;"><i class="fa-solid fa-circle-arrow-left"></i>&nbsp;Go back</a>
   </div>
   <main id="main">
    <div class="property-details-page">
      <div class="property-images-box">
        <div class="property-images">
          <div class="img-holder active">
           <img style="cursor: pointer;" onclick="displayFullScreen(this)" src="../uploads/<?= $PropertyDetails->propertyMain_image?>" name="propertyMain_image">
         </div>
         <div class="img-holder">
           <img style="height:100px;width:100%;" src="../uploads/<?= $PropertyDetails->propertyFirst_image?>" name="propertyFirst_image">
         </div>
         <div class="img-holder">
            <img style="height:100px;width:100%;" src="../uploads/<?= $PropertyDetails->propertySecond_image?>" name="propertySecond_image">
         </div>
         <div class="img-holder">
           <img style="height:100px;width: 100%;" src="../uploads/<?= $PropertyDetails->propertyThird_image?>" name="propertyThird_image">
         </div>
         <?php if (!empty($PropertyDetails->propertyFourth_image)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../uploads/<?= $PropertyDetails->propertyFourth_image ?>" name="propertyFourth_image">
           </div>
         <?php endif; ?>
         <?php if (!empty($PropertyDetails->propertyFifth_image)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../uploads/<?= $PropertyDetails->propertyFifth_image ?>" name="propertyFifth_image">
           </div> 
         <?php endif; ?>
         <?php if (!empty($PropertyDetails->propertySixth_image)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../uploads/<?= $PropertyDetails->propertySixth_image ?>" name="propertySixth_image">
           </div>
         <?php endif; ?>
       </div>
       <div class="property-basic-info">
          <h1 name="propertyTitle"><?= $propertyTitle ?></h1>
          <div class="property-address">
            <h3 name="propertyAddress" style="margin-bottom:10px;"><?= $propertyAddress ?></h3>
            <h3 style="margin-bottom:10px;"><span name="propertyCity"><?= $propertyCity ?></span></h3>
            <h3 style="margin-bottom:10px;"><span name="propertyCountry"><?= $propertyCountry ?></span> </h3>  
         </div>
         <h5>Status: <span name="propertyStatus"><?= $propertyStatus ?></span></h3>
         <h3>Price:<span name="propertyPrice"><?= $propertyPrice ?></span><span name="propertyCurrency"><?= $propertyCurrency ?>&nbsp;<?php if ($propertyStatus == 'For rent') { echo "Per month"; } ?></span></h4>
         <div class="property-type">
            <a>Property type :<span name="propertyType"><?= $propertyType ?></span></a>
         </div>
       </div>
       <div class="property-description">
          <h3>Description</h3>
          <p name="propertyDescription"><?= $propertyDescription ?></p>
       </div>
       <div class="property-description">
          <ul class="property-features">
            <h3>Home Highlights</h3>
            <li><i class="fa-solid fa-maximize"></i>&nbsp;Size: <span name="propertySize"><?= $propertySize ?>m2</span></li>
            <li><i class="fa-solid fa-maximize"></i>&nbsp;Floors: <span name="propertyFloors"><?= $propertyFloors ?></span></li>
            <li><i class="fa-solid fa-bed"></i></i>Number of bedrooms: <span name="propertyNumber_of_bedrooms"><?= $propertyNumber_of_bedrooms ?></span></li>
            <li><i class="fa-solid fa-shower"></i>&nbsp;Number of bathrooms: <span name="propertyNumber_of_bathrooms"><?= $propertyNumber_of_bathrooms ?></span></li>
            <li><i class="fa-solid fa-cloud-sun"></i></i>Outdoors: <span name="propertyOutdoors"><?= $propertyOutdoors ?></span></li>
            <li><i class="fa-solid fa-warehouse"></i>Garage: <span name="propertyGarage"><?= $propertyGarage ?></span></li>
          </ul>
       </div>
       <div class="property-description">
          <h3>Contact information</h3>
          <ul class="property-posted-by">
            <li>Posted by <span style="color: #6f1d1b;" name="agent_name"><?= $posterName ?> <?= $posterLastName ?></span></li>
          </ul>
          <ul class="property-posted-by">
            <li>Email <span style="color: #6f1d1b;" name="agent_name"><?= $emailAddress ?></span></li>
          </ul>
          <ul class="property-posted-by">
            <li>Phone number <span style="color: #6f1d1b;" name="agent_name"><?= $phoneNumber ?></span></li>
          </ul>
       </div>
     </div>
    </div>
   </main>
   <?php
     require('../Footer/footer_user.php')
   ?>
 </body>
 <script>
    //for mobile view menu
   const menuHamburger = document.querySelector("#menu-hamburger")
   const navLinks = document.querySelector(".navlinks")
   menuHamburger.addEventListener('click',()=>
   {
     navLinks.classList.toggle('mobile-menu')
   }
   )
   //to not display the header and footer content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const content = document.querySelector('.property-details-page');
   const footer = document.querySelector('#footer');
   icon.addEventListener('click', function() 
   {
     if (content.style.display === 'none')
      {
        content.style.display = 'flex';
        footer.style.display = 'block';
      } else 
      {
        content.style.display = 'none';
        footer.style.display = 'none';
      }
   }
   );
   // change menu icon to close icon while open
   let changeIcon = function(close)
   {
     icon.classList.toggle('fa-xmark')
   }
   // profile menu
   let subMenu = document.getElementById("subMenu");
   function ToggleMenu()
   {
    subMenu.classList.toggle("open-menu");
   }
   // Get all the image holders and the main image holder
   const imageHolders = document.querySelectorAll('.property-images .img-holder');
   const mainImageHolder = document.querySelector('.property-images .img-holder.active');
   // Loop through each image holder and add a click event listener
   imageHolders.forEach(imageHolder => {
   imageHolder.addEventListener('click', () => {
    // Get the index of the clicked image holder
    const clickedIndex = Array.from(imageHolders).indexOf(imageHolder);
    // Swap the images in the main image holder and the clicked image holder
    const clickedImage = imageHolder.querySelector('img').src;
    const mainImage = mainImageHolder.querySelector('img').src;
    mainImageHolder.querySelector('img').src = clickedImage;
    imageHolder.querySelector('img').src = mainImage;
    // Add the 'active' class to the clicked image holder and remove it from the main image holder
    imageHolder.classList.add('active');
    mainImageHolder.classList.remove('active');
    // Update the grid template areas
    if (clickedIndex == 1) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"active idle idle idle idle idle" "idle idle idle idle idle idle"';
    } else if (clickedIndex == 2) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"idle active idle idle idle idle" "idle idle idle idle idle idle"';
    } else if (clickedIndex == 3) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle active idle idle idle" "idle idle idle idle idle idle"';
    } else if (clickedIndex == 4) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle idle idle idle idle" "active idle idle idle idle idle"';
    } else if (clickedIndex == 5) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle idle idle idle idle" "idle active idle idle idle idle"';
    } else if (clickedIndex == 6) {
    document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle idle idle idle idle" "idle idle active idle idle idle"';
    }
    });
    });
   function goBack()
    {
     window.history.back();
    }
    function displayFullScreen(img) {
    // Create a new <div> element to display the full screen image
    var overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
    overlay.style.zIndex = 9999;
    // Create a new <img> element to display the full screen image
   var fullImg = document.createElement("img");
   fullImg.src = img.src;
   fullImg.style.maxHeight = "100%";
   fullImg.style.maxWidth = "100%";
   fullImg.style.position = "absolute";
   fullImg.style.top = "50%";
   fullImg.style.left = "50%";
   fullImg.style.transform = "translate(-50%, -50%)";
   // Add the <img> element to the <div> element
   overlay.appendChild(fullImg);
   // Add the <div> element to the document body
   document.body.appendChild(overlay);
   // Add an event listener to the <div> element to remove it when clicked
   overlay.addEventListener("click", function() {
    document.body.removeChild(overlay);
   });
   }
 </script>
</html>