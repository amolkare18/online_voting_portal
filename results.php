<?php
require_once('static/header.php');
?>
<?php 
if(isset($_GET['viewResult'])){
require_once("viewResults.php");
}
  ?>

  <?php
  if(isset($_GET['home'])){
    require_once('static/main.php');
  }
?>












