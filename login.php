<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
// if the login form is submitted
    if(isset($_POST['submit'])){
        //makes sure input is filled
        if(!$_POST['username']|!$_POST['pass']){
            die('Fill in the username and password');
        }
    //Checks it against the database  
        
        $sql ="SELECT * FROM users WHERE username ='".$_POST['username']."'";
        $check = mysqli_query($conn,$sql) or die(mysqli_error());
        
    //Error if user dosen't exist
        $check2 = mysqli_num_rows($check);
        if($check2 == 0){
            die("this username dosen't exist, <a href='sign.php'>Sign up Here</a>");
        }
       while($info = mysqli_fetch_array($check)){
           if($_POST['pass'] != $info['password']){ // if password is wrong, redirect to login
               die('Incorrect password, please <a href="index.php">try again</a>.');
               
           }else{// if login is ok then we add a cookie
              $hour = time() + 36000;
              setcookie(ID_site, $_POST['username'],$hour);
              setcookie(Key_site, $_POST['pass'], $hour);
               
        //Then redirect to the members area
               header("Location: index.php");
           }
       } 
    }
   echo date("Y-m-d H:i:s");
  ?>

   <div class="container">
      <h1>Login</h1>
    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label for="username">Username</label>
        <input class="form-control" type="text" name="username" placeholder="Username">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="pass" placeholder="Password"><br>
        <input class="btn btn-default" type="submit" name="submit" value="Login"> 
    </form>
   </div>
</body>
</html>