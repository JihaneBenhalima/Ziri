<?php
  /*done a 100%*/
  @include_once '../Configuration/connect.php';
    session_start();
    if(!isset($_SESSION['userName']))
    {
      header('location:../Admin/log-in_admin.php');
    }
  require_once('../Configuration/command.php');
  $admins=Admins();
  if (isset($_POST['deleteAdmin']))
  {
    $id = $_POST['deleteAdmin'];
    DeleteAdmin($id);
    header('location:../Admin/admins.php');
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
    <title>Admins</title>
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
      <h1 style="text-align: center; margin-bottom:30px;">All admins</h1>
      <div class="overflow-x-auto">
       <table class="table w-full">
         <!-- head -->
         <thead>
           <tr>
             <th>Id</th>
             <th>user name</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
           <!-- row 1 -->
           <form method="post" onsubmit="return confirmDelete();">
             <?php foreach($admins as $admin):?>
               <input type="hidden" name="adminID" value="<?= $admin->id ?>">
               <tr>
                 <th><?= $admin->id?></th>
                 <td><?= $admin->userName?></td>
                 <td><button class="btn btn-outline btn-error"  name="deleteAdmin" type="submit" value="<?= $admin->id ?>">Delete</button></td>
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
    return confirm("Are you sure you want to delete this admin?");
}
</script>

</html>