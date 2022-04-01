<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        #backgroundIMG {
            border: 2px solid black;
            padding: 25px;
            background: url(<?php echo URLROOT . '/public/img/img/confirmBooking.jpg' ?>);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body class="brownbox" style="overflow:hidden" id="backgroundIMG">
    <div class="header" style="margin-top:-26px;margin-left:-18px">
        <?php include 'includes/header.php' ?>
    </div>

    <div class=" signupFrm" style="display:flex; flex-direction: column;align-items: center;justify-content: center; height:500px;    flex-direction: column;">

        <div class="form" style="display:flex;    flex-direction: column;justify-content: center;font-size:1.5rem;text-align:center">
            TOTAL PRICE <br> <div style="font-size:2rem;text-align:center">LKR. <?php echo $_SESSION['price']; ?></div> 
             
        </div>

        <form class="form" style="display:flex;   flex-direction: column;" action="<?php echo URLROOT ?>/booknow/sendmail" method="post">
            <button class="submitBtn" style="width:100%" type="submit" name="confirm">Confirm</button>
        </form>
    </div>

    </div>



</body>

</html>