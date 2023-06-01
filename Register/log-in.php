<?php
 session_start();
 $login=0;
 $invalid=0;
 $google=0;
 $empty=0;
 if(isset($_POST['google']))
 {
   $google=1;
 }
 if($_SERVER['REQUEST_METHOD']=='POST')
 {
   include '../Configuration/connect.php';
   $email=$_POST['email'];
   $password=$_POST['password'];
   // Use the PDO prepare statement to sanitize the user input and prevent SQL injection attacks
   $userType = isset($_POST['user_type']) ? $_POST['user_type'] : '';
   $stmt = $connect->prepare("SELECT * FROM user WHERE email=:email ");
   $stmt->bindParam(':email', $email);
   
   $stmt->execute();
   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   if($result)
   {
     $num=count($result);
     if($num>0)
     {
       $row = $result[0];
       if(password_verify($password, $row['password']))
       {
         $login=1;
         if($row['user_type'] == 'user')
         {
           $_SESSION['user_name'] = $row['name'];
           $_SESSION['user_last_name'] = $row['last_name'];
           $_SESSION['profilePicture'] = $row['profilePicture'];
           header('location:../UserSession/user-page.php');
         }
         elseif($row['user_type'] == 'agent')
         {
           $_SESSION['agent_name'] = $row['name'];
           $_SESSION['agent_last_name'] = $row['last_name'];
           $_SESSION['profilePicture'] = $row['profilePicture'];
           header('location:../AgentSession/agent-page.php');
         }
       }
       else
       {
         // login failed
         $invalid = 1;
       }
      }
   }
   elseif($email =='' || $password=='')
    {
      $empty=1;
    }
    else
    {
    // login failed
     $invalid = 1;
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
    <title>Ziri | Log in</title>
 </head>
 <body>
   <?php
     if($invalid)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         Invalid credentials. 
         </div>';
      }
      if($empty)
     {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
         Please fill all fields.
         </div>';
      }
      if($google)
     {
        
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        A Ziri account for this log-in option does not exist yet. Please try another log in option for now. 
         </div>';
      }
   ?>
   <section class="register-section" id="register-page">
     <div class="register-box">
        <div class="register-header">
          <a href="../Home/home.php">
            <img class="register-logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
          </a>
          <div class="close-register-page" id="close-register-page-btn">
           <a onclick="goBack()" style="color: white;"><i class="fa-solid fa-xmark"></i></a>
          </div>
       </div>
       <div class="register-container">
          <div class="log-in-title">
            <h1>Login</h1>
          </div>
          <form method="post">
          <div class="register-input-field">
            <input type="email" class="input" placeholder="Email" id="username"  name="email">
            <i id="register-input-field-icon1" class="fa-regular fa-user"></i>  
          </div>
          <div class="register-input-field">
            <input type="Password" class="input" placeholder="Password" id="password-input"  name="password">
            <i id="register-input-field-icon2" class="fa-solid fa-lock"></i>
            <div class="show-password" onclick="showPassword()">
              <i id="hide" class="fa-regular fa-eye"></i>
              <i id="unhide" class="fa-regular fa-eye-slash"></i>
            </div>
            <div class="register-help">
              <div class="register-help-one">
                <input type="checkbox" name="" id="check">
                <p for="check">Remember me</p>
              </div>
              <div class="register-help-two">
                <p><a href="#">Forgot password ?</a></p>
              </div>
            </div>
            <button type="submit" class="register-btn"> Log in
              <div class="register-btn-icon">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
              </div>
            </button>
          </form>
            <hr>
         <div class="Sign-up-with">
           <h5>Or</h5>
            <button name="google" type="submit"><img src="../google-logo.png" >
              Log in with Google
            </button>
         </div>
            <div class="register-to-sing-up-link">
              <h4>You don't have an account ? 
                <button class="register-to-sign-link-btn" id="sign-up-btn">
                  <a href="../Register/sign-up.php">Sign up</a>
                </button>
              </h4>
           </div>
        </div>
     </div>  
   </section>
 </body>
 <script> 
   function showPassword()
   {
     var a = document.getElementById("password-input");
     var b = document.getElementById("hide");
     var c = document.getElementById("unhide");
     if( a.type === 'password')
     {
        a.type = "text";
        b.style.display = "block";
        c.style.display = "none";
      }
     else
     {
        a.type = "password";
        b.style.display = "none";
        c.style.display = "block";
     }
    }
    function goBack()
    {
     window.history.back();
    }
 </script>
</html>