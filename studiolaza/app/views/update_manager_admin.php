<?php

if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/forms.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
       
    </style>

</head>

<body class="brownbox" >
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation" style="margin-top:51px">
            <?php if ($_SESSION['type'] == "M") {
                include 'includes/managersidenav.php';
            }
            if ($_SESSION['type'] == "A") {
                include 'includes/adminsidenav.php';
            } ?>
        </div>


        <div class="" style="display:flex; width:85%; justify-content: center;">
            <div class="content" style="display:flexbox; ">
                <br><br>
                <h1 style="text-align:center; ">Update Profile</h1>
                <form action="<?php echo URLROOT; ?>/update/update_manager_admin" method="post" enctype="multipart/form-data">
                    <div style="display:flex ; flex-direction: column;">
                        <label for="username"><b>Username</b></label><br>
                        <?php
                        $x = $data["username"];
                        echo "<input type='text' id='username' placeholder='Enter username' value='$x' readonly>";
                        ?>
                        <br>
                        <br>

                        <label for="email"><b>Email</b></label><br>
                        <?php if ($data["emailerror"] == "") {
                            $x = $data["email"];

                            echo "<input type='text' id='email' placeholder='Enter email' name='email' value='$x'>";
                        } else {
                            echo "<input type='text' id='email' name='email' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["emailerror"]; ?>
                        </span><br><br>
                    </div>
                    <div style="text-align:center; display:flex; justify-content: center;">
                        <label class="button buttonSpace" for="profile_pic">
                            <b>Update profile picture</b><input type="file" id="profile_pic" name="image"></label>
                        
                        <label class="button buttonSpace" for="remove_profile_pic">
                            <b>Remove profile picture</b><br><input type="checkbox" id="remove_profile_pic" name="remove_image">
                        </label>

                    </div>


                    <br>
                    <div style="text-align:center;">
                        <a href="<?php echo URLROOT ?>/update/updatepassword"> Change Password </a>
                    </div>
                    <br>
                    <div style="text-align:center;">
                        <button class="button labelbox" style=" width:100%;"
                        
                         type="submit" name="submit"> Update </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>


</body>

</html>