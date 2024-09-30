<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results</title>
</head>
<body>
<h3>Elections</h3>



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
    require_once("admin/inc/config.php");
          $fetchingdata=mysqli_query($db,"SELECT * FROM elections WHERE status='expired'") or die(mysqli_error($db));
    $isempty=mysqli_num_rows($fetchingdata);
    if($isempty > 0){
        $sno=1;
        while($row=mysqli_fetch_assoc($fetchingdata)){
          $election_id=$row['id'];
        ?>
        <tr><td><?php echo $sno++ ?></td>
        <td><?php echo $row['election_topic'] ?></td>
        <td><?php echo $row['no_of_candidates'] ?></td>
        <td><?php echo $row['starting_date'] ?></td>
        <td><?php echo $row['ending_date']?></td>
        <td><?php echo $row['status'] ?></td>
        <td>
            <a href="results.php?viewResult=<?php echo $election_id ?> " class="btn btn-sm btn-success">view Result</a>
            
        </td></tr>

<?php
        }
        ?>
        <?php
    }else{
?>
<tr>
  <td class="col-3">No any election has been done yet</td>
</tr>

<?php
    }
?>
  
</tbody>
</table>

</div>
</div>
</body>
</html>





