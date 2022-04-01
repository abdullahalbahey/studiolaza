<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>



<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/radio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        input[type=email] {
            width: 100%;
            height: 30px;
            padding-left: 20px;

        }

        button {
            background-color: #f2f2f2;
            border: 2px solid #890000;
            color: #890000;
            padding: 10px;
            padding-left: 20px;
            padding-right: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 30px;
            z-index: 1;
            height: 40px;
        }

        .input {
            width: 100%;
            height: 30px;
            padding-left: 20px;

        }

        button:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }

        .labelbox {
            color: white;
            background-color: #c70039;
            height: 50px;
            width: 500px;
            margin: auto;
            justify-content: center;
            display: flex;
            align-items: center;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        .labelbox:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }

        .formNew {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
    </style>

</head>

<body style="flex-direction: column;">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="mainCLM" style="display:flex; flex-direction:row;justify-content: center;    align-items: center;">
        <div class="sidenavigation " style="margin-top:40px">
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="content signupFrm">
            <h3>Add/Update employee -----<a href="<?php echo URLROOT; ?>/adminemployee/updateemployee" style="text-decoration:none;">Click here to update employee</a></h3>
            <form class="formNew" style="width:80%" action="<?php echo URLROOT; ?>/adminemployee/addemployee" method="post" enctype="multipart/form-data">
                <div class="inputContainer">
                    <input type="text" class="input" id="username" placeholder="Enter Name" name="name" value="<?php if (empty($data['nameerror'])) {
                                                                                                                    echo $_SESSION['name_1'];
                                                                                                                } ?>">
                    <label for="username" class="label"><b>Name</b></label>
                    <span class="errormessage"> <?php echo $data["nameerror"]; ?></span><br><br>

                </div>

                <div class="inputContainer">

                    <input type="text" class="input" id="username" placeholder="Enter NIC" name="nic" value="<?php if (empty($data['nicerror'])) {
                                                                                                                    echo $_SESSION['nic'];
                                                                                                                } ?>">
                    <label for="username" class="label"><b>NIC</b></label>
                    <span class="errormessage">
                        <?php echo $data["nicerror"]; ?>
                    </span>
                </div>

                <div class="inputContainer">

                    <input type="text" class="input" id="username" placeholder="Enter Username" name="username" value="<?php if (empty($data['usernameerror'])) {
                                                                                                                            echo $_SESSION['username'];
                                                                                                                        } ?>">
                    <label for="username" class="label"><b>User name</b></label>
                    <span class="errormessage">
                        <?php echo $data["usernameerror"]; ?>
                    </span>
                </div>

                <div class="inputContainer">
                    <input type="password" class="input" id="password" placeholder="Enter Password" name="password">
                    <label for="password" class="label"><b>Password</b></label>
                    <span class="errormessage">
                        <?php echo $data['passworderror']; ?>
                    </span>
                </div>

                <div class="inputContainer">
                    <input type="password" class="input" id="conf_password" placeholder="Re-Enter Password" name="conf_password">
                    <label for="conf_password" class="label"><b>Confirm Password</b></label>
                    <span class="errormessage">
                        <?php echo $data['conf_passworderror']; ?>
                    </span>
                </div>

                <div class="inputContainer">
                    <input type="email" style="width:100% ;height:50px" class="input" id="address_city" placeholder="Enter Email" name="email" value="<?php if (empty($data['emailerror'])) {
                                                                                                                                                            echo $_SESSION['email'];
                                                                                                                                                        } ?>">
                    <label for="email" class="label"><b>Email</b></label>
                    <span class="errormessage">
                        <?php echo $data['emailerror']; ?>
                    </span>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" id="address_line1" placeholder="Enter Address" name="line1" value="<?php if (empty($data['line1error'])) {
                                                                                                                            echo $_SESSION['line1'];
                                                                                                                        } ?>">
                    <label for="address_line1" class="label"><b>Address Line1</b></label>
                    <span class="errormessage">
                        <?php echo $data["line1error"]; ?>
                    </span>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" id="address_city" placeholder="Enter City" name="city" value="<?php if (empty($data['cityerror'])) {
                                                                                                                        echo $_SESSION['city'];
                                                                                                                    } ?>">
                    <label for="address_city" class="label"><b>Address City</b></label>
                    <span class="errormessage">
                        <?php echo $data["cityerror"]; ?>
                    </span>
                </div>
                <div class="inputContainer">
                    <input type="number" class="input" id="contact" placeholder="Enter Contact" name="contact" value="<?php if (empty($data['contacterror'])) {
                                                                                                                            echo $_SESSION['contact'];
                                                                                                                        } ?>">
                    <label for="contact" class="label"><b>Contact</b></label>
                    <span class="errormessage">
                        <?php echo $data["contacterror"]; ?>
                    </span>
                </div>

                <div class="inputContaine wrapper">
                    <label for="role" style=" text-transform: uppercase;"><b>Select roles</b></label>
                    <input type="checkbox" id="role" name="role[]" value="Photographer">Photographer
                    <input type="checkbox" id="role" name="role[]" value="Editor">Editor
                    <span class="errormessage">
                        <?php echo $data["roleerror"]; ?>
                    </span>
                </div>            
                <div class="inputContainer wrapper">
                <label for="emptype" style=" text-transform: uppercase;" ><b>Select employee type</b></label>
                    <input type="radio" id="option-1" name="emptype" value="Outsourced" >
                    <input type="radio" id="option-2" name="emptype" value="Permanent">
                    <span class="errormessage">
                        <?php echo $data["emptypeerror"]; ?>
                    </span><br><br>
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Outsourced</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Permanent</span>
                    </label>
                </div>



                <div class="inputContainer" style="text-align:center;">
                    <label class="labelButton"for="profile_pic"  ><b>Add profile picture</b></label>
                    <input type="file"class="input"id="profile_pic" name="image">
                </div>

                



                <div style="text-align:center;">
                    <button class="submitBtn" type="submit"> Register </button>
                </div>
                <br>
        </div>
    </div>
</body>

</html>