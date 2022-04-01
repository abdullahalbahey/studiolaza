<?php

if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <Style>
        .content {
            width: 60%;
            display: flex;
            height: auto;
            background-color: #fffdfd;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .labelbox {
            color: white;
            background-color: #890000;
            height: 50px;
            width: 500px;
            margin: auto;
            justify-content: center;
            display: flex;
            align-items: center;
            border-radius: 20px;
            cursor: pointer;
        }

        .labelbox:hover {
            background-color: #890000;
            border: 2px solid white;
            color: white;

        }
    </Style>
</head>

<body class="" style="overflow: hidden">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox" style="margin-top:51px">
            <?php if ($_SESSION['type'] == "C") {
                include 'includes/customersidenav.php';
            }
            if ($_SESSION['type'] == "E") {
                include 'includes/employeesidenav.php';
            }
            if ($_SESSION['type'] == "M") {
                include 'includes/managersidenav.php';
            }
            if ($_SESSION['type'] == "A") {
                include 'includes/adminsidenav.php';
            } ?>
        </div>
        <div class="" style="display:flex; width:90%; justify-content: center; ">
            <div class="content" style="margin-top:50px ; width:60%; display:flexbox; align-items: center;">
                <h1>Update Password</h1>
                <form class="" action="<?php echo URLROOT; ?>/update/updatepassword" method="post" enctype="multipart/form-data">
                    <div style="display:flex;    flex-direction: column; ">


                        <label for="password"><b>Current Password</b></label><br>
                        <input type='password' id='password' placeholder='Enter current password' name='password'>

                        <span class="errormessage">
                            <?php echo $data["passworderror"]; ?>
                        </span><br><br>

                        <label for="password"><b>New Password</b></label><br>
                        <input type='password' id='password' placeholder='Enter new password' name='newpassword'>

                        <span class="errormessage">
                            <?php echo $data["newpassworderror"]; ?>
                        </span><br><br>


                        <label for="conf_password"><b>Confirm Pasword</b></label><br>
                        <input type='password' id='conf_password' placeholder='Re-enter password' name='conf_password'>

                        <span class="errormessage">
                            <?php echo $data["conf_passworderror"]; ?>
                        </span><br><br>

                        <div style="text-align:center;">
                            <button class="button labelbox" type="submit" name="submit"> Update </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>

</html>