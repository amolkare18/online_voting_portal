
<?php
if(isset($_GET['added'])){
    ?>
    <div class="alert alert-success" role="alert">
 election has been added succesfully
</div>
<?php
}
?>




<div class="row my-4  bg-body">
<div class="col-4 bg-body">
<h3>Add New Election</h3>
<form method="POST">
<div class="form-group">
<input type="text"class="text-center form-control"  name='election_topic' placeholder="election topic" required/>

</div>
<div class="form-group">
<input type="text"class="text-center form-control"  name='no_of_candidates' placeholder="no of candidates" required/>

</div>
<div class="form-group">
<input type="text" class="text-center form-control" onfocus="this.type='Date'" name='starting_date' placeholder="starting date" required/>

</div>
<div class="form-group">
<input type="text"class="text-center form-control" onfocus="this.type='Date'" name='ending_date' placeholder="ending date" required/>

</div>
<input type="submit" value="Add Election" name="AddElectionBtn" class="btn btn-success">
</form>
</div>
<div class="col-8">
<h3>Upcoming Elections</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Election Name</th>
      <th scope="col">#Candidates</th>
      <th scope="col">starting_date</th>
      <th scope="col">ending_date</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>
      <?php
      $fetchingdata=mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
      $isempty=mysqli_num_rows($fetchingdata);
      if($isempty > 0){
          $sno=1;
          while($row=mysqli_fetch_assoc($fetchingdata)){
          ?>
          <tr><td><?php echo $sno++ ?></td>
          <td><?php echo $row['election_topic'] ?></td>
          <td><?php echo $row['no_of_candidates'] ?></td>
          <td><?php echo $row['starting_date'] ?></td>
          <td><?php echo $row['ending_date']?></td>
          <td><?php echo $row['status'] ?></td>
          <td>
          <form action="delete&update2.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id ?>"> <!-- Pass the ID here -->
                <button type="submit" name="delete" class="btn-delete btn-danger">Delete</button>
          
                
          </td></tr>

<?php
          }
          ?>
          <?php
      }else{
?>
<tr>
    <td class="col-7">No any election has been added yet</td>
</tr>

<?php
      }
?>
    
  </tbody>
</table>

</div>
</div>

<?php



if(isset($_POST['AddElectionBtn'])){
$election_topic=mysqli_real_escape_string($db,$_POST['election_topic']);
$no_of_candidates=mysqli_real_escape_string($db,$_POST['no_of_candidates']);
$starting_date=mysqli_real_escape_string($db,$_POST['starting_date']);
$ending_date=mysqli_real_escape_string($db,$_POST['ending_date']);
$inserted_by=$_SESSION['username'];
$inserted_on=date("y-m-d");

$date1=date_create($inserted_on);
$date2=date_create($starting_date);
$diff=date_diff($date1,$date2);
if($diff->format('%R%a' > 0)){
  $status="inActive";

}elseif($diff->format('%R%a' <= 0)){
    $status="Active";
};

mysqli_query($db,"INSERT INTO elections(election_topic,no_of_candidates,starting_date,ending_date,status,inserted_by,inserted_on) VALUE('".$election_topic."','".$no_of_candidates."','".$starting_date."','".$ending_date."','".$status."','".$inserted_by."','".$inserted_on."')") or die(mysqli_error($db));





?>
<script>location.assign("index.php?addElectionPage=1&added=1");</script>;
<?php
}
?>

