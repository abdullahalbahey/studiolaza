
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
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="content brownbox">
            <h1>Thanking card update</h1>
            <form class="" action="<?php echo URLROOT; ?>/admincostume/update" method="post" enctype="multipart/form-data">
                    <label for="username"><b>Thankingcard ID</b></label>
                    <input type="text" id="username" name="id" value="<?php echo $data["id"]?>" >

                    <label for="username"><b>Name</b></label>
                    <input type="text" id="username" name="name" value="<?php echo $data["name"]?>" >
                    <span class="errormessage">
                        <?php 
                        if(!empty($data['error'])){
                            echo $data['error']['nameerror'];
                        }?> 
                    </span><br>

                    <label for="username"><b>Description</b></label><br>
                    <textarea  id="username" name="description" style="width:30%;height:150px"><?php echo $data["description"]?></textarea>
                    <span class="errormessage">
                        <?php 
                        if(!empty($data['error'])){
                            echo $data['error']['descriptionerror'];
                        }?> 
                </span><br>
                    <br><br>
                

                    <div class="labelbox">
                    <label for="profile_pic"><b>Change picture</b></label>
                    <input type="file" id="profile_pic"  name="image" >
                    </div>
                    <br>
                    <span class="errormessage">
                    <?php echo $data["imageerror"];?> 
                    </span><br><br>
                    <br>

                    <div style="text-align:center;">
                        <button type="submit" name="submit"> Update </button>
                        
                        <br><br>
                        <button type="button" onclick="location.href='<?php echo URLROOT?>/adminthankingcard'" > Close </button>
                    </div>
                    
                    
                </form>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>




























<!--
    <head>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/includes/header.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/includes/navigation.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/reg.css">
    </head>

    <body>
    <?php include 'includes/header.php'; ?>
        <div class="main">
            <?php include 'includes/adminnavigation.php'; ?>
            <div class="displaying-page">
                <form class="" action="<?php echo URLROOT; ?>/admincostume/update" method="post" enctype="multipart/form-data">
                    <label for="username"><b>Costume ID</b></label>
                    <input type="text" id="username" value="<?php echo $data["id"]?>" >

                    <label for="username"><b>Name</b></label>
                    <input type="text" id="username" value="<?php echo $data["name"]?>" >

                    <label for="username"><b>Price</b></label>
                    <input type="text" id="username" value="<?php echo $data["price"]?>" >

                    <label for="profile_pic"><b>Change profile picture</b></label>
                    <input type="file" id="profile_pic"  name="image"  >
                    
                    
                    <button type="submit" name="submit"> Update </button>
                    <button type="button" onclick="location.href='<?php echo URLROOT?>/admincostume'" > Close </button>
                </form>
            </div>
        </div>