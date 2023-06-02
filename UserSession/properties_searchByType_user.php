<?php
    /**Done a 100% */
    @include '../Configuration/connect.php';
    require("../Configuration/command.php");
    session_start();
    if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
    {
     header('location:../Register/log-in.php');
    }
    $properties=display();
    $noResult=0;
    $propertyType = ''; // Set default value to an empty string
    if(isset($_GET['propertyType']))
    {
        $propertyType = $_GET['propertyType'];
    }
    // Query the database to get properties of the requested type
    $stmt = $connect->prepare("SELECT * FROM `property` WHERE `propertyType` = :propertyType");
    $stmt->execute(['propertyType' => $propertyType]);
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
     <title>Ziri|Properties</title>
 </head>
 <body>
     <!-- the header -->
     <?php
         require('../Header/header_user.php')
       ?>
       <!-- properties page -->
       <div class="properties-page" id="property-page" style="background-color: #1a1a1a;">
         <div class="properties-page-heading">
             <h1>Proprieties</h1>
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
                      <span class="label-text">Property status</span>
                 </label>
                 <select class="select" name="propertyStatus" id="searchBoxStatus" onchange="searchStatus()">
                     <option value="">All</option>
                     <?php
                         include("../Configuration/connect.php");
                         $status="SELECT DISTINCT propertyStatus FROM property ORDER BY propertyStatus";
                         $resultS=$connect->query($status);
                         while($row=$resultS->fetch(PDO::FETCH_OBJ)){
                       ?>    
                     <option class="option" value="<?= $row->propertyStatus; ?>"><?= $row->propertyStatus; ?></option> 
                     <?php } ?>    
                 </select>
             </div>
             <div class="form-control max-w-xs">
                 <label class="label">
                      <span class="label-text">Property Type</span>
                 </label>
                 <select class="select" name="propertyType" id="searchBoxType" onchange="redirectToPage()">
                     <option value="">All</option>  
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Family%20home">Family home</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=apartment">Apartment</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Duplex">Duplex</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Villa">Villa</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Farm%20house">Farm house</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Retail%20property">Retail property</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Office%20building">Office building</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Warehouse">Warehouse</option>
                     <option class="option" value="../UserSession/properties_searchByType_user.php?propertyType=Land">Land</option>  
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
                     <img class="property-box-img" name="propertyMain_image" src="../uploads/<?= $property->propertyMain_image?>">
                     <div class="property-box-overlay">
                         <a class="fancy" href="../UserSession/propertyDetails_user.php?PropertyMoreDetails=<?php echo $property->id ?>">
                            <span class="overlay-box-btn-text">View property</a></span>
                         </a>
                     </div>
                     <p name="propertyStatus" class="property-status-box" ><?= $property->propertyStatus?></p>
                     <h2 name="propertyTitle" style="font-weight:lighter;"><?= $property->propertyTitle?></h2>
                     <h4 name="propertyType" style="margin-top: 0;margin-bottom:0px; font-weight:lighter;"><?= $property->propertyType?></h4>
                     <h5 name="propertyAddress" style="margin-top: 0;margin-bottom:0px; font-size:16px;"><?= $property->propertyAddress?></h5>
                     <h5 name="propertyCity" style="margin-top: 0;margin-bottom:0px; font-size:16px;font-weight:600;"><?= $property->propertyCity?>,<?= $property->propertyCountry?></h5>
                     <div class="property-box-features" >
                         |&nbsp;&nbsp;<i class="fa-solid fa-bed">&nbsp;<span name="propertyNumber_of_bedrooms"><?= $property->propertyNumber_of_bedrooms?></span>&nbsp;bd</i>&nbsp;|
                         <i class="fa-solid fa-shower">&nbsp;<span name="propertyNumber_of_bathrooms"><?= $property->propertyNumber_of_bathrooms?></span>&nbsp;bt</i>&nbsp;|
                         <i class="fa-solid fa-maximize">&nbsp;<span name="propertySize"><?= $property->propertySize?></span></i>&nbsp;m2|
                     </div>
                     <div class="property-box-price">
                         <span name="propertyPrice" style="font-weight:bolder;" style="font-size: 17px; text-transform:uppercase;"><?= $property->propertyPrice?><?= $property->propertyCurrency?>&nbsp;<?php if ($property->propertyStatus == 'For rent') { echo "Per month"; } ?></span>
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
    const search = () =>{
    const searchBox = document.getElementById("searchBox").value.toUpperCase();
    const properties = document.getElementById("properties-page-container");
    const property = document.querySelectorAll(".property-box");
    for(var i=0; i < property.length; i++){
        let matchFound = false;
        const details = property[i].querySelectorAll(".property-box h2, .property-box h4, .property-box h5, .property-box p");
        if(details){
            details.forEach((detail) => {
              let textValue = detail.textContent || detail.innerHTML;
              if(textValue.toUpperCase().indexOf(searchBox) !== -1){
                matchFound = true;
              }
            })
        }
        if(matchFound){
            property[i].style.display = "";
        }else{
            property[i].style.display = "none";
        }          
    }}
    const searchStatus = () =>
       {
         const searchBoxStatus = document.getElementById("searchBoxStatus").value.toUpperCase();
         const properties = document.getElementById("properties-page-container");
         const property = document.querySelectorAll(".property-box");
         for(var i=0; i < property.length; i++)
         {
             let matchFound = false;
             const details = property[i].querySelectorAll(".property-box p");
             if(details)
             {
                 details.forEach((detail) =>
                 {
                     let textValue = detail.textContent || detail.innerHTML;
                     if(textValue.toUpperCase().indexOf(searchBoxStatus) !== -1)
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
       function redirectToPage() {
     var selectElement = document.getElementById("searchBoxType");
     var selectedValue = selectElement.value;
     if (selectedValue !== "") {
      window.location.href = selectedValue;
    }
    }
    

</script>
</html> 