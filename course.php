<link rel="stylesheet" href="css/bootstrap.min.css">

<?php

  if(isset($_COOKIE['ID_site'])){
   $username = $_COOKIE['ID_site'];
   $today = date("Y-m-d H:i:s");  
   $sql ="SELECT * FROM courses WHERE course1 ='$username'";
   $query = mysqli_query($conn,$sql)or die(mysqli_error());
//check if the username is in the db
   $checkName = mysqli_num_rows($query);
   $checkAccess = mysqli_fetch_assoc($query);

            if($checkName != 0){
               if($checkAccess['course1'] == $username && $today < $checkAccess['time'] ){
                   $msg = "Welcome ".$username;
               }else{
                   header("Location: expire.php");
               }
            }else{
                header("Location: index.php");
            }

  }else{header("Location: login.php");}

?>
<a href="logout.php"><input type="button" value="LogOut"></a>
<div class="container">
    <div class="panel panel-default">
    <h1 class="panel-heading">Course Content</h1>
    <h2 class="panel-body"><?php echo $msg;?></h2>
    </div>
</div>