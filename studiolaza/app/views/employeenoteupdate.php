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
                <form class="" action="<?php echo URLROOT; ?>/employeenotes/update" method="post" enctype="multipart/form-data">
                    <label for="username"><b>Note ID</b></label>
                    <input type="text" readonly name="id" id="username" value="<?php echo $data["id"]?>" ><br><br>
                    <div style="text-align:center;">
                    <label for="username"><b>Content</b></label><br>
                    <textarea name="note" id="username" style="width:30%;height:150px"><?php echo $data["content"]?></textarea>
                    <span class="errormessage">
                        <?php echo $data['noteerror'];?>
                    </span>
                    <br><br>
                    
                        <button type="submit" name="update"> Update </button>
                        <button type="button" onclick="location.href='<?php echo URLROOT?>/employeenotes'" > Close </button>
                    </div>
                </form>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>



























<!--<?php 
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>

    <head>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/includes/header.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/includes/navigation.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/reg.css">
    </head>

    <body>
    <?php include 'includes/header.php'; ?>
        <div class="main">
            <?php include 'includes/employeenavigation.php'; ?>
            <div class="displaying-page">
                <form class="" action="<?php echo URLROOT; ?>/employeenotes/update" method="post" enctype="multipart/form-data">
                    <label for="username"><b>Note ID</b></label>
                    <input type="text" id="username" value="<?php echo $data["id"]?>" >

                    <label for="username"><b>Content</b></label>
                    <input type="text" id="username" value="<?php echo $data["content"]?>" >

                    

                    
                    
                    
                    <button type="submit" name="submit"> Update </button>
                    <button type="button" onclick="location.href='<?php echo URLROOT?>/employeenotes'" > Close </button>
                </form>
            </div>
        </div>