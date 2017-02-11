<?php
 $price = $_POST['amount'];
 $desc = $_POST['desc'];
 echo "Price is ".$price ." Egp for ". $desc;
?>


 <form class="btn btn-default" id="pay" action="pay.php" method="POST">
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