<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/cusbooking.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .displaying-page {
            width: 100%;
            display: flex;
            background-color: #fab5b5;
        }

        /*date*/
        input[type="date"] {
            width: 10rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            resize: none;
        }

        /*time*/
        input[type="time"] {
            width: 10rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            resize: none;
        }

        /*text box*/
        input[type="text"] {
            width: 10rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }

        /*radio button*/
        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked+label {
            background-color: rgb(112, 110, 110);
            color: rgb(255, 255, 255);
            display: flex;
        }

        select {
            height: 2rem;
        }

        h2 {
            text-align: center;
        }

        a {
            text-decoration: none;
        }

        .form-box {
            padding: 1rem 1rem 1rem 1rem;
            width: 55%;
            margin-left: 22.5%;
            margin-top: 5%;
            background: whitesmoke;
            border: 0.2rem solid #890000;
            border-radius: 2rem;
        }

        .form-box h2 {
            padding-bottom: 2rem;
        }

        .formcontent {
            width: 100%;
            height: 1.2rem;
            border: 0.05rem solid #696969;
            background-color: rgb(222, 225, 226);
            margin-top: 0.2rem;
            margin-bottom: 1rem;
            padding-left: 0.3rem;
            padding-bottom: 2rem;
        }

        .formcontent label {
            position: absolute;
            font-size: 1rem;
            padding: 0.5rem;
        }

        .option label {
            position: relative;
            height: 100%;
            color: rgb(0, 0, 0);
            font-size: 1rem;
            border: 2px solid rgb(133, 132, 132);
            padding: 5px 15px;
            align-items: center;
            cursor: pointer;
            float: right;
        }

        /*number*/
        input[type="number"] {
            width: 4rem;
            height: 2rem;
            float: right;
            align-content: center;
        }


        /*checkbox*/
        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }

        .checkbox {
            float: right;
            height: 2.1rem;
            width: 5%;
            color: rgb(0, 0, 0);
            font-size: 1rem;
            border: 0.04rem solid rgb(126, 124, 124);
            padding: 0.5rem 0.5rem;
            align-items: center;
            cursor: pointer;
            text-align: center;
        }


        .price {
            position: relative;
            width: 15%;
            height: 2.1rem;
            color: rgb(0, 0, 0);
            font-size: 1rem;
            border: 0.04rem solid rgb(122, 122, 122);
            padding: 0.5rem 0.5rem;
            align-items: center;
            float: right;
        }

        

        .button, button {
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
            margin: 30px 20px;
            cursor: pointer;
            border-radius: 30px;
            z-index: 1;
            height: 40px;
        }

        .button:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }
        /*
        label {
            display: inline-block;
            width: 72%;
            color: #890000;
        }*/
        select {
            margin-bottom: 40px;
            margin-left: 10px;
            width:20%;
            border: 3px solid #890000;

        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="middle_2 brownbox">'

        <div class="form-box">
            <h2>Pre Wedding Shoot Form</h2>

            <form class="" action="<?php echo URLROOT; ?>/customerbooking/preshoot_update_form" method="post" enctype="multipart/form-data">

                <!--Magazine preshoot Album-->
                <div class="formcontent">
                    <label><b>Magazine Preshoot Album [20sheets/40pgs]</b></label>

                    <div class="option">
                        <div class="price">
                            30 000 LKR.
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="preshootalbum" value="Magazine_Preshoot_Album_[20sheets/40pgs]">
                        </div>
                    </div>
                </div>

                <label for="pgs" style="padding-left:20px"><b>Album Size :</b></label>
                <select name="albumsize" id="pgs">
                    <option value="8x12">8 x 12 </option>
                    <option value="10x12">10 x 12</option>
                    <option value="12x15">12 x 15</option>
                </select>


                <!--Animated Slide Show of Pre Shoot-->
                <div class="formcontent">
                    <label><b>Animated Slide Show of Pre Shoot</b></label>

                    <div class="option">
                        <div class="price">
                            5 000 LKR.
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="slideshow" value="Animated_Slide_Show_of_PreShoot">
                        </div>
                    </div>
                </div>

                <!--pre shoot time-->
                <label for="albumsize" style="padding-left:5px"><b>Time Required for event:</b></label>
                <select name="time" id="time">
                    <option value="4">4 hours</option>
                    <option value="8">8 hours</option>
                </select>

                <!--submit-->
                <div style="text-align:center;">
                    <button type="submit"> <b>Clear</b> </button>
                    <button type="submit" name="savedetails"> <b>Next</b> </button></a>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/view_details_preshoot'">Close</button>

                </div>

            </form>
        </div>

    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>


</body>

</html>