<link rel="stylesheet" href="css/bootstrap.min.css">

<?php
 session_start();
$servername ="localhost";
$username="root";
$dbname ="myDB";

// Create connection
$conn = mysqli_connect($servername, $username,"", $dbname);
// Check connection
if(!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}
  if(isset($_COOKIE['ID_site'])){
   $username = $_COOKIE['ID_site'];
   $today = date("Y-m-d H:i:s");  
   $sql ="SELECT * FROM courses WHERE PHP ='$username'";
   $query = mysqli_query($conn,$sql)or die(mysqli_error());
//check if the username is in the db
   $checkName = mysqli_num_rows($query);
   $checkAccess = mysqli_fetch_assoc($query);

            if($checkName != 0){
               if($checkAccess['PHP'] == $username && $today < $checkAccess['time'] ){
                   $msg = "Welcome ".$username;
               }else{
                   $_SESSION['price'] =1000;
                   $_SESSION['name'] ="PHP";
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