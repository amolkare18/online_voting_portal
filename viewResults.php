<div class="">
<h3>results</h3>
<div class="bg-nav">
<?php  

require_once("admin/inc/config.php");
$election_id=$_GET['viewResult'];
$fetchingactiveelections=mysqli_query($db,"SELECT * FROM elections WHERE id=$election_id") or die($mysqli_query($db));
while($isactive=mysqli_fetch_assoc($fetchingactiveelections)){
    $election_id=$isactive['id'];
    $election_topic=$isactive['election_topic'];

?>

<h3 class="px-1 py-3">election topic:<?php echo $election_topic ?> </h3>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      
      <th scope="col">Candidate Name</th>
      <th scope="col">Candidate Details</th>
      <th scope="col"># of votes</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
  <tr>
  <?php 
$fetchingcandidate=mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id=$election_id ");
while($candidate=mysqli_fetch_assoc($fetchingcandidate)){
  $candidate_id=$candidate['id'];   
  $candidate_photo=$candidate['candidate_photo'];
  
  $sno=1;?>

<?php
$checkifvotecasted=mysqli_query($db,"SELECT * FROM votings WHERE candidate_id='".$candidate_id."'AND election_id='".$election_id."' ")or die(mysqli_error($db));

$isvoted=mysqli_num_rows($checkifvotecasted);
if($isvoted > 0){

  $canddata=mysqli_fetch_assoc($checkifvotecasted);
  

}
  ?>



 
  <td class="text-canter"><?php echo $sno++ ?></td>
 
  <td  class="text-canter"><?php  echo $candidate['candidate_name'] ?></td>
  <td><?php  echo $candidate['candidate_details'] ?></td>
  <td><?php echo  mysqli_num_rows($checkifvotecasted); ?></td>
  </tr>
  
  </tbody>
  <?php
}
?>

  <?php 

}
?>