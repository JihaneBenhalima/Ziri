<?php
 @include_once '../Configuration/connect.php';
  session_start();
  if(!isset($_SESSION['userName']))
  {
    header('location:../Admin/log-in_admin.php');
  }
  require_once('../Configuration/connect.php');
  require_once('../Configuration/command.php');
  $properties=displayToVerify();

  if (isset($_POST['deleteProperty']))
  {
    $id = $_POST['deleteProperty'];
    deleteProperty($id);
    header('location:../Admin/listedProperties.php');
    exit();
  }
  if (isset($_POST['verifyProperty']))
  {
    $propertyID = $_POST['propertyID'];
    $stmt = $connect->prepare("UPDATE property SET verified ='yes' WHERE  id = :id");
    $stmt->bindParam(':id', $propertyID, PDO::PARAM_INT);
    $stmt->execute();
    header('location:../Admin/listedProperties.php');
    exit();
  }
  $total_records = count(displayToVerify());
  $records_per_page = 10;
  $total_pages = ceil($total_records / $records_per_page);
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($current_page < 1) {
  $current_page = 1;
  } else if ($current_page > $total_pages) {
   $current_page = $total_pages;
  }
  $offset = ($current_page - 1) * $records_per_page;
  $properties = array_slice(displayToVerify(), $offset, $records_per_page);
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
    <title>Listed properties</title>
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
      <div class="dash-content" style="margin-bottom: 30px;">
        <h1 style="margin-bottom: 20px;text-align:center;">Listed properties</h1>
        <div class="overflow-x-auto">
          <table class="table w-full">
           <!-- head -->
           <thead>
              <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Photo</th>
                <th>Full address</th>
                <th>Property Type</th>
                <th>Price</th>
                <th>Poster</th>
                <th>Action</th>
             </tr>
            </thead>
            <tbody>
             <!-- row 1 -->
             <form method="post">
                <?php foreach($properties as $property):?>
                  <input type="hidden" name="propertyID" value="<?= $property->id ?>">
                  <tr>
                    <th><?= $property->id?></th>
                    <td><?= $property->propertyTitle?></td>
                    <td><img style="cursor: pointer;" src="../uploads/<?= $property->propertyMain_image?>" alt="property main image"  onclick="displayFullScreen(this)"></td>
                    <td><?= $property->propertyAddress?>,<?= $property->propertyCity?>,<?= $property->propertyCountry?></td>
                    <td><?= $property->propertyType?></td>
                    <td><?= $property->propertyPrice?><?= $property->propertyCurrency?></td>
                    <td><?= $property->posterName?>&nbsp;<?= $property->posterLastName?></td>
                    <td><button class="btn btn-outline btn-info"><a href="../GuestSession/propertyDetails_guest.php?PropertyMoreDetails=<?php echo $property->id ?>">View more</a></button>&nbsp;<button type="submit" name="verifyProperty" class="btn btn-outline btn-accent"><i class="fa-solid fa-check"></i></button>&nbsp;<button type="submit" name="deleteProperty" value="<?= $property->id ?>" class="btn btn-outline btn-error"><i class="fa-solid fa-xmark"></i></button></td>
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
    return confirm("Are you sure you want to delete this property?");
   }
 </script>
</html>