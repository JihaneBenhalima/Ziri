<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ziri";
  try
  {
     $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     // set the PDO error mode to exception
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } 
   catch(PDOException $e)
   {
     echo "Connection failed: " . $e->getMessage();
   }
?>