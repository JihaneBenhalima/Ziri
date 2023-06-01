<?php
  /**done a 100% */
  @include '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
  {
    header('location:../Register/log-in.php');
  }
  $id = $_GET['rentalMoreDetails'] ?? '';
  require("../Configuration/command.php");
  $PropertiesDetails = getRental($id);
  if (!$PropertiesDetails) {
    // Handle error case
    die("Failed to retrieve rental details");
  }
  foreach ($PropertiesDetails as $PropertyDetails)
  {
    $id = $PropertyDetails->id;
    $rentalTitle = $PropertyDetails->rentalTitle;
    $rentalAddress = $PropertyDetails->rentalAddress;
    $rentalCity = $PropertyDetails->rentalCity;
    $rentalCountry = $PropertyDetails->rentalCountry;
    $rentalType = $PropertyDetails->rentalType;
    $rentalStatus = $PropertyDetails->rentalStatus;
    $rentalAskingPrice = $PropertyDetails->rentalAskingPrice;
    $rentalCurrency = $PropertyDetails->rentalCurrency;
    $rentalMainImage = $PropertyDetails->rentalMainImage;
    $rentalFirstImage = $PropertyDetails->rentalFirstImage;
    $rentalSecondImage = $PropertyDetails->rentalSecondImage;
    $rentalThirdImage = $PropertyDetails->rentalThirdImage;
    $rentalFourthImage = $PropertyDetails->rentalFourthImage;
    $rentalFifthImage = $PropertyDetails->rentalFifthImage;
    $rentalSixthImage = $PropertyDetails->rentalSixthImage;
    $size = $PropertyDetails->size;
    $HouseRules = $PropertyDetails->HouseRules;
    $AvailabilityFrom = $PropertyDetails->AvailabilityFrom;
    $AvailabilityTo = $PropertyDetails->AvailabilityTo;
    $perWeekPerNight = $PropertyDetails->perWeekPerNight;
    $HostName = $PropertyDetails->HostName;
    $Amenities = $PropertyDetails->Amenities;
    $accommodation = $PropertyDetails->accommodation;
    $rentalListingType = $PropertyDetails->rentalListingType;
    $Bedrooms	 = $PropertyDetails->Bedrooms	;
    $Bathrooms	 = $PropertyDetails->Bathrooms;
    $rentalGarage = $PropertyDetails->rentalGarage;
    $rentalOutdoors = $PropertyDetails->rentalOutdoors;
    $rentalDescription = $PropertyDetails->rentalDescription;
    $notes = $PropertyDetails->notes;
    $rentalPosterName = $PropertyDetails->rentalPosterName;
    $rentalPosterLastName = $PropertyDetails->rentalPosterLastName;
    require("../Configuration/connect.php");
    // Prepare and execute the SQL query
    $query = "SELECT phoneNumber, email FROM user WHERE name = ? AND last_name = ?";
    $stmt = $connect->prepare($query);
    $stmt->execute([$rentalPosterName, $rentalPosterLastName]);
    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result)
    {
      $phoneNumber = $result['phoneNumber'];
      $emailAddress = $result['email'];
    }
    else
    {
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
             <img style="cursor: pointer;" onclick="displayFullScreen(this)"  src="../rentals/<?= $PropertyDetails->rentalMainImage?>" name="rentalMainImage">
           </div>
         <div class="img-holder">
           <img style="height:100px;width:100%;" src="../rentals/<?= $PropertyDetails->rentalFirstImage?>" name="rentalFirstImage">
         </div>
         <div class="img-holder">
           <img style="height:100px;width:100%;" src="../rentals/<?= $PropertyDetails->rentalSecondImage?>" name="rentalSecondImage">
         </div>
         <div class="img-holder">
           <img style="height:100px;width: 100%;" src="../rentals/<?= $PropertyDetails->rentalThirdImage?>" name="rentalThirdImage">
         </div>
         <?php if (!empty($PropertyDetails->rentalFourthImage)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../rentals/<?= $PropertyDetails->rentalFourthImage ?>" name="rentalFourthImage">
           </div>
         <?php endif; ?>
         <?php if (!empty($PropertyDetails->rentalFifthImage)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../rentals/<?= $PropertyDetails->rentalFifthImage ?>" name="rentalFifthImage">
           </div>
         <?php endif; ?>
         <?php if (!empty($PropertyDetails->rentalSixthImage)): ?>
           <div class="img-holder">
             <img style="height: 100px; width: 100%;" src="../rentals/<?= $PropertyDetails->rentalSixthImage ?>" name="rentalSixthImage">
           </div>
         <?php endif; ?>
       </div>
       <div class="property-basic-info">
          <h1 name="rentalTitle"><?= $rentalTitle ?></h1>
          <div class="property-address">
            <h3 style="margin-bottom:10px;"><span name="rentalAddress" ><?= $rentalAddress?></span>,<span name="rentalCity"><?= $rentalCity?></span></h3>
            <h3 style="margin-bottom:10px;"><span name="rentalCountry"><?= $rentalCountry ?></span></h3> 
          </div>
          <h5>Status: <span name="rentalStatus"><?= $rentalStatus ?></span></h3>
          <h3>Price:<span name="rentalAskingPrice"><?= $rentalAskingPrice ?></span><span name="rentalCurrency"><?= $rentalCurrency ?>&nbsp;</span><span name="perWeekPerNight"><?= $perWeekPerNight ?></span></h3>
          <div class="property-type">
           <a>Rental type :&nbsp;<span name="rentalType"><?= $rentalType?>,&nbsp;<?= $rentalListingType?></span></a>
         </div>
         <h5>Accommodation:<span name="accommodation"><?= $accommodation?></h5>
         <div style="border: 1px solid #B69121;padding: 10px;width: 162px;">
           <h3>Available From:&nbsp;<span name="AvailabilityFrom"><?= $AvailabilityFrom ?></span></h3>
           <h3>To:&nbsp;<span name="AvailabilityTo"><?= $AvailabilityTo ?></span></h3>
         </div>
       </div>
       <div class="property-description">
         <h3>Description</h3>
         <p name="rentalDescription"><?= $rentalDescription ?></p>
         <h3>Amenities</h3>
         <p name="Amenities"><?= $Amenities?></p>
         <h3>House rules</h3>
         <p name="rentalDescription"><?= $HouseRules?></p>
       </div>
       <div class="property-description">
         <ul class="property-features">
           <h3>Home Highlights</h3>
           <li><i class="fa-solid fa-maximize"></i>&nbsp;Size: <span name="size"><?= $size ?>m2</span></li>
           <li><i class="fa-solid fa-bed"></i></i>Number of bedrooms: <span name="Bedrooms	"><?= $Bedrooms	 ?></span></li>
           <li><i class="fa-solid fa-shower"></i>&nbsp;Number of bathrooms: <span name="Bathrooms	"><?= $Bathrooms	 ?></span></li>
           <li><i class="fa-solid fa-cloud-sun"></i></i>Outdoors: <span name="rentalOutdoors"><?= $rentalOutdoors ?></span></li>
           <li><i class="fa-solid fa-warehouse"></i>Garage: <span name="rentalGarage"><?= $rentalGarage ?></span></li>
         </ul>   
         <div class="property-description">
           <h3>Notes</h3>
           <p name="notes"><?= $notes?></p>
         </div>      
         <ul class="property-posted-by">
           <li>Host: <span style="color: #6f1d1b;" name="agent_name"><?= $HostName ?></span></li>
         </ul>
       </div>
       <div class="property-description">
          <h3>Contact information</h3>
          <ul class="property-posted-by">
            <li>Posted by <span style="color: #6f1d1b;" name="agent_name"><?= $rentalPosterName ?> <?= $rentalPosterLastName ?></span></li>
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
      document.querySelector('.property-images').style.gridTemplateAreas = '"idle active active" "idle idle idle"';
    } else if (clickedIndex == 2) {
      document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle active" "idle idle idle"';
    } else if (clickedIndex == 3) {
      document.querySelector('.property-images').style.gridTemplateAreas = '"idle idle idle" "idle active active"';
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