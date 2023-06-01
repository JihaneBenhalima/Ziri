<?php

session_start();
session_destroy();
header('location:../Register/log-in.php');

?>