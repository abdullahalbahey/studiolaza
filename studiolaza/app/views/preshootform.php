<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .TickLabel {

            color: #890000;
            width: 200px;
            font-size: 1.2rem;
            border: 0.5px solid #e0e0e0;
            display: flex;
            padding: 5 10 5 10;
            text-decoration: none;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            float: right;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 3px 0 rgba(0, 0, 0, 0.19);
        }

        .form {
            width: 100%;
        }

        .signupFrm {
            width: 60%;
            display: flex;
            
        }


        .borderforcels {
            border: 2px solid #e0e0e0;
            padding: 10px 20px 0 20px;
            border-radius: 10px;
            margin: 10px 0 10px 0;

        }
    </style>

</head>

<body class="brownbox" style="flex-direction: column; ">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class=" signupFrm"  >


        <h2>PRE WEDDING SHOOT DETAILS</h2>

        <form class="form" style="display: flex;flex-direction: column; width: 90%;align-content: space-between;" action="<?php echo URLROOT; ?>/booknow/preshootform" method="post" enctype="multipart/form-data">
            <!--Option 1--><!--Magazine preshoot Album-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Preshoot Album [20sheets/40pgs]</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="preshootalbum">
                        30 000 LKR.
                        <input type="checkbox" id="preshootalbum" name="preshootalbum" value="Magazine_Preshoot_Album_[20sheets/40pgs]">
                    </label>
                </div>

                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="albumsize" id="pgs" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="8x12">8 x 12 </option>
                            <option value="10x12">10 x 12</option>
                            <option value="12x15">12 x 15</option>
                        </select>
                    </label>
                </div>
            </div>

            


            <!--pre shoot time-->

            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Animated Slide Show of Pre Shoot</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="slideshow">
                        5 000 LKR.
                        <input type="checkbox" id="slideshow" name="slideshow" value="Animated_Slide_Show_of_PreShoot">
                    </label>
                </div>

                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Time Required for event:</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="time">
                        <select name="time" id="time" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="4">4 hours</option>
                            <option value="8">8 hours</option>
                        </select>
                    </label>
                </div>
            </div>
            <!--Animated Slide Show of Pre Shoot-->




            <!--submit-->
            <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                <div style="flex-direction:column; width:40%">
                    <button type="submit" class="submitBtn"> <b>Clear</b> </button>
                </div>
                <div style="flex-direction:column;  width:40%">
                    <button type="submit" class="submitBtn" name="savedetails"> <b>Next</b> </button></a>
                </div>
            </div>

        </form>


    </div>


</body>

</html>