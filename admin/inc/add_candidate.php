<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Candidate</title>
</head>
<body>
    
<?php
if(isset($_GET['added'])){
    ?>
    <div class="alert alert-success" role="alert">
candidate has been added succesfully
</div>
<?php
}
?>
<?php
if(isset($_GET['largeFile'])){
    ?>
    <div class="alert alert-danger" role="alert">
File you are trying to upload is too large please upload file of size less than 4 mb
</div>
<?php
}
?>
<?php
if(isset($_GET['invalidFile'])){
    ?>
    <div class="alert alert-danger" role="alert">
invalid file format(please upload .jpg,.png or .jpeg file)
</div>
<?php
}
?>
<?php
if(isset($_GET['failed'])){
    ?>
    <div class="alert alert-danger" role="alert">
failed to upload an image try again
</div>
<?php
}
?>





<div class="row my-4  bg-body">
<div class="col-4 bg-body">
<h3>Add New Candidates</h3>
<form method="POST" enctype="multipart/form-data">
<div class="form-group">
<select class="form-control"name="election_id" required>

    <option value="">select election</option>
  <?php
$fetchingdata=mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));
$isempty=mysqli_num_rows($fetchingdata);
if($isempty > 0){
    while($row=mysqli_fetch_assoc($fetchingdata)){
        $election_id=$row['id'];
        $election_name=$row['election_topic'];
        ?>
        <option value="<?php echo $election_id ?>"><?php echo $election_name ?></option>
<?php
    }}else{
        ?>
        <option value="">Please add election first</option>
        <?php
    }
    ?>

  
  </select></div>
<div class="form-group">
<input type="text"class=" form-control"  name='candidate_name' placeholder="name of candidate" required/>

</div>
<div class="form-group">
<input type="file" class="text-center form-control"  name='candidate_photo' placeholder="candidate photo" required/>

</div>
<div class="form-group">
<input type="text"class="form-control"  name='candidate_details' placeholder="candidate details" required/>

</div>
<input type="submit" value="Add Candidate" name="AddCandidateBtn" class="btn btn-success">
</form>
</div>
<div class="col-8">
<h3>Candidates Details</h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Photo</th>
      
      <th scope="col">Name</th>
      <th scope="col">Details</th>
      <th scope="col">Election</th>
      <th scope="col">Action</th>

    </tr>
  </thead>
  <tbody>

  <?php
      $fetchingdata=mysqli_query($db,"SELECT * FROM candidate_details") or die(mysqli_error($db));
      $isempty=mysqli_num_rows($fetchingdata);
      if($isempty > 0){
          $sno=1;
          while($row=mysqli_fetch_assoc($fetchingdata)){
          ?>
<tr>
    <td><?php echo $sno++; ?></td>
    <td><img class="candidate_photo" src="<?php echo $row['candidate_photo']; ?>" alt="" /></td>
    <td><?php echo $row['candidate_name']; ?></td>
    <td><?php echo $row['candidate_details']; ?></td>

    <?php
    $election_id = $row['election_id'];
    $fetchingdat = mysqli_query($db, "SELECT * FROM elections WHERE id=$election_id") or die(mysqli_error($db));
    $isempty = mysqli_num_rows($fetchingdat);

    if ($isempty > 0) {
        while ($election = mysqli_fetch_assoc($fetchingdat)) {
    ?>
            <td><?php echo $election['election_topic']; ?></td>
    <?php
        }
    } else {
        echo "<td>No Election Found</td>";
    }
    ?>

    <td>
        <!-- Delete Form -->
        <form action="delete&update.php" method="POST" style="display:inline-block;">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Pass the ID here -->
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
        </form>

        <!-- Update Form -->
        
    </td>
</tr>

         
          

<?php
          }
          ?>
          <?php
      }else{
?>
<tr>
    <td class="col-7">No any candidate  has been added yet</td>
</tr>

<?php
      }
?>
    
  </tbody>
</table>


<?php
if(isset($_POST['AddCandidateBtn'])){
   
    $election_id=mysqli_real_escape_string($db,$_POST['election_id']);
    $candidate_name=mysqli_real_escape_string($db,$_POST['candidate_name']);
    $candidate_details=mysqli_real_escape_string($db,$_POST['candidate_details']);
    $inserted_by=$_SESSION['username'];
    $inserted_on=date("y-m-d");


       $targetted_folder="../assets/images/candidate_photos";
    $candidate_photo=$targetted_folder.rand(111111,999999)."_".rand(1111111111,9999999999).$_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name=$_FILES['candidate_photo']['tmp_name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));

    $allowed_types=array("jpg","png","jpeg");
    $image_size=$_FILES['candidate_photo']['size'];

    if($image_size < 4000000){
        if(in_array($candidate_photo_type,$allowed_types)){
            if(move_uploaded_file($candidate_photo_tmp_name,$candidate_photo)){

                mysqli_query($db,"INSERT INTO candidate_details(election_id,candidate_name,candidate_details,candidate_photo,inserted_by,inserted_on) VALUE('".$election_id."','".$candidate_name."','".$candidate_details."','".$candidate_photo."','".$inserted_by."','".$inserted_on."')") or die(mysqli_error($db));
                echo"<script>location.assign('index.php?addCandidatePage=1&added=1')</script>";

            }else{
                echo "<script>location.assign('index.php?addCandidatePage=1&failed=1')</script>";
            }
        }else{
            echo "<script>location.assign('index.php?addCandidatePage=1&invalidFile=1')</script>";
        }
    }else{
        echo "<script>location.assign('index.php?addCandidatePage=1&largeFile=1')</script>";
    }
}

?>
<?php

?>



</div>
</div>
</body>
</html>