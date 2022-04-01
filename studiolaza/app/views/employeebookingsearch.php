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
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">

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
<script type="text/javascript">
            function showHide1() {
                if (document.getElementById('option1').checked) {
                    document.getElementById('hiddenField1').style.display = 'block';
                } else {
                    document.getElementById('hiddenField1').style.display = 'none';
                }
            }
            function showHide2() {
                if (document.getElementById('option2').checked) {
                    document.getElementById('hiddenField2').style.display = 'block';
                } else {
                    document.getElementById('hiddenField2').style.display = 'none';
                }
            }
            function showHide3() {
                if (document.getElementById('option3').checked) {
                    document.getElementById('hiddenField3').style.display = 'block';
                } else {
                    document.getElementById('hiddenField3').style.display = 'none';
                }
            }
            function showHide4() {
                if (document.getElementById('option4').checked) {
                    document.getElementById('hiddenField4').style.display = 'block';
                } else {
                    document.getElementById('hiddenField4').style.display = 'none';
                }
            }
            
 </script>

<body class="brownbox" style="    flex-direction: column;flex-direction: column;
    justify-content: center;">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1" >
        <div class="sidenavigation" style="margin-top:51px">
            <?php include 'includes/employeesidenav.php' ?>
        </div>
        <div class="content form" style="display:flex;justify-content: center;" >
            <div class="checkbox">
                wedding
                <input type="checkbox" id="option1" onclick="showHide1()"> 
            </div>
            <div class="checkbox">
                preshoot
                <input type="checkbox" id="option2" onclick="showHide2()"> 
            </div>
            <div class="checkbox">
                engagement
                <input type="checkbox" id="option3" onclick="showHide3()"> 
            </div>
            <div class="checkbox">
                homecoming
                <input type="checkbox" id="option4" onclick="showHide4()"> 
            </div>
            <div id="hiddenField1" style="display:none">
                <table class="red_table">
                        <thead>
                            <tr>
                                <th>BookingId</th>
                                <th>Event role</th>
                                <th colspan="2">Charges</th>
                                <th>View Details</th>
                                    
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php if(!empty($data['weddingbookings'])){
                                    $a=count($data['weddingbookings']);
                                    for($i=0;$i<$a;$i++){?>
                                
                                <tr>
                                    <td><?php echo $data['weddingbookings'][$i]->booking_id; ?></td>
                                    <td><?php if($data['weddingbookings'][$i]->photographer_id==$data['employee_id'] && $data['weddingbookings'][$i]->editor_id==$data['employee_id']){echo "Photographer/Editor";}else if($data['weddingbookings'][$i]->photographer_id==$data['employee_id']){ echo "Photographer";}else if($data['weddingbookings'][$i]->editor_id==$data['employee_id']){echo "Editor";}?></td>
                                    
                                    <?php if($data['weddingbookings'][$i]->photographer_id==$data['employee_id'] && $data['weddingbookings'][$i]->editor_id==$data['employee_id'])
                                    {echo "<td>Rs. ".$data['weddingbookings'][$i]->p_charges."</td><td>Rs. ".$data['weddingbookings'][$i]->e_charges."</td>";}
                                    else if($data['weddingbookings'][$i]->photographer_id==$data['employee_id'])
                                    { echo "<td colspan='2'>Rs. ".$data['weddingbookings'][$i]->p_charges."</td>";}
                                    else if($data['weddingbookings'][$i]->editor_id==$data['employee_id'])
                                    {echo "<td colspan='2'>Rs. ".$data['weddingbookings'][$i]->e_charges."</td>";}?>  
                                    
                                    <td>
                                        <form action="<?php echo URLROOT; ?>/employeebooking/fetchweddingdetails" method="POST">
                                            <input type="textbox" hidden name="id" value="<?php echo $data['weddingbookings'][$i]->booking_id ; ?>">
                                            <input type="hidden" name="wid" value="<?php echo $data['weddingbookings'][$i]->wedding_id ; ?>">
                                            <button type="submit" name="view_details">View details</button>
                                        </form>
                                    </td>
                            
                                </tr>
                        
                        <?php }}?>
                        </tbody>
                </table>
            </div>

            <div id="hiddenField2" style="display:none">
                <table class="red_table">
                    <thead>
                        <tr>
                            <th>BookingId</th>
                            <th>Event role</th>
                            <th>View Details</th>
                                    
                        </tr>
                    </thead>
                        
                    <tbody>
                        <?php
                            if(!empty($data['preshootbookings'])){
                                    $b=count($data['preshootbookings']);
                                    for($i=0;$i<$b;$i++){?>

                                <tr>
                                    <td><?php echo $data['preshootbookings'][$i]->booking_id; ?></td>
                                    <td><?php if($data['preshootbookings'][$i]->photographer_id==$data['employee_id'] && $data['preshootbookings'][$i]->editor_id==$data['employee_id']){echo "Photographer/Editor";}else if($data['preshootbookings'][$i]->photographer_id==$data['employee_id']){ echo "Photographer";}else if($data['preshootbookings'][$i]->editor_id==$data['employee_id']){echo "Editor";}?></td>
                                    <td>
                                        <form action="<?php echo URLROOT; ?>/employeebooking/fetchpreshootdetails" method="POST">
                                            <input type="textbox" hidden name="id" value="<?php echo $data['preshootbookings'][$i]->booking_id ; ?>">
                                            <input type="hidden" name="pid" value="<?php echo $data['preshootbookings'][$i]->preweddingshoot_id;?>">
                                            <button type="submit" name="view_details">View details</button>
                                        </form>
                                    </td>
                            
                                </tr>
                
                        <?php }}?>
                        </tbody>
                </table>
            </div>

            <div id="hiddenField3" style="display:none">
                <table class="red_table">
                    <thead>
                        <tr>
                            <th>BookingId</th>
                            <th>Event role</th>
                            <th>View Details</th>
                                    
                        </tr>
                    </thead>
                        
                    <tbody>
                        <?php
                        if(!empty($data['engagementbookings'])){
                                $c=count($data['engagementbookings']);
                                for($i=0;$i<$c;$i++){?>

                            <tr>
                                <td><?php echo $data['engagementbookings'][$i]->booking_id; ?></td>
                                <td><?php if($data['engagementbookings'][$i]->photographer_id==$data['employee_id'] && $data['engagementbookings'][$i]->editor_id==$data['employee_id']){echo "Photographer/Editor";}else if($data['engagementbookings'][$i]->photographer_id==$data['employee_id']){ echo "Photographer";}else if($data['engagementbookings'][$i]->editor_id==$data['employee_id']){echo "Editor";}?></td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/employeebooking/fetchengagementdetails" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['engagementbookings'][$i]->booking_id ; ?>">
                                        <input type="hidden" name="eid" value="<?php echo $data['engagementbookings'][$i]->engagement_id; ?>">
                                        <button type="submit" name="view_details">View details</button>
                                    </form>
                                </td>
                        
                            </tr>
                    
                        <?php }}?>
                        </tbody>
                </table>
            </div>

            <div id="hiddenField4" style="display:none">
                <table class="red_table">
                    <thead>
                        <tr>
                            <th>BookingId</th>
                            <th>Event role</th>
                            <th>View Details</th>
                                    
                        </tr>
                    </thead>
                        
                    <tbody>
                        <?php
                        if(!empty($data['homecomingbookings'])){
                                $d=count($data['homecomingbookings']);
                                for($i=0;$i<$d;$i++){?>

                            <tr>
                                <td><?php echo $data['homecomingbookings'][$i]->booking_id; ?></td>
                                <td><?php if($data['homecomingbookings'][$i]->photographer_id==$data['employee_id'] && $data['homecomingbookings'][$i]->editor_id==$data['employee_id']){echo "Photographer/Editor";}else if($data['homecomingbookings'][$i]->photographer_id==$data['employee_id']){ echo "Photographer";}else if($data['homecomingbookings'][$i]->editor_id==$data['employee_id']){echo "Editor";}?></td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/employeebooking/fetchhomecomingdetails" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['homecomingbookings'][$i]->booking_id ; ?>">
                                        <input type="hidden" name="hid" value="<?php echo $data['homecomingbookings'][$i]->homecoming_id?>">
                                        <button type="submit" name="view_details">View details</button>
                                    </form>
                                </td>
                        
                            </tr>
                        <?php }}?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    


</body>

</html>