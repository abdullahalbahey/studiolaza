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

        .submitBtn {
            display: block;
            margin-left: auto;
            padding: 10px 20px;
            border: none;
            background-color: #980000;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            margin-top: 30px;
            width: 100%;
        }

        .submitBtn:hover {
            background-color: #980000;
            transform: translateY(-3px);
        }

        input[type="file"] {
            display: none;
        }

        .labelbox:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }

        li {
            float: none;
        }

        select {
            width: 20%;
            border: 1px solid #890000;
            border-radius: 10px;
            height: 40px;
        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation" style="margin-top:51px">

            <?php
            include 'includes/managersidenav.php';
            ?>

        </div>
        <div class="content brownbox" style="margin-top:51px">
            <div class="container brownbox">

                <div class="bookingPackageDetails" style="text-align:left">

                    <?php
                    if (!empty($data['weddingdetails'])) {
                    ?>
                        <form action="<?php echo URLROOT ?>/Managerbookings/show_update_form" method="post">
                            <h2 style="text-align:center">Wedding Package Details</h2>
                            <input type="hidden" name="wform" value="<?php echo $data["weddingdetails"][0]->wedding_id; ?>">
                            <?php
                            echo $data['weddingdetails'][0]->weddingdetails;
                            ?>

                            <input type="checkbox" name="cform" checked hidden id="option1">
                            <input type="checkbox" name="tform" checked hidden id="option2">

                            <?php if ($data['weddingdetails'][0]->costume_id != NULL) { ?>
                                <button type="submit"> <b>View costume</b> </button>

                            <?php }
                            if ($data['weddingdetails'][0]->thankingcard_id != NULL) { ?>
                                <button type="submit"> <b>View thanking card</b> </button>
                            <?php
                            }
                            ?>
                        </form>
                        <form action="<?php echo URLROOT ?>/Managerbookings/view_details_wedding" method="post">

                        <?php

                    }
                        ?>

                        <?php

                        if (!empty($data['preshootdetails'])) { ?>
                            <form action="<?php echo URLROOT ?>/Managerbookings/view_details_preshoot" method="post">
                                <h2 style="text-align:center">Preshoot Package Details</h2>
                                <input type="hidden" name="pform" value="<?php echo $data["preshootdetails"][0]->preweddingshoot_id; ?>">
                            <?php
                            echo $data['preshootdetails'][0]->preweddingshootdetails;
                        }
                        if (!empty($data['engagementdetails'])) { ?>
                                <form action="<?php echo URLROOT ?>/Managerbookings/view_details_engagement" method="post">
                                    <h2 style="text-align:center">Engagement Package Details</h2>
                                    <input type="hidden" name="eform" value="<?php echo $data["engagementdetails"][0]->engagement_id; ?>">
                                <?php
                                echo $data['engagementdetails'][0]->engagementdetails;
                            }

                            if (!empty($data['homecomingdetails'])) { ?>
                                    <form action="<?php echo URLROOT ?>/Managerbookings/view_details_homecoming" method="post">
                                        <h2 style="text-align:center">Homecoming Package Details</h2>
                                        <input type="hidden" name="hform" value="<?php echo $data["homecomingdetails"][0]->homecoming_id; ?>">

                                    <?php
                                    echo $data['homecomingdetails'][0]->homecomingdetails;
                                }
                                    ?>

                                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/managerbookings/fetchbookingdetails'">Close</button>

                </div>

                <br>

            </div>





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
                        <th>Update</th>
                    </tr>
                    <tr>

                        <?php if ($data['details'] != NULL) {
                            $x = $data['details'];
                            for ($i = 0; $i <= $x; $i++) {
                        ?>

                                <td><input type="checkbox" checked disabled> </td>
                                <?php }
                            if ($x != 9) {
                                for ($j = $x + 1; $j < 10; $j++) {
                                ?>
                                    <td><input type="checkbox" name="progress" value="<?php echo $j ?>"> </td>
                                <?php
                                }
                            }
                        } else {
                            for ($i = 0; $i < 10; $i++) {

                                ?>
                                <td><input type="checkbox" name="progress" value="<?php echo $i ?>"> </td>
                        <?php

                            }
                        }


                        ?>
                        <td><input type="submit" class="submitBtn" name="submit" value="Update"></td>

                    </tr>

                </table>
            </div>
            <!--St of Employee Details-->
            <div class="bookingEmpDetails brownbox">
                <h3 style="text-align:left">Employee Details</h3>
                <p>Photographer:<?php if (!empty($data['photographer'])) {
                                    echo $data['photographer'][0]->name;
                                } ?></p><br>
                <p>Photographer Charges:<?php if ($data['photographer_charges'] != NULL) {
                                            echo $data['photographer_charges'];
                                        } ?></p><br>
                <p>Editor:<?php if (!empty($data['editor'])) {
                                echo $data['editor'][0]->name;
                            } ?></p>
                <p>Editor Charges:<?php if ($data['editor_charges'] != NULL) {
                                        echo $data['editor_charges'];
                                    } ?></p><br>
                <div>
                    <label>Photographer: </label>
                    <select name="photographer" id="photographer1">
                        <?php if (!empty($data['empdetails'])) {
                            $x = count($data['empdetails']);
                            for ($i = 0; $i < $x; $i++) {
                                if ($data['empdetails'][$i]->roles == 'Photographer,Editor' || $data['empdetails'][$i]->roles == 'Photographer') {
                        ?>
                                    <option value="<?php echo $data['empdetails'][$i]->employee_id ?>"><?php echo $data['empdetails'][$i]->name ?></option>
                        <?php       }
                            }
                        }
                        ?>
                    </select><br>
                    <label>Photographer charges: </label>
                    <input type="number" name="p_charges">
                    <br>
                    <label>Editor: </label>
                    <select name="editor" id="editor">
                        <?php if (!empty($data['empdetails'])) {
                            $x = count($data['empdetails']);
                            for ($i = 0; $i < $x; $i++) {
                                if ($data['empdetails'][$i]->roles == 'Photographer,Editor' || $data['empdetails'][$i]->roles == 'Editor') {
                        ?>
                                    <option value="<?php echo $data['empdetails'][$i]->employee_id ?>"><?php echo $data['empdetails'][$i]->name ?></option>
                        <?php       }
                            }
                        }
                        ?>
                    </select><br>
                    <label>Editor charges: </label>
                    <input type="number" name="e_charges">
                </div>

                <button type="submit" name="update_employee">Update</button>
                </form>

            </div>
            <!--End of Employee Details-->



        </div>
    </div>




</body>

</html>