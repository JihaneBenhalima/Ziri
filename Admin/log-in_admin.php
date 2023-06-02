<?php
 session_start();
 $invalid=0;
 $empty=0;
 if(isset($_POST['log-in-admin']))
 {
   include '../Configuration/connect.php';
   $userName=$_POST['userName'];
   $code=$_POST['code'];
   
   $stmt = $connect->prepare("SELECT * FROM admintable WHERE userName=:userName ");
   $stmt->bindParam(':userName', $userName);
   
   $stmt->execute();
   $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   if($result)
   {
     $num=count($result);
     if($num>0)
     {
       $row = $result[0];
       if(password_verify($code, $row['code']))
       {
          $_SESSION['userName'] = $row['userName'];
          header('location:../Admin/admin.php');
       }
       else
       {
         // login failed
         $invalid = 1;
       }
      }
   }
   elseif($userName =='' || $code=='')
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
   ?>
   <section class="register-section" id="register-page">
     <div class="register-box">
        <div class="register-header">
          <a href="../Home/home.php">
            <img class="register-logo" src="../img/Logo/ZiriLogoWhite.png" alt="Ziri.logo">
          </a>
       </div>
       <div class="register-container" style="position: relative;display: flex;justify-content: center;">
          <div class="log-in-title">
            <h1>Login</h1>
          </div>
          <form method="post">
          <div class="register-input-field">
            <input type="text" class="input" placeholder="user name" id="username"  name="userName">
            <i id="register-input-field-icon1" class="fa-regular fa-user"></i>  
          </div>
          <div class="register-input-field">
            <input type="Password" class="input" placeholder="code" id="password-input"  name="code">
            <i id="register-input-field-icon2" class="fa-solid fa-lock"></i>
            <div class="show-password" onclick="showPassword()">
              <i id="hide" class="fa-regular fa-eye"></i>
              <i id="unhide" class="fa-regular fa-eye-slash"></i>
            </div>
            <button type="submit" name="log-in-admin" class="register-btn" method="post"> Log in
              <div class="register-btn-icon">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
              </div>
            </button>
          </form>
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
 </script>
</html>