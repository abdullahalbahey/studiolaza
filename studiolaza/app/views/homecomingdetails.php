<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

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

        li {
            float: none;
        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">

            <?php if ($_SESSION['type'] == "E") {
                include 'includes/employeesidenav.php';
            }
            ?>
            <?php if ($_SESSION['type'] == "M") {
                include 'includes/managersidenav.php';
            }
            ?>
            <?php if ($_SESSION['type'] == "C") {
                include 'includes/customersidenav.php';
            }
            ?>
        </div>
        <div class="content brownbox">
            <div class="container brownbox">

                <div class="bookingPackageDetails" style="text-align:left">

                    <h2 style="text-align:center">Home coming Package Details</h2>

                    <ol type="1" start="1">
                        <li>Magazine Album (20Spreads/40Pgs) - Size 10x12</li>
                        <li>Magazine Mini Album</li>
                        <li>Magazine Family Album-Photo Cover[8x12] - 15Spreads/30pgs</li>
                        <li>Animated Slide Show</li>
                    </ol>
                </div>

                <br>

            </div>
            <div style="text-align:center">
                <button onclick="goBack()">Go Back</button>

                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>
            </div>
        </div>

    </div>

    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>