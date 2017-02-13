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
               if($checkAccess['PHP'] == $username && $today > $checkAccess['time'] ){
                  
               }
            }else{
                die("You need to subscripe first <a href='index.php'>From Here</a>") ;
            }

  }else{die("You need to <a href='index.php'>Login</a>");}

  //The Payment Code
    require_once('vendor/autoload.php');
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    
    // Token is created using Stripe.js or Checkout!
    // Get the payment token submitted by the form:
  if(isset($_POST['stripeToken'])){
    $token = $_POST['stripeToken'];
    $price = $_SESSION['price'];
    $desc = $_SESSION['name'];
    // Charge the user's card:
    $charge = \Stripe\Charge::create(array(
      "amount" => $price,
      "currency" => "egp",
      "description" => $desc,
      "source" => $token,
    ));
    
   if($charge){

    $user = $_COOKIE['ID_site'];
    $time = date("Y-m-d H:i:s",strtotime("+5 minute"));   
    $sql="UPDATE courses SET time='$time' WHERE ".$_SESSION['name']."='$user'";
    $add= mysqli_query($conn,$sql);
    header("Location: course.php");
  }
}
 
?>
   <?php echo "<h2>Sorry your subscription for ".$_SESSION['name']." has expired, you can renew from here for ".$_SESSION['price']." Egp</h2>";?>
    <form id="renew" action="" method="POST">
          <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
            data-amount="<?php echo $_SESSION['price'];?>"
            data-name="Payment"
            data-description="<?php echo $_SESSION['name'];?>"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-zip-code="false">
          </script>
    </form>