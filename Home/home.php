<?php 
  require("../Configuration/command.php");
  $properties=Latest();
  $rentals=LatestRentals();
  $latestAgents=displayAgentsHome();
  $reviews=LatestReviews();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="../CssFiles/style.css">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../css/all.min.css">
   <title>Ziri</title>
  </head>
  <body>
   <!-- loader in case its taking too long to load -->
   <?php
     require('../loader.php')
    ?>

   <!-- navigation bar -->
   <header id="header">
      <nav class="navbar">
       <a href="../Home/home.php">
          <img class="logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
       </a>
       <div class="navlinks">
          <ul class="menu">
            <li><a href="../Search/search_guest.php">Search</a></li>
            <li><a href="#">Our properties</a>
              <ul class="sousmenu">
                <li><a href="../GuestSession/properties_guest.php">See all properties</a></li>
                <li><a href="../GuestSession/propertiesForSale_guest.php?propertyStatus='For sale'">Buy</a></li>
                <li><a href="../GuestSession/propertiesForRent_guest.php?propertyStatus='For rent'">Rent</a></li>
              </ul>
            </li>
            <li><a href="../GuestSession/vacationRentals_guest.php">Vacations rentals</a></li>
            <li><a href="#">Work with us</a>
              <ul class="sousmenu">
                <li><a href="../GuestSession/agents_guest.php">Find an agent</a></li>
                <li><a href="../Register/sign-up.php">Sign up as an agent</a></li>
                <li><a href="../contact-us.php">Contact us</a></li>
              </ul>
            </li>
            <li><a href="../Register/log-in.php" id="log-in-btn">Log in</a></li>
          </ul>
       </div>    
       <i class="fa-solid fa-bars" id="menu-hamburger" onclick="changeIcon(this)"></i>  
      </nav>

      <div class="opening-content">
        <div class="homepage-opening">
          <h4 class="pre-title">Welcome to our Real Estate Website</h4>
          <h2 class="big-title">Find Your Dream Property Today</h2>
          <h3 class="sub-title">Discover a vast selection of properties for rent, sale, and vacation rentals</h3>
          <h3 class="sub-title">all in one place</h3>
          <button  class="see-properties-btn">
            <a href="../GuestSession/properties_guest.php">
             <span class="circle" aria-hidden="true">
               <i id="arrow-icon" class="fa-solid fa-chevron-right"></i>
             </span>
             <span class="button-text">See properties</span>
           </a>
          </button>  
       </div>
     </div>

     <video id="header-video" loop muted autoplay>
        <source src="../backgroundVideo.mp4" type="video/mp4">
     </video>   
    </header>

    <main id="main">
     <!--latest added properties -->
     <section class="trending-gallery" style="background:black;">
       <div class="trending-gallery-header">
         <h1 style="text-align: center; padding-top: 20px; color:white; font-weight:400;">Latest additions</h3>
       </div>

       <div class="trending-img-gallery">
         <?php foreach($properties as $property):?>
           <div class="trending-img-box">
             <a href="../GuestSession/propertyDetails_guest.php?PropertyMoreDetails=<?php echo $property->id ?>">
               <img id="trendingImgHome" name="propertyMain_image" src="../uploads/<?= $property->propertyMain_image?>" alt="property image">
               <div class="overlay"></div>
             </a>
           </div>
         <?php endforeach;?>
       </div>

       <button class="trending-view-more-btn">
         <span class="trending-circle">
           <i id="trending-arrow-icon" class="fa-solid fa-chevron-right"></i>
         </span>
         <span class="trending-button-text"><a style="color: white;" href="../GuestSession/properties_guest.php">view more</a></span>
       </button>  
     </section>

     <!-- about us section -->
     <section class="about-us-section" id="aboutUsSection">
       <div class="about-us-content">
         <div class="about-us-image-container">
           <img src="../img/backgrounds/aboutUsImg.jpg" alt="about us image">
         </div>
         <div class="about-us-text">
           <h4>About us</h4>
           <p>Ziri is the ultimate destination for finding your dream property. Our platform offers a vast selection of properties for rent, sale, and vacation rentals</p>
           <h1>Welcome to Our World of Real Estate</h1>
           <p>Our mission is to make the real estate process as seamless and stress-free as possible. Whether you're an agent posting your properties or user searching for your next home, we're here to help</p>
         </div>
       </div>
     </section>

     <!--latest added vacation rentals -->
     <section class="trending-gallery" style="background-color: black;">
       <div class="trending-gallery-header">
         <h1 style="text-align: center; padding-top: 20px; color:white; font-weight:400;">Recently added vacation rentals</h3>
       </div>

       <div class="trending-img-gallery">
         <?php foreach($rentals as $rental):?>
           <div class="trending-img-box">
             <a href="../GuestSession/rentalDetails_guest.php?rentalMoreDetails=<?php echo $rental->id ?>">
             <img id="trendingImgHome" name="rentalMainImage" src="../rentals/<?= $rental->rentalMainImage?>" alt="short term rental image">
             <div class="overlay"></div>
             </a>
           </div>
         <?php endforeach;?>
       </div>

       <button class="trending-view-more-btn">
         <span class="trending-circle">
           <i id="trending-arrow-icon" class="fa-solid fa-chevron-right"></i>
         </span>
         <span class="trending-button-text"><a style="color: white;" href="../GuestSession/vacationRentals_guest.php">view more</a></span>
       </button>  
     </section>

     <!--our services section-->
     <section class="our-services-section"> 
       <h3 style="display: flex; justify-content: center; position: relative; margin-bottom:20px; font-size:25px; font-family:Arial, Helvetica, sans-serif;">Our services</h3>
       <p style="text-align:center; display: flex; justify-content: center; position: relative; font-size:18px; font-family:Arial, Helvetica, sans-serif; margin-bottom:20px;">Explore our range of real estate services designed to meet your needs. Find, list, and manage properties with ease</p>
       <div class="our-services">
         <div class="our-services-layout">
           <div class="services-layout-col">
             <div class="u-layout-row">
               <!--first img -->
               <div class=" u-image u-size-20 services-img-one">
                 <div class="container-one"></div>
               </div>
               <!--first box top middle-->
               <div class="u-size-20 services-box-one">
                 <div class=" container-two">
                   <h6 class="u-align-center services-title-one">Earn More with Airbnb</h6>
                   <h3 class="u-align-center services-text-one">List Your Vacation Rentals on Our Website</h3>
                   <p class="u-align-center services-text-one2">List your vacation rentals on our platform, attract more guests, and manage bookings and reviews in one place.</p>
                 </div>
               </div>
               <!--second img-->
               <div class=" u-image u-size-20 services-img-two">
                 <div class=" container-three"></div>
               </div>
             </div>
           </div>
           <div class="services-layout-col">
             <div class="u-layout-row">
               <!--second box first second line-->
               <div class="u-size-20 services-box-two">
                 <div class="container-four">
                   <h6 class="u-align-center services-title-two">Your Dream Home Awaits</h6>
                   <h3 class="u-align-center services-text-two">Discover the Best Properties for Rent or Sale</h3>
                   <p class="u-align-center services-text-two2">Easily find your perfect property with our user-friendly search tool, detailed property descriptions, photos, and virtual tours.</p>
                 </div>
               </div>
               <!--third img-->
               <div class=" u-image  u-size-20 services-img-three">
                 <div class=" container-five"></div>
               </div>
               <!--third box second line last one-->
               <div class="   u-size-20 services-box-three">
                 <div class="  container-six">
                   <h6 class="u-align-center services-title-three">Reach More Clients Now</h6>
                   <h3 class="u-align-center services-text-three">List Your Properties on Our Website</h3>
                   <p class="u-align-center services-text-three2">List your properties for rent or sale on our platform, showcasing their unique features and expanding your reach.</p>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </section>

     <!--  sponsor slider section -->
     <div class="sponsor"> 
       <h3>Sponsored by</h3>
       <div class="sponsor-wrapper">
	       <div class="sponsor-slider">
           <div class="sponsor-slide-track">
             <div class="vl"></div>
             <div class="sponsor-slide">
				        <img src="../img/SponsorImg/sponsor1.png" alt="sponsor logo">
		         </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor2.png" alt="sponsor logo">
			       </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor3.png" alt="sponsor logo">
			       </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor4.png" alt="sponsor logo">
			       </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor5.png" alt="sponsor logo">
			       </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor6.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor7.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor1.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor2.png" alt="sponsor logo">
		    	   </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor3.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor4.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor5.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div>
             <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor6.png" alt="sponsor logo">
		  	     </div>
             <div class="vl"></div> 
              <div class="sponsor-slide">
               <img src="../img/SponsorImg/sponsor7.png" alt="sponsor logo">
			       </div>
             <div class="vl"></div> 
	         </div>
         </div>
       </div>
     </div>

     <!-- latest agent section-->
     <div style="text-align: center;margin-bottom:20px;" class="testimonials">
       <h1 style="font-size: 25px; padding:0;">Our newest agents</h1>
     </div>

     <section id="team" style="background-color: #FAF0E6; display:flex; justify-content:center;" >
       <div class="our-agents-container" id="our-agents-container">
         <?php foreach($latestAgents as $newAgent):?>
            <div class="agent-box" style="width:195px;">
              <div class="agent-box-top-bar"></div>
              <div class="agent-box-nav">
                <i class="agent-box-verify fas fa-check-circle"></i>
              </div>
              <div class="agent-box-details">
                <img src="../agents/<?= $newAgent->profilePicture?>" alt="agent profile picture">
                <h3><strong name="name"><?= $newAgent->name?></strong>&nbsp;<strong name="last_name"><?= $newAgent->last_name?></strong></h3>
                <p name="email"><?= $newAgent->email?></p>
              </div>
              <div class="agent-box-details">
                <p name="homeAddress"><?= $newAgent->homeAddress?></p>
              </div>
              <div class="agent-box-details">
                <p name="aboutMe" style="text-align: center;height:50px;"><?php $maxLength = 100; $aboutMe = $newAgent->aboutMe; if (strlen($aboutMe) > $maxLength) { $aboutMe = substr($aboutMe, 0, $maxLength) . '...'; } echo $aboutMe; ?></p>
              </div>
              <div class="agent-socials">
                <a href="<?= $newAgent->facebookLink?>" style="color: blue;"><i class="fab fa-facebook-f"></i></a>
                <a href="<?= $newAgent->linkedinLink?>" style="color: #0073b1;"><i class="fa-brands fa-linkedin"></i></a>
                <a href="<?= $newAgent->instagramLink?>" style="color: #fc5c9c;"><i class="fab fa-instagram"></i></a>
              </div>
           </div>
         <?php endforeach;?>
       </div>

       <button class="agents-see-all-btn">
         <span class="agents-see-all-btn-circle">
           <i id="agents-see-all-btn-icon" class="fa-solid fa-chevron-right"></i>
         </span>
         <span class="agents-see-all-button-text"><a style="color: black;" href="../GuestSession/agents_guest.php">See all</a></span>
       </button>  
     </section>
     
     <!-- testimonial part-->
     <div class="testimonials" style="display: flex;justify-content:center;align-items:center;flex-direction:column;">
       <h1 style="font-size: 25px; margin-bottom: 20px;margin-top:20px; font-family:Arial, Helvetica, sans-serif;">What people says about us</h1>
     </div>
     <div class="wrapper" style="margin-bottom: 50px;">
       <?php foreach($reviews as $review):?>
         <div class="box">
           <i class="fas fa-quote-left quote"></i>
           <p style="height: 70px;font-size:14px;"><?= $review->comment?></p>
           <div class="content">
             <div class="info">
               <div class="name"><?= $review->reviewerName?>&nbsp;<?= $review->reviewerLastName?></div>
               <div class="job"><?= $review->user_type?></div>
               <div class="stars">
                 <?php for($i = 1; $i <= $review->starsRating; $i++): // this is a loop ?>
                   <i class="fas fa-star"></i>
                 <?php endfor; ?>
               </div>
             </div>
             <div class="image">
               <img src="<?= (!empty($review->profilePicture)) ? '../agents/' . $review->profilePicture : '../img/user.jpg"' ?>" alt="reviewer profile picture">
             </div>
           </div>
         </div>
       <?php endforeach;?> 
     </div>

     <!-- contact us section -->
     <div class="work-with-us" id="contact-us">
       <div class="work-with-us-content-box">
         <div class="work-with-us-content">
           <h2>Work with us</h2>
           <p>Got a property you want to sell or rent and didn't know how to put in in the market or get clients?</p>
           <p>Looking for a home and you are confused how to start ?</p>
           <p>Let us take care of it</p>
           <p>We offer the highest level of expertise, service, and integrity</p>
           <button class="contact-button" onclick="location.href='../contact-us.php';">Contact</button>
         </div>
       </div>
     </div> 
   </main>

    <!-- footer -->
    <?php
     require('../Footer/footer_guest.php')
    ?>

    <!-- FAQ chatbot -->
    <script>(function(){var js,fs,d=document,id="tars-widget-script",b="https://tars-file-upload.s3.amazonaws.com/bulb/";if(!d.getElementById(id)){js=d.createElement("script");js.id=id;js.type="text/javascript";js.src=b+"js/widget.js";fs=d.getElementsByTagName("script")[0];fs.parentNode.insertBefore(js,fs)}})();window.tarsSettings = {"convid":"MvUiq5"};</script>
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
   //to not display the header content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const content = document.querySelector('.opening-content');
   icon.addEventListener('click', function() 
   {
     if (content.style.display === 'none')
      {
        content.style.display = 'block';
      } else 
      {
        content.style.display = 'none';
      }
   }
   );
   // change menu icon to close icon while open
   let changeIcon = function(close)
   {
     icon.classList.toggle('fa-xmark')
   }
 </script>
</html>