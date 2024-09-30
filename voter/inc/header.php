<?php
session_start();

require_once("../admin/inc/config.php");
if(!isset($_SESSION['key']) || $_SESSION['key'] != "voterskey") {
    echo "<script>location.assign('../admin/logout.php')</script>";
        exit();
    }
    // If already on logout, don't redirect back
   


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="../assets/css/bootstrap.min.css"/>
     <link rel="stylesheet" href="../assets/css/style.css"/>
    <title>Voters-panel</title>
</head>
<body>
   <div class="container-fluid">

   <div class="row bg-black text-white">
   <div class="col-1">
   <img src="../assets/images/OIP.jpg" alt="vote" width="80px" >
   </div>
   <div class="col-11 my-auto">
   <h3>online voting system-<small>welcome <?php echo $_SESSION['username']; ?></small></h3></div>
  
   </div>

   </div>
  