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

        input[type="date"] {
            height: auto;
            width: auto;
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

        .errormessage {
            float: right;
            margin: 10px 10px 0 0;
            color: #980000;

        }

        .submitBtn:hover {
            background-color: #f1f1f1;
            border: 2px solid #890000;
            color: #890000;
            transform: translateY(-3px);

        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="content" >
            <p class="h2report " style="text-align:center; margin-top:100px">
            <form action="<?php echo URLROOT ?>/adminlog/view_logs" style="text-align: center;" method="post">
                <b>FROM:</b> <input type="date" id="fromDateReport" name="date1" style="height: 40px; margin-right: 60px;">

                <b>TO: </b><input type="date" id="toDateReport" name="date2" style="height: 40px;"><br><br>
                <div class="" style="text-align:center">
                    <button type="submit" class="submitBtn" name="submit"> Go </button>
                </div>

            </form>


            <div class="indexReview">
            <?php
            if (!empty($data['details'])) {
                $x = count($data['details']);
                $y = $x - $data['count'][0]->abc;
            ?>
                    
                    <div class="singlereviewbox brownbox">
                        <div class="reviewerName">
                        <h2> <?php echo $data['count'][0]->abc; ?> </h2>
                        <p>No. of customers logged in the time period</p><br>
                    </div>
                </div>

                <div class="singlereviewbox brownbox">
                        <div class="reviewerName">        
                        <h2> <?php echo $y; ?> </h2>
                        <p>No. of other users </p>
                    </div>
                </div>
                
            </div>

                <table class="red_table">
                    <thead>
                        <tr>
                            <th>LoginId</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < $x; $i++) {
                        ?>

                            <tr>
                                <td><?php echo $data['details'][$i]->login_id; ?></td>
                                <td><?php echo $data['details'][$i]->username; ?></td>
                                <td><?php echo $data['details'][$i]->type; ?></td>
                                <td><?php echo $data['details'][$i]->date; ?></td>
                                <td><?php echo $data['details'][$i]->time; ?></td>
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