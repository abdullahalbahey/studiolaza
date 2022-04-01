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

<body class="">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation"  style="margin-top:51px">
            <?php include 'includes/managersidenav.php' ?>
        </div>
        <div class="content brownbox">
           <table class="red_table">
                <thead>
                    <tr>
                        <th>Tentative Id</th>
                        <th>View details</th>
                        <th>Bill</th>
                        <th>Confirm</th>
                        <th>Decline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($data['tentatives'])){
                            $x=count($data['tentatives']);
                            for($i=0;$i<$x;$i++){
                    ?>
                    <tr>
                        <td><?php echo $data['tentatives'][$i]->booking_id ?></td>
                        <td>
                            <form action="<?php echo URLROOT; ?>/managerbookings/fetchbookingdetails" method="POST">
                                <input type="textbox" hidden name="id" value="<?php echo $data['tentatives'][$i]->booking_id ; ?>">
                                <button type="submit" name="view_details">View details</button>
                            </form>
                        </td>
                        <td><?php echo $data['tentatives'][$i]->price ?></td>
                        <form action="<?php echo URLROOT; ?>/managertentatives/tentative" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['tentatives'][$i]->booking_id ; ?>">
                            <td><button type="submit" name="update">Confirm</button></td>
                            <td><button type="submit" name="delete">Decline</button></td>
                        </form>
                    </tr>
                    <?php
                            }
                        }
                    ?>    
                    
                </tbody>
            </table>
        </div>
    </div>




</body>

</html>