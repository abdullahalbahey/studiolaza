<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

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
        li{
            float:none;
        }
    </style>

</head>
<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox" style="margin-top:52px">
            <?php
                include 'includes/employeesidenav.php';
            ?>

        </div>
        <div class="content brownbox">
        
            <div class="container brownbox">

                <div class="bookingPackageDetails" style="text-align:left">
               
                    <?php 
                        if(!empty($data['weddingdetails'])){
                    ?>
                            <h2 style="text-align:center">Wedding Package Details</h2>
                            
                            <?php 
                                echo $data['weddingdetails'][0]->weddingdetails;
                                if($data['weddingdetails'][0]->thankingcard_detail!=NULL){
                                    echo $data['weddingdetails'][0]->thankingcard_detail;
                                }
                    ?>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/employeebooking/fetchweddingdetails'">Close</button>
                    <?php
                            }
                            
                            

                        if(!empty($data['preshootdetails'])){?>

                    <h2 style="text-align:center">Preshoot Package Details</h2>
                    <?php  
                            echo $data['preshootdetails'][0]->preweddingshootdetails;
                    ?>
                        <button type="button" onclick="location.href='<?php echo URLROOT ?>/employeebooking/fetchpreshootdetails'">Close</button>
                    <?php
                        }
                        if(!empty($data['engagementdetails'])){?>
                    <h2 style="text-align:center">Engagement Package Details</h2>
                    <?php 
                            echo $data['engagementdetails'][0]->engagementdetails;
                    ?>
                        <button type="button" onclick="location.href='<?php echo URLROOT ?>/employeebooking/fetchengagementdetails'">Close</button>
                    <?php
                        }
                        if(!empty($data['homecomingdetails'])){?>
                    <h2 style="text-align:center">Homecoming Package Details</h2>                        
                    <?php
                        echo $data['homecomingdetails'][0]->homecomingdetails;
                        
                    ?>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/employeebooking/fetchhomecomingdetails'">Close</button>
                    <?php
                        }
                    ?>
                    
                    
               
                </div>
                    
                <br>

            </div>

        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>