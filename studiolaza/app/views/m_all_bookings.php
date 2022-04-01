<html>

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

</html>

<body>


    <div class="progressTracker">
        <table class="red_table tracker_table">
            <tr>
                <th>Confirmed</th>
                <th>Engagement Shoot</th>
                <th>Preshoot</th>
                <th>Wedding Shoot</th>
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
                <form action="">
                    <td><input type="checkbox" name="confirm"> </td>
                    <td><input type="checkbox" name="engagementDone"> </td>
                    <td><input type="checkbox" name="preshootDone"> </td>
                    <td><input type="checkbox" name="wedshootDone"> </td>
                    <td><input type="checkbox" name="backupDone"> </td>
                    <td><input type="checkbox" name="sampleSent"> </td>
                    <td><input type="checkbox" name="chosenPhoto"> </td>
                    <td><input type="checkbox" name="albumCreation"> </td>
                    <td><input type="checkbox" name="albumSampleSent"> </td>
                    <td><input type="checkbox" name="layoutConfirm"> </td>
                    <td><input type="checkbox" name="senttoPrint"> </td>
                    <td><input type="checkbox" name="delivered"> </td>
                </form>
            </tr>

        </table>
    </div>
    <!--End of ProgressTracker-->
    <div class="bookingDetails">
        <h1>Booking Details - #1</h1>
        <div class="bookingScrollBar">

        </div>

        <div class="row brownbox" style="padding:10px 20px">
            <!--Starting with all the booking details-->
            <div class="bookingDetails" style="text-align:center">

                <div class="bookingCustomerDetails bookingPreshoot brownbox">
                    <h3 style="text-align:left">Customer Details</h3>

                    <table class="emptyTable">
                        <tr>
                            <td>
                                <label for="customerName"><strong>Name: </strong> </label>
                                <input readonly type="text" style="width:50% ; height:30px;" id="customerName" name="customerName" value="Rahul" placeholder=""> <!-- Value -> SELECT query for Customer Name-->
                            </td>
                            <td>
                                <label for="customerPhone"><strong>Phone: </strong> </label>
                                <input readonly type="number" style="width:50% ; height:30px" id="customerPhone" name="customerPhone" value="0779897506" placeholder=""> <!-- Value -> SELECT query for Customer Phone-->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="customeremail"><strong>Email: </strong> </label>
                                <input readonly type="email" style="width:50% ; height:30px" id="customeremail" name="customeremail" value="sharleneferreira@gmail.com" placeholder=""> <!-- Value -> SELECT query for Customer Email-->
                            </td>
                            <td>
                                <label for="customerAddress"><strong>Address: </strong> </label>
                                <input readonly type="email" style="width:50% ; height:30px" id="customerAddress" name="customerAddress" value="328/C, Hanifa Road, Kalmunai" placeholder=""> <!-- Value -> SELECT query for Customer Address-->
                            </td>
                        </tr>
                        <br>

                    </table>
                </div>
                <hr style="height:3px; background-color: #890000;">

                <!--Preshoot-->
                <div class="bookingPreshoot brownbox">

            
                    <table class="emptyTable">
                        <tr>
                            <h4 style="text-align:left; margin-left: 20px">Wedding </h4>
                            <td>
                                <label for="weddingdate"><strong>Date: </strong> </label>
                                <input readonly type="date" id="weddingdate" name="weddingdate" style="width:50% ; height:30px" value="<?php echo $data['weddingdetails'][0]->datew ; ?>">
                            </td>
                            <td>
                                <label><strong>Time: </strong> </label>
                                <input readonly type="time" id="" style="width: 50%; height:30px" value="<?php echo $data['weddingdetails'][0]->timew ; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="text"><strong>Venue: </strong> </label>
                                <input readonly type="text" style="width: 50% ; height:30px" value="<?php echo $data['weddingdetails'][0]->venuew ; ?>"> <!-- Search Query for venue location using google-->
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:40%;">
                                <form action="<?php echo URLROOT; ?>/customerbooking/view_details_wedding" method="POST">
                                     <input type="textbox" hidden name="id" value="<?php echo $data['weddingdetails'][0]->booking_id ; ?>">
                                     <button type="submit" name="view_detailsw">View details</button>

                                </form>
                            </td>
                        </tr>
                        
                    </table>
            
                </div>
                
        

                <!--Preshoot-->
                <?php if(!empty($data['preshootdetails'])) { ?>
                <div class="bookingPreshoot brownbox">
            
                    <table class="emptyTable">
                        <tr>
                            <h4 style="text-align:left; margin-left: 20px">Preshoot </h4>
                            <td>
                                <label for="weddingdate"><strong>Date: </strong> </label>
                                <input readonly type="date" id="weddingdate" name="weddingdate" style="width:50% ; height:30px" value="<?php echo $data['preshootdetails'][0]->dateh ; ?>">
                            </td>
                            <td>
                                <label><strong>Time: </strong> </label>
                                <input readonly type="time" id="" style="width: 50%; height:30px" 
                    value="<?php echo $data['preshootdetails'][0]->timeh ; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="text"><strong>Venue: </strong> </label>
                                <input readonly type="text" style="width: 50% ; height:30px" 
                    value="<?php echo $data['preshootdetails'][0]->venueh ; ?>"> <!-- Search Query for venue location using google-->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:40%;">
                                <form action="<?php echo URLROOT; ?>/customerbooking/view_details_preshoot" method="POST">
                                     <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id ; ?>">
                                     <button type="submit" name="view_detailsp">View details</button>

                                </form>
                            </td>
                        </tr>
                            
                   
                    </table>
            
                </div>
                <?php }?>            

                <!--Engagement-->
                <?php if(!empty($data['engagementdetails'])) { ?>
                <div class="bookingPreshoot brownbox">
            
                    <table class="emptyTable">
                        <tr>
                            <h4 style="text-align:left; margin-left: 20px">Engagement </h4>
                            <td>
                                <label for="weddingdate"><strong>Date: </strong> </label>
                                <input readonly type="date" class="red" name="eng_date" style="width: 50%" id="eng_date" value="<?php echo $data['engagementdetails'][0]->datee ; ?>">
                            </td>
                            <td>
                                <label><strong>Time: </strong> </label>
                                <input readonly type="time" class="red" name="eng_time" style="width: 50%" id="eng_time" value="<?php echo $data['engagementdetails'][0]->timee ; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="text"><strong>Venue: </strong> </label>
                                <input readonly type="text" class="red" name="eng_venue" style="width: 50%" id="eng_venue" value="<?php echo $data['engagementdetails'][0]->venuee ; ?>"><!-- Search Query for venue location using google-->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:40%;">
                                <form action="<?php echo URLROOT; ?>/customerbooking/view_details_engagement" method="POST">
                                     <input type="textbox" hidden name="id" value="<?php echo $data['engagementdetails'][0]->booking_id ; ?>">
                                     <button type="submit" name="view_detailse">View details</button>

                                </form>
                            </td>
                        </tr>
                        
                      
                    </table>
            
                </div>
                <?php } ?>


                <!--Homecoming-->
                <?php if(!empty($data['homecomingdetails'])) { ?>
                <div class="bookingPreshoot brownbox">
            
                    <table class="emptyTable">
                        <tr>
                            <h4 style="text-align:left; margin-left: 20px">Homecoming </h4>
                            <td>
                                <label for="weddingdate"><strong>Date: </strong> </label>
                                <input readonly type="date" class="red" name="HCmng_date" style="width: 50%" id="HCmng_date" value="<?php echo $data['homecomingdetails'][0]->datew ; ?>">
                            </td>
                            <td>
                                <label><strong>Time: </strong> </label>
                                <input readonly type="time" class="red" name="HCmng_time" style="width: 50%" id="HCmng_time" value="<?php echo $data['homecomingdetails'][0]->timew ; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="text"><strong>Venue: </strong> </label>
                                <input readonly type="text" class="red" name="HCmng_venue" style="width: 50%" id="HCmng_venue" value="<?php echo $data['homecomingdetails'][0]->venuew ; ?>"><!-- Search Query for venue location using google-->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:40%;">
                                <form action="<?php echo URLROOT; ?>/customerbooking/view_details_homecoming" method="POST">
                                     <input type="textbox" hidden name="id" value="<?php echo $data['homecomingdetails'][0]->booking_id ; ?>">
                                     <button type="submit" name="view_detailsh">View details</button>

                                </form>
                            </td>
                        </tr>
                        
                        
                    </table>
            
                </div>
                <?php }?>

                


                <!--St of Employee Details-->
                <div class="bookingEmpDetails brownbox">
                    <h3 style="text-align:left">Employee Details</h3>

                    <div>
                        <label>Photographer 1: </label>
                        <select name="photographer1" id="photographer1">
                            <option value="sahan">Sahan</option>
                            <option value="kumana">Kumana</option>
                            <option value="apil">Apil</option>
                            <option value="maleesh">Maleesh</option>
                        </select>

                        <label>Photographer 2: </label>
                        <select name="photographer2" id="photographer2">
                            <option value="kumana">Kumana</option>
                            <option value="sahan">Sahan</option>
                            <option value="apil">Apil</option>
                            <option value="maleesh">Maleesh</option>
                        </select>
                        <br>
                        <label>Assistant: </label>
                        <select name="assistant" id="assistant">
                            <option value="kumana">Kumana</option>
                            <option value="sahan">Sahan</option>
                            <option value="apil">Apil</option>
                            <option value="maleesh">Maleesh</option>
                        </select>
                        <label>Editor: </label>
                        <select name="editor" id="editor">
                            <option value="kumana">Kumana</option>
                            <option value="sahan">Sahan</option>
                            <option value="apil">Apil</option>
                            <option value="maleesh">Maleesh</option>
                        </select>
                    </div>


                </div>
                <!--End of Employee Details-->


            </div>
            <!--End of bookingEngagement-->

            <br>
            <!--End of bookingPreshoot-->
            <div class="row browbox" style="text-align:left;">

                <div class="column_2 brownbox" style="padding:0 20px 20px 20px">
                    <h3 style="text-align:left">
                        Payment Details
                    </h3>
                    <label width="width: 200px; display: inline-block;" for="budget"><strong>Total Amount: </strong> </label>
                    LKR: <input readonly type="number" id="budget" name="budget" style="width:40% ; height:30px" value="200000">
                    <br>
                    <label width="width: 200px; display: inline-block;" for="budget"><strong>Amount Paid: </strong> </label>
                    LKR: <input readonly type="number" id="budget" name="budget" style="width:40% ; height:30px" value="80000">
                    <br>
                    <label width="width: 200px; display: inline-block;" for="budget"><strong>Amount Paid: </strong> </label>
                    LKR: <input readonly type="number" id="budget" name="budget" style="width:40% ; height:30px" value="120000">

                </div>
                <div class="column_2" style="text-align:center">
                    <form action="">
                        <div class="button-allign">
                            <input type="button" class="button agreementEmail" value="Send Agreement Email" onClick="alert('Agreement email Sent!');">
                            <input type="button" class="button 80PEmail" value="Send 80% Payment Email" onClick="alert('80% Payment Email Sent!');">
                        </div>
                    </form>
                </div>
            </div>
            <!--End of bookingFinance-->
            <div class="button-allign">
                <input type="button" class="button agreementEmail" value="Update" onClick="alert('Update Booking');">
                <input type="button" class="button 80PEmail" value="Delete" onClick="alert('Delete Booking');">
            </div>
        </div>
    </div>

</body>