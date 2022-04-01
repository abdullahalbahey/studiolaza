<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">

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
        <div class="sidenavigation" style="margin-top:51px">
            <?php include 'includes/customersidenav.php' ?>
        </div>
        <div class="" style="display:flex; width:85%; justify-content: center;">

            <div class="content" style="display:flexbox; ">
                <br>
                <h3 style="text-align:center">BOOKING DETAILS</h3>


                <div style="display:flex ; flex-direction: column;">
                    <label for="weddingdate"><strong>Date: </strong> </label>
                    <input readonly type="date" id="weddingdate" name="weddingdate" style="width:50% ; height:30px" value="<?php echo $data['weddingdetails'][0]->datew; ?>">
                    <br>
                    <label><strong>Time: </strong> </label>
                    <input readonly type="time" id="" style="width: 50%; height:30px" value="<?php echo $data['weddingdetails'][0]->timew; ?>">
                    <br>
                    <label for="text"><strong>Venue: </strong> </label>
                    <input readonly type="text" style="width: 50% ; height:30px" value="<?php echo $data['weddingdetails'][0]->venuew; ?>"> <!-- Search Query for venue location using google-->
                </div>
                <div style="display:flex ; flex-direction: row;justify-content: center;">
                    <form action="<?php echo URLROOT; ?>/customerbooking/view_details_wedding" method="POST">
                        <input type="textbox" hidden name="id" value="<?php echo $data['weddingdetails'][0]->booking_id; ?>">
                        <button type="submit" name="view_detailsw">View details</button>

                    </form>
                </div>
                <!-- PRESHOOT DETAILS-->

                <?php if (!empty($data['weddingdetails'])) { ?>

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
                        <form action="<?php echo URLROOT; ?>/managerbookings/view_details_preshoot" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id; ?>">
                            <button type="submit" name="view_detailsp">View Preshoot Details</button>
                        </form>
                    </div>
                    <div style="display:flex ; flex-direction: column;">

                    <?php $date = date('Y-m-d');
                            if (date('Y-m-d', strtotime($data['weddingdetails'][0]->datew . ' + 2 days')) <= $date || $data['weddingdetails'][0]->progress >= 2) {
                                echo "";
                            } else { ?>
                                <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                    <input type="textbox" hidden name="id" value="<?php echo $data['weddingdetails'][0]->booking_id; ?>">
                                    <input type="hidden" name="type" value="wedding">
                                    <td colspan="2" style="text-align:right">
                                        <button type="submit" name="update">Update</button>
                                </form>
                            <?php }
                            if (date('Y-m-d', strtotime($_SESSION['cancel_date'] . ' + 2 days')) <= $date) {
                                echo "";
                            } else { ?>
                            <div style="display:flex ; flex-direction: row;justify-content: center;">
                                <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                    <input type="textbox" hidden name="id" value="<?php echo $data['weddingdetails'][0]->booking_id; ?>">
                                    <input type="hidden" name="type" value="wedding">
                                    <button type="submit" name="cancel">Cancel</button>
                                    </td>
                                </form>
                            </div>
                            <?php } ?>
                    </div>
                <?php } ?>




                <!-- PRESHOOT DETAILS-->




                <!--Preshoot-->
                <?php if (!empty($data['preshootdetails'])) { ?>
                    <div class="bookingPreshoot brownbox">

                        <table class="emptyTable">
                            <tr>
                                <h4 style="text-align:left; margin-left: 20px">Preshoot </h4>
                                <td>
                                    <label for="weddingdate"><strong>Date: </strong> </label>
                                    <input readonly type="date" id="weddingdate" name="weddingdate" style="width:50% ; height:30px" value="<?php echo $data['preshootdetails'][0]->dateh; ?>">
                                </td>
                                <td>
                                    <label><strong>Time: </strong> </label>
                                    <input readonly type="time" id="" style="width: 50%; height:30px" value="<?php echo $data['preshootdetails'][0]->timeh; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="text"><strong>Venue: </strong> </label>
                                    <input readonly type="text" style="width: 50% ; height:30px" value="<?php echo $data['preshootdetails'][0]->venueh; ?>"> <!-- Search Query for venue location using google-->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-left:40%;">
                                    <form action="<?php echo URLROOT; ?>/customerbooking/view_details_preshoot" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id; ?>">
                                        <button type="submit" name="view_detailsp">View details</button>

                                    </form>
                                </td>
                            <tr>
                                <?php $date = date('Y-m-d');
                                if (date('Y-m-d', strtotime($data['preshootdetails'][0]->dateh . ' + 2 days')) <= $date || $data['preshootdetails'][0]->progress >= 2) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="preshoot">
                                        <td colspan="2" style="text-align:right">
                                            <button type="submit" name="update">Update</button>
                                    </form>
                                <?php }
                                if (date('Y-m-d', strtotime($_SESSION['cancel_date'] . ' + 2 days')) <= $date) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['preshootdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="preshoot">
                                        <button type="submit" name="cancel">Cancel</button>
                                        </td>
                                    </form>

                                <?php } ?>
                            </tr>

                        </table>

                    </div>
                <?php } ?>

                <!--Engagement-->
                <?php if (!empty($data['engagementdetails'])) { ?>
                    <div class="bookingPreshoot brownbox">

                        <table class="emptyTable">
                            <tr>
                                <h4 style="text-align:left; margin-left: 20px">Engagement </h4>
                                <td>
                                    <label for="weddingdate"><strong>Date: </strong> </label>
                                    <input readonly type="date" class="red" name="eng_date" style="width: 50%" id="eng_date" value="<?php echo $data['engagementdetails'][0]->datee; ?>">
                                </td>
                                <td>
                                    <label><strong>Time: </strong> </label>
                                    <input readonly type="time" class="red" name="eng_time" style="width: 50%" id="eng_time" value="<?php echo $data['engagementdetails'][0]->timee; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="text"><strong>Venue: </strong> </label>
                                    <input readonly type="text" class="red" name="eng_venue" style="width: 50%" id="eng_venue" value="<?php echo $data['engagementdetails'][0]->venuee; ?>"><!-- Search Query for venue location using google-->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-left:40%;">
                                    <form action="<?php echo URLROOT; ?>/customerbooking/view_details_engagement" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['engagementdetails'][0]->booking_id; ?>">
                                        <button type="submit" name="view_detailse">View details</button>

                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <?php $date = date('Y-m-d');
                                if (date('Y-m-d', strtotime($data['engagementdetails'][0]->datee . ' + 2 days')) <= $date || $data['engagementdetails'][0]->progress >= 2) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['engagementdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="engagement">
                                        <td colspan="2" style="text-align:right">
                                            <button type="submit" name="update">Update</button>
                                    </form>
                                <?php }
                                if (date('Y-m-d', strtotime($_SESSION['cancel_date'] . ' + 2 days')) <= $date) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['engagementdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="engagement">
                                        <button type="submit" name="cancel">Cancel</button>
                                        </td>
                                    </form>

                                <?php } ?>
                            </tr>

                        </table>

                    </div>
                <?php } ?>


                <!--Homecoming-->
                <?php if (!empty($data['homecomingdetails'])) { ?>
                    <div class="bookingPreshoot brownbox">

                        <table class="emptyTable">
                            <tr>
                                <h4 style="text-align:left; margin-left: 20px">Homecoming </h4>
                                <td>
                                    <label for="weddingdate"><strong>Date: </strong> </label>
                                    <input readonly type="date" class="red" name="HCmng_date" style="width: 50%" id="HCmng_date" value="<?php echo $data['homecomingdetails'][0]->datew; ?>">
                                </td>
                                <td>
                                    <label><strong>Time: </strong> </label>
                                    <input readonly type="time" class="red" name="HCmng_time" style="width: 50%" id="HCmng_time" value="<?php echo $data['homecomingdetails'][0]->timew; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="text"><strong>Venue: </strong> </label>
                                    <input readonly type="text" class="red" name="HCmng_venue" style="width: 50%" id="HCmng_venue" value="<?php echo $data['homecomingdetails'][0]->venuew; ?>"><!-- Search Query for venue location using google-->
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-left:40%;">
                                    <form action="<?php echo URLROOT; ?>/customerbooking/view_details_homecoming" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['homecomingdetails'][0]->booking_id; ?>">
                                        <button type="submit" name="view_detailsh">View details</button>

                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <?php $date = date('Y-m-d');
                                if (date('Y-m-d', strtotime($data['homecomingdetails'][0]->datew . ' + 2 days')) <= $date || $data['homecomingdetails'][0]->progress >= 2) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['homecomingdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="homecoming">
                                        <td colspan="2" style="text-align:right">
                                            <button type="submit" name="update">Update</button>
                                    </form>
                                <?php }
                                if (date('Y-m-d', strtotime($_SESSION['cancel_date'] . ' + 2 days')) <= $date) {
                                    echo "";
                                } else { ?>
                                    <form action="<?php echo URLROOT; ?>/reschedule" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['homecomingdetails'][0]->booking_id; ?>">
                                        <input type="hidden" name="type" value="homecoming">
                                        <button type="submit" name="cancel">Cancel</button>
                                        </td>
                                    </form>

                                <?php } ?>
                            </tr>

                        </table>

                    </div>
                <?php } ?>

            </div>

            <div class="row browbox" style="text-align:left;">

                <div class="column_2 brownbox" style="padding:0 20px 20px 20px">
                    <h3 style="text-align:left">
                        Payment Details
                    </h3>
                    <label width="width: 200px; display: inline-block;" for="budget"><strong>Total Amount: </strong> </label>
                    LKR: <input readonly type="number" id="budget" name="budget" style="width:40% ; height:30px" value="<?php echo $data['booking_data'][0]->price ?>">
                    <br>
                    <label width="width: 200px; display: inline-block;" for="budget"><strong>Amount paid: </strong> </label>
                    LKR: <input readonly type="number" id="budget" name="budget" style="width:40% ; height:30px" value="<?php echo $data['booking_data'][0]->balance ?>">
                    <br>
                </div>

            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>