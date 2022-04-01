<html>  

<head>

</head>

<body>
    <form action="<?php echo URLROOT; ?>/forgotpassword/setpassword" method="POST">
        <label for="password"><b>New Password</b></label>
            <input type="password" id="password" placeholder="Enter New Password" name="password">
            <span class="errormessage">
                <?php echo $data['passworderror']; ?>
            </span><br><br>

        <label for="conf_password"><b>Confirm Password</b></label>
            <input width="100%" type="password" id="conf_password" placeholder="Re-Enter Password" name="conf_password">
            <span class="errormessage">
                <?php echo $data['conf_passworderror']; ?>
            </span><br><br>

            <input type="hidden" name="email" value="<?php echo $_SESSION['emailforp']?>">

            <button type="submit" name="update"> Update </button>
    </form>
</body>
</html>