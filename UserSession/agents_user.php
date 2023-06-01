<?php
  /**done */
  require("../Configuration/connect.php");
  require("../Configuration/command.php");
  session_start();
  if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_last_name']))
  {
     header('location:../Register/log-in.php');
  }
  $records_per_page = 6;
  if (isset($_GET['page']) && is_numeric($_GET['page']))
  {
    $current_page = $_GET['page'];
  }
  else
  {
    $current_page = 1;
  }
  // SQL query to retrieve total number of records
  $total_query = $connect->query("SELECT COUNT(*) as total_records FROM user WHERE user_type='agent' AND Verified='yes'");
  $total_results = $total_query->fetch(PDO::FETCH_ASSOC)['total_records'];
  $total_pages = ceil($total_results / $records_per_page);
  // SQL query to retrieve records for current page
  $start = ($current_page - 1) * $records_per_page;
  $users_query = $connect->prepare("SELECT * FROM user WHERE user_type='agent' AND Verified='yes'  LIMIT :start, :records_per_page");
  $users_query->bindParam(':start', $start, PDO::PARAM_INT);
  $users_query->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
  $users_query->execute();
  $users = $users_query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CssFiles/agents.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <title>Ziri | Our agents</title>
 </head>
 <body>
    <?php
     require('../Header/header_user.php')
    ?>
    <main id="main" style="background-color: #FAF0E6;">         
      <section id="team" >
       <h1 class="agents-heading" style="text-align: center; justify-content:center;display:flex;font-size:30px;">
         <strong>Our certified agents</strong>
       </h1>
       <div class="search-bar">
          <input id="search-item" onkeyup="search()" type="text" name="text" class="search-bar-input" placeholder="search...">
          <span class="search-icon"> 
            <i class="fa-solid fa-magnifying-glass"></i>
          </span>
       </div>
       <div class="our-agents-container" id="our-agents-container">
         <?php foreach($users as $user):?>
            <div class="agent-box" id="agent-<?= $user->id ?>">
              <div class="agent-box-top-bar"></div>
              <div class="agent-box-nav">
                <i class="agent-box-verify fas fa-check-circle"></i>
              </div>
              <div class="agent-box-details">
                <img src="../agents/<?= $user->profilePicture?>" alt="">
                <h3><strong name="name"><?= $user->name?></strong>&nbsp;<strong name="last_name"><?= $user->last_name?></strong></h3>
                <p name="email"><?= $user->email?></p>
                <p name="phoneNumber"><?= $user->phoneNumber?></p>
              </div>
              <div class="agent-box-details">
                <p name="homeAddress"><?= $user->homeAddress?></p>
              </div>
              <div class="agent-box-details">
                <p name="aboutMe" style="text-align: center;height:120px;"><?= $user->aboutMe?></p>
              </div>
              <div class="agent-socials">
                <a href="<?= $user->facebookLink?>" style="color: blue;"><i class="fab fa-facebook-f"></i></a>
                <a href="<?= $user->linkedinLink?>" style="color: #0073b1;"><i class="fa-brands fa-linkedin"></i></a>
                <a href="<?= $user->instagramLink?>" style="color: #fc5c9c;"><i class="fab fa-instagram"></i></a>
              </div>
           </div>
         <?php endforeach;?>
       </div>
       <div class="pagination">  
         <?php if ($current_page > 1) : ?>
           <a href="?page=<?= $current_page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
         <?php endif; ?>
         <?php for ($i = $current_page - 1; $i <= $current_page + 1; $i++) :
           if ($i >= 1 && $i <= $total_pages) : ?>
           <a href="?page=<?= $i ?>"<?= $i == $current_page ? ' class="active"' : '' ?>><?= $i ?></a>
         <?php endif; endfor; ?>
         <?php if ($current_page < $total_pages) : ?>
         <a href="?page=<?= $current_page + 1 ?>"><i class="fa-solid fa-angle-right"></i></a>
         <?php endif; ?>
       </div>
     </section>
   </main>
   <?php
     require('../Footer/footer_user.php')
   ?>
 </body>
 <script>
   const search = () => {
    const searchBox = document.getElementById("search-item").value.toUpperCase();
    console.log(searchBox); // Print the value of the search box in uppercase
    const agents = document.getElementById("our-agents-container");
    agents.innerHTML = ""; // clear the current agents list
    if (searchBox.trim() === "") {
    window.location.reload(); // Reload the page if the search box is empty
    return;
   }
    const requests = []; //  an array to store all the fetch requests
    for (let i = 1; i <= <?= $total_pages ?>; i++) {
      const url = `?page=${i}`;
      requests.push(
      fetch(url)  // Send a fetch request to the specified URL
      .then(response => response.text()) // Extract the response body as text
      );
    }
    Promise.all(requests)
    .then(htmls => {
    const parser = new DOMParser();
    const agentList = []; // an array to store all the matching agents
    htmls.forEach(html => {
    const doc = parser.parseFromString(html, "text/html");
    const agent = doc.querySelectorAll(".agent-box"); // Find all elements with the class "agent-box"
    agent.forEach(agentBox => {
    const details = agentBox.querySelectorAll(".agent-box-details p, .agent-box-details h3");// Find all <p> and <h3> elements within the agent box
    console.log(details); // Print the found details
    let matchFound = false;
    if(details){
      details.forEach((detail) => {
      let textValue = detail.innerText || detail.innerHTML; // Extract the text content from the detail element
      if(textValue.toUpperCase().indexOf(searchBox) !== -1){ // Check if the search term is present in the text
      matchFound = true;
    }
    });
    }                
    if(matchFound){
    agentList.push(agentBox); // Add the agent box to the list if a match is found
    }
    });
    });
    if(agentList.length === 0){
    agents.innerHTML = "No agents found"; // Display a message if no agents are found
    }else{
    agentList.forEach(agentBox => agents.appendChild(agentBox)); // Append the matching agent boxes to the agents container
    }
    });
    };

   let subMenu = document.getElementById("subMenu");
   function ToggleMenu()
   {
    subMenu.classList.toggle("open-menu");
   }
   //for mobile view menu
   const menuHamburger = document.querySelector("#menu-hamburger")
   const navLinks = document.querySelector(".navlinks")
   menuHamburger.addEventListener('click',()=>
   {
     navLinks.classList.toggle('mobile-menu')
   }
   )
   // change menu icon to close icon while open
   let changeIcon = function(close)
   {
     icon.classList.toggle('fa-xmark')
   }
   //to not display the header content while menu is open
   const icon = document.querySelector('#menu-hamburger');
   const main = document.getElementById("main");
   const footer = document.getElementById("footer");
   icon.addEventListener('click', function() 
   {
     if (main.style.display === 'none')
      {
        main.style.display = 'block';
        footer.style.display = 'block';
      } else 
      {
        main.style.display = 'none';
        footer.style.display = 'none';
      }
   }
   );
 </script>
</html>