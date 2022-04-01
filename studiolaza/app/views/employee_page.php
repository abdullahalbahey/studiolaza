<?php

if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/forms.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation" style="margin-top:51px">
            <?php include 'includes/employeesidenav.php' ?>
        </div>


        <div class="" style="display:flex; width:85%; justify-content: center;">
            <div class="content" style="display:flexbox; ">
                <br><br>
                <h1 style="text-align:center; ">Booking Details</h1>

                <h3 style="text-align:center;">Customer Details and Wedding Detials </h3>
                <div style="display:flex ; flex-direction: row;">
                    <div style="display:flex ; flex-direction: column;">
                        <label for="username"><b>Name</b></label>
                        <input readonly class="input" type="text" id="customerName" name="customerName" value="<?php echo $data['customer_data'][0]->name; ?>" placeholder=""> <!-- Value -> SELECT query for Customer Name-->
                        <br>
                        <label for="email"><b>Phone</b></label>
                        <input readonly class="input" type="number" id="customerPhone" name="customerPhone" value="<?php echo $data['customer_data'][0]->contact; ?>" placeholder=""> <!-- Value -> SELECT query for Customer Phone-->
                        <br>
                        <label for="email"><b>Address</b></label>
                        <input readonly class="input" type="email" id="customerAddress" name="customerAddress" value="<?php echo $data['customer_data'][0]->line1 . $data['customer_data'][0]->city; ?>" placeholder=""> <!-- Value -> SELECT query for Customer Address-->
                    </div>
                    <hr>

                    <!-- -------------------    Wedding Details    ------------------------>

                    <div style="display:flex ; flex-direction: column;">
                        <label for="username"><b>Date</b></label>
                        <input readonly type="date" id="weddingdate" name="weddingdate" value="<?php echo $data['weddingdetails'][0]->datew; ?>">
                        <br>
                        <label for="email"><b>Time</b></label>
                        <input readonly type="time" id="" value="<?php echo $data['weddingdetails'][0]->timew; ?>">
                        <br>
                        <label for="email"><b>Venue</b></label>
                        <input readonly type="text" value="<?php echo $data['weddingdetails'][0]->venuew; ?>"> <!-- Search Query for venue location using google-->
                    </div>
                </div>

                <div style="display:flex ; flex-direction: row;justify-content: center;">
                    <form action="<?php echo URLROOT; ?>/employeebooking/view_details_wedding" method="POST">
                        <input type="textbox" hidden name="id" value="<?php echo $data['weddingdetails'][0]->booking_id; ?>">
                        <button class="submitBtn" type="submit" name="view_detailsw">View Wedding Details</button>
                    </form>
                </div>
                <br><br>
                <!-- -------------------    Preshoot    ------------------------>

                <?php if (!empty($data['preshootdetails'])) { ?>
                    <h3 style="text-align:center;">Preshoot Details</h3>

                    <div style="display:flex ; flex-direction: column;">
                        <label for="weddingdate"><strong>Date: </strong> </label>
                        <input readonly type="date" id="weddingdate" name="weddingdate" value="<?php echo $data['preshootdetails'][0]->dateh; ?>">
                        <br>
                        <label><strong>Time: </strong> </label>
                        <input readonly type="time" id="" style="width: 50%; height:30px" value="<?php echo $data['preshootdetails'][0]->timeh; ?>">
                        <br>
                        <label for="text"><strong>Venue: </strong> </label>
                        <input readonly type="text" style="width: 50% ; height:30px" value="<?php echo $data['preshootdetails'][0]->venueh; ?>"> <!-- Search Query for venue location using google-->
                    </div>
                    <div style="display:flex ; flex-direction: row;justify-content: center;">
                        <form action="<?php echo URLROOT; ?>/employeebooking/view_details_preshoot" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id; ?>">
                            <button type="submit" name="view_detailsp">View Preshoot Details</button>
                        </form>
                    </div>
                <?php } ?>
                <!---------------------    Engagement    ------------------------>

                <?php if (!empty($data['engagementdetails'])) { ?>
                    <h3 style="text-align:center;">Engagement Details</h3>
                    <div style="display:flex ; flex-direction: column;">
                        <label for="weddingdate"><strong>Date: </strong> </label>
                        <input readonly type="date" class="red" name="eng_date" style="width: 50%" id="eng_date" value="<?php echo $data['engagementdetails'][0]->datee; ?>">
                        <br>
                        <label><strong>Time: </strong> </label>
                        <input readonly type="time" class="red" name="eng_time" style="width: 50%" id="eng_time" value="<?php echo $data['engagementdetails'][0]->timee; ?>">
                        <br>
                        <label for="text"><strong>Venue: </strong> </label>
                        <input readonly type="text" class="red" name="eng_venue" style="width: 50%" id="eng_venue" value="<?php echo $data['engagementdetails'][0]->venuee; ?>"><!-- Search Query for venue location using google-->
                    </div>
                    <div style="display:flex ; flex-direction: row;justify-content: center;">
                        <form action="<?php echo URLROOT; ?>/employeebooking/view_details_engagement" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['engagementdetails'][0]->booking_id; ?>">
                            <button type="submit" name="view_detailse">View Engagement Details</button>
                        </form>
                    </div>
                <?php } ?>
                <!---------------------    Homecoming    ------------------------>
                <?php if (!empty($data['engagementdetails'])) { ?>
                    <h3 style="text-align:center;">Homecoming Details</h3>
                    <div style="display:flex ; flex-direction: column;">
                        <label for="weddingdate"><strong>Date: </strong> </label>
                        <input readonly type="date" class="red" name="HCmng_date" style="width: 50%" id="HCmng_date" value="<?php echo $data['homecomingdetails'][0]->datew; ?>">
                        <br>
                        <label><strong>Time: </strong> </label>
                        <input readonly type="time" class="red" name="HCmng_time" style="width: 50%" id="HCmng_time" value="<?php echo $data['homecomingdetails'][0]->timew; ?>">
                        <br>
                        <label for="text"><strong>Venue: </strong> </label>
                        <input readonly type="text" class="red" name="HCmng_venue" style="width: 50%" id="HCmng_venue" value="<?php echo $data['homecomingdetails'][0]->venuew; ?>"><!-- Search Query for venue location using google-->
                    </div>
                    <div style="display:flex ; flex-direction: row;justify-content: center;">
                        <form action="<?php echo URLROOT; ?>/employeebooking/view_details_homecoming" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['homecomingdetails'][0]->booking_id; ?>">
                            <button type="submit" name="view_detailsh">View Homecoming Details</button>
                        </form>
                    </div>
                <?php } ?>


                <!---------------------    End of bookingEngagement    ------------------------>
                
            </div>

        </div>
    </div>
    </div>


</body>

</html>











































