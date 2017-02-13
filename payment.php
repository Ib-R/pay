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

if(isset($_POST['amount'])){
     $price = $_POST['amount'];
     $desc = $_POST['desc'];
    $_SESSION['amount'] = $price;
    $_SESSION['desc'] = $desc;
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
    }else{//if user is not logged in redirect to login page
        header("Location: login.php");}

  //The Payment Code
    require_once('vendor/autoload.php');
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    
    // Token is created using Stripe.js or Checkout!
    // Get the payment token submitted by the form:
  if(isset($_POST['stripeToken'])){
    $token = $_POST['stripeToken'];
    $price = $_SESSION['amount'];
    $desc = $_SESSION['desc'];
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
    $sql="INSERT INTO courses ($desc, time) VALUES ('$user','$time')";
    $add= mysqli_query($conn,$sql);
    header("Location: course.php");
  }
}
 
 echo "Price is ".$price ." Egp for ". $desc;
?>


 <form class="btn btn-default" action="" method="POST">
      <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_6pRNASCoBOKtIshFeQd4XMUh"
        data-amount="<?php echo $price;?>"
        data-name="Payment"
        data-description="<?php echo $desc;?>"
        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
        data-locale="auto"
        data-zip-code="false">
      </script>
    </form>