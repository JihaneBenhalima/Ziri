<?php
 @include_once '../Configuration/connect.php';
 session_start();
 if(!isset($_SESSION['agent_name']) AND !isset($_SESSION['agent_last_name']))
 {
   header('location:../Register/log-in.php');
 }
 require_once("../Configuration/command.php");
 $id = $_GET['profile'];
 $agentProfile = getAgentProfile($id);
 // Check if the function returned any data
 if ($agentProfile)
 {
    // If it did extract the ID from the first result in the array
    $id = $agentProfile[0]->id;
  }
  else
  {
    // If it didn't set the ID to null or display an error message
    $id = null;
  }
  $empty=0;
  $added=0;
  if(isset($_POST['addAgentInfos']))
  {
   $aboutMe = $_POST['aboutMe'];
   $homeAddress = $_POST['homeAddress'];
   $phoneNumber = $_POST['phoneNumber'];
   $linkedinLink = $_POST['linkedinLink'];
   $facebookLink = $_POST['facebookLink'];
   $instagramLink = $_POST['instagramLink'];
   $agreement = isset($_POST['agreement']) ? $_POST['agreement'] : '';
   //accessing images
   $profilePicture = $_FILES['profilePicture']['name'];
   $license = $_FILES['license']['name'];
   //accessing img tmp name
   $temp_profilePicture = $_FILES['profilePicture']['tmp_name'];
   $temp_license = $_FILES['license']['tmp_name'];
   //checking empty condition
   if($aboutMe=='' or $homeAddress=='' or $phoneNumber=='' or $linkedinLink=='' or $facebookLink=='' or $instagramLink=='' or $agreement=='' or $profilePicture=='' or $license=='' )
   {
     $empty=1;
   }
   else
   {
     move_uploaded_file($temp_profilePicture, "../agents/$profilePicture");
     move_uploaded_file($temp_license, "../agents/$license");
     //insert query
     try
     { 
       require_once("../Configuration/command.php");
       addAgentInfos($aboutMe, $homeAddress, $phoneNumber, $linkedinLink, $facebookLink, $instagramLink, $agreement, $profilePicture, $license, $id );
       $added=1;
      }
      catch(Exception $e)
      {
       echo "Error: " . $e->getMessage();
      }
   }
 }
 require_once("../Configuration/command.php");
 $id = $_GET['profile'];
 // Retrieve existing image names from the database
 $query = "SELECT profilePicture,password FROM user WHERE user_type='agent' AND id = :id";
 $stmt = $connect->prepare($query);
 $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Bind the ID parameter
 $stmt->execute();
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 $profileEdit=getAgentProfile($id);
 foreach($profileEdit as $newProfile)
 {
   $id = $newProfile->id;
   $name = $newProfile->name;
   $last_name = $newProfile->last_name;
   $email = $newProfile->email;
   $aboutMe = $newProfile->aboutMe;
   $linkedinLink = $newProfile->linkedinLink;
   $facebookLink = $newProfile->facebookLink;
   $instagramLink = $newProfile->instagramLink;
   $profilePicture = $newProfile->profilePicture;
   $license = $newProfile->license;
   $agreement = $newProfile->agreement;
   $homeAddress = $newProfile->homeAddress;
   $phoneNumber = $newProfile->phoneNumber;
 }
 if(isset($_POST['edit_profile']))
 {
   $name = $_POST['name'];
   $last_name = $_POST['last_name'];
   $email = $_POST['email'];
   $aboutMe = $_POST['aboutMe'];
   $linkedinLink = $_POST['linkedinLink'];
   $facebookLink = $_POST['facebookLink'];
   $instagramLink = $_POST['instagramLink'];
   $homeAddress = $_POST['homeAddress'];
   $phoneNumber= $_POST['phoneNumber'];
   $password = $_POST['password'];
   //accessing images
   $existingProfileImage = $result['profilePicture'];
   $existingPassword = $result['password'];
   $profilePicture = $_FILES['profilePicture']['name'];
   //accessing img tmp name
   $temp_profilePicture = $_FILES['profilePicture']['tmp_name'];
   //checking empty condition
   if($name=='' or $last_name=='' or $email=='' or $aboutMe=='' or $linkedinLink=='' or $facebookLink=='' or $instagramLink=='' or $homeAddress=='' or $phoneNumber=='' )
   {
      echo"<script>alert('An important field is not set')</script>";
   }
   else
   { 
     if (empty($profilePicture))
     {
       $profilePicture = $existingProfileImage;
     }
     else
     { 
       // Upload the new main image
       move_uploaded_file($temp_profilePicture, "../agents/$profilePicture");
     }
     if (empty($password))
     {
       $hashedPassword = $existingPassword;
     }
     else
     {
       // Update password logic
       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
       $query = "UPDATE user SET password = :password WHERE id = :id";
       $stmt = $connect->prepare($query);
       $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
       $stmt->bindValue(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
     }
     //insert query
     try
     {
       EditProfile($name, $last_name, $email, $phoneNumber, $hashedPassword, $aboutMe, $profilePicture, $linkedinLink, $facebookLink, $instagramLink, $homeAddress ,$id);
       echo "<script>alert('profile edited')</script>";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CssFiles/profile.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <title>My profile</title>
 </head>
 <body>
   <?php
     require('../Header/header_agent.php')
   ?>
   <main id="main"> 
     <section><!--This section if for the agent to add their infos so they can get verified-->
     <div class="my-additional-infos" style="margin-top: 50px;margin-bottom:50px;<?php if(!is_null($newProfile) && !empty($newProfile->license)){echo "display:none !important;";}   ?>">
       <h2 style="margin-bottom: 15px;text-align:center;">Hello,<?php echo $_SESSION['agent_name']?>&nbsp;<?php echo $_SESSION['agent_last_name']?></h2>
       <p style="margin-bottom: 20px;text-align:center;">Please fill this additional infos in order to complete your profile<br>And benefit of full agent functionalities</p>
       <div class="modal">
         <form class="form" method="post" enctype="multipart/form-data">
         <?php
         if($added)
         {
           echo '<div style="border: 1px solid green;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: green;" class="fa-regular fa-circle-check"></i>
             <span>Information added successfully!</span>
           </div>
         </div>';
         }
         if($empty)
         {
           echo '<div style="border: 1px solid red;margin-bottom:30px;" class="alert shadow-lg">
           <div>
             <i style="color: red;" class="fa-solid fa-circle-exclamation"></i>
             <span>Please fill all fields</span>
           </div>
         </div>';
         }
       ?>
           <div class="separator">
             <hr class="line">
               <p>My information</p>
             <hr class="line">
           </div>
           <div class="agent-supp-info">
             <div class="input_container-p">
                <label for="profilePic" class="input_label">My profile picture</label>
                <input style="padding-top:7px;" id="profilePic" class="input_field-p" type="file" name="profilePicture" onchange="displayImage(event)">
                <div style="justify-content: center;display: flex;">
                 <div id="image-preview" style="background-image: url(../img/user.jpg);"></div>
                </div>
             </div>
             <div class="input_container-p">
                <label for="myAdd" class="input_label">My address</label>
                <input id="myAdd" class="input_field-p" type="text" name="homeAddress" placeholder="Enter your address">
             </div>
             <div class="input_container-p">
                <label for="phone" class="input_label">My phone number</label>
                <input id="phone" class="input_field-p" type="text" name="phoneNumber" placeholder="Enter your phone number">
             </div>
             <div class="input_container-p">
                <label for="myLic" class="input_label">My real estate agent license</label>
                <input style="padding-top:7px;" id="pmyLic" class="input_field-p" type="file" name="license" onchange="displaySecondImage(event)">
                <div style="justify-content: center; display: flex;">
                 <div id="image-preview-two" style="background-image: url(../img/download.jpg);"></div>
                </div>
             </div>
             <div class="input_container-p">
                <label for="abtMe" class="input_label">About me</label>
                <textarea style="height: 60px;" id="abtMe" class="input_field-p" name="aboutMe" placeholder="About me..."></textarea>
             </div>
           </div>
           <div class="separator">
             <hr class="line">
               <p>My social media links</p>
             <hr class="line">
           </div>
           <div class="agent-social-links">
             <input name="facebookLink" class="input_field-p" type="text" placeholder="facebook link" >
             <input name="instagramLink"class="input_field-p" type="text" placeholder="instagram link">
             <input name="linkedinLink" class="input_field-p" type="text" placeholder="linkedin link">
           </div>
           <label>
             <input type="checkbox" name="agreement" value="yes"> I agree to the website ethics and real estate policies.
           </label>
           <button name="addAgentInfos" type="submit" class="add-infos">Submit</button>
         </form>
       </div>
     </div>
     </section>

     <section><!--This section is for when the agent information are getting verified-->
       <div class="hero min-h-screen bg-base-200" <?php if(!is_null($newProfile) && empty($newProfile->license) || !is_null($newProfile) && !empty($newProfile->Verified)){echo "<div class=\"hero\" style=\"display:none !important;\">";}   ?>>
         <div class="hero-content text-center">
            <div class="max-w-md">
             <h2 class="text-5xl font-bold">Thank you for submitting your license</h2>
             <p class="py-6">Your information are being reviewed by our team. Please note that the approval process may take some time, and we will notify you via email once a decision has been made</p>
             <p class="py-6" style="font-size: 14px;">In the meantime, feel free to explore our website and familiarize yourself with our services. If you have any urgent questions or concerns, please don't hesitate to reach out to our support team <a href="../contact-us.php">here</a></p>
            </div>
         </div>
       </div>
     </section>

     <section>
       <div class="container" <?php if(!is_null($newProfile) && empty($newProfile->Verified)){echo "<div class=\"container\" style=\"display:none !important;\">";}?>>
         <h2>My account</h2>
         <form method="post" enctype="multipart/form-data">
            <div class="form first">
             <div class="details personal" style="display: flex; justify-content:space-between;">
                <div>
                <span class="title">Profile picture</span>
                <div class="fields">
                  <div class="input-field">
                    <div class="profile-pic-div">
                      <img src="../agents/<?= $newProfile->profilePicture?>" id="photo">
                      <input name="profilePicture" type="file" id="file" value="<?= $profilePicture ?>">
                      <label for="file" id="uploadBtn">Choose Photo</label>
                   </div>
                 </div>
               </div>
               </div>
               <div>
                <span class="title">My license</span>
                <div class="fields">
                  <div class="input-field">
                    <div class="license-pic">
                      <img src="../agents/<?= $newProfile->license?>" id="photo">
                   </div>
                 </div>
               </div>
               </div>
             </div>
             <div class="details personal">
                <span class="title">Personal Details</span>
                <div class="fields">
                  <div class="input-field">
                    <label>First name</label>
                    <input value="<?= $name ?>" name="name" type="text" placeholder="Enter your name" >
                 </div>
                 <div class="input-field">
                    <label>Last name</label>
                    <input value="<?= $last_name ?>" type="text" name="last_name" placeholder="Enter your last name">
                 </div>
                 <div class="input-field">
                    <label>Email</label>
                    <input value="<?= $email ?>" type="email" name="email" placeholder="Enter your email" >
                 </div>
                 <div class="input-field">
                    <label>Home address</label>
                    <input value="<?= $homeAddress ?>" type="text" name="homeAddress" placeholder="Enter your address" >
                 </div>      
               </div>
               <div class="fields">
                 <div class="input-field">
                    <label>Phone number</label>
                    <input value="<?= $phoneNumber ?>" type="text" name="phoneNumber" placeholder="Enter your phone number" >
                 </div>       
               </div>
             </div>
             <div class="details personal">
               <span class="title">About me</span>
               <div class="fields">
                 <div class="input-field">
                    <textarea name="aboutMe" placeholder="A few words about you ..." ><?= $aboutMe ?></textarea>
                 </div>
               </div>
             </div>
             <div class="details ID">
                <span class="title">Social media links</span>
                <div class="fields">
                  <div class="input-field">
                    <label><i style="color: blue;" class="fa-brands fa-facebook"></i>&nbsp;Facebook link</label>
                    <input type="text" name="facebookLink" placeholder="facebook" value="<?= $facebookLink ?>" >
                 </div>
                 <div class="input-field">
                    <label><i style="color: #fc5c9c;" class="fa-brands fa-instagram"></i>&nbsp;Instagram link</label>
                    <input type="text" name="instagramLink" placeholder="instagram" value="<?= $instagramLink ?>" >
                 </div>
                 <div class="input-field">
                    <label><i style="color: #0073b1;" class="fa-brands fa-linkedin"></i>&nbsp;Linkedin link</label>
                    <input type="text" name="linkedinLink" placeholder="linkedin" value="<?= $linkedinLink ?>" >
                 </div>
               </div>
             </div>
             <div class="details ID">
                <span class="title">Identity Details</span>
                <div class="fields">
                  <div class="input-field">
                    <label>Password</label>
                    <input name="password" id="password-input" type="password" placeholder="reset your password">
                    <a style="cursor: pointer;" id="toggle-password-btn" onclick="togglePasswordVisibility()"><i class="fa-regular fa-eye"></i></a>
                  </div>
                </div>
                <button class="nextBtn" name="edit_profile" type="submit">
                  <span class="btnText">Edit profile</span>
                </button>
              </div> 
           </div>
         </form>
       </div>
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
   //to not display the header content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const main = document.getElementById("ulp");
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
   //declearing html elements
   const imgDiv = document.querySelector('.profile-pic-div');
   const img = document.querySelector('#photo');
   const file = document.querySelector('#file');
   const uploadBtn = document.querySelector('#uploadBtn');
   //if user hover on img div 
   imgDiv.addEventListener('mouseenter', function()
   {
     uploadBtn.style.display = "block";
   });
   //if we hover out from img div
   imgDiv.addEventListener('mouseleave', function()
   {
     uploadBtn.style.display = "none";
   });
   //lets work for image showing functionality when we choose an image to upload
   //when we choose a foto to upload
   file.addEventListener('change', function()
   {
   //this refers to file
   const choosedFile = this.files[0];
   if (choosedFile)
   {
     const reader = new FileReader(); //FileReader is a predefined function of JS
     reader.addEventListener('load', function()
     {
        img.setAttribute('src', reader.result);
      });
      reader.readAsDataURL(choosedFile);
    }
   });
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
   function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password-input");
  var toggleButton = document.getElementById("toggle-password-btn");
  var eyeIcon = document.getElementById("eye-icon");

if (passwordInput.type === "password") {
  passwordInput.type = "text";
  eyeIcon.className = "fa-regular fa-eye-slash";
  } else {
    passwordInput.type = "password";
    eyeIcon.className = "fa-regular fa-eye";
  }
}
 </script>
</html>