

<?php 

require_once("inc/header.php");
$user_id=$_SESSION['id'];
?>



<?php
require_once("inc/navigation.php");
if(isset($_GET['homePage'])){
    require_once("./inc/homePage.php");
}elseif(isset($_GET['logout'])){
  require_once("../admin/logout.php");}?>



  <div class="row">
     <div class="col-12">
     <h3 mx-3>voters panel</h3>
     
         <?php
$fetchingactiveelections=mysqli_query($db,"SELECT * FROM elections WHERE status='active'") or die($mysqli_query($db));
while($isactive=mysqli_fetch_assoc($fetchingactiveelections)){
    $election_id=$isactive['id'];
    $election_topic=$isactive['election_topic'];
?>
<div class="bg-nav">

<h3 class="px-1 py-3">election topic : <?php echo $election_topic ?></h3>
</div>
<div class="main bg-body" style="display:flex;align-items:center;justify-content:center;">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


     <?php
$fetchingcandidate=mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id=$election_id ");
while($candidate=mysqli_fetch_assoc($fetchingcandidate)){
  $candidate_id=$candidate['id'];   
  $candidate_photo=$candidate['candidate_photo'];?>

  <!-- //making card -->
<div class="card " style="width:20%;height:192.58px; display:flex;align-items:center; margin-right:20px; margin-bottom:30px;margin-top:30px">
  <img   class="candidate_photo"src="<?php echo $candidate_photo ?>" alt="John" style="width:80px">
  <h5><?php echo $candidate['candidate_name'] ?></h5>
<p><?php echo $candidate['candidate_details'] ?></p>



<!-- logic after casting vote -->
<?php
$checkifvotecasted=mysqli_query($db,"SELECT * FROM votings WHERE voter_id='".$_SESSION['id']."'AND election_id='".$election_id."' ")or die(mysqli_error($db));

$isvoted=mysqli_num_rows($checkifvotecasted);
if($isvoted > 0){

  $canddata=mysqli_fetch_assoc($checkifvotecasted);
  if($canddata['candidate_id']==$candidate_id){
    ?>
 <img src="../assets/images/images.jpg" alt="" width="50px">
    
    <?php
  }
  
}else{ ?>
 

  <button class="btn btn-success" onclick="castvote(<?php echo $election_id ?>,<?php echo $candidate_id?>,<?php echo $_SESSION['id'] ?>)">Vote</button>
  <?php
};
?>







</div>

 <?php   
}
     ?>
     </div >

<?php
}
?>


     
 
     </div>

  </div>  



<?php
require_once("inc/footer.php");

?>
<script src="../assets/js/jquery.min.js"></script>

<script>

const castvote = (e_id, c_id, v_id) => {
    $.ajax({
        type: "POST",
        url: "inc/ajaxcalls.php",
        data: {
            e_id: e_id,
            c_id: c_id,
            v_id: v_id
        },
        success: function(response) {
            console.log(response);
            if(response=="success"){
          location.assign("index.php?votecasted=1");

        }else{
          location.assign("index.php?votenotcasted=1");
        }


        }
        
  });
  

  


}
</script>
