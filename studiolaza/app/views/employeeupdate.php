<?php
    
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>
<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
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

        
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">
            <?php include 'includes/employeesidenav.php' ?>
        </div>
        <div class="content brownbox">
            <h1>Update Profile</h1>
            <form class="" action="<?php echo URLROOT; ?>/employeeupdate/update" method="post" enctype="multipart/form-data">

                
                    
                    <label for="name"><b>Name</b></label>
                    <?php if($data["nameerror"]==""){
                        $x=$data["name"];
                    
                        echo "<input type='text' id='name' placeholder='Enter name' name='name' value='$x'>";
                    }else{
                        echo "<input type='text' id='name' name='name' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["nameerror"];?>
                    </span><br><br>
                    
                    <label for="nic"><b>NIC</b></label>
                    <?php if($data["nicerror"]==""){
                        $x=$data["nic"];
                    
                        echo "<input type='text' id='nic' placeholder='Enter name' name='nic' value='$x'>";
                    }else{
                        echo "<input type='text' id='nic' name='name' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["nicerror"];?>
                    </span><br><br>
                    

                    <label for="username"><b>Username</b></label>
                    <?php if($data["usernameerror"]==""){
                        $x=$data["username"];
                    
                        echo "<input type='text' id='username' placeholder='Enter username' name='username' value='$x'>";
                    }else{
                        echo "<input type='text' id='name' name='name' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["usernameerror"];?>
                    </span><br><br>

                    <label for="password"><b>Current Password</b></label>
                    <?php if($data["passworderror"]==""){
                        $x=$data["password"];
                    
                        echo "<input type='password' id='password' placeholder='Enter password' name='password' value='$x'>";
                    }else{
                        echo "<input type='passsword' id='password' name='password' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["passworderror"];?>
                    </span><br><br>


                    <label for="password"><b>New Password</b></label>
                    <?php if($data["passworderror"]==""){
                        $x=$data["password"];
                    
                        echo "<input type='password' id='password' placeholder='Enter password' name='password' value='$x'>";
                    }else{
                        echo "<input type='passsword' id='password' name='password' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["passworderror"];?>
                    </span><br><br>


                    <label for="conf_password"><b>Confirm Pasword</b></label>
                    <?php if($data["conf_passworderror"]==""){
                        $x=$data["password"];
                    
                        echo "<input type='password' id='conf_password' placeholder='Re-enter password' name='conf_password' value='$x'>";
                    }else{
                        echo "<input type='passsword' id='conf_password' name='conf_password' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["conf_passworderror"];?>
                    </span><br><br>


                    <label for="email"><b>Email</b></label>
                    <?php if($data["emailerror"]==""){
                        $x=$data["email"];
                    
                        echo "<input type='text' id='email' placeholder='Enter email' name='email' value='$x'>";
                    }else{
                        echo "<input type='text' id='email' name='email' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["emailerror"];?>
                    </span><br><br>

                    
                    <label for="address_line1"><b>Address Line1</b></label>
		            <?php if($data["line1error"]==""){
                        $x=$data["line1"];
                    
                        echo "<input type='text' id='address_line1' placeholder='Enter Address' name='line1' value='$x'>";
                    }else{
                        echo "<input type='text' id='address_line1' name='line1' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["line1error"];?>
                    </span><br><br>

                    
                    <label for="city"><b>Address City</b></label>
		            <?php if($data["cityerror"]==""){
                        $x=$data["line1"];
                    
                        echo "<input type='text' id='city' placeholder='Enter City' name='city' value='$x'>";
                    }else{
                        echo "<input type='text' id='city' name='city' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["cityerror"];?>
                    </span><br><br>


                    <label for="contact"><b>Contact</b></label>
		            <?php if($data["contacterror"]==""){
                        $x=$data["contact"];
                    
                        echo "<input type='text' id='contact' placeholder='Enter Address' name='contact' value='$x'>";
                    }else{
                        echo "<input type='text' id='contact' name='contact' value='' >";
                    }?>
                    <span class="errormessage">
                         <?php echo $data["contacterror"];?>
                    </span><br><br>



                    <div class="labelbox">
                    <label for="profile_pic"><b>Change profile picture</b></label>
                    <input type="file" id="profile_pic"  name="image"  >
                    </div>

                    <br><br>
                    
                    <div style="text-align:center;">
                        <button class="button" type="submit" name="submit"> Update </button>
                    </div>

                   

                 
            </form>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>
</body>

</html>