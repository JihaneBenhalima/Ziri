<?php
  @include_once '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['userName']))
  {
    header('location:../Admin/log-in_admin.php');
  }
  require_once('../Configuration/connect.php');
  require_once('../Configuration/command.php');
  $agents=agents();
  function countAgentRentals(PDO $pdo, int $agentId): int
 {
    $query = "SELECT COUNT(vacationrentals.id) AS num_rentals FROM user INNER JOIN vacationrentals ON user.name = vacationrentals.rentalPosterName AND user.last_name = vacationrentals.rentalPosterLastName WHERE user_type='agent' AND user.id = :agentId ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($result['num_rentals']);
 }
 function countAgentProperties(PDO $pdo, int $agentId): int
 {
    $query = "SELECT COUNT(property.id) AS num_properties FROM user INNER JOIN property ON user.name = property.posterName AND user.last_name = property.posterLastName WHERE user_type='agent' AND user.id = :agentId ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':agentId', $agentId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($result['num_properties']);
 }
  if (isset($_POST['deleteAgent']))
  {
    $id = $_POST['deleteAgent'];
    DeletePendingAgent($id);
    header('location:../Admin/agents_admin.php');
    exit();
  }
  $total_records = count(agents());
  $records_per_page = 4;
  $total_pages = ceil($total_records / $records_per_page);
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($current_page < 1)
  {
   $current_page = 1;
  } else if ($current_page > $total_pages)
  {
   $current_page = $total_pages;
  }
  $offset = ($current_page - 1) * $records_per_page;
  $agents = array_slice(agents(), $offset, $records_per_page);
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
    <title>Agents</title>
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
          <div class="dash-content" style="margin-bottom:30px;">
             <h1 style="text-align: center; margin-bottom:30px;">All certified agents</h1>
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
                             <th>Phone number</th>
                             <th>Number of properties posted</th>
                             <th>Number of rentals posted</th>
                             <th>License</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <!-- row 1 -->
                         <form method="post" onsubmit="return confirmDelete();">
                             <?php foreach($agents as $agent):
                                 $rentalCount = countAgentRentals($connect, $agent->id);
                                 $PropertyCount = countAgentProperties($connect, $agent->id);
                                 if ($rentalCount == 0 AND $PropertyCount == 0)
                                 {
                                    continue; // skip this user if they haven't posted anything
                                 } 
                               ?>
                               <input type="hidden" name="agentID" value="<?= $agent->id ?>">
                               <tr>
                                  <th><?= $agent->id?></th>
                                  <td><div class="avatar"><div class="w-14 rounded-full"><img src="../agents/<?= $agent->profilePicture?>" /></div></div></td>
                                  <td><?= $agent->name?></td>
                                  <td><?= $agent->last_name?></td>
                                  <td><?= $agent->homeAddress?></td>
                                  <td><?= $agent->email?></td>
                                  <td><?= $agent->phoneNumber?></td>
                                  <td><?= countAgentProperties($connect, $agent->id) ?></td>
                                  <td><?= countAgentRentals($connect, $agent->id) ?></td>
                                  <td><img style="cursor: pointer;" src="../agents/<?= $agent->license?>" alt="agent license picture"  onclick="displayFullScreen(this)"></td>
                                  <td><button class="btn btn-outline btn-error" name="deleteAgent" type="submit" value="<?= $agent->id ?>">Delete</button></td>
                               </tr>
                               <?php endforeach;?>
                          </form>
                      </tbody>
                  </table>
              </div>
         </div>
         <?php
            echo '<div class="btn-group" style="display: flex;justify-content: center;">';
            if ($current_page > 1)
           {
             echo '<a href="?page='.($current_page-1).'" class="btn">&laquo;</a>';
           }
           for ($i=1; $i<=$total_pages; $i++)
           {
            if ($i == $current_page) {
            echo '<button class="btn btn-info">Page '.$i.'</button>';
            } else {
            echo '<a href="?page='.$i.'" class="btn">'.$i.'</a>';
            }
            }
            if ($current_page < $total_pages) {
            echo '<a href="?page='.($current_page+1).'" class="btn">&raquo;</a>';
            }
            echo '</div>';
         ?>
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
   function confirmDelete() {
     return confirm("Are you sure you want to delete this agent?");
    }
 </script>
</html>