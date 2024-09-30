



<?php 


require('inc/header.php')
?>
<?php 


require('inc/navigation.php');
if(isset($_GET['homePage'])){
    require_once("./inc/homePage.php");
}
elseif(isset($_GET['addElectionPage'])){
   require_once("./inc/add_elections.php");

}elseif(isset($_GET['addCandidatePage'])){
   require_once("./inc/add_candidate.php");
}elseif(isset($_GET['logout'])){
   require_once("./logout.php");
}


?>
<?php 


require('inc/footer.php')
?>