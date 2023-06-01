<?php
$success=0;
$user=0;
$match=0;
$google=0;
$empty=0;
$invalid_password=0;
if(isset($_POST['google'])){
  $google=1;
 }
if($_SERVER['REQUEST_METHOD']=='POST'){
  include '../Configuration/connect.php';
  $name=$_POST['name'];
  $lastName=$_POST['last_name'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $confirmpassword=$_POST['cpassword'];

  $userType = isset($_POST['user_type']) ? $_POST['user_type'] : '';

  $sql="SELECT * FROM user WHERE email=:email OR (name=:name AND last_name=:last_name)";
  $stmt = $connect->prepare($sql);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':last_name', $lastName);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if($result){
    $user=1;
  }
  elseif($password != $confirmpassword){
    $match=1;
  }
  elseif($name=='' || $lastName==''|| $email=='' || $password=='' || $confirmpassword=='')
  {
     $empty=1;
  }
  elseif(!preg_match('/^(?=.*\d)(?=.*[A-Z]).{8,}$/', $password))
  {
    $invalid_password=1;
  }
  else{
    $sql = "INSERT INTO user (name, last_name, user_type, email, password ) VALUES (:name, :last_name, :user_type, :email, :password)";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':user_type', $userType);
    $stmt->bindParam(':email', $email);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashed_password);
    $result = $stmt->execute();
    if($result){
        $success=1;
    }else{
       die($connect->errorInfo()[2]);
    }
  }  
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../CssFiles/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziri | Sign up</title>
 </head>
 <body>
   <?php
     if($user)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Sorry!</strong> User already exists.
              </div>';
      }
      if($success)
      {
         echo '<div style="background:rgb(212,237,218); color:rgb(53,112,67);" class="alert alert-warning alert-dismissible fade show" role="alert">
               <strong>Good!</strong> You have successfully signed up.
               </div>';
      }
      if($match)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Careful!</strong> Passwords does not match.
              </div>';
      }
      if($google)
     {
        
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        A Ziri account for this sing-up option does not exist yet. Please try another singing up option for now. 
         </div>';
      }
      if($empty)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         Please fill all fields.
         </div>';
      }
      if($invalid_password)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Password does not meet requirements.Your password must be at least 8 characters long, with at least one number and one uppercase letter.
         </div>';
      }
   ?>
   <section class="register-section"  id="sign-up-page" >
     <div class="register-box">
        <div class="register-container" id="registerContainer">
         <div class="register-header">
           <a href="../Home/home.php">
             <img class="register-logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
           </a>
           <div class="close-register-page" id="close-sign-up-page-btn">
             <a style="color: white;" onclick="goBack()"><i id="register-input-field-icon1" class="fa-solid fa-xmark"></i></a>
           </div>
         </div>
         <div class="sign-up-title">
            <h1>Sign up</h1>
         </div>
         <form action="" method="post">
          <div class="Profile-switch-box">
            <a href="#" class="profile-help-btn"><i id="ProfileHelp" class="fa-regular fa-circle-question"></i></a>
            <div class="profile-btn-box">
              <div id="profile-btn"></div>
              <button id="profile-btn1" type="button" class="profile-toggle-btn active" value="user" onclick="NormalUserClick()">User</button>
              <button id="profile-btn2" type="button" class="profile-toggle-btn" value="agent"  onclick="ProUserClick()">Agent</button>
              <input type="hidden" name="user_type" id="user_type" value="user">
		        </div>
	        </div>
          <div class="sign-up-page-row">
            <div class="sign-up-input-field">
              <input type="text" class="sign-up-input" placeholder="First name"  name="name">
              <i id="input-icon" class="fa-regular fa-user"></i>
           </div>
           <div class="sign-up-input-field" id="test">
             <input type="text" class="sign-up-input" placeholder="Last name "  name="last_name">
           </div>
          </div>
          <div class="sign-up-input-field">
            <input type="email" class="sign-up-input" placeholder="Email" id=""  name="email">
            <i id="input-icon" class="fa-regular fa-envelope"></i>
         </div>
         <div class="sign-up-input-field">
            <input type="Password" class="sign-up-input" placeholder="Password" id="password-input"  name="password">
            <i id="input-icon" class="fa-solid fa-lock"></i>
            <input type="Password" class="sign-up-input" placeholder="Confirm password" id="confirm-password-input"  name="cpassword">
            <i id="input-icon" class="fa-solid fa-lock"></i>
            <div class="sign-up-show-password" onclick="showPasswordSignUp()">
              <i id="sign-up-hide1" class="fa-regular fa-eye"></i>
              <i id="sign-up-unhide1" class="fa-regular fa-eye-slash"></i>
           </div>
           <div class="sign-up-show-password" onclick="showConfirmPassword()">
             <i id="sign-up-hide2" class="fa-regular fa-eye"></i>
             <i id="sign-up-unhide2" class="fa-regular fa-eye-slash"></i>
           </div>
         </div>
         <button type="submit" name="sign" class="sign-up-btn">Join now
           <div class="sign-up-btn-icon">
              <i class="fa-solid fa-arrow-right-to-bracket"></i>
           </div>
         </button>
         <hr>
         <div class="Sign-up-with">
           <h5>Or</h5>
            <button type="submit" name="google"><img src="../google-logo.png" >
              Sign up with Google
            </button>
         </div>
         <div class="register-to-log-link">
            <h4>Already have an account ? 
              <button class="register-to-log-link-btn" id="to-log-btn">
                <a href="../Register/log-in.php">Log in</a>
             </button>
           </h4>
         </div>
          </form>
       </div>
     </div>  
   </section>
    <section class="help-profile-pop-up" id="helpProfilePopUp">
      <div class="help-profile-card-header">
        <div class="help-profile-card-header-text">Choose Your User Type</div>
      </div>
      <div class="help-profile-card-registerContainer">
        <div class="messages-help-boxes-container">
         <div class="message-help-box top">
            <p>Select <span style="color: #6f1d1b;">Agent</span> if you want to post and manage your own properties</p>
         </div>
         <div class="message-help-box bottom">
            <p>Select <span style="color: #6f1d1b;">User</span> if you want to browse properties or publish your own vacations rentals </p>
         </div>
       </div>
       <div class="close-profile-help-btn">
         <button class="close-help-profile-pop-up">I understand!</button>
       </div>
     </div>
   </section>
 </body>
 <script>
    function showPasswordSignUp()
    {
     var u = document.getElementById("password-input");
     var i = document.getElementById("sign-up-hide1");
     var o = document.getElementById("sign-up-unhide1");
     if( u.type === 'password')
     {
       u.type = "text";
       i.style.display = "block";
       o.style.display = "none";
     }
     else
     {
       u.type = "password";
       i.style.display = "none";
       o.style.display = "block";
     }
    }
    function showConfirmPassword()
    {
     var q = document.getElementById("confirm-password-input");
     var w = document.getElementById("sign-up-hide2");
     var e = document.getElementById("sign-up-unhide2");
     if( q.type === 'password')
     {
        q.type = "text";
        w.style.display = "block";
        e.style.display = "none";
      }
     else
     {
        q.type = "password";
        w.style.display = "none";
        e.style.display = "block";
      }
    }
    /**users toggle switch */
    var profileBtn = document.getElementById('profile-btn')
    var NormalUserBtn = document.getElementById('profile-btn1')
    var ProUserBtn = document.getElementById('profile-btn2')
    function NormalUserClick()
    {
	   profileBtn.style.left = '0'
     NormalUserBtn.style.color = "white";
     ProUserBtn.style.color = "grey";
    }
    function ProUserClick()
    {
	   profileBtn.style.left = '120px'
     ProUserBtn.style.color = "white";
     NormalUserBtn.style.color = "grey";
    }
    // Get the helpProfilePopUp and the registerContainer 
    const  helpProfilePopUp = document.getElementById("helpProfilePopUp");
    var registerContainer = document.getElementById("registerContainer");
    // Get the button that opens the helpProfilePopUp
    var profileHelpBtn = document.getElementsByClassName("profile-help-btn")[0];
    // When the user clicks the button, open the helpProfilePopUp and hide the registerContainer
    profileHelpBtn.onclick = function()
    {
     helpProfilePopUp.style.display = "flex";
     registerContainer.style.display = "none";
    }
    // Get the btn closes the helpProfilePopUp
    var closeHelpProfilePopUp = document.getElementsByClassName("close-help-profile-pop-up")[0];
    // When the user clicks close the helpProfilePopUp and show the registerContainer
    closeHelpProfilePopUp.onclick = function()
    {
     helpProfilePopUp.style.display = "none";
     registerContainer.style.display = "block";
    }
    var userTypeInput = document.getElementById('user_type');
    var userButtons = document.querySelectorAll('.profile-toggle-btn');

    userButtons.forEach(function(btn) {
    btn.addEventListener('click', function() {
      userButtons.forEach(function(b) {
        b.classList.remove('active');
      });
      this.classList.add('active');
      userTypeInput.value = this.value;
    });
  });
  function goBack()
  {
    window.history.back();
  }
 </script>
</html>