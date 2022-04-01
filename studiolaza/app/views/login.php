<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body class="" style="overflow: hidden">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div>
        <div class="">
            <img src="<?php echo URLROOT; ?>/public/img/loginwallpaper.jpeg" style="opacity:0.5; width:100%;" />
        </div>
        <div class="loginbox signupFrm" style="border-radius: 10px; background:#FFFDFD;margin-top:20px; position:fixed; ">

            <h1>Sign in</h1>

            <form style="width:100%" class="" action="<?php echo URLROOT; ?>/loginpage/login" method="post">

                <div class="" >

                    <div class="inputContainer">
                        
                        <input type="text" class="input" placeholder="Enter Username" name="username" value="<?php if(empty($data['usernameerror'])){echo $_SESSION['username']; } ?>">
                        <label class="label"  for="pwd"><b>User name</b></label>
                        <span class="errormessage" style="float: right;"><?php echo $data["usernameerror"]; ?></span>
                    </div>
                    <br>
                    <div class="inputContainer">
                        <input type="password" class="input" placeholder="Enter Password" name="password">
                        <label class="label" for="pwd"><b>Password</b></label>
                        <span class="errormessage" style="float: right;"><?php echo $data['passworderror']; ?></span> 
                    </div>
                    <br>
                    <span class="errormessage" style="float: right;">
                        <?php echo $data["mainerror"]; ?>
                    </span>

                </div>
                <div style="text-align:center;">
                    <div>
                        <button type="submit"> Sign in </button>
                    </div>
                    <br>
                    <div>
                        <span class="pwd"> <a href="<?php echo URLROOT; ?>/forgotpassword">Forgot password?</a></span>
                    </div>
                    <br>
                    <div>
                        <button type="button" onclick="location.href='<?php echo URLROOT; ?>/registrationpage'"> Create an account </button>
                    </div>
                </div>


        </div>


        </form>
    </div>
    </div>



</body>

</html>