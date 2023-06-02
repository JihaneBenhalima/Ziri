<?php
    @include '../Configuration/connect.php';
    session_start();
    if(!isset($_SESSION['userName']))
    {
      header('location:../Admin/log-in_admin.php');
    }
    $countPendingAgents=$connect->prepare("SELECT count(id) as cptpa from user WHERE user_type = 'agent' AND license <> '' AND Verified='' ");
    $countPendingAgents->setFetchMode(PDO::FETCH_ASSOC);
    $countPendingAgents->execute();
    $countPendingAgentsResult=$countPendingAgents->fetchAll();

    $countPendingReview=$connect->prepare("SELECT count(id) as cptpr from review WHERE Verified='' ");
    $countPendingReview->setFetchMode(PDO::FETCH_ASSOC);
    $countPendingReview->execute();
    $countPendingReviewResult=$countPendingReview->fetchAll();

    $countNotVerifiedProperties=$connect->prepare("SELECT count(id) as cptnvp from property WHERE Verified='' ");
    $countNotVerifiedProperties->setFetchMode(PDO::FETCH_ASSOC);
    $countNotVerifiedProperties->execute();
    $countNotVerifiedPropertiesResult=$countNotVerifiedProperties->fetchAll();

    $countNotVerifiedRentals=$connect->prepare("SELECT count(id) as cptnvr from vacationrentals WHERE Verified='' ");
    $countNotVerifiedRentals->setFetchMode(PDO::FETCH_ASSOC);
    $countNotVerifiedRentals->execute();
    $countNotVerifiedRentalsResult=$countNotVerifiedRentals->fetchAll();

    $countReview=$connect->prepare("SELECT count(id) as cptsr from review WHERE Verified='yes' ");
    $countReview->setFetchMode(PDO::FETCH_ASSOC);
    $countReview->execute();
    $countReviewResult=$countReview->fetchAll();

    $countAgents=$connect->prepare("SELECT count(id) as nofag from user WHERE user_type = 'agent' AND Verified='yes' ");
    $countAgents->setFetchMode(PDO::FETCH_ASSOC);
    $countAgents->execute();
    $countAgentsResult=$countAgents->fetchAll();

    $countProperty=$connect->prepare("SELECT count(id) as cptp from property ");
    $countProperty->setFetchMode(PDO::FETCH_ASSOC);
    $countProperty->execute();
    $countPropertyResult=$countProperty->fetchAll();

    $countRental=$connect->prepare("SELECT count(id) as cptr from vacationrentals ");
    $countRental->setFetchMode(PDO::FETCH_ASSOC);
    $countRental->execute();
    $countRentalResult=$countRental->fetchAll();

    $countAdmin=$connect->prepare("SELECT count(id) as cpta from admintable ");
    $countAdmin->setFetchMode(PDO::FETCH_ASSOC);
    $countAdmin->execute();
    $countAdminResult=$countAdmin->fetchAll();

    $countUser=$connect->prepare("SELECT count(id) as cptu from user WHERE user_type = 'user'  ");
    $countUser->setFetchMode(PDO::FETCH_ASSOC);
    $countUser->execute();
    $countUserResult=$countUser->fetchAll();
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
        <div class="dash-content">
            <div class="overview">
             <div class="hero  bg-base-200">
                 <div class="hero-content text-center">
                     <div class="max-w-md">
                         <h1 class="text-5xl font-bold">Hello there!</h1>
                         <p class="py-6">This is Ziri website management</p>
                     </div>
                 </div>
             </div>
             <div class="title">
                 <i class="fa-solid fa-chart-simple"></i>
                 <span class="text">Dashboard</span> 
             </div>
             <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box" style="margin-bottom: 30px">
                 <div class="collapse-title text-xl font-medium">
                      See pending requests
                 </div>
                 <div class="collapse-content">  
                     <p>There is <?php echo $countPendingAgentsResult[0]["cptpa"] ?> agents waiting to be verified </p>
                     <p>There is <?php echo $countPendingReviewResult[0]["cptpr"] ?> reviews waiting to be verified </p>
                     <p>There is <?php echo $countNotVerifiedPropertiesResult[0]["cptnvp"] ?> properties waiting to be verified </p>
                     <p>There is <?php echo $countNotVerifiedRentalsResult[0]["cptnvr"] ?> rentals waiting to be verified </p>
                 </div>
             </div>
             <div class="boxes">
                    <div class="box box1">
                        <i class="fa-solid fa-user-tie"></i>
                        <span class="text">Total agents</span>
                        <span class="number"><?php echo $countAgentsResult[0]["nofag"] ?></span>
                    </div>
                    <div class="box box2">
                        <i class="fa-solid fa-user"></i>
                        <span class="text">Total users</span>
                        <span class="number"><?php echo $countUserResult[0]["cptu"] ?></span>
                    </div>
                    <div class="box box3">
                        <i class="fa-solid fa-house"></i>
                        <span class="text">Total properties</span>
                        <span class="number"><?php echo $countPropertyResult[0]["cptp"] ?></span>
                    </div>
                    <div class="box box2">
                        <i class="fa-solid fa-house-flood-water"></i>
                        <span class="text">Total vacation rentals</span>
                        <span class="number"><?php echo $countRentalResult[0]["cptr"] ?></span>
                    </div>
                    <div class="box box3">
                        <i class="fa-regular fa-comment"></i>
                        <span class="text">Total reviews</span>
                        <span class="number"><?php echo $countReviewResult[0]["cptsr"] ?></span>
                    </div>
                    <div class="box box1">
                        <i class="fa-solid fa-user-pen"></i>
                        <span class="text">Total admins</span>
                        <span class="number"><?php echo $countAdminResult[0]["cpta"] ?></span>
                    </div>
                </div>
            </div>      
     </section>
  </body>
</html>