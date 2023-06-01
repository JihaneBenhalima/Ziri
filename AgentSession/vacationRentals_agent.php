<?php
    /**done a 100% */
    require("../Configuration/command.php");
    $properties=displayRentals();
    include("../Configuration/connect.php");
    session_start();
    if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
    {
     header('location:../Register/log-in.php');
    }
    $records_per_page = 12;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
    } else {
    $current_page = 1;
    }
    // SQL query to retrieve total number of records
    $total_query = $connect->query("SELECT COUNT(*) as total_records FROM vacationrentals ");
    $total_results = $total_query->fetch(PDO::FETCH_ASSOC)['total_records'];
    $total_pages = ceil($total_results / $records_per_page);
    // SQL query to retrieve records for current page
    $start = ($current_page - 1) * $records_per_page;
    $users_query = $connect->prepare("SELECT * FROM vacationrentals LIMIT :start, :records_per_page");
    $users_query->bindParam(':start', $start, PDO::PARAM_INT);
    $users_query->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
    $users_query->execute();
    $properties = $users_query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
 <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="../CssFiles/properties.css">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/all.min.css">
     <link rel="stylesheet" href="../CssFiles/header.css">
     <title>Ziri|Properties</title>
 </head>
 <body>
     <?php
         require('../Header/header_agent.php')
     ?>
     <!-- properties page -->
     <div class="properties-page" id="property-page" style="background-color: #1a1a1a;">
         <div class="properties-page-heading">
             <h1>Our Proprieties</h1>
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
                     <span class="label-text">Listing type</span>
                 </label>
                 <select class="select" id="searchBoxListing" onchange="searchProperties()">
                     <option value="">All</option> 
                     <?php
                         include("../Configuration/connect.php");
                         $status="SELECT DISTINCT rentalListingType FROM vacationrentals ORDER BY rentalListingType";
                         $resultS=$connect->query($status);
                         while($row=$resultS->fetch(PDO::FETCH_OBJ)){
                      ?>    
                     <option class="option" value="<?= $row->rentalListingType; ?>"><?= $row->rentalListingType; ?></option> 
                     <?php } ?>    
                 </select>
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
         </div>
         <div class="properties-page-container">
             <?php foreach($properties as $property):?>
                 <div class="property-box">
                     <img class="property-box-img" name="rentalMainImage" src="../rentals/<?= $property->rentalMainImage?>">
                     <div class="property-box-overlay">
                         <a class="fancy" href="../AgentSession/rentalDetails_agent.php?rentalMoreDetails=<?php echo $property->id ?>">
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
         <div class="pagination">
             <?php if ($current_page > 1) : ?>
             <a href="?page=<?= $current_page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
             <?php endif; ?>
             <?php for ($i = $current_page - 1; $i <= $current_page + 1; $i++) :
             if ($i >= 1 && $i <= $total_pages) : ?>
             <a href="?page=<?= $i ?>"<?= $i == $current_page ? ' class="active"' : '' ?>><?= $i ?></a>
             <?php endif; endfor; ?>
             <?php if ($current_page < $total_pages) : ?>
             <a href="?page=<?= $current_page + 1 ?>"><i class="fa-solid fa-angle-right"></i></a>
             <?php endif; ?>
          </div>
     </div>
     <!-- footer-->
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
     const search = () =>{
     const searchBox = document.getElementById("searchBox").value.toUpperCase().replace(/\s/g, "");
     const properties = document.getElementById("properties-page-container");
     const property = document.querySelectorAll(".property-box");
     for(var i=0; i < property.length; i++)
     {
         let matchFound = false;
         const details = property[i].querySelectorAll(".property-box h2, .property-box h4, .property-box h5");
         if(details)
         {
             details.forEach((detail) =>
             {
                 let textValue = detail.textContent || detail.innerHTML;
                 if(textValue.toUpperCase().indexOf(searchBox) !== -1)
                 {
                    matchFound = true;
                 }
              })
         }
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
      function searchProperties()
      {
        var status = document.getElementById("searchBoxStatus").value;
        var type = document.getElementById("searchBoxType").value;
        var listing = document.getElementById("searchBoxListing").value;
        var properties = document.getElementsByClassName("property-box");
        for (var i = 0; i < properties.length; i++)
       {
         var property = properties[i];
         var propertyStatus = property.querySelector("[name='rentalStatus']").textContent.trim();
         var propertyListing = property.querySelector("[name='rentalListingType']").textContent.trim();
         var propertyType = property.querySelector("[name='rentalType']").textContent.trim();
         if (status == "" || propertyStatus == status)
         {
            if (type == "" || propertyType == type)
            {
              if (listing == "" || propertyListing == listing)
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
          else
          {
            property.style.display = "none";
          }
       }
      }
 </script>
</html> 