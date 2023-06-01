<?php
  /**done a 100% */
  @include '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
  {
   header('location:../Register/log-in.php');
  }
  $success=0;
  $fail=0;
  $limit=0;
  if(isset($_POST['add_rental']))
  {
    $rentalTitle = $_POST['rentalTitle'];
    $rentalAddress = $_POST['rentalAddress'];
    $rentalCity = $_POST['rentalCity'];
    $rentalCountry = $_POST['rentalCountry'];
    $rentalType = $_POST['rentalType'];
    $rentalStatus = $_POST['rentalStatus'];
    $rentalListingType = $_POST['rentalListingType'];
    $rentalAskingPrice = $_POST['rentalAskingPrice'];
    $size = $_POST['size'];
    $AvailabilityFrom = $_POST['AvailabilityFrom'];
    $AvailabilityTo = $_POST['AvailabilityTo'];
    $accommodation = $_POST['accommodation'];
    $Bedrooms = $_POST['Bedrooms'];
    $Bathrooms = $_POST['Bathrooms'];
    $Amenities = $_POST['Amenities'];
    $rentalGarage = $_POST['rentalGarage'];
    $rentalOutdoors = $_POST['rentalOutdoors'];
    $HouseRules = $_POST['HouseRules'];
    $rentalDescription = $_POST['rentalDescription'];
    $notes = $_POST['notes'];
    $HostName = $_POST['HostName'];
    $rentalPosterName = $_POST['rentalPosterName'];
    $rentalPosterLastName = $_POST['rentalPosterLastName'];
    $perWeekPerNight = isset($_POST['perWeekPerNight']) ? $_POST['perWeekPerNight'] : '';
    $rentalCurrency = isset($_POST['rentalCurrency']) ? $_POST['rentalCurrency'] : '';
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
    //checking empty condition
    if($rentalTitle=='' or $rentalAddress=='' or $rentalCity=='' or $rentalCountry=='' or $rentalMainImage=='' or $rentalFirstImage=='' or $rentalSecondImage=='' or $rentalThirdImage=='' or $rentalListingType=='' or  $rentalType=='' or $Bedrooms=='' or $Bathrooms=='' or $Amenities=='' or $size=='' or
    $HouseRules=='' or $AvailabilityFrom=='' or $AvailabilityTo=='' or $rentalAskingPrice=='' or $perWeekPerNight=='' or $rentalCurrency=='' or $rentalDescription=='' or $notes=='' or $HostName=='' or $rentalStatus=='' or $rentalGarage=='' or $rentalOutdoors=='' or $rentalPosterName=='' or $rentalPosterLastName=='' or $accommodation==''
    ){
       $fail=1;
       
    }
    else
    {
      $sql = "SELECT COUNT(*) AS rentalCount FROM vacationrentals WHERE rentalPosterName = '{$_SESSION['user_name']}' AND rentalPosterLastName = '{$_SESSION['user_last_name']}'";
      $result = $connect->prepare($sql);
      $result->execute();
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $rentalCount = $row['rentalCount'];
      if($rentalCount >= 30)
      {
        $limit=1;
      }
      else 
      {
        move_uploaded_file($temp_rentalMainImage, "../rentals/$rentalMainImage");
        move_uploaded_file($temp_rentalFirstImage, "../rentals/$rentalFirstImage");
        move_uploaded_file($temp_rentalSecondImage, "../rentals/$rentalSecondImage");
        move_uploaded_file($temp_rentalThirdImage, "../rentals/$rentalThirdImage");
        move_uploaded_file($temp_rentalFourthImage, "../rentals/$rentalFourthImage");
        move_uploaded_file($temp_rentalFifthImage, "../rentals/$rentalFifthImage");
        move_uploaded_file($temp_rentalSixthImage, "../rentals/$rentalSixthImage");
      //insert query
      $insert_vacationrentals="insert into `vacationrentals` (rentalTitle, rentalAddress, rentalCity, rentalCountry, rentalMainImage, rentalFirstImage, rentalSecondImage, rentalThirdImage, rentalFourthImage, rentalFifthImage, rentalSixthImage, rentalListingType, rentalType, Bedrooms, Bathrooms, Amenities, size, HouseRules, AvailabilityFrom, AvailabilityTo, rentalAskingPrice, perWeekPerNight, rentalCurrency, rentalDescription, notes, HostName , rentalStatus, rentalGarage, rentalOutdoors, rentalPosterName, rentalPosterLastName, accommodation) values ('$rentalTitle', '$rentalAddress', '$rentalCity', '$rentalCountry', '$rentalMainImage', '$rentalFirstImage', '$rentalSecondImage', '$rentalThirdImage', '$rentalFourthImage', '$rentalFifthImage', '$rentalSixthImage', '$rentalListingType', '$rentalType', '$Bedrooms', '$Bathrooms', '$Amenities', '$size', '$HouseRules', '$AvailabilityFrom', '$AvailabilityTo', '$rentalAskingPrice', '$perWeekPerNight', '$rentalCurrency', '$rentalDescription', '$notes', '$HostName', '$rentalStatus', '$rentalGarage', '$rentalOutdoors', '$rentalPosterName' ,'$rentalPosterLastName', '$accommodation')";
      $result = $connect->query($insert_vacationrentals);
      if($result)
      {
        $success=1;
      }
    }
    }
  }  
  // Retrieve the field from the user table
  $query = "SELECT phoneNumber FROM user WHERE user_type='user' AND name = '{$_SESSION['user_name']}' AND last_name = '{$_SESSION['user_last_name']}'";
  $stmt = $connect->prepare($query);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $phoneNumber = $user['phoneNumber'];
  $pending=0;
  if (empty($phoneNumber))
  {
   $pending = 1;
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
    <title>Ziri|Add new rental</title>
 </head>
 <body>
   <?php
     require('../Header/header_user.php')
   ?>
   <main id="main">
      <section class="container" <?php if(empty($phoneNumber)){echo "<section class=\"container\" style=\"display:none !important;\">";}   ?>>
       <?php
         if($success)
         {
           echo '<div style="border: 1px solid green;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: green;" class="fa-regular fa-circle-check"></i>
             <span>Rental added successfully!</span>
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
         if($limit)
         {
           echo '<div style="border: 1px solid red;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: red;" class="fa-solid fa-circle-exclamation"></i>
             <span>You have reached the limit of short-term rentals post</span>
           </div>
         </div>';
         }
       ?>
       <h2>Add new rental</h2>
       <form method="post" enctype="multipart/form-data" class="add-new-property-form">
         <div class="add-new-property-input-box">
            <label>Rental title</label>
            <input type="text" placeholder="Enter a title" class="input-focus"  name="rentalTitle"/>
         </div>
         <div class="add-new-property-input-box">
           <label>Address</label>
           <input type="text" placeholder="Enter address" class="input-focus"   name="rentalAddress"/>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>City</label>
             <input type="text" placeholder="Enter city" class="input-focus"   name="rentalCity"/>
           </div>
           <div class="add-new-property-input-box">
             <label>Country</label>
             <input type="text" placeholder="Enter country" class="input-focus"   name="rentalCountry" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <div class="add-new-property-column">
             <div class="add-new-property-select-box">
               <label for="property-type" id="add-select-label">Type</label>
               <select id="property-type" name="rentalType">
                  <option hidden>Choose</option>
                  <option>House</option>
                  <option>Apartment</option>
                  <option>Duplex</option>
                  <option>Villa</option>
                  <option>Farm house</option>
                  <option>Cabin</option>
                  <option>Chalet</option>
                  <option>Bungalow</option>
                  <option>Bed and breakfast</option>
                  <option>Hotel</option>
               </select>
             </div>
             <div class="add-new-property-select-box">
               <label for="property-status" id="add-select-label">Status</label>
               <select id="property-status" name="rentalStatus">
                 <option hidden>Choose</option>
                 <option>Available</option>
                 <option>Booked</option>
               </select>
             </div>
           </div>
         </div>
         <div class="add-new-property-input-box">
         <div class="add-new-property-select-box">
               <label for="property-type" id="add-select-label">Listing type</label>
               <select id="property-type" name="rentalListingType">
                  <option hidden>Choose</option>
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
           <input type="number" min="1" placeholder="Price" class="input-focus"  name="rentalAskingPrice" />
           <label style="display: inline-block;">
                  <input style="width: 1em;height: 1em;" type="radio" name="perWeekPerNight" value="per week"> per week
                  <input style="width: 1em;height: 1em;" type="radio" name="perWeekPerNight" value="per night"> per night
            </label>
         </div>
         <div class="add-new-property-input-box">
           <label style="display: inline-block;">
           <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="$">USD ($)
            <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="€">EUR (€)
            <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="£">GBP (£)
            <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="¥">JPY (¥)
            <input style="width: 1em;height: 1em;" type="radio" name="rentalCurrency" value="DA">DZD (DA)
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
               <input type="file" id="add-property-image-input"  name="rentalMainImage" onchange="displayImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">First image</label>
               <input type="file" id="add-property-image-input"  name="rentalFirstImage" onchange="displayFirstImage(event)">
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
              <div id="image-preview" class="image-preview" style="background-image: url(../img/download.jpg);" onclick="displayFullScreen(this)" ></div>
              <div id="image-preview-one" class="image-preview" style="background-image: url(../img/download.jpg);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-two" class="image-preview" style="background-image: url(../img/download.jpg);" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-three" class="image-preview" style="background-image: url(../img/download.jpg);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-four" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-five" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-six" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Details</label>
           <div class="add-new-property-input-box">
             <label>Accommodates</label>
             <input type="text" placeholder="The maximum number of guests that can stay in the property" class="input-focus"   name="accommodation"/>
           </div>
           <div class="add-new-property-input-box">
           <label>
             Amenities
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">The size should be in square meters</span>
             </span>
            </label>
           <textarea style="height: 50px;" type="text" placeholder="List of amenities that your property offers, such as Wi-Fi, kitchen, TV, air conditioning, etc." class="input-focus"  name="Amenities"></textarea>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" min="10" placeholder="Size" class="input-focus"  name="size" />
             <input type="number" min="1" placeholder="Number of bedrooms" class="input-focus"  name="Bedrooms"/>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" min="1" placeholder="Number of bathrooms" class="input-focus"  name="Bathrooms"/>
             <input type="text" placeholder="Garage" class="input-focus"  name="rentalGarage"/>
             <input type="text" placeholder="Outdoors" class="input-focus"  name="rentalOutdoors" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Availability</label>
           <div class="add-new-property-column" id="add-property-column">
             <label>From:</label>
             <input type="date" class="input-focus"  name="AvailabilityFrom" />
             <label>To:</label>
             <input type="date" class="input-focus"  name="AvailabilityTo"/>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>House rules</label>
           <textarea style="height: 50px;" type="text" placeholder="What are the house rules ex: no pets , no smoking ..." class="input-focus"  name="HouseRules"></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Description</label>
           <textarea  maxlength="300" type="text" placeholder="Enter a property description" class="input-focus"  name="rentalDescription"></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Important notes</label>
           <textarea  maxlength="300" type="text" placeholder="Notes about the rental ex: it's a shared bathrooms, there is no AC..." class="input-focus"  name="notes"></textarea>
         </div>
         <div class="add-new-property-input-box">
           <label>Host name</label>
           <input type="text" placeholder="Host name and last name" class="input-focus"   name="HostName"/>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>Posted by</label>
             <input type="text" value="<?php echo $_SESSION['user_name']?>" readonly name="rentalPosterName">
           </div>
           <div class="add-new-property-input-box">
             <label>&nbsp;&nbsp;&nbsp;</label>
             <input type="text" value="<?php echo $_SESSION['user_last_name']?>" readonly name="rentalPosterLastName">
           </div>
         </div>
         <button type="submit" name="add_rental">Add</button>
       </form>
     </section>
     <?php 
       if($pending)
       {
         echo '
           <section>
             <div class="hero min-h-screen bg-base-200">
               <div class="hero-content text-center">
                 <div class="max-w-md">
                   <h2 class="text-5xl font-bold">We are sorry, but access to this feature is currently restricted</h2>
                   <p class="py-6">To gain access to this functionality, please ensure that you have submitted your contact information.</p>
                   <p class="py-6" style="font-size: 14px;">In the meantime, feel free to explore our website and familiarize yourself with our services. If you have any urgent questions or concerns, please don t hesitate to reach out to our support team <a href="../contact-us.php">here</a>.</p>
                 </div>
               </div>
             </div>
           </section>
         ';
       }
     ?>
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


