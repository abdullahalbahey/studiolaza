<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .topnav {

            background-color: #890000;
            margin: 0px 0 20px -10px;
            color: #f1f1f1;
            height: 52px;
            position: fixed;
            z-index: 1;
            width: 100%;

        }

        .topnav a {
            float: left;
            margin-right: 10;
            display: block;
            color: #f1f1f1;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            border-radius: 6px;

            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #890000;
            color: white;

        }

        .topnav .icon {
            display: none;
            height: 50px !important;
        }

        .topnav a .icon {
            height: 50px !important;

        }

        @media screen and (max-width: 1035px) {
            .topnav a:not(:first-child) {
                display: none;
            }

            .topnav a.icon {
                float: right;
                display: block;
                color: #f1f1f1;
            }
        }

        @media screen and (max-width: 1035px) {
            .fa {
                color: white;
            }


            .topnav.responsive {
                position: relative;
                height: auto;
            }

            .topnav.responsive .icon .fa:hover {
                position: absolute;
                right: 0;
                top: 0;
            }

            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;

            }

            img {
               display: none;
               height:0;
               width:0;
            }
        }
    </style>
</head>

<body>

    <div class="topnav" id="myTopnav">


        <a href="<?php echo URLROOT; ?>/landing" class="active" style="padding:0 80px 0 80px"> <img src="<?php echo URLROOT; ?>/public/img/logo.png" height="50px" /></a>
        <a href="javascript:void(0);" style="padding-bottom: 0px;    bottom: auto;    padding-top: 0px;" class="icon" onclick="myFunction()">
            <i style="height:50px;padding-bottom: 0px;  padding-top: 0px;margin-top: 15px;" class="fa fa-bars"></i>
        </a>
        <!--Home button function  change according to user-->
        <?php if (!isset($_SESSION['type'])) { ?>
            <a href="<?php echo URLROOT; ?>/landing"> Home </a>
        <?php } else if ($_SESSION['type'] == "C") { ?>
            <a href="<?php echo URLROOT; ?>/customerbooking">My Profile</a>

        <?php } else if ($_SESSION['type'] == "M") { ?>

            <a href="<?php echo URLROOT; ?>/managerbookings">My Profile</a>

        <?php } else if ($_SESSION['type'] == "A") { ?>

            <a href="<?php echo URLROOT; ?>/adminemployee">My Profile</a>

        <?php } else { ?>

            <a href="<?php echo URLROOT; ?>/employeebooking">My Profile</a>

        <?php } ?>



        <a href="<?php echo URLROOT; ?>/booknow">Book now</a>
        <a href="<?php echo URLROOT; ?>/landing/portfolio">Portfolio</a>
        <a href="<?php echo URLROOT; ?>/landing/aboutus">About us</a>
        <a href="<?php echo URLROOT; ?>/landing/contactus">Contact us</a>
        <div style="float:right;width:100px;"><i class="fas-fa-user"></i>
            <?php if (isset($_SESSION["id"])) {
                echo "<a href=" . URLROOT . "/loginpage/logout > Logout</a>";
            } else {
                echo "<a href=" . URLROOT . "/loginpage > Login</a>";
            } ?>
        </div>


    </div>

    <a href="javascript:void(0);" class="icon" onclick="myFunction()">

    </a>



    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>

</body>

</html>