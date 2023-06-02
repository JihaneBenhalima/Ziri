<?php
  @include_once '../Configuration/connect.php';
    session_start();
    if(!isset($_SESSION['userName']))
    {
      header('location:../Admin/log-in_admin.php');
    }
  require_once('../Configuration/command.php');
  $users=users();
  function countUserRentals(PDO $pdo, int $userId): int
  {
    $query = "SELECT COUNT(vacationrentals.id) AS num_rentals FROM user INNER JOIN vacationrentals ON user.name = vacationrentals.rentalPosterName AND user.last_name = vacationrentals.rentalPosterLastName WHERE user.id = :userId ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return intval($result['num_rentals']);
  }
  if (isset($_POST['deleteUser']))
  {
    $id = $_POST['deleteUser'];
    deleteUser($id);
    header('location:../Admin/users_admin.php');
    exit();
  }
  $total_records = count(users());
  $records_per_page = 10;
  $total_pages = ceil($total_records / $records_per_page);
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($current_page < 1) {
  $current_page = 1;
  } else if ($current_page > $total_pages) {
   $current_page = $total_pages;
  }
  $offset = ($current_page - 1) * $records_per_page;
  $users = array_slice(users(), $offset, $records_per_page);
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
    <title>Users</title>
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
          <div class="dash-content" style="margin-bottom:20px;">
             <h1 style="text-align: center; margin-bottom:30px;">All users</h1>
             <div class="overflow-x-auto">
                 <table class="table w-full">
                     <!-- head -->
                     <thead>
                         <tr>
                             <th>Id</th>
                             <th>Picture</th>
                             <th>Name</th>
                             <th>Last name</th>
                             <th>Email</th>
                             <th>Phone number</th>
                             <th>Number of rentals posted</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <!-- row 1 -->
                         <form method="post" onsubmit="return confirmDelete();">
                             <?php foreach($users as $user):
                                 $rentalCount = countUserRentals($connect, $user->id);
                                 if ($rentalCount == 0)
                                 {
                                     continue; // skip this user if they haven't posted any rentals
                                 } 
                               ?>
                               <input type="hidden" name="userID" value="<?= $user->id ?>">
                               <tr>
                                  <th><?= $user->id?></th>
                                  <td><div class="avatar"><div class="w-14 rounded-full"><img src="../agents/<?= $user->profilePicture?>" /></div></div></td>
                                  <td><?= $user->name?></td>
                                  <td><?= $user->last_name?></td>
                                  <td><?= $user->email?></td>
                                  <td><?= $user->phoneNumber?></td>
                                  <td><?= countUserRentals($connect, $user->id) ?></td>
                                  <td><button class="btn btn-outline btn-error" name="deleteUser" type="submit" value="<?= $user->id ?>">Delete</button></td>
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
           for($i=1; $i<=$total_pages; $i++)
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
    function confirmDelete() {
     return confirm("Are you sure you want to delete this user?");
    }
 </script>
</html>