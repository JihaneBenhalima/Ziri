<?php
  @include_once '../Configuration/connect.php';
    session_start();
    if(!isset($_SESSION['userName']))
    {
      header('location:../Admin/log-in_admin.php');
    }
  require_once('../Configuration/connect.php');
  require_once('../Configuration/command.php');

  $pendingReviews=displayPendingReviews();
  if (isset($_POST['deletePendingReview']))
  {
    $id = $_POST['deletePendingReview'];
    DeleteReview($id);
    header('location:../Admin/allReviews.php');
    exit();
  }
  if (isset($_POST['verifyReview']))
  {
    $pendingReviewID = $_POST['pendingReviewID'];
    $stmt = $connect->prepare("UPDATE review SET Verified ='yes' WHERE id = :id");
    $stmt->bindParam(':id', $pendingReviewID, PDO::PARAM_INT);
    $stmt->execute();
    header('location:../Admin/AllReviews.php');
    exit();
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
     <title>Pending review requests</title>
  </head>
  <body> 
      <?php
         include_once('../Admin/navbar.php')
       ?>
       <section class="dashboard">
         <?php
           include_once('../Admin/top.php')
          ?>
          <input type="text" onkeyup="searchTable()" id="searchInput" placeholder="Search..." class="input input-bordered input-info w-full max-w-xs" />
         <div class="dash-content">
             <h1 style="text-align: center; margin-bottom:20px;">Pending reviews</h1>
             <div class="overflow-x-auto">
             <table class="table w-full">
                 <!-- head -->
                 <thead>
                     <tr>
                         <th>Id</th>
                         <th>Reviewer name</th>
                         <th>Reviewer last name</th>
                         <th>Number of stars</th>
                         <th>Comment</th>
                         <th>Action</th>
                      </tr>
                 </thead>
                 <tbody>
                     <!-- row 1 -->
                     <form method="post">
                         <?php foreach($pendingReviews as $pendingReview):?>
                              <input type="hidden" name="pendingReviewID" value="<?= $pendingReview->id ?>">
                              <tr>
                                 <th><?= $pendingReview->id?></th>
                                 <td><?= $pendingReview->reviewerName?></td>
                                 <td><?= $pendingReview->reviewerLastName?></td>
                                 <td><?= $pendingReview->starsRating?></td>
                                 <td><?= $pendingReview->comment?></td>
                                 <td><button type="submit" name="verifyReview" class="btn btn-outline btn-info"><i class="fa-solid fa-check"></i></button>&nbsp;<button type="submit" value="<?= $pendingReview->id ?>" name="deletePendingReview" class="btn btn-outline btn-error"><i class="fa-solid fa-xmark"></i></button></td>
                              </tr>
                         <?php endforeach;?>
                     </form>
                 </tbody>
              </table>
          </div>
     </div>
   </section>
  </body>
  <script>
  function searchTable() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementsByClassName("table")[0];
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows and cells and hide those that don't match the search query
  for (i = 0; i < tr.length; i++) {
    for (j = 0; j < tr[i].cells.length; j++) {
      td = tr[i].cells[j];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
  }
  </script>
</html>