<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CssFiles/loader.css">
    <title>Document</title>
</head>
<body>
     <div id="preLoader">
         <section class="dots-container">
             <div class="dot"></div>
             <div class="dot"></div>
             <div class="dot"></div>
             <div class="dot"></div>
             <div class="dot"></div>
         </section>
     </div>
 </body>
 <script>
       var loader = document.getElementById("preLoader");
       window.addEventListener("load",function()
       {
         loader.style.display = "none";
       })
 </script>
</html>