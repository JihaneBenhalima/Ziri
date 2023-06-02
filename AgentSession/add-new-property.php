<?php
  @include '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']) )
  {
   header('location:../Register/log-in.php');
  }
  $success=0;
  $fail=0;
  if(isset($_POST['add_property']))
  {
    $propertyTitle = $_POST['propertyTitle'];
    $propertyAddress = $_POST['propertyAddress'];
    $propertyCity = $_POST['propertyCity'];
    $propertyCountry = $_POST['propertyCountry'];
    $propertyType = $_POST['propertyType'];
    $propertyStatus = $_POST['propertyStatus'];
    $propertyPrice = $_POST['propertyPrice'];
    $propertyCurrency = $_POST['propertyCurrency'];
    $propertySize = $_POST['propertySize'];
    $propertyFloors = $_POST['propertyFloors'];
    $propertyNumber_of_bedrooms = $_POST['propertyNumber_of_bedrooms'];
    $propertyNumber_of_bathrooms = $_POST['propertyNumber_of_bathrooms'];
    $propertyGarage = $_POST['propertyGarage'];
    $propertyOutdoors = $_POST['propertyOutdoors'];
    $propertyDescription = $_POST['propertyDescription'];
    $posterName = $_POST['posterName'];
    $posterLastName = $_POST['posterLastName'];
    //accessing images
    $propertyMain_image = $_FILES['propertyMain_image']['name'];
    $propertyFirst_image = $_FILES['propertyFirst_image']['name'];
    $propertySecond_image = $_FILES['propertySecond_image']['name'];
    $propertyThird_image = $_FILES['propertyThird_image']['name'];
    $propertyFourth_image = $_FILES['propertyFourth_image']['name'];
    $propertyFifth_image = $_FILES['propertyFifth_image']['name'];
    $propertySixth_image = $_FILES['propertySixth_image']['name'];
    //accessing img tmp name
    $temp_propertyMain_image = $_FILES['propertyMain_image']['tmp_name'];
    $temp_propertyFirst_image = $_FILES['propertyFirst_image']['tmp_name'];
    $temp_propertySecond_image = $_FILES['propertySecond_image']['tmp_name'];
    $temp_propertyThird_image = $_FILES['propertyThird_image']['tmp_name'];
    $temp_propertyFourth_image = $_FILES['propertyFourth_image']['tmp_name'];
    $temp_propertyFifth_image = $_FILES['propertyFifth_image']['tmp_name'];
    $temp_propertySixth_image = $_FILES['propertySixth_image']['tmp_name'];
    //checking empty condition
    if($propertyTitle=='' or $propertyAddress=='' or $propertyCity=='' or $propertyCountry=='' or $propertyType=='' or $propertyStatus=='' or $propertyPrice=='' or $propertyCurrency=='' or $propertySize=='' or $propertyFloors=='' or  $propertyNumber_of_bedrooms=='' or $propertyNumber_of_bathrooms=='' or $propertyGarage=='' or $propertyOutdoors=='' or $propertyDescription=='' or
    $propertyMain_image=='' or $propertyFirst_image=='' or $propertySecond_image=='' or $propertyThird_image=='' or $posterName=='' or $posterLastName==''
    )
    {
      $fail=1;
    }
    else
    {
      move_uploaded_file($temp_propertyMain_image, "../uploads/$propertyMain_image");
      move_uploaded_file($temp_propertyFirst_image, "../uploads/$propertyFirst_image");
      move_uploaded_file($temp_propertySecond_image, "../uploads/$propertySecond_image");
      move_uploaded_file($temp_propertyThird_image, "../uploads/$propertyThird_image");
      move_uploaded_file($temp_propertyFourth_image, "../uploads/$propertyFourth_image");
      move_uploaded_file($temp_propertyFifth_image, "../uploads/$propertyFifth_image");
      move_uploaded_file($temp_propertySixth_image, "../uploads/$propertySixth_image");
      //insert query
      $insert_property="insert into `property` (propertyTitle, propertyAddress, propertyCity, propertyCountry, propertyType, propertyStatus, propertyPrice, propertyCurrency, propertyMain_image, propertyFirst_image, propertySecond_image, propertyThird_image,propertyFourth_image, propertyFifth_image, propertySixth_image, propertySize, propertyFloors, propertyNumber_of_bedrooms, propertyNumber_of_bathrooms, propertyGarage, propertyOutdoors, propertyDescription, posterName, posterLastName) values ('$propertyTitle', '$propertyAddress', '$propertyCity', '$propertyCountry', '$propertyType', '$propertyStatus', '$propertyPrice', '$propertyCurrency', '$propertyMain_image', '$propertyFirst_image', '$propertySecond_image', '$propertyThird_image', '$propertyFourth_image', '$propertyFifth_image', '$propertySixth_image', '$propertySize', '$propertyFloors', '$propertyNumber_of_bedrooms', '$propertyNumber_of_bathrooms', '$propertyGarage', '$propertyOutdoors', '$propertyDescription', '$posterName', '$posterLastName')";
      $result = $connect->query($insert_property);
      if($result)
      {
        $success=1;
      }
    }
  }
  // Retrieve the verified field from the user table
  $query = "SELECT Verified FROM user WHERE user_type='agent' AND name = '{$_SESSION['agent_name']}' AND last_name = '{$_SESSION['agent_last_name']}'";
  $stmt = $connect->prepare($query);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $verified = $user['Verified'];
  $pending=0;
  if (empty($verified))
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
    <title>Ziri|Add new property</title>
 </head>
 <body>
 <?php
require('../Header/header_agent.php')
?>
   <main id="main">
      <section class="container" <?php if(empty($verified)){echo "<section class=\"container\" style=\"display:none !important;\">";}   ?> >
      <?php
         if($success)
         {
           echo '<div style="border: 1px solid green;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: green;" class="fa-regular fa-circle-check"></i>
             <span>property added successfully!</span>
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
       <h2>Add new property</h2>
       <form method="post" enctype="multipart/form-data" class="add-new-property-form">
         <div class="add-new-property-input-box">
            <label>Property title</label>
            <input type="text" placeholder="Enter a title for you property" class="input-focus" required name="propertyTitle"/>
         </div>
         <div class="add-new-property-input-box">
           <label>Address</label>
           <input type="text" placeholder="Enter address" class="input-focus" required  name="propertyAddress"/>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>City</label>
             <input type="text" placeholder="Enter city" class="input-focus" required  name="propertyCity"/>
           </div>
           <div class="add-new-property-input-box">
             <label>Country</label>
             <input type="text" placeholder="Enter country" class="input-focus" required  name="propertyCountry" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <div class="add-new-property-column">
             <div class="add-new-property-select-box">
               <label for="property-type" id="add-select-label">Type</label>
               <select id="property-type" name="propertyType">
                  <option hidden>Choose</option>
                  <option>Family home</option>
                  <option>Apartment</option>
                  <option>Duplex</option>
                  <option>Villa</option>
                  <option>Farm house</option>
                  <option>Retail property</option>
                  <option>Office building</option>
                  <option>Warehouse</option>
                  <option>Land</option>
               </select>
             </div>
             <div class="add-new-property-select-box">
               <label for="property-status" id="add-select-label">Status</label>
               <select id="property-status" name="propertyStatus">
                 <option hidden>Choose</option>
                 <option>For sale</option>
                 <option>For rent</option>
                 <option>Sold</option>
                 <option>Rented</option>
               </select>
             </div>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>
             Asking price
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">If the property posted is for rent, the price should be per month</span>
             </span>
           </label>
           <input type="number" min="1" placeholder="Price" class="input-focus" required name="propertyPrice" />
         </div>
         <label style="display: inline-block;">
            <input style="width: 1em;height: 1em;" type="radio" name="propertyCurrency" value="$">USD ($)
            <input style="width: 1em;height: 1em;" type="radio" name="propertyCurrency" value="€">EUR (€)
            <input style="width: 1em;height: 1em;" type="radio" name="propertyCurrency" value="£">GBP (£)
            <input style="width: 1em;height: 1em;" type="radio" name="propertyCurrency" value="¥">JPY (¥)
            <input style="width: 1em;height: 1em;" type="radio" name="propertyCurrency" value="DA">DZD (DA)
         </label>
         <div class="add-new-property-input-box">
          <label>
             Property images
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">The first four images are required.</span>
             </span>
           </label>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Main image</label>
               <input type="file" id="add-property-image-input"  name="propertyMain_image" onchange="displayImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">First image</label>
               <input type="file" id="add-property-image-input"  name="propertyFirst_image" onchange="displayFirstImage(event)">
             </div>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Second image</label>
               <input type="file" id="add-property-image-input" name="propertySecond_image" onchange="displaySecondImage(event)" >
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Third image</label>
               <input type="file" id="add-property-image-input"  name="propertyThird_image" onchange="displayThirdImage(event)">
             </div>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Fourth image</label>
               <input type="file" id="add-property-image-input"  name="propertyFourth_image" onchange="displayFourthImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Fifth image</label>
               <input type="file" id="add-property-image-input"  name="propertyFifth_image" onchange="displayFifthImage(event)">
             </div>
             <div class="add-property-img">
               <label for="image-input" id="add-property-img-label">Sixth image</label>
               <input type="file" id="add-property-image-input"  name="propertySixth_image" onchange="displaySixthImage(event)">
             </div>
           </div>
         </div>
         <div class="add-new-property-input-box" id="displayChosenImages">
           <h5 style="text-align: center;background:white;position: relative;top: -15px;">Chosen images</h5>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
              <div id="image-preview" class="image-preview" style="background-image: url(../img/uploadImage.png);" onclick="displayFullScreen(this)" ></div>
              <div id="image-preview-one" class="image-preview" style="background-image: url(../img/uploadImage.png);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-two" class="image-preview" style="background-image: url(../img/uploadImage.png);" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-three" class="image-preview" style="background-image: url(../img/uploadImage.png);" onclick="displayFullScreen(this)" ></div>
           </div>
           <div class="add-new-property-column" id="add-property-column" style="column-gap:5px;justify-content: center;">
             <div id="image-preview-four" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-five" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
             <div id="image-preview-six" class="image-preview" style="display:none;" onclick="displayFullScreen(this)" ></div>
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>
            Details
             <span class="icon">
               <span><i class="fa-regular fa-circle-question"></i></span>
               <span class="tooltip">Size must be in square meters</span>
             </span>
           </label>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" placeholder="Size" class="input-focus" min="1" required name="propertySize"/>
             <input type="number" placeholder="floors/floor level" class="input-focus" min="1" required name="propertyFloors"/>
             <input type="number" min="0" placeholder="Number of bedrooms" class="input-focus" required name="propertyNumber_of_bedrooms"/>
           </div>
           <div class="add-new-property-column" id="add-property-column">
             <input type="number" placeholder="Number of bathrooms" class="input-focus" min="0" required name="propertyNumber_of_bathrooms"/>
             <input type="text" placeholder="Garage" class="input-focus" required name="propertyGarage"/>
             <input type="text" placeholder="Outdoors" class="input-focus" required name="propertyOutdoors" />
           </div>
         </div>
         <div class="add-new-property-input-box">
           <label>Description</label>
           <textarea type="text" placeholder="Enter a property description" class="input-focus" required name="propertyDescription"></textarea>
         </div>
         <div class="add-new-property-column">
           <div class="add-new-property-input-box">
             <label>Posted by</label>
             <input type="text" value="<?php echo $_SESSION['agent_name']?>" readonly name="posterName">
           </div>
           <div class="add-new-property-input-box">
             <label>&nbsp;&nbsp;&nbsp;</label>
             <input type="text" value="<?php echo $_SESSION['agent_last_name']?>" readonly name="posterLastName">
           </div>
         </div>
         <button type="submit" name="add_property">Add property</button>
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
                   <h2 class="text-5xl font-bold">We are sorry, but access to this feature is currently restricted to verified agents only</h2>
                   <p class="py-6">To gain access to this functionality, please ensure that you have submitted your license for verification. Our team is working diligently to review your application, and we will notify you via email once you have been verified</p>
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


