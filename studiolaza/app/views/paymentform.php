<html>
<body>
<form method="post" action="https://sandbox.payhere.lk/pay/checkout">   
    <input type="hidden" name="merchant_id" value="1219593">    <!-- Replace your Merchant ID -->
    <input type="hidden" name="return_url" value="<?php echo URLROOT?>/payment/update_payment">
    <input type="hidden" name="cancel_url" value="<?php echo URLROOT?>/payment/cancel_payment">
    <input type="hidden" name="notify_url" value="<?php echo URLROOT?>/payment/cancel_payment">  
    <input type="hidden" name="order_id" value="<?php echo $data['bookingdetails'][0]->booking_id; ?>">
    <input type="hidden" name="items" value="Advance payment">
    <input type="hidden" name="currency" value="LKR">
    <input type="hidden" name="amount" value="25000">  
    <input type="hidden" name="first_name" value="Sire">
    <input type="hidden" name="last_name" value="<?php echo $data['customerdetails'][0]->name;?>"><br>
    <input type="hidden" name="email" value="<?php echo $data['customerdetails'][0]->email;?>">
    <input type="hidden" name="phone" value="<?php echo $data['customerdetails'][0]->contact;?>"><br>
    <input type="hidden" name="address" value="<?php echo $data['customerdetails'][0]->line1;?>">
    <input type="hidden" name="city" value="<?php echo $data['customerdetails'][0]->city;?>">
    <input type="hidden" name="country" value="Sri Lanka"><br><br> 
    <input type="submit" value="Pay">   
</form> 
</body>
</html>