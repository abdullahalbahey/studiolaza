<?php 
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>
    <?php 
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/portfolio_grid.css">
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
            <div class="grid">

                <form action="<?php echo URLROOT;?>/adminportfolio/delete_pics" method="POST">
                    <?php if(!empty($data['picdetails'])){
                        $x=count($data['picdetails']);
                        for($i=0;$i<$x;$i++){
                    ?>                        
                            <label for="1"><img src="<?php echo URLROOT."/".$data['picdetails'][$i]->image; ?>" width="200px" height="200px"></label>
                            <input type="checkbox" name="id_no[]" id="1" value="<?php echo $data['picdetails'][$i]->image_id;?>">
                            
                
                    <?php }?>
                    <button class="button" type="submit" name="submit"> Delete </button>
                    <?php

                    }?>
                        
                    </form>   
            </div>    
                
    
                <br><br>
                <div style="text-align:center;">
                        
                        
                        
                        <button class="button" type="submit" onclick="location.href='<?php echo URLROOT?>/adminportfolio'"> Close </button>
                        
                </div>
                <form  action="<?php echo URLROOT; ?>/adminportfolio/add_pics" method="post" enctype="multipart/form-data">
                <div class="labelbox">
                    <label for="profile_pic"><b>Add pictures</b></label>
                    <input type="file" id="profile_pic" name="files[]" multiple>
                    <input type="hidden" name="name" value="<?php echo $data['name'];?>">
                    <input type="hidden" name="portfolio_id" value="<?php echo $data['portfolio_id'];?>">
                    
                </div>
                <button class="button" type="submit" name="add"> Add </button>
                    </form>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>    

