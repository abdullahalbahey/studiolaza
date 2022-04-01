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

        button:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }

        .inputContainer {
            margin: 30px;
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

        .input {
            float: right;
        }

        .labelbox:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }
    </style>

</head>

<body class="" style="flex-direction: column;">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="mainCLM" style="display:flex; flex-direction:row;justify-content: center;    align-items: center;">
        <div class="sidenavigation" style="margin-top:60px">
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="content signupFrm">
            <h1 style="text-transform: uppercase">Update employee</h1>
            <form class="" action="<?php echo URLROOT; ?>/adminemployee/updatedetails" method="post">

                <div class="inputContainer">
                    <input type="text" class="input" id="username" value="<?php echo $data["id"] ?>">
                    <label class="label" for="username"><b>Employee ID</b></label>
                </div>

                <div class="inputContainer">
                    <input class="input" type="text" id="username" value="<?php echo $data["name"] ?>">
                    <label class="label" for="username"><b>Name</b></label>
                </div>
                <div class="inputContainer">
                    <input type="text" class="input" id="username" value="<?php echo $data["roles"] ?>">
                    <label class="label" for="username"><b>Roles</b></label>
                </div>
                <div class="inputContainer wrapper" style="display:flex;">
                    <label for="role" style=" text-transform: uppercase;"><b>Select roles</b></label>
                    <input type="checkbox" id="role" name="role[]" value="Photographer">Photographer
                    <input type="checkbox" id="role" name="role[]" value="Editor">Editor
                    <span class="errormessage"><?php echo $data['roleerror'] ?></span>
                </div>

                <div class="inputContainer">
                    <input type="text" class="input" id="type" value="<?php echo $data["type"] ?>">
                    <label for="type" class="label" style="top:-10px;left:0px;"><b>Type</b></label>
                </div>

                <div class="inputContainer wrapper">
                    <label for="emptype" style=" text-transform: uppercase;"><b>Select employee type</b></label>
                    <input type="radio" id="option-1" name="emptype" value="Outsourced">
                    <input type="radio" id="option-2" name="emptype" value="Permanent">
                    <span class="errormessage">
                        <?php echo $data["emptypeerror"]; ?>
                    </span>
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Outsourced</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Permanent</span>
                    </label>
                </div>

                <span class="errormessage">
                    <?php echo $data['emptypeerror'] ?>
                </span>
                
                <div class="inputContainer" style="text-align:center;">
                    <label class="labelButton" for="profile_pic"><b>Add profile picture</b></label>
                    <input type="file" class="input" id="profile_pic" name="image">
                </div>
                <button type="submit" class="submitBtn" name="update"> Update </button>
                <button type="button" class="submitBtn" onclick="location.href='<?php echo URLROOT ?>/adminemployee/updateemployee'"> Close </button>
            </form>
        </div>
    </div>

   





</body>

</html>