<?php
    /**done a 100% */
    @include '../Configuration/connect.php';
    require("../Configuration/command.php");
    session_start();
    if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']) )
    {
     header('location:../Register/log-in.php');
    }
    $properties=display();
    $noResult=0;
    $propertyStatus = 'For rent'; // Set default value to an empty string
    if(isset($_GET['propertyStatus']))
    {
        $propertyStatus = $_GET['propertyStatus'];
    }
    // Query the database to get properties of the requested type
    $stmt = $connect->prepare("SELECT * FROM `property` WHERE `propertyStatus` = 'For rent'");
    $stmt->execute();
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
    $records_per_page = 12;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
    } else {
    $current_page = 1;
    }
    // SQL query to retrieve total number of records
    $total_query = $connect->query("SELECT COUNT(*) as total_records FROM property WHERE propertyStatus = 'For rent' ");
    $total_results = $total_query->fetch(PDO::FETCH_ASSOC)['total_records'];
    $total_pages = ceil($total_results / $records_per_page);
    // SQL query to retrieve records for current page
    $start = ($current_page - 1) * $records_per_page;
    $users_query = $connect->prepare("SELECT * FROM property WHERE propertyStatus = 'For rent' LIMIT :start, :records_per_page");
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
     <title>Ziri|Properties</title>
 </head>
 <body>
     <!-- the header -->
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
                     <span class="label-text">Property type</span>
                 </label>
                 <select class="select" name="propertyType" id="searchBoxType" onchange="searchType()">
                     <option value="">All</option>
                     <?php
                     $type="SELECT DISTINCT propertyType FROM property ORDER BY propertyType";
                     $resultT=$connect->query($type);
                     while($row=$resultT->fetch(PDO::FETCH_OBJ)){
                     ?>    
                     <option class="option" value="<?= $row->propertyType; ?>"><?= $row->propertyType; ?></option> 
                     <?php } ?>    
                 </select>
              </div>
         </div>
         <?php 
         if($noResult)
         {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
               No properties found for rent.
         </div>';
          }
         ?>
         <div class="properties-page-container">
             <?php foreach($properties as $property):?>
                 <div class="property-box">
                     <img class="property-box-img" name="propertyMain_image" src="../uploads/<?= $property->propertyMain_image?>">
                     <div class="property-box-overlay">
                         <a class="fancy" href="../AgentSession/propertyDetails_agent.php?PropertyMoreDetails=<?php echo $property->id ?>">
                            <span class="overlay-box-btn-text">View property</a></span>
                         </a>
                     </div>
                     <span name="propertyStatus" class="property-status-box" ><?= $property->propertyStatus?></span>
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
    const search = () =>{
    const searchBox = document.getElementById("searchBox").value.toUpperCase();
    const properties = document.getElementById("properties-page-container");
    const property = document.querySelectorAll(".property-box");
    for(var i=0; i < property.length; i++){
        let matchFound = false;
        const details = property[i].querySelectorAll(".property-box h2, .property-box h4, .property-box h5");
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
    }
}
const searchType = () =>
    {
     const searchBoxType = document.getElementById("searchBoxType").value.toUpperCase();
     const properties = document.getElementById("properties-page-container");
     const property = document.querySelectorAll(".property-box");
     for (var i = 0; i < property.length; i++)
     {
        let matchFound = false;
        const details = property[i].querySelectorAll(".property-box h4");
        if (details)
        {
            details.forEach((detail) =>
            {
                let textValue = detail.textContent || detail.innerHTML;
                if (textValue.toUpperCase().indexOf(searchBoxType) !== -1)
                {
                    matchFound = true;
                }
            });
        }
        if (matchFound)
        {
            property[i].style.display = "";
        } else
        {
            property[i].style.display = "none";
        }
      }
   };
</script>
</html> 