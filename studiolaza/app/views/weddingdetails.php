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
<script>
    function checkbox1() {
                document.getElementById('option2').value="";
    }
    function checkbox2() {
                document.getElementById('option2').value="";
    }
    function checkbox3() {
                document.getElementById('option1').value="";
    }
    function checkbox4() {
                document.getElementById('option1').value="";
    }
</script>
<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">
            <?php
                include 'includes/customersidenav.php';
            ?>

        </div>
        <div class="content brownbox">
        <div class="progressTracker">
        <table class="red_table tracker_table">
            <tr>
                <th>Confirmed</th>
                <th>Shoot</th>
                <th>BackUp Photos</th>
                <th>Selection Samples Sent</th>
                <th>Photos Choosen</th>
                <th>Album Creation</th>
                <th>Album Sample Sent</th>
                <th>Layout Confirmed</th>
                <th>Sent for Printing</th>
                <th>Delivered</th>
            </tr>
            <tr>
                    <?php if($data['details']!=NULL){
                            $x=$data['details'];
                            for($i=0;$i<=$x;$i++){ 
                    ?>
                    
                        <td><input type="checkbox"  checked disabled > </td>
                    <?php }
                            if($x!=9){
                                for($j=$x+1;$j<10;$j++){
                    ?>
                        <td><input type="checkbox" disabled > </td>
                    <?php
                                }
                            }
                        }else{
                            for($i=0;$i<10;$i++){
                        
                    ?>
                        <td><input type="checkbox" disabled> </td>
                    <?php

                            }
                        }
                           
                        
                    ?>
            </tr>

        </table>
    </div>
            <div class="container brownbox">

                <div class="bookingPackageDetails" style="text-align:left">
                <form action="<?php echo URLROOT ?>/customerbooking/show_update_form" method="post">
                    <?php 
                        if(!empty($data['weddingdetails'])){
                    ?>
                            <h2 style="text-align:center">Wedding Package Details</h2>
                            <input type="hidden" name="wform">
                            <?php 
                                echo $data['weddingdetails'][0]->weddingdetails;
                                if($data['weddingdetails'][0]->thankingcard_detail!=NULL){
                                    echo $data['weddingdetails'][0]->thankingcard_detail;
                                }
                            ?>
                            
                            <input type="checkbox" name="cform" checked hidden id="option1">
                            <input type="checkbox" name="tform" checked hidden id="option2">
                            <?php $date=date('Y-m-d');
                                if($_SESSION['cancel_date'] <= date('Y-m-d', strtotime($date. ' + 2 days'))){ 
                                    echo "";               
                             }else{
                                 if($data['weddingdetails'][0]->costume_id!=NULL){?>
                                <button type="submit" onclick="checkbox1()"> <b>View costume</b> </button>
                            <?php }else{ ?>
                                <button type="submit" onclick="checkbox2()"> <b>Add costume</b> </button>
                            <?php }if($data['weddingdetails'][0]->thankingcard_id!=NULL){?>
                                <button type="submit" onclick="checkbox3()"> <b>View thanking card</b> </button>
                            <?php }else{ ?>
                                <button type="submit" onclick="checkbox4()"> <b>Add thankingcard</b> </button>
                    
                    <?php 
                                }       
                        }
                    }

                        if(!empty($data['preshootdetails'])){?>

                    <h2 style="text-align:center">Preshoot Package Details</h2>
                    <input type="hidden" name="pform" value="<?php echo $data["preshootdetails"][0]->booking_id; ?>">
                    <?php  
                            echo $data['preshootdetails'][0]->preweddingshootdetails;
                        }
                        if(!empty($data['engagementdetails'])){?>
                    <h2 style="text-align:center">Engagement Package Details</h2>
                    <input type="hidden" name="eform" value="<?php echo $data["engagementdetails"][0]->booking_id; ?>">
                    <?php 
                            echo $data['engagementdetails'][0]->engagementdetails;
                        }

                        if(!empty($data['homecomingdetails'])){?>
                    <h2 style="text-align:center">Homecoming Package Details</h2>
                    <input type="hidden" name="hform" value="<?php echo $data["homecomingdetails"][0]->booking_id; ?>">
                        
                    <?php
                        echo $data['homecomingdetails'][0]->homecomingdetails;
                        }
                    ?>
                    <?php $date=date('Y-m-d');
                        if($_SESSION['cancel_date'] <= date('Y-m-d', strtotime($date. ' + 2 days'))){ 
                                    echo "";               
                             }else{?><button type="submit"> <b>Update package details</b> </button><?php } ?>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/fetchbookingdetails'">Close</button>
                </form>
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