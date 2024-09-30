








<?php
if(isset($_GET['home'])){
    require_once("results.php");
}


require_once("admin/inc/config.php");




$fetchingelec=mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));

while($data=mysqli_fetch_assoc($fetchingelec)){
$starting_date=$data['starting_date'];
$ending_date=$data['ending_date'];
$current_date=date("y-m-d");
$election_id=$data['id'];
$status=$data['status'];



if($status=='Active'){

    

$date1=date_create($ending_date);
$date2=date_create($current_date);
$diff=date_diff($date1,$date2);
if((int)$diff->format('%R%a') > 0){

 $updatedata=mysqli_query($db,"UPDATE elections SET status='Expired' WHERE id='".$election_id."'") or die(mysqli_error($db));

};

}elseif($status=='inActive'){
   
    $date1=date_create($current_date);
    $date2=date_create($starting_date);
    $diff=date_diff($date1,$date2);
    
    if((int)$diff->format('%R%a') <= 0){
     
     $updatedata=mysqli_query($db,"UPDATE elections SET status='Active' WHERE id='".$election_id."'") or die(mysqli_error($db));
    };
};


}

?>




















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login-online voting system</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="assets/css/login.css">
     <link rel="stylesheet" href="assets/css/style.css">

</head>
<body >
<a style="position:relative;top:570px;left:700px; background-color:#28a745"href="results.php?home=1" class="btn btn-primary">view results</a>


<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span> <img src="assets/images/OIP.jpg" class="w-75" alt="Logo" height="70px" width='100px'> </span><br/>
                        <span class="logo_title mt-5"> Login Dashboard </span>
<!--            <h1>--><?php //echo $message?><!--</h1>-->

        </div>
        <?php
        if(isset($_GET['signup'])){
            ?>
<div class="card-body">
            <form action="" method="post">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                   
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="su_username" class="form-control" placeholder="Username" required/>
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                   
                        <span class="input-group-text"><i class="fas fa-user" ></i></span>
                    </div>
                    <input type="email" name="su_email" class="form-control" placeholder="email" required/>
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="su_password" class="form-control" placeholder="Password" required/>
                </div>
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                   
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="password" name="su_retype_password" class="form-control" placeholder="ReType password" required/>
                </div>
                
                <div class="signup">
                <p style="color:white">already have an account? <a href='index.php'>sign in</a></p></div>

                <div class="form-group">
                    <input type="submit" name="sign_up_btn" value="sign up" class="btn btn-outline-danger float-right login_btn">
                </div>

            </form>
        </div>
        <?php


        }else
        {
            ?>
 <div class="card-body">
            <form action="" method="POST">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                   
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" class="form-control" placeholder="Username" required/>
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" class="form-control" placeholder="Password" required/>
                </div>
                <div class="signup">
                <p style="color:white">dont have an account? <a href='?signup=1'>signup</a></p></div>

                <div class="form-group">
                    <input type="submit" name="login_btn" value="Login" class="btn btn-outline-danger float-right login_btn">
                </div>

            </form>
        </div>
            <?php
        }
            ?>
<?php

require_once("admin/inc/config.php");
     if(isset($_POST['login_btn'])){
$username=mysqli_real_escape_string($db,$_POST['username']);
$password=mysqli_real_escape_string($db,sha1($_POST['password']));


$fetchingdata=mysqli_query($db,"SELECT * FROM users WHERE username='".$username."'") or die(mysqli_error($db));

if(mysqli_num_rows($fetchingdata) > 0){

    $data=mysqli_fetch_assoc($fetchingdata);

if($username==$data['username'] AND $password==$data['password']){
    session_start();
    $_SESSION['user_role']=$data['user_role'];
    $_SESSION['username']=$data['username'];
    $_SESSION['id']=$data['id'];
    

    if($data['user_role']=="admin"){
         $_SESSION['key']="adminkey";
         
 
?>

 <script>location.assign("admin/index.php?homePage=1")</script>
 
 <?php
}else{
    $_SESSION['key']="voterskey";
?>
 <script>location.assign("voter/index.php")</script>
 <?php
}

    }else{
        ?>
         <script>location.assign("index.php?invalid_access=1")</script>
    <?php
    }
?>
<?php
}else{

?>
<script>location.assign("index.php?not_registered=1")</script>
<?php
}


?>
<?php
}


?>




<?php
?>




            <?php
if(isset($_GET['registered'])){

            ?>
            <span class="text-success bg-white text-center">your account has been successfully created</span>
            
            <?php
}else if(isset($_GET['invalid'])){
    ?>

        <span class="text-danger bg-white text-center">password doesnt match please try again!</span>
        <?php
}else if(isset($_GET['not_registered'])){
      ?>  
       <span class="text-danger bg-white text-center">sorry,you are not registered</span>
        <?php
}else if(isset($_GET['invalid_access'])){
?>
<span class="text-danger bg-white text-center">username already registere,try any other username</span>
        <?php
}

?>
    </div>
</div>



<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
</body>
</html>


<?php
require_once("admin/inc/config.php");
if(isset($_POST['sign_up_btn'])){
$su_username=mysqli_real_escape_string($db,$_POST['su_username']);
$su_email=mysqli_real_escape_string($db,$_POST['su_email']);
$su_password=mysqli_real_escape_string($db,sha1($_POST['su_password']));
$su_retype_password=mysqli_real_escape_string($db,sha1($_POST['su_retype_password']));
$user_role="voter";
if($su_password==$su_retype_password){

mysqli_query($db,"INSERT INTO users(username,email,password,user_role) VALUES('".$su_username."','".$su_email."','".$su_password."','".$user_role."')") or die(mysqli_error($db));

?>
 <script>location.assign("index.php?signup=1&registered=1")</script>
<?php


}else{
    ?>
    <script>location.assign("index.php?signup=1&invalid=1")</script>

<?php
}
}
?>










