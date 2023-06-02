<?php
  @include_once '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['userName']))
  {
    header('location:../Admin/log-in_admin.php');
  }
  $success=0;
  $user=0;
  $match=0;
  $empty=0;
  $invalid_password=0;
  $max_admins = 10;
  $maxAdmins=0;
 if(isset($_POST['add-admin']))
 {
   include '../Configuration/connect.php';
   $userName=$_POST['userName'];
   $code=$_POST['code'];
   $verifyCode=$_POST['verifyCode'];
   $countReq = $connect->query("SELECT COUNT(*) FROM admintable");
   $count = $countReq->fetchColumn();
   $sql="SELECT * FROM admintable WHERE userName=:userName ";
   $stmt = $connect->prepare($sql);
   $stmt->bindParam(':userName', $userName);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);
   if($result)
   {
     $user=1;
   }
   elseif ($count >= $max_admins)
   {
     $maxAdmins=1;
   }
   elseif($code != $verifyCode)
   {
     $match=1;
   }
   elseif($userName=='' || $code=='' || $verifyCode=='')
   {
     $empty=1;
   }
   elseif(!preg_match('/^(?=.*\d)(?=.*[A-Z]).{8,}$/', $code))
   {
     $invalid_password=1;
   }
   else
   {
     $sql = "INSERT INTO admintable (userName, code ) VALUES (:userName, :code)";
     $stmt = $connect->prepare($sql);
     $stmt->bindParam(':userName', $userName);
     $hashed_password = password_hash($code, PASSWORD_DEFAULT);
     $stmt->bindParam(':code', $hashed_password);
     $result = $stmt->execute();
     if($result)
     {
        $success=1;
      }
      else
      {
       die($connect->errorInfo()[2]);
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
    <link rel="stylesheet" href="../Admin/admin.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin Dashboard</title>
 </head>
 <body>
    <?php
      include_once('../Admin/navbar.php')
    ?>
    <section class="dashboard">
      <?php 
        include_once('../Admin/top.php');
      ?>
      <div class="dash-content" style="justify-content: center;display: flex;flex-direction: column;align-items: center;position:relative;">
        <?php
         if($user)
         {
           echo '<div class="alert alert-error shadow-lg" style="margin-bottom: 50px;><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Admin already exists</span></div></div>';
         }
         if($maxAdmins)
         {
           echo '<div class="alert alert-error shadow-lg" style="margin-bottom: 50px;><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Error: Maximum number of admins reached</span></div></div>';
         }
         if($success)
         {
           echo '<div class="alert alert-success shadow-lg" style="margin-bottom: 50px;><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Admin added successfully!</span></div></div>';
         }
         if($match)
         {
           echo '<div class="alert alert-error shadow-lg" style="margin-bottom: 50px;><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Code does not match</span></div></div>';
         }
         if($empty)
         {
           echo '<div class="alert alert-error shadow-lg" style="margin-bottom: 50px;><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Fill all fields</span></div></div>';
         }
         if($invalid_password)
         {
           echo '<div class="alert alert-error shadow-lg" style="margin-bottom: 50px;"><div><svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span>Code does not meet requirements.Your Code must be at least 8 characters long, with at least one number and one uppercase letter.</span></div></div>';
         }
       ?>
       <h2 style="text-align: center;">Add an Admin</h2>
       <form method="post" style=" margin-top: 30px;display: grid;justify-content: center;">   
         <div class="form-control w-full max-w-xs">
           <label class="label">
             <span class="label-text">Admin user name</span>
           </label>
           <input type="text" name="userName" placeholder="Type here" class="input input-bordered input-info w-full max-w-xs" />
         </div>
         <div class="form-control w-full max-w-xs">
           <label class="label">
             <span class="label-text">Code</span>
           </label>
           <input type="password" name="code" id="password-input" placeholder="Type here" class="input input-bordered input-info w-full max-w-xs" />
         </div>
         <div class="form-control w-full max-w-xs">
           <label class="label">
             <span class="label-text">Verify code</span>
           </label>
           <input type="password" id="confirm-password-input" name="verifyCode" placeholder="Type here" class="input input-bordered input-info w-full max-w-xs" />
         </div>  
         <label class="cursor-pointer label" style="justify-content: flex-start;">  
           <input type="checkbox" id="checkbox" onclick="showPassword()"  class="checkbox checkbox-sm" /> 
           <span class="label-text">Show code</span>
         </label>
         <button type="submit" method="post" name="add-admin" style="margin-top: 20px;color:deepskyblue;" class="btn btn-primary">Add admin</button>
        </form>
      </div>     
    </section>
 </body>
 <script>
   function showPassword()
   {
     var passwordInput = document.getElementById("password-input");
     var confirmPasswordInput = document.getElementById("confirm-password-input");
     var checkbox = document.getElementById("checkbox");
     if (checkbox.checked)
     {
       passwordInput.type = "text";
       confirmPasswordInput.type = "text";
     }
     else
     {
       passwordInput.type = "password";
       confirmPasswordInput.type = "password";
     }
   }
 </script>
</html>