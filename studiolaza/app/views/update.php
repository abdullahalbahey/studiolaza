<?php

if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="brownbox" style="flex-direction: column;">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation " style="margin-top:51px;">
            <?php if ($_SESSION['type'] == "C") {
                include 'includes/customersidenav.php';
            }
            if ($_SESSION['type'] == "E") {
                include 'includes/employeesidenav.php';
            } ?>
        </div>
        <div class="" style="display:flex; width:85%; justify-content: center;">
            <div class="content" style="display:flexbox; "> <br>
                <h1 style="text-align:center; ">Update Profile</h1>
                <form class="" action="<?php echo URLROOT; ?>/update/update" method="post" enctype="multipart/form-data">
                    <div style="display:flex ; flex-direction: column;">
                        <label for="username"><b>Username</b></label>
                        <?php
                        $x = $data["username"];
                        echo "<input type='text' id='username' placeholder='Enter username' value='$x' readonly>";
                        ?>
                        <br>

                        <label for="email"><b>Email</b></label>
                        <?php if ($data["emailerror"] == "") {
                            $x = $data["email"];

                            echo "<input type='text' id='email' placeholder='Enter email' name='email' value='$x'>";
                        } else {
                            echo "<input type='text' id='email' name='email' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["emailerror"]; ?>
                        </span><br>


                        <label for="name"><b>Name</b></label>
                        <?php if ($data["nameerror"] == "") {
                            $x = $data["name"];

                            echo "<input type='text' id='name' placeholder='Enter name' name='name' value='$x'>";
                        } else {
                            echo "<input type='text' id='name' name='name' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["nameerror"]; ?>
                        </span><br>

                        <label for="nic"><b>NIC</b></label>
                        <?php if ($data["nicerror"] == "") {
                            $x = $data["nic"];

                            echo "<input type='text' id='nic' placeholder='Enter name' name='nic' value='$x'>";
                        } else {
                            echo "<input type='text' id='nic' name='name' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["nicerror"]; ?>
                        </span><br>


                        <label for="address_line1"><b>Address Line1</b></label>
                        <?php if ($data["line1error"] == "") {
                            $x = $data["line1"];

                            echo "<input type='text' id='address_line1' placeholder='Enter Address' name='line1' value='$x'>";
                        } else {
                            echo "<input type='text' id='address_line1' name='line1' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["line1error"]; ?>
                        </span><br>


                        <label for="city"><b>Address City</b></label>
                        <?php if ($data["cityerror"] == "") {
                            $x = $data["city"];

                            echo "<input type='text' id='city' placeholder='Enter City' name='city' value='$x'>";
                        } else {
                            echo "<input type='text' id='city' name='city' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["cityerror"]; ?>
                        </span><br>


                        <label for="contact"><b>Contact</b></label>
                        <?php if ($data["contacterror"] == "") {
                            $x = $data["contact"];

                            echo "<input type='text' id='contact' placeholder='Enter Address' name='contact' value='$x'>";
                        } else {
                            echo "<input type='text' id='contact' name='contact' value='' >";
                        } ?>
                        <span class="errormessage">
                            <?php echo $data["contacterror"]; ?>
                        </span><br>

                    </div>
                    <!-- 
                    <div class="labelbox">
                        <label for="profile_pic"><b>Change profile picture</b></label>
                        <input type="file" id="profile_pic" name="image">
                    </div>

                    <br>
                    <div class="labelbox">
                        <label for="remove_profile_pic"><b>Remove profile picture</b></label>
                        <input type="checkbox" id="remove_profile_pic" name="remove_image">
                    </div>
                    -->
                    <div style="text-align:center; display:flex; justify-content: center;">
                        <label class="button buttonSpace" for="profile_pic">
                            <b>Update profile picture</b><input type="file" id="profile_pic" name="image"></label>

                        <label class="button buttonSpace" for="remove_profile_pic">
                            <b>Remove profile picture</b><br><input type="checkbox" id="remove_profile_pic" name="remove_image">
                        </label>

                    </div>

                    <br>
                    <div style="text-align:center;">
                        <a href="<?php echo URLROOT ?>/update/updatepassword"> Change password </a>
                    </div>
                            <br><br>
                    <div style="text-align:center;">
                        <button class="button" type="submit" name="submit"> Update </button>
                    </div>





                </form>
            </div>
        </div>
    </div>


</body>

</html>