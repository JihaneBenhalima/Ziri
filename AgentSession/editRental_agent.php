<?php
  /**done a 100% */
  @include '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
  {
    header('location:../Register/log-in.php');
  }
  $id = $_GET['editRental'] ?? '';
  require("../Configuration/command.php");
  $myPropertiesEdit= getRental($id);
  // Retrieve existing image names from the database
  $query = "SELECT rentalMainImage, rentalFirstImage, rentalSecondImage, rentalThirdImage FROM vacationrentals WHERE id = :id";
  $stmt = $connect->prepare($query);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Bind the ID parameter
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach($myPropertiesEdit as $myPropertyEdit)
  {
    $id = $myPropertyEdit->id;
    $rentalTitle = $myPropertyEdit->rentalTitle;
    $rentalAddress = $myPropertyEdit->rentalAddress;
    $rentalCity = $myPropertyEdit->rentalCity;
    $rentalCountry = $myPropertyEdit->rentalCountry;
    $rentalMainImage = $myPropertyEdit->rentalMainImage;
    $rentalFirstImage = $myPropertyEdit->rentalFirstImage;
    $rentalSecondImage = $myPropertyEdit->rentalSecondImage;
    $rentalThirdImage = $myPropertyEdit->rentalThirdImage;
    $rentalFourthImage = $myPropertyEdit->rentalFourthImage;
    $rentalFifthImage = $myPropertyEdit->rentalFifthImage;
    $rentalSixthImage = $myPropertyEdit->rentalSixthImage;
    $rentalListingType = $myPropertyEdit->rentalListingType;
    $rentalType = $myPropertyEdit->rentalType;
    $Bedrooms = $myPropertyEdit->Bedrooms;
    $Bathrooms = $myPropertyEdit->Bathrooms;
    $Amenities = $myPropertyEdit->Amenities;
    $size = $myPropertyEdit->size;
    $HouseRules = $myPropertyEdit->HouseRules;
    $AvailabilityFrom = $myPropertyEdit->AvailabilityFrom;
    $AvailabilityTo = $myPropertyEdit->AvailabilityTo;
    $rentalAskingPrice = $myPropertyEdit->rentalAskingPrice;
    $perWeekPerNight = $myPropertyEdit->perWeekPerNight;
    $rentalCurrency = $myPropertyEdit->rentalCurrency;
    $rentalDescription = $myPropertyEdit->rentalDescription;
    $notes = $myPropertyEdit->notes;
    $HostName = $myPropertyEdit->HostName;
    $rentalStatus = $myPropertyEdit->rentalStatus;
    $rentalGarage = $myPropertyEdit->rentalGarage;
    $rentalOutdoors = $myPropertyEdit->rentalOutdoors;
    $accommodation = $myPropertyEdit->accommodation;
  }
  $success=0;
  $fail=0;
    if(isset($_POST['edit_rental']))  
    {
     $rentalTitle = $_POST['rentalTitle'];
     $rentalAddress = $_POST['rentalAddress'];
     $rentalCity = $_POST['rentalCity'];
     $rentalCountry = $_POST['rentalCountry'];


     $existingMainImage = $result['rentalMainImage'];
     $existingFirstImage = $result['rentalFirstImage'];
     $existingSecondImage = $result['rentalSecondImage'];
     $existingThirdImage = $result['rentalThirdImage'];
     $existingFourthImage = isset($result['rentalFourthImage']) ? $result['rentalFourthImage'] : '';
     $existingFifthImage = isset($result['rentalFifthImage']) ? $result['rentalFifthImage'] : '';
     $existingSixthImage = isset($result['rentalSixthImage']) ? $result['rentalSixthImage'] : '';
     //accessing images
     $rentalMainImage = $_FILES['rentalMainImage']['name'];
     $rentalFirstImage = $_FILES['rentalFirstImage']['name'];
     $rentalSecondImage = $_FILES['rentalSecondImage']['name'];
     $rentalThirdImage = $_FILES['rentalThirdImage']['name'];
     $rentalFourthImage = $_FILES['rentalFourthImage']['name'];
     $rentalFifthImage = $_FILES['rentalFifthImage']['name'];
     $rentalSixthImage = $_FILES['rentalSixthImage']['name'];
     //accessing img tmp name
     $temp_rentalMainImage = $_FILES['rentalMainImage']['tmp_name'];
     $temp_rentalFirstImage = $_FILES['rentalFirstImage']['tmp_name'];
     $temp_rentalSecondImage = $_FILES['rentalSecondImage']['tmp_name'];
     $temp_rentalThirdImage = $_FILES['rentalThirdImage']['tmp_name'];
     $temp_rentalFourthImage = $_FILES['rentalFourthImage']['tmp_name'];
     $temp_rentalFifthImage = $_FILES['rentalFifthImage']['tmp_name'];
     $temp_rentalSixthImage = $_FILES['rentalSixthImage']['tmp_name'];

     $rentalListingType = $_POST['rentalListingType'];
     $rentalType = $_POST['rentalType'];
     $Bedrooms = $_POST['Bedrooms'];
     $Bathrooms = $_POST['Bathrooms'];
     $Amenities = $_POST['Amenities'];
     $size = $_POST['size'];
     $HouseRules = $_POST['HouseRules'];
     $AvailabilityFrom = $_POST['AvailabilityFrom'];
     $AvailabilityTo = $_POST['AvailabilityTo'];
     $rentalAskingPrice = $_POST['rentalAskingPrice'];
     $perWeekPerNight = $_POST['perWeekPerNight'];
     $rentalCurrency = $_POST['rentalCurrency'];
     $rentalDescription = $_POST['rentalDescription'];
     $notes = $_POST['notes'];
     $HostName = $_POST['HostName'];
     $rentalStatus = $_POST['rentalStatus'];
     $rentalGarage = $_POST['rentalGarage'];
     $rentalOutdoors = $_POST['rentalOutdoors'];
     $rentalPosterName = $_POST['rentalPosterName'];
     $rentalPosterLastName = $_POST['rentalPosterLastName'];
     $accommodation = $_POST['accommodation'];
     //checking empty condition
     if($rentalTitle=='' or $rentalAddress=='' or $rentalCity=='' or $rentalCountry=='' or $rentalType=='' or $rentalListingType=='' or $rentalStatus=='' or $rentalAskingPrice=='' or $rentalCurrency=='' or $perWeekPerNight=='' or $size=='' or $HouseRules=='' or $AvailabilityFrom=='' or $AvailabilityTo=='' or $accommodation=='' or  $Bedrooms=='' or $Bathrooms=='' or $Amenities=='' or $rentalGarage=='' or $rentalOutdoors=='' or $rentalDescription=='' or $notes=='' or $HostName=='' or $rentalPosterName=='' or $rentalPosterLastName=='' )
     {
        $fail=1;
     }
     else
     { 
        // Check if new images were selected
        if (empty($rentalMainImage))
        {
          $rentalMainImage = $existingMainImage;
        }
        else
        {
        // Upload the new main image
        move_uploaded_file($_FILES['rentalMainImage']['tmp_name'], "../rentals/$rentalMainImage");
        }
        if (empty($rentalFirstImage))
        {
         $rentalFirstImage = $existingFirstImage;
        }
        else
        {
         // Upload the new first image
         move_uploaded_file($_FILES['rentalFirstImage']['tmp_name'], "../rentals/$rentalFirstImage");
        }
        if (empty($rentalSecondImage))
        {
         $rentalSecondImage = $existingSecondImage;
        }
        else
        {
         // Upload the new second image
         move_uploaded_file($_FILES['rentalSecondImage']['tmp_name'], "../rentals/$rentalSecondImage");
        }
        if (empty($rentalThirdImage))
        {
         $rentalThirdImage = $existingThirdImage;
        }
        else
        {
         // Upload the new third image
         move_uploaded_file($_FILES['rentalThirdImage']['tmp_name'], "../rentals/$rentalThirdImage");
        }

        if (empty($rentalFourthImage))
        {
         $rentalFourthImage = $existingFourthImage;
        }
        else
        {
         // Upload the new third image
         move_uploaded_file($_FILES['rentalFourthImage']['tmp_name'], "../rentals/$rentalFourthImage");
        }

        if (empty($rentalFifthImage))
        {
         $rentalFifthImage = $existingFifthImage;
        }
        else
        {
         // Upload the new third image
         move_uploaded_file($_FILES['rentalFifthImage']['tmp_name'], "../rentals/$rentalFifthImage");
        }

        if (empty($rentalSixthImage))
        {
         $rentalSixthImage = $existingSixthImage;
        }
        else
        {
         // Upload the new third image
         move_uploaded_file($_FILES['rentalSixthImage']['tmp_name'], "../rentals/$rentalSixthImage");
        }
        //insert query
       try
       {
         EditRental($rentalTitle, $rentalAddress, $rentalCity, $rentalCountry, $rentalMainImage, $rentalFirstImage, $rentalSecondImage, $rentalThirdImage, $rentalFourthImage, $rentalFifthImage, $rentalSixthImage, $rentalListingType, $rentalType, $Bedrooms, $Bathrooms, $Amenities, $size, $HouseRules, $AvailabilityFrom, $AvailabilityTo, $rentalAskingPrice, $perWeekPerNight, $rentalCurrency, $rentalDescription, $notes, $HostName, $rentalStatus, $rentalGarage, $rentalOutdoors, $accommodation, $id );
         $success=1;
        }
        catch(Exception $e)
        {
         echo "Error: " . $e->getMessage();
        }
      } 
    }
   
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CssFiles/test.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/all.min.css">
    <title>Ziri|Edit property</title>
 </head>
 <body>
   <?php
      require("../Header/header_agent.php")
   ?>
   <main id="main">
      <section class="container">
       <?php
         if($success)
         {
           echo '<div style="border: 1px solid green;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: green;" class="fa-regular fa-circle-check"></i>
             <span>Rental successfully edited!</span>
           </div>
         </div>';
         }
         if($fail)
         {
           echo '<div style="border: 1px solid red;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: red;" class="fa-solid fa-circle-exclamation"></i>
             <span>Please fill all fields</span>
           </div>
         </div>';
         }
       ?>
       <h2>Edit short term rental</h2>
       <form method="post" enctype="multipart/form-data" class="add-new-property-form">
         <div class="add-new-property-input-box">
            <label>Rental title</label>
            <input type="text" placeholder="Enter a title" class="input-focus" value="<?= $rentalTitle ?>"  name="rentalTitle"/>
         </div>
         <div class="add-new-property-input-box">
           <label>Address</label>
           <input type="text" placeholder="Enter address" class="input-focus"  value="<?= $rentalAddress ?>"   name="rentalAddress"/>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>City</label>
             <input type="text" placeholder="Enter city" class="input-focus" value="<?= $rentalCity ?>"   name="rentalCity"/>
           </div>
           <div class="add-new-property-input-box">
             <label>Country</label>
             <input type="text" placeholder="Enter country" class="input-focus"  value="<?= $rentalCountry ?>"  name="rentalCountry" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <div class="add-new-property-column">
             <div class="add-new-property-select-box">
               <label for="property-type" id="add-select-label">Type</label>
               <select id="property-type" name="rentalType">
                  <option hidden><?= $rentalType ?></option>
                  <option>House</option>
                  <option>Apartment</option>
                  <option>Duplex</option>
                  <option>Villa</option>
                  <option>Farm house</option>
                  <option>Cabin</option>
                  <option>Cottage</option>
                  <option>Chalet</option>
                  <option>Bungalow</option>

               </select>
             </div>
             <div class="add-new-property-select-box">
               <label for="property-status" id="add-select-label">Status</label>
               <select id="property-status" name="rentalStatus">
                 <option hidden><?= $rentalStatus ?></option>
                 <option>Available</option>
                 <option>Booked</option>
               </select>
             </div>
           </div>
         </div>
         <div class="add-new-property-input-box">
         <div class="add-new-property-select-box">
               <label for="property-type" id="add-select-label">Listing type</label>
               <select id="property-type" name="rentalListingType" >
                  <option hidden><?= $rentalListingType ?></option>
                  <option>Entire place</option>
                  <option>Private room</option>
                  <option>Shared room</option>
                  <option>Hotel room</option>
                  <option>Unique stays</option>
                  <option>Bed and breakfast</option>
               </select>
             </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Asking price</label>
           <input type="number" min="1" placeholder="Price" class="input-focus" value="<?= $rentalAskingPrice ?>"  name="rentalAskingPrice" />
           <label style="display: inline-block;">
                  <input style="width: 1em;height: 1em;" type="radio" name="perWeekPerNight" value="per week" <?= ($perWeekPerNight === 'per week') ? 'checked' : '' ?>> per week
                  <input style="width: 1em;height: 1em;" type="radio" name="perWeekPerNight" value="per night" <?= ($perWeekPerNight === 'per night') ? 'checked' : '' ?>> per night
            </label>
         </div>
         <div class="add-new-property-input-box">
           <label style="display: inline-block;">
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="$" <?= ($rentalCurrency === '$') ? 'checked' : '' ?>>USD ($)
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="€" <?= ($rentalCurrency === '€') ? 'checked' : '' ?>>EUR (€)
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="£" <?= ($rentalCurrency === '£') ? 'checked' : '' ?>>GBP (£)
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="¥" <?= ($rentalCurrency === '¥') ? 'checked' : '' ?>>JPY (¥)
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="DA" <?= ($rentalCurrency === 'DA') ? 'checked' : '' ?>>DZD (DA)
            </label>
         </div>
         <div class="add-new-property-input-box">
         <label>
             Rental images
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">The first four images are required.</span>
             </span>
           </label>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Main image</label>
               <input type="file" id="add-property-image-input" name="rentalMainImage" onchange="displayImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">First image</label>
               <input type="file" id="add-property-image-input"  name="rentalFirstImage" onchange="displayFirstImage(event)" >
             </div>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Second image</label>
               <input type="file" id="add-property-image-input" name="rentalSecondImage" onchange="displaySecondImage(event)" >
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Third image</label>
               <input type="file" id="add-property-image-input"  name="rentalThirdImage" onchange="displayThirdImage(event)">
             </div>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Fourth image</label>
               <input type="file" id="add-property-image-input"  name="rentalFourthImage" onchange="displayFourthImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Fifth image</label>
               <input type="file" id="add-property-image-input"  name="rentalFifthImage" onchange="displayFifthImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Sixth image</label>
               <input type="file" id="add-property-image-input"  name="rentalSixthImage" onchange="displaySixthImage(event)">
             </div>
           </div>
         </div>
         <div class="add-new-property-input-box" id="displayChosenImages">
           <h5 style="text-align: center;background:white;position: relative;top: -15px;">Chosen images</h5>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
              <div id="image-preview" class="image-preview" style="background-image: url(../rentals/<?= $rentalMainImage?>);" onclick="displayFullScreen(this)" ></div>
              <div id="image-preview-one" class="image-preview" style="background-image: url(../rentals/<?= $rentalFirstImage?>);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-two" class="image-preview" style="background-image: url(../rentals/<?= $rentalSecondImage?>);" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-three" class="image-preview" style="background-image: url(../rentals/<?= $rentalThirdImage?>);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-four" class="image-preview" style="background-image: url(../rentals/<?= $rentalFourthImage?>);" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-five" class="image-preview" style="background-image: url(../rentals/<?= $rentalFifthImage?>);" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-six" class="image-preview" style="background-image: url(../rentals/<?= $rentalSixthImage?>);" onclick="displayFullScreen(this)" ></div>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Details</label>
           <div class="add-new-property-input-box">
             <label>Accommodates</label>
             <input type="text" placeholder="The maximum number of guests that can stay in the property" class="input-focus" value="<?= $accommodation ?>"   name="accommodation"/>
           </div>
           <div class="add-new-property-input-box">
           <label>
             Amenities
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">The size should be in square meters</span>
             </span>
            </label>
           <textarea style="height: 50px;" type="text" placeholder="List of amenities that your property offers, such as Wi-Fi, kitchen, TV, air conditioning, etc." class="input-focus"  name="Amenities"><?= $Amenities ?></textarea>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" min="10" placeholder="Size" class="input-focus" value="<?= $size ?>"  name="size" />
             <input type="number" min="1" placeholder="Number of bedrooms" class="input-focus" value="<?= $Bedrooms ?>"  name="Bedrooms"/>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" min="1" placeholder="Number of bathrooms" class="input-focus" value="<?= $Bathrooms ?>"  name="Bathrooms"/>
             <input type="text" placeholder="Garage" class="input-focus" value="<?= $rentalGarage ?>"  name="rentalGarage"/>
             <input type="text" placeholder="Outdoors" class="input-focus" value="<?= $rentalOutdoors ?>"  name="rentalOutdoors" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Availability</label>
           <div class="add-new-property-column" id="add-property-column">
             <label>From:</label>
             <input type="date" class="input-focus" value="<?= $AvailabilityFrom ?>"  name="AvailabilityFrom" />
             <label>To:</label>
             <input type="date" class="input-focus" value="<?= $AvailabilityTo ?>"  name="AvailabilityTo"/>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>House rules</label>
           <textarea style="height: 50px;" type="text" placeholder="What are the house rules ex: no pets , no smoking ..." class="input-focus"  name="HouseRules"><?= $HouseRules ?></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Description</label>
           <textarea  maxlength="300" type="text" placeholder="Enter a property description" class="input-focus"  name="rentalDescription"><?= $rentalDescription ?></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Important notes</label>
           <textarea  maxlength="300" type="text" placeholder="Notes about the rental ex: it's a shared bathrooms, there is no AC..." class="input-focus"  name="notes"><?= $notes ?></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Host name</label>
           <input type="text" placeholder="Host name and last name" class="input-focus" value="<?= $HostName ?>"  name="HostName"/>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>Posted by</label>
             <input type="text" value="<?php echo $_SESSION['agent_name']?>" readonly name="rentalPosterName">
           </div>
           <div class="add-new-property-input-box">
             <label>&nbsp;&nbsp;&nbsp;</label>
             <input type="text" value="<?php echo $_SESSION['agent_last_name']?>" readonly name="rentalPosterLastName">
           </div>
         </div>
         <button type="submit" name="edit_rental">Edit</button>
       </form>
     </section>
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
   // end of this part
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
   function displayImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreview = document.getElementById('image-preview');
       imagePreview.style.backgroundImage = "url('" + reader.result + "')";
     };
     reader.readAsDataURL(input.files[0]);
   }
   function displayFirstImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewOne = document.getElementById('image-preview-one');
       imagePreviewOne.style.backgroundImage = "url('" + reader.result + "')";
     };
     reader.readAsDataURL(input.files[0]);
   }
   function displaySecondImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewTwo = document.getElementById('image-preview-two');
       imagePreviewTwo.style.backgroundImage = "url('" + reader.result + "')";
     };
     reader.readAsDataURL(input.files[0]);
    }
   function displayThirdImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewThree = document.getElementById('image-preview-three');
       imagePreviewThree.style.backgroundImage = "url('" + reader.result + "')";
     };
     reader.readAsDataURL(input.files[0]);
   }


















   function displayFourthImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewFour = document.getElementById('image-preview-four');
       imagePreviewFour.style.backgroundImage = "url('" + reader.result + "')";
       imagePreviewFour.style.display = "block"; // Show the preview div
     };
     reader.readAsDataURL(input.files[0]);
   }
   function displayFifthImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewFive = document.getElementById('image-preview-five');
       imagePreviewFive.style.backgroundImage = "url('" + reader.result + "')";
       imagePreviewFive.style.display = "block"; // Show the preview div
     };
     reader.readAsDataURL(input.files[0]);
   }
   function displaySixthImage(event)
   {
     var input = event.target;
     var reader = new FileReader();
     reader.onload = function()
     {
       var imagePreviewSix = document.getElementById('image-preview-six');
       imagePreviewSix.style.backgroundImage = "url('" + reader.result + "')";
       imagePreviewSix.style.display = "block"; // Show the preview div
     };
     reader.readAsDataURL(input.files[0]);
    }
   
   function displayFullScreen(img)
   {
     // Extract the image URL from the background-image property
     var backgroundImage = img.style.backgroundImage;
     var imageUrl = backgroundImage.slice(5, -2);
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
     fullImg.src = imageUrl;
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
     overlay.addEventListener("click", function ()
     {
       document.body.removeChild(overlay);
     });
    }
 </script>
</html>


