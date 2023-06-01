<?php 
 @include_once '../Configuration/connect.php';
 session_start();
 if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']) )
 {
   header('location:../Register/log-in.php');
 }
 // Create connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT * FROM property";
$result = mysqli_query($connect, $sql);
$empty=0;
// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Variable to track if user has properties
    $hasProperties = false;

    // Loop through each row and check if user has properties
    while ($row = mysqli_fetch_assoc($result)) {
        $posterName = $row['posterName'];
        $posterLastName = $row['posterLastName'];
        if ($_SESSION['agent_name'] == $posterName && $_SESSION['agent_last_name'] == $posterLastName) {
            require_once("../Configuration/command.php");
            $myRentals = myProperties();
            $hasProperties = true;
        }
    }

    // Display message if user has no properties
    if (!$hasProperties) {
        $empty=1;
    }
} else {
    echo "fail";
}

  if (isset($_POST['DeleteRental']))
  {
    $id = $_POST['DeleteRental'];
    DeleteProperty($id);
    header('location:../AgentSession/MyProperties.php');
    exit();
  }
  
  
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CssFiles/test.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <title>My posted rentals</title>
 </head>
 <body>
   <?php
     require('../Header/header_agent.php')
   ?>
   <h1 style="margin: 20px;display: flex; justify-content: center;">My listed properties</h1>
   <div class="search-bar">
      <input id="search-item" onkeyup="search()" type="text" name="text" class="search-bar-input" placeholder="search...">
      <span class="search-icon"> 
       <i class="fa-solid fa-magnifying-glass"></i>
      </span>
   </div>
   <section id="mp" style="background-color: #eee; margin-top:50px; margin-bottom:50px; ">
     <div class="py-5">
       <div class="row justify-content-center" style="margin-top: 20px;margin-bottom:20px;">
         <div class="col-md-12 col-xl-10">
         <?php
if ($empty) {
  echo '<div style="margin-bottom:30px;margin-top:30px;border:1px solid black;" class="alert shadow-lg">
  <div>
    <span>No properties posted yet</span>
  </div>
</div>';
} else {
    foreach ($myRentals as $myRental) {
        ?>
        <input type="hidden" name="rentalID" value="<?= $myRental->id ?>">
        <div class="card">
            <div class="card-body">
                <h2><?= $myRental->id ?></h2>
                <div class="row">
                    <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                        <div class="mpi">
                            <img onclick="displayFullScreen(this)" src="../uploads/<?= $myRental->propertyMain_image ?>" class="w-100" name="propertyMain_image" />
                            <div>
                                <div style="background-color: rgba(253, 253, 253, 0.15);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="cold-md-6 col-lg-6 col-xl-6">
                        <h4 class="mpt" name="propertyTitle"><?= $myRental->propertyTitle ?></h4>
                        <div>
                            <span class="mpa" name="propertyAddress"><?= $myRental->propertyAddress ?></span>
                        </div>
                        <div>
                            <span name="propertyCity"><?= $myRental->propertyCity ?></span>
                            <span style="color: #0073b1;"> , </span>
                            <span name="propertyCountry"><?= $myRental->propertyCountry ?><br></span>
                        </div>
                        <div style="color: grey;" class="mpd1">
                            <span name="propertySize"><?= $myRental->propertySize ?>m2</span>
                            <span style="color: #0073b1;"> • </span>
                            <span name="propertyFloors"><?= $myRental->propertyFloors ?></span>
                            <span style="color: #0073b1;"> • </span>
                            <span name="propertyNumber_of_bedrooms"><?= $myRental->propertyNumber_of_bedrooms ?>bt<br /></span>
                        </div>
                        <div style="color: grey;" class="mpd2">
                            <span name="propertyNumber_of_bathrooms"><?= $myRental->propertyNumber_of_bathrooms ?>bd</span>
                            <span style="color: #0073b1;"> • </span>
                            <span name="propertyGarage"><?= $myRental->propertyGarage ?></span>
                            <span style="color: #0073b1;"> • </span>
                            <span name="propertyOutdoors"><?= $myRental->propertyOutdoors ?><br /></span>
                        </div>
                        <p class="mpdp text-truncate" name="propertyDescription"><?= $myRental->propertyDescription ?></p>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xl-3">
                        <div>
                            <h5 class="mppt"><span name="propertyType"><?= $myRental->propertyType ?></span></h5>
                            <span class="mps" name="propertyStatus"><?= $myRental->propertyStatus ?></span>
                        </div>
                        <span class="mpp" name="propertyPrice"><?= $myRental->propertyPrice ?><?= $myRental->propertyCurrency ?></span>
                        <div class="d-flex flex-column ">
                            <button class="btn btn-primary " style="margin-bottom: 7px;" type="button"><a style="color: white;" href="../AgentSession/propertyDetails_agent.php?PropertyMoreDetails=<?php echo $myRental->id ?>">View all</a></button>
                            <form method="post" style="display: contents;">
                                <button class="btn btn-primary " style="margin-bottom: 7px;" type="button"><a style="color: white;" href="../AgentSession/editProperty.php?editProperty=<?= $myRental->id ?>">Edit</a></button>
                            </form>
                            <form style="display: contents;" method="post" onsubmit="return confirmDelete();">
                                <button style="border: 1px solid red;" class="btn btn-outline-primary  mt-2" type="submit" name="DeleteRental" value="<?= $myRental->id ?>">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>

         </div>
       </div>
     </div>
   </section>
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
   const main = document.getElementById("mp");
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
   function showAlert()
   {
     alert("For security reasons, you can't delete the property. For further questions, contact our customer service.", "Ziri");
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

function confirmDelete() {
    return confirm("Are you sure you want to delete this property?");
}

function search() {
  var searchInput = document.getElementById("search-item").value.toLowerCase();
  var rentalCards = document.getElementsByClassName("card");

  for (var i = 0; i < rentalCards.length; i++) {
    var rentalCard = rentalCards[i];
    var propertyTitle = rentalCard.querySelector("[name='propertyTitle']").textContent.toLowerCase();
    var propertyAddress = rentalCard.querySelector("[name='propertyAddress']").textContent.toLowerCase();
    var propertyCity = rentalCard.querySelector("[name='propertyCity']").textContent.toLowerCase();
    var propertyCountry = rentalCard.querySelector("[name='propertyCountry']").textContent.toLowerCase();
    var propertySize = rentalCard.querySelector("[name='propertySize']").textContent.toLowerCase();
    var accommodation = rentalCard.querySelector("[name='accommodation']").textContent.toLowerCase();
    var propertyNumber_of_bedrooms = rentalCard.querySelector("[name='propertyNumber_of_bedrooms']").textContent.toLowerCase();
    var bedrooms = rentalCard.querySelector("[name='Bedrooms']").textContent.toLowerCase();
    var propertyDescription = rentalCard.querySelector("[name='propertyDescription']").textContent.toLowerCase();

    var isMatch =
      propertyTitle.includes(searchInput) ||
      propertyAddress.includes(searchInput) ||
      propertyCity.includes(searchInput) ||
      propertyCountry.includes(searchInput) ||
      propertySize.includes(searchInput) ||
      accommodation.includes(searchInput) ||
      propertyNumber_of_bedrooms.includes(searchInput) ||
      bedrooms.includes(searchInput) ||
      propertyDescription.includes(searchInput);

    if (isMatch) {
      rentalCard.style.display = "block";
    } else {
      rentalCard.style.display = "none";
    }
  }
}









 </script>
</html>