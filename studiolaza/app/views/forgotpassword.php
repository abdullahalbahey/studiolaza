<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        button:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }
    </style>
</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_2 brownbox" style="height:auto">
        <div class="slider">
            <img src="<?php echo URLROOT; ?>/public/img/loginwallpaper.jpeg" width="100%" style="opacity:0.5" />
        </div>
        <div class="loginbox" style="border: 3px solid #890000; border-radius: 10px; background:#FFFDFD;margin-top:20px">

            <h1>Reset your password!</h1>

            <form action="<?php echo URLROOT; ?>/forgotpassword/emailerrormake" method="post">

                <div class="container">
                    <p>
                        Enter your username or user account's verified email address and we will send you a password reset link.
                    </p>
                    <label for="email"><b>Email: </b></label>
                    <input type="text" placeholder="Enter your username or email address" name="email">
                    <span class="errormessage">
                        <?php echo $data["emailerror"]; ?>
                    </span><br><br>
                </div>

                <div class="center" >
                    <button type="submit" style="width:auto" name="submit"> Send reset email </button>
                </div>
                <div class="center">
                    <button type="button" onclick="location.href='<?php echo URLROOT; ?>/registrationpage'"> Create an account </button>
                </div>

        </div>


        </form>
    </div>
    </div>


    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>