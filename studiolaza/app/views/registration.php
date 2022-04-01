<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">

</head>

<body style="flex-direction: column; ">

    <div class="header" style="z-index:4; margin-left:10px">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="mainCLM" style="display:flex; flex-direction:row;justify-content: center;    align-items: center;">
        <div class="twoCLMIMG" style="display:flex">
            <img style="height:30%; display:flex " src="<?php echo URLROOT . '/public/img/img/register.svg' ?>" alt="">
        </div>
        <div class="signupFrm twoCLM">

            <h2 style="text-align: center; color:#890000">Sign up</h2>
            <br>

            <form class="" style="width:80%" action="<?php echo URLROOT; ?>/registrationpage/register" method="post" enctype="multipart/form-data">


                <div class="inputContainer">
                    <input type="text" id="username" class="input" placeholder="Enter Name" name="name" value="<?php if(empty($data['nameerror'])){echo $_SESSION['name_1']; } ?>">
                    <label class="label" for="username"><b>Name</b></label>
                    <span class="errormessage"><?php echo $data["nameerror"]; ?></span>
                </div>
                <div class="inputContainer">
                    <input type="text" id="username" class="input" placeholder="Enter NIC" name="nic" value="<?php if(empty($data['nicerror'])){echo $_SESSION['nic']; } ?>">
                    <label class="label" for="username"><b>NIC</b></label>
                    <span class="errormessage"><?php echo $data["nicerror"]; ?></span>
                </div>
                <div class="inputContainer">

                    <input type="text" id="username" class="input" placeholder="Enter Username" name="username" value="<?php if(empty($data['usernameerror'])){echo $_SESSION['username']; } ?>">
                    <label class="label" for="username"><b>User name</b></label>
                     <span class="errormessage"><?php echo $data["usernameerror"]; ?></span>
                </div>

                <div class="inputContainer">
                    <input type="password" id="password" class="input" placeholder="Enter Password" name="password">
                    <label class="label" for="password"><b>Password</b></label>
                    <span class="errormessage"><?php echo $data['passworderror']; ?></span>
                </div>

                <div class="inputContainer">
                    <input type="password" class="input" id="conf_password" placeholder="Re-Enter Password" name="conf_password">
                    <label class="label" for="conf_password"><b>Confirm Password</b></label>
                    <span class="errormessage"><?php echo $data['conf_passworderror']; ?></span>
                </div>

                <div class="inputContainer">
                    <input type="email" id="address_city" class="input" placeholder="Enter Email" name="email" value="<?php if(empty($data['emailerror'])){echo $_SESSION['email']; } ?>">
                    <label class="label" for="email"><b>Email</b></label>
                    <span class="errormessage"><?php echo $data['emailerror']; ?></span>
                </div>

                <div class="inputContainer">
                    <input type="text" id="address_line1" class="input" placeholder="Enter Address" name="line1" value="<?php if(empty($data['line1error'])){echo $_SESSION['line1']; } ?>">
                    <label class="label" for="address_line1"><b>Address Line1</b></label>
                    <span class="errormessage"><?php echo $data["line1error"]; ?></span>
                </div>

                <div class="inputContainer">

                    <input type="text" id="address_city" class="input" placeholder="Enter City" name="city" value="<?php if(empty($data['cityerror'])){echo $_SESSION['city']; } ?>">
                    <label class="label" for="address_city"><b>Address City</b></label>
                    <span class="errormessage"><?php echo $data["cityerror"]; ?></span>
                </div>

                <div class="inputContainer">

                    <input type="number" id="contact" class="input" placeholder="Enter Contact" name="contact" value="<?php if(empty($data['contacterror'])){echo $_SESSION['contact']; } ?>">
                    <label class="label" for="contact"><b>Contact</b></label>
                    <span class="errormessage"><?php echo $data["contacterror"]; ?></span>
                </div>

                <div class="inputContainer">
                    <div style="text-align:center;">
                        <input type="file" class="input" id="profile_pic" name="image" style="visibility:hidden;">
                        <label class="labelButton" for="profile_pic"><b>Add profile picture</b></label>
                    </div>
                </div>


                <div style="text-align:center;">
                    <button class="submitBtn" type="submit"> Register </button>
                </div>




            </form>
        </div>

    </div>



    </div>

    <!-- 
    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>

-->


</body>

</html>