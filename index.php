<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>
<body>

<?php
    $servername ="localhost";
    $username="root";
    $dbname ="myDB";

    // Create connection
    $conn = mysqli_connect($servername, $username,"", $dbname);
    // Check connection
    if(!$conn) {
        die("Connection failed: ". mysqli_connect_error());
    }
 //checks cookies to make sure they are logged in
    if(isset($_COOKIE['ID_site'])){
        $username = $_COOKIE['ID_site'];
        $passcode = $_COOKIE['Key_site'];
        
        $sql ="SELECT * FROM users WHERE username ='$username'";
        $query = mysqli_query($conn,$sql)or die(mysql_error());
        
        while($info = mysqli_fetch_array($query)){
            
    //if the cookie has the wrong password,go to login page
            if($passcode != $info['password']){
                header("Location: login.php");
            }
        }
    }else{header("Location: login.php");}
    
// Check if the user paid hide the pay button
   if(isset($_COOKIE['ID_site'])){
   $username = $_COOKIE['ID_site'];
   $sql ="SELECT * FROM courses";
   $query = mysqli_query($conn,$sql)or die(mysqli_error());
//check if the username is in the db
   $checkName = mysqli_num_rows($query);
   while($checkAccess = mysqli_fetch_assoc($query)){
         // course1 check
               if($checkAccess['course1'] == $username){
                    ?>
                    <style>#pay{display:none;}</style>
                   <?php
               }
        //couse2 check     
             if($checkAccess['course2'] == $username){
                    ?>
                    <style>#pay1{display:none;}</style>
                   <?php
               }
        }
  }
?>
<style>
    .h {display: none}    
</style>
<a href="logout.php"><input type="button" value="LogOut"></a>
<div class="container">
  <h1>The Online Courses</h1>
   <div class="panel panel-default">
    <h1 class="panel-heading">PHP Course</h1>
    <h3 class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae saepe dolor quibusdam vitae consequatur veniam minus mollitia provident consectetur amet doloribus eum facere quis iusto quasi temporibus architecto consequuntur, a.</h3>

         <form action="payment.php" method="post">
             <input class="h" type="text" name="amount" value="1000">
             <input class="h" type="text" name="desc" value="PHP Course">
             <input type="submit" value="Subscripe for this course">
         </form>

    <a href="course.php">if you already bought it</a>
   </div>
   
    <div class="panel panel-default">
    <h1 class="panel-heading">AngularJs Course</h1>
    <h3 class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae saepe dolor quibusdam vitae consequatur veniam minus mollitia provident consectetur amet doloribus eum facere quis iusto quasi temporibus architecto consequuntur, a.</h3>
         <form action="payment.php" method="post">
             <input class="h" type="text" name="amount" value="1500">
             <input class="h" type="text" name="desc" value="AngularJs Course">
             <input type="submit" value="Subscripe for this course">
         </form>
    <a href="course.php">if you already bought it</a>
   </div>

</div>
</body>
</html>