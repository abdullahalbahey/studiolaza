<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .column_2 {
            width: 49%;
            float: left;
            border: 1px solid #890000;
            border-radius: 10px;
            text-align: center;
        }

        .sidenav {
            height: 100%;

        }

        .signupFrm {
            display: flex;

            justify-content: center;
            border-radius: 2%;
            width: 35%;
            margin: 6% auto;
            background-color: white;
            align-items: center;
            flex-direction: column;
            border: 2.5px solid #dadce0;
            /* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.09);
    
    height: 80%; */
        }

        .twoCLMIMG {
            margin: 30px;
        }
    </style>
</head>

</html>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation" style="margin-top:50px; min-height:100%">
            <?php include 'includes/managersidenav.php' ?>
        </div>




        <div class="mainCLM" style="display:flex; flex-direction:row; margin-top:70px">
            <div class="twoCLMIMG">
                <h2 style="text-align:left;">Tentative Booking Calendar</h2>

                <table class="table table-bordered red_table">
                    <tr>
                        <th> Order ID </th>
                        <th> Date </th>
                        <th> Customer Name </th>

                    </tr>
                    <?php
                    if (!empty($data['tentativedetails'])) {
                        $x = count($data['tentativedetails']);
                        for ($i = 0; $i < $x; $i++) {
                    ?>

                            <td>
                                <?php echo $data['tentativedetails'][$i]->booking_id; ?>
                            </td>
                            <td>
                                <?php echo $data['tentativedetails'][$i]->booking_date; ?>
                            </td>
                            <td>
                                <?php echo $data['tentativedetails'][$i]->name; ?>
                            </td>

                            </tr>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5">No Tentative Booking records</td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>

            <!-- Second Box -->

            <div class="twoCLMIMG">
                <h2 style="text-align:left">Confirmed Booking Calendar</h2>

                <table class="table table-bordered red_table">
                    <tr>
                        <th> Order ID </th>
                        <th> Date </th>
                        <th> Customer Name </th>

                    </tr>
                    <?php
                    if (!empty($data['confirmeddetails'])) {
                        $x = count($data['confirmeddetails']);
                        for ($i = 0; $i < $x; $i++) {
                    ?>

                            <td>
                                <?php echo $data['confirmeddetails'][$i]->booking_id; ?>
                            </td>
                            <td>
                                <?php echo $data['confirmeddetails'][$i]->booking_date; ?>
                            </td>
                            <td>
                                <?php echo $data['confirmeddetails'][$i]->name; ?>
                            </td>

                            </tr>
                        <?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5">No Tentative Booking records</td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>







        </div>
</body>