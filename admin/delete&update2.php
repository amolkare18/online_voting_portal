
<?php

require_once('inc/config.php');
require('inc/header.php');
?><?php
if(isset($_POST['delete'])){
    ?><div class="alert alert-danger" role="alert">
  candidate successfully deleted
  
  </div>
  
<?php 
$fetchingdata=mysqli_query($db,"DELETE FROM elections WHERE id='".$_POST['id']."'") or die(mysqli_error($db));
}


?>
<?php
if (isset($_POST['update'])) {
    $election_id = $_POST['id']; // Election ID

    // Fetch current election details
    $fetchElection = mysqli_query($db, "SELECT * FROM elections WHERE id='$election_id'") or die(mysqli_error($db));
    $election = mysqli_fetch_assoc($fetchElection);

    ?>
    <body class="bg-body">
        <h3 class="text-center" style="margin-top:20px;">Update Election Details</h3>
        <div class="main2 bg-body text-center" style="margin-top:20px;">
            <form method="POST" enctype="multipart/form-data" class="translate-middle-x">
                <div class="form-group">
                    <input type="text" class="form-control" name="election_topic"  placeholder="Election Topic" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="election_details"  placeholder="Election Details" required />
                </div>
                <input type="hidden" name="id" >
                <input type="submit" value="Update Election" name="UpdateElectionBtn" class="btn btn-success text-center">
            </form>
        </div>
    </body>
    <?php
}
?>

<?php
if (isset($_POST['UpdateElectionBtn'])) {
    $election_id = mysqli_real_escape_string($db, $_POST['id']);
    $election_topic = mysqli_real_escape_string($db, $_POST['election_topic']);
    $election_details = mysqli_real_escape_string($db, $_POST['election_details']);

    // Update election details in the database
    $updateQuery = "UPDATE elections SET election_topic='$election_topic', election_details='$election_details' WHERE id='$election_id'";
    $result = mysqli_query($db, $updateQuery) or die(mysqli_error($db));

    if ($result) {
        echo "<script>location.assign('index.php?updatedElection=1');</script>";
    } else {
        echo "<script>alert('Failed to update election details. Please try again.');</script>";
    }
}
?>

<?php
if (isset($_GET['updatedElection'])) {
    ?>
    <div class="alert alert-success" role="alert">
        Election has been updated successfully!
    </div>
    <?php
}
?>

