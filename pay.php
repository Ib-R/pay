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

// check if the user already bought the course
$usercheck = $_COOKIE['ID_site'];
$sql ="SELECT course1 FROM courses WHERE course1 ='$usercheck'";
$query = mysqli_query($conn,$sql)
    or die(mysqli_error($conn));
$check = mysqli_num_rows($query);
    
 // if the name exists gives a msg

if ($check != 0) {
 	echo 'You already paid Mr/Mrs: '.$usercheck.'<a href="course.php"> Go to the course</a>';
  }else {
    
    require_once('vendor/autoload.php');
    // Set your secret key: remember to change this to your live secret key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    \Stripe\Stripe::setApiKey("sk_test_BQokikJOvBiI2HlWgH4olfQ2");
    
    // Token is created using Stripe.js or Checkout!
    // Get the payment token submitted by the form:
    $token = $_POST['stripeToken'];

    // Charge the user's card:
    $charge = \Stripe\Charge::create(array(
      "amount" => 1000,
      "currency" => "egp",
      "description" => "Example charge",
      "source" => $token,
    ));
    
   if($charge){

    $user = $_COOKIE['ID_site'];
    $time = date("Y-m-d H:i:s",strtotime("+5 minute"));   
    $sql="INSERT INTO courses (course1, time) VALUES ('$user','$time')";
    $add= mysqli_query($conn,$sql);
    header("Location: course.php");
  }
} 

?>