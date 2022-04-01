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

        .form {
            opacity: 0.9;
            background-color: white;
            width: 60%;
            display: flex;
            border-radius: 8px;
            padding: 20px 40px;
            box-shadow: 0 10px 25px rgba(92, 99, 105, .2);
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
        <div class="content" style="margin-top:51px; display:flex;    align-items: center;">
            <div class="form">
                <?php $x = count($data['numberofbookings']);
                if ($x != 0) {
                    for ($i = 0; $i < $x; $i++) {
                        $a = $i + 1;
                ?>
                        <p STYLE="font-size:2rem"><?php echo "YOU HAVE 0" . $a ." BOOKING"; ?> </p>
                        <form action="<?php echo URLROOT; ?>/customerbooking/fetchbookingdetails" method="POST">
                            <input type="textbox" hidden name="id" value="<?php echo $data['numberofbookings'][$i]->booking_id; ?>">
                            <button type="submit" name="view_details">View details</button>

                        </form>
                <?php
                    }
                } else {
                    echo "All confirmed bookings will be shown here <br> No confirmed bookings yet!";
                }
                ?>
            </div>


        </div>

    </div>





</body>

</html>