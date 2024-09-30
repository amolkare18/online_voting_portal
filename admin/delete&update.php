<?php

require_once('inc/config.php');
require('inc/header.php');
?>

<?php
if(isset($_GET['updated'])){
    ?>
    <div class="alert alert-success" role="alert">
candidate has been updated succesfully
</div>
<?php
}
?>
<?php
if(isset($_GET['largeFile'])){
    ?>
    <div class="alert alert-danger" role="alert">
File you are trying to upload is too large please upload file of size less than 2mb
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




<?php

if(isset($_POST['delete'])){
  ?> <div class="alert alert-danger" role="alert">
  candidate successfully deleted
  <?php echo $_POST['id'];
  ?>
  </div>
  
<?php 
$fetchingdata=mysqli_query($db,"DELETE  FROM candidate_details WHERE id='".$_POST['id']."'") or die(mysqli_error($db));
}
?>

<?php
if(isset($_POST['update'])){
   
    ?>
    <body class="bg-body" >
        <h3 class="text-center"  style="margin-top:20px;">Update candidate details</h3>
        
   
    <div class="main2 bg-body  text-center" style="margin-top:20px;">
  <form method="POST" enctype="multipart/form-data" class="translate-middle-x">
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
<input type="text"class=" form-control"  name='candidate_name' placeholder="candidate_name" required/>

</div>
<div class="form-group">
<input type="file" class="text-center form-control"  name='candidate_photo' placeholder="candidate photo" required/>

</div>
<div class="form-group">
<input type="text"class="form-control"  name='candidate_details' placeholder="candidate details" required/>

</div>
<input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
<input type="submit" value="Update Candidate" name="UpdateCandidateBtn" class="btn btn-success text-center">
</form>




    </form>
    </div>
    </body>
    <?php
}
        

?>
<?php
if(isset($_POST['UpdateCandidateBtn'])){
   
   
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

    if($image_size > 3000000){
        if(in_array($candidate_photo_type,$allowed_types)){
            if(move_uploaded_file($candidate_photo_tmp_name,$candidate_photo)){

                mysqli_query($db,"UPDATE candidate_details SET election_id='$election_id', candidate_name='$candidate_name', candidate_details='$candidate_details', candidate_photo='$candidate_photo' WHERE id='{$_POST['id']}'") or die(mysqli_error($db));

                echo"<script>location.assign('index.php?addCandidatePage=1&updated=1')</script>";

            }else{
                echo "<script>location.assign('index.php?addCandidatePage=1&failed=1')</script>";
            }
        }else{
            echo "<script>location.assign('index.php?addCandidatePage=1&invalidFile=1')</script>";
        }
    }else{
        echo "<script>location.assign('index.php?addCandidatePage=1&largeFile=1')</script>";
    }
}?>



