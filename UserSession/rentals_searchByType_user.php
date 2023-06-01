<?php
    /**done a 100% */
    @include '../Configuration/connect.php';
    require("../Configuration/command.php");
     session_start();
     if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
    {
     header('location:../Register/log-in.php');
     }
    $properties=display();
    $noResult=0;
    $rentalListingType = ''; // Set default value to an empty string
    if(isset($_GET['rentalListingType']))
    {
        $rentalListingType = $_GET['rentalListingType'];
    }
    // Query the database to get properties of the requested type
    $stmt = $connect->prepare("SELECT * FROM `vacationrentals` WHERE `rentalListingType` = :rentalListingType");
    $stmt->execute(['rentalListingType' => $rentalListingType]);
    $properties = $stmt->fetchAll(PDO::FETCH_OBJ);
    // Check if any properties were found
    $show = false;
    if(count($properties) > 0)
    {
        $show = true;
    }
    // If properties were found, display them
    if($show)
    {
    ?>
        <?php foreach($properties as $property):?>        
        <?php endforeach;?>
    <?php
    }
    else
    {   
        $noResult=1;   
    } 
?>
<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="../CssFiles/properties.css">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/all.min.css">
     <title>Ziri|Short term rentals</title>
 </head>
 <body>
     <!-- the header -->
     <?php
         require('../Header/header_user.php')
       ?>
       <!-- properties page -->
       <div class="properties-page" id="property-page" style="background-color: #1a1a1a;">
         <div class="properties-page-heading">
             <h1>Short term rentals</h1>
         </div>
         <div class="thing">
             <div class="search-bar">
                 <input type="text" name="text" id="searchBox" onkeyup="search()" class="search-bar-input" placeholder="search...">
                 <span class="search-icon"> 
                     <i class="fa-solid fa-magnifying-glass"></i>
                 </span>
             </div>
             <div class="form-control max-w-xs">
                 <label class="label">
                     <span class="label-text">Status</span>
                 </label>
                 <select class="select" id="searchBoxStatus" onchange="searchProperties()">
                     <option value="">All</option> 
                     <?php
                         include("../Configuration/connect.php");
                         $status="SELECT DISTINCT rentalStatus FROM vacationrentals ORDER BY rentalStatus";
                         $resultS=$connect->query($status);
                         while($row=$resultS->fetch(PDO::FETCH_OBJ)){
                      ?>    
                     <option class="option" value="<?= $row->rentalStatus; ?>"><?= $row->rentalStatus; ?></option> 
                     <?php } ?>    
                 </select>
             </div>
             <div class="form-control max-w-xs">
                 <label class="label">
                      <span class="label-text">Property type</span>
                 </label>
                 <select class="select" name="propertyType" id="searchBoxType" onchange="searchProperties()">
                     <option value="">All</option>
                     <?php
                         $type="SELECT DISTINCT rentalType FROM vacationrentals ORDER BY rentalType";
                         $resultT=$connect->query($type);
                         while($row=$resultT->fetch(PDO::FETCH_OBJ)){
                       ?>    
                      <option name="rentalType" class="option" value="<?= $row->rentalType; ?>"><?= $row->rentalType; ?></option> 
                     <?php } ?>    
                  </select>
              </div>
              <div class="form-control max-w-xs">
                 <label class="label">
                      <span class="label-text">rental Type</span>
                 </label>
                 <select class="select" name="rentalListingType" id="searchBoxListingType" onchange="redirectToPage()">
                     <option value="">All</option>  
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Entire%20place">Entire place</option>
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Private%20room">Private room</option>
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Shared%20room">Shared room</option>
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Hotel%20room">Hotel room</option>
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Unique%20stays">Unique stays</option>
                     <option class="option" value="../UserSession/rentals_searchByType_user.php?rentalListingType=Bed%20and%20breakfast">Bed and breakfast</option>
                 </select>
             </div>
         </div>
         <?php 
         if($noResult)
         {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">No properties found for "'.$propertyType.'" </div>';
          }
         ?>
         <div class="properties-page-container">
         <?php foreach($properties as $property):?>
                 <div class="property-box">
                     <img class="property-box-img" name="rentalMainImage" src="../rentals/<?= $property->rentalMainImage?>">
                     <div class="property-box-overlay">
                         <a class="fancy" href="../UserSession/rentalDetails_user.php?rentalMoreDetails=<?php echo $property->id ?>">
                             <span class="overlay-box-btn-text">View rental</span>
                         </a>
                     </div>
                     <span name="rentalStatus" class="property-status-box" ><?= $property->rentalStatus?></span>
                     <h2 name="rentalTitle" style="font-weight:lighter;"><?= $property->rentalTitle?></h2>
                     <h4 name="rentalType" style="margin-top: 0;margin-bottom:0px; font-weight:lighter;"><?= $property->rentalType?></h4>
                     <h4 name="rentalListingType" style="margin-top: 0;margin-bottom:0px;"><?= $property->rentalListingType?></h4>
                     <h5 name="rentalAddress" style="margin-top: 0;margin-bottom:0px; font-size:16px;"><?= $property->rentalAddress?></h5>
                     <h5 name="rentalCity" style="margin-top: 0;margin-bottom:0px; font-size:16px;font-weight:600;"><?= $property->rentalCity?>,<?= $property->rentalCountry?></h5>
                     <div class="property-box-features" >
                         |&nbsp;&nbsp;<i class="fa-solid fa-bed">&nbsp;<span name="Bedrooms"><?= $property->Bedrooms?></span>&nbsp;bd</i>&nbsp;|
                         <i class="fa-solid fa-shower">&nbsp;<span name="Bathrooms"><?= $property->Bathrooms?></span>&nbsp;bt</i>&nbsp;|
                         <i class="fa-solid fa-maximize">&nbsp;<span name="size"><?= $property->size?>&nbsp;m2</span></i>&nbsp;|
                     </div>
                     <div class="property-box-price">
                         <span name="Availability" style=" style="font-size: 17px;">From:&nbsp;<?= $property->AvailabilityFrom?>&nbsp;To:&nbsp;<?= $property->AvailabilityTo?></span>
                     </div>
                     <div class="property-box-price">
                         <span name="rentalAskingPrice" style="font-weight:bolder; margin-bottom:1px;" style="font-size: 17px; text-transform:uppercase;"><?= $property->rentalAskingPrice?><?= $property->rentalCurrency?></span>
                         <span name="perWeekPerNight" style="font-weight:bolder;" style="font-size: 15px;"><?= $property->perWeekPerNight?></span>
                     </div> 
                     <?php if ($property->Verified == 'yes'): ?>
                         <div style="position: absolute; bottom: 0;left: 0;">
                             <i style="color: blue;" class="agent-box-verify fas fa-check-circle"></i>
                         </div>
                      <?php endif; ?>    
                 </div>
             <?php endforeach;?>
         </div>
     </div>
     <!-- footer-->
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
     const main = document.getElementById("property-page");
     const footer = document.getElementById("footer");
     icon.addEventListener('click', function() 
     {
      if (main.style.display === 'none')
      {
         main.style.display = 'block';
         footer.style.display = 'block';
       }
      else 
      {
         main.style.display = 'none';
         footer.style.display = 'none';
      }
     }
     );
     const search = () =>
       {
         const searchBox = document.getElementById("searchBox").value.toUpperCase(); // Retrieve the value entered in the search box and convert it to uppercase
         const properties = document.getElementById("properties-page-container"); // Retrieve the container element that holds the property boxes
         const property = document.querySelectorAll(".property-box"); // Retrieve all the property box elements on the page
         for(var i=0; i < property.length; i++)
         {
             let matchFound = false;
             const details = property[i].querySelectorAll(".property-box h2, .property-box h4, .property-box h5, .property-box p");// Retrieve the specific details of each property box (h2, h4, h5, p)
             if(details)
             {
                 details.forEach((detail) =>// Loop through the details of each property box
                 {
                     let textValue = detail.textContent || detail.innerHTML;
                     if(textValue.toUpperCase().indexOf(searchBox) !== -1) // Check if the text content matches the search query
                     {
                         matchFound = true;
                     }
                 })
             }
             // Display or hide the property box element based on matchFound value
             if(matchFound)
             {
                 property[i].style.display = "";
             }
             else
             {
                 property[i].style.display = "none";
             }          
          }
       }
     function goBack()
     {
       window.history.back();
     }
     function searchProperties()
     {
       var status = document.getElementById("searchBoxStatus").value; // Retrieve the selected values from the status and type filters
       var type = document.getElementById("searchBoxType").value;
       var properties = document.getElementsByClassName("property-box");
       for (var i = 0; i < properties.length; i++)
       {
         var property = properties[i];
         var propertyStatus = property.querySelector("[name='rentalStatus']").textContent.trim();// Retrieve the specific status and type values for each property box
         var propertyType = property.querySelector("[name='rentalType']").textContent.trim();// Retrieve the specific status and type values for each property box
         if (status == "" || propertyStatus == status)// Apply styles to display or hide the property box based on the filter criteria
         {
            if (type == "" || propertyType == type)
            {
              property.style.display = "flex";
            }
            else
            {
             property.style.display = "none";
            }
          }
          else
         {
           property.style.display = "none";
         }
        }
       }

       function redirectToPage() {
     var selectElement = document.getElementById("searchBoxListingType");
     var selectedValue = selectElement.value;
     if (selectedValue !== "") {
      window.location.href = selectedValue;
    }
    }
</script>
</html> 