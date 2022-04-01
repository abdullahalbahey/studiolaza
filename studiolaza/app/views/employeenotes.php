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
            <h3><a href="<?php echo URLROOT;?>/employeebooking/bookingdetails" style="text-decoration:none">Back</a></h3><br>

            <form class="" action="<?php  echo URLROOT; ?>/employeenotes/add" method="post" style="text-align:center;" >
                
                    <label><b>Note:</b></label> <br><br>
                    <textarea  name="note" style="width:30%;height:150px"> </textarea> <br>
                    <span class="errormessage">
                        <?php echo $data['noteerror'];?>
                    </span>
                    <br><br>
                
                        <button class="button" type="submit" name="add"> Add </button>
                
            </form>

            <table class="red_table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th width="30%">Content</th>
                            <th>Update</th>
                            <th>Delete</th>
                                   
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                                if(!empty($data['notedetails'])){
                                $x=count($data["notedetails"]);
                                for($i=0;$i<$x;$i++){
                
                        ?>                            
                            <tr>
                                <td><?php echo $data['notedetails'][$i]->date ; ?></td>
                                <td><?php echo $data['notedetails'][$i]->time ; ?></td>
                                <td><?php echo $data['notedetails'][$i]->content ; ?></td>
                                <form action="<?php echo URLROOT; ?>/employeenotes/change" method="POST">
                                    <input type="textbox" hidden name="id" value="<?php echo $data['notedetails'][$i]->note_id ; ?>">
                                    <td><button type="submit" name="update">Update</button></a></td>
                                    <td><button type="submit" name="delete">Delete</button></a></td>
                                </form>
                            
                            <?php 
                            }  
                        }                        
                            ?>
            
                    </tbody>
            <table>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>