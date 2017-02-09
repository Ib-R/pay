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
  if(isset($_COOKIE['ID_site'])){
   $username = $_COOKIE['ID_site'];
   $today = date("Y-m-d H:i:s");  
   $sql ="SELECT * FROM courses WHERE course1 ='$username'";
   $query = mysqli_query($conn,$sql)or die(mysqli_error());
//check if the username is in the db
   $checkName = mysqli_num_rows($query);
   $checkAccess = mysqli_fetch_assoc($query);
   
            if($checkName != 0){
               if($checkAccess['course1'] == $username && $today > $checkAccess['time'] ){
                  
               }
            }else{
                die("You need to subscripe first <a href='index.php'>From Here</a>") ;
            }

  }else{die("You need to <a href='index.php'>Login</a>");}
?>
   <h2>Sorry your subscription has expired, you can renew from here</h2>
    <form id="renew" action="renew.php" method="POST">
          <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
            data-amount="1000"
            data-name="Payment"
            data-description="Widget"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-zip-code="false">
          </script>
    </form>