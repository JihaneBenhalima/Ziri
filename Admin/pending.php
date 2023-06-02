<?php
  require_once('../Configuration/connect.php');
  require_once('../Configuration/command.php');
    session_start();
    if(!isset($_SESSION['userName']))
    {
      header('location:../Admin/log-in_admin.php');
    }
  $pendingAgents=displayPendingAgents();
  if (isset($_POST['deletePendingAgent']))
  {
    $id = $_POST['deletePendingAgent'];
    deletePendingAgent($id);
    header('location:../Admin/pending.php');
    exit();
  }
  if (isset($_POST['verifyAgent']))
  {
    $pendingAgentID = $_POST['pendingAgentID'];
    $stmt = $connect->prepare("UPDATE user SET verified ='yes' WHERE user_type='agent' AND id = :id");
    $stmt->bindParam(':id', $pendingAgentID, PDO::PARAM_INT);
    $stmt->execute();
    header('location:../Admin/pending.php');
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
    <title>Pending agents requests</title>
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
             <h1 style="text-align: center; margin-bottom:20px;">Pending agents requests</h1>
             <div class="overflow-x-auto">
             <table class="table w-full">
                 <!-- head -->
                 <thead>
                     <tr>
                         <th>Id</th>
                         <th>Picture</th>
                         <th>Name</th>
                         <th>Last name</th>
                         <th>Address</th>
                         <th>Email</th>
                         <th>License</th>
                         <th>Action</th>
                      </tr>
                 </thead>
                 <tbody>
                     <!-- row 1 -->
                     <form method="post">
                         <?php foreach($pendingAgents as $pendingAgent):?>
                              <input type="hidden" name="pendingAgentID" value="<?= $pendingAgent->id ?>">
                              <tr>
                                 <th><?= $pendingAgent->id?></th>
                                 <td><div class="avatar"><div class="w-14 rounded-full"><img src="../agents/<?= $agent->profilePicture?>" /></div></div></td>
                                 <td><?= $pendingAgent->name?></td>
                                 <td><?= $pendingAgent->last_name?></td>
                                 <td><?= $pendingAgent->homeAddress?></td>
                                 <td><?= $pendingAgent->email?></td>
                                 <td><img style="cursor: pointer;" src="../agents/<?= $pendingAgent->license?>" alt="agent license"  onclick="displayFullScreen(this)"></td>
                                 <td><button type="submit" name="verifyAgent" class="btn btn-outline btn-info"><i class="fa-solid fa-check"></i></button>&nbsp;<button type="submit" value="<?= $pendingAgent->id ?>" name="deletePendingAgent" class="btn btn-outline btn-error"><i class="fa-solid fa-xmark"></i></button></td>
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
   function searchTable()
    {
     var input, filter, table, tr, td, i, txtValue;
     input = document.getElementById("searchInput");
     filter = input.value.toUpperCase();
     table = document.getElementsByClassName("table")[0];
     tr = table.getElementsByTagName("tr");
     // Loop through all table rows and hide those that don't match the search query
     for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[0];
     if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
   }
   }
 </script>
</html>