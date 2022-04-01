<head>
    <style>
        li a{
            font-size:18px;
        }
        
    </style>
</head>

<header>
    <ul>
        <!--Home button function  change according to user-->
        <?php if(!isset($_SESSION['type'])){?>
                <li>
                    <a href="<?php echo URLROOT; ?>/landing">Home</a>
                </li>
        <?php }else if($_SESSION['type']=="C"){?>
                <li>
                    <a href="<?php echo URLROOT; ?>/customerbooking">My Profile</a>
                </li>
        <?php }else if($_SESSION['type']=="M"){?>
                <li>
                    <a href="<?php echo URLROOT; ?>/managerbookings">My Profile</a>
                </li>
        <?php }else if($_SESSION['type']=="A"){?>
                <li>
                    <a href="<?php echo URLROOT; ?>/adminemployee">My Profile</a>
                </li>
        <?php }else{?>
                <li>
                    <a href="<?php echo URLROOT; ?>/employeebooking">My Profile</a>
                </li>
        <?php }?>







        <li>
            <a href="<?php echo URLROOT; ?>/booknow">Book now</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/landing/portfolio">Portfolio</a>
        </li>
       
            <li>
                <a href="<?php echo URLROOT; ?>/landing"> <img src="<?php echo URLROOT; ?>/public/img/logo.png" /></a>
            </li>
        <li>
            <a href="<?php echo URLROOT; ?>/landing/aboutus">About us</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/landing/contactus">Contact us</a>
        </li>
        <li>
            <?php if (isset($_SESSION["id"])) {

                echo "<a href=" . URLROOT . "/loginpage/logout > Logout</a>";
            } else {
                echo "<a href=" . URLROOT . "/loginpage > Login</a>";
            } ?>

        </li>
        


    </ul>
</header>