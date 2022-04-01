<?php

if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>




<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox" style="margin-top:50px" >
            <?php include 'includes/managersidenav.php' ?>
        </div>
        <div class="content brownbox" style="margin-top:50px">
            <h1 style="text-align:center">Finance Page</h1>
            <?php
                include 'finance.php'
            ?>
        </div>
    </div>

</body>

</html>