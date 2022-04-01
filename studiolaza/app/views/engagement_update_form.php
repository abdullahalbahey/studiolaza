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
            flex-direction: row;
        }

        .borderforcels {
            border: 2px solid #e0e0e0;
            padding: 10px 20px 0 20px;
            border-radius: 10px;
            margin: 10px 0 10px 0;

        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="middle_2 " style="display: flex; border-radius: 2%;  align-items: center; width:60%; margin: 6% auto;   background-color: white; border: 2.5px solid #dadce0; padding-bottom:120px">

        <h2>Engagement Form</h2>

        <form class="" style="display: flex;flex-direction: column; width: 90%;align-content: space-between;" action="<?php echo URLROOT; ?>/customerbooking/engagementform" method="post" enctype="multipart/form-data">

            <!--Option 1-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Family Album [8 x 12] + Photo Cover</b>
                    </div><br>
                    <label class="TickLabel" style="float:right" for="familyalbum">
                        10 000 LKR.
                        <input type="checkbox" id="familyalbum" name="familyalbum" Value="Magazine_Family_Album+Photo_Cover_[8x12]_">
                    </label>
                </div>
                <!--Option 2 ENDS HERE-->

                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred venue)
                    </div>
                    <label class="TickLabel" style="float:right" for="bridepreparation">
                        <select name="familyalbumsize" id="pgs" class="TickLabel" id="venue" style="border:none; box-shadow:none">
                            <option value="10/20 ">10 Sheets/20pgs </option>
                            <option value="15/30 ">15 Sheets/30pgs</option>
                        </select>
                    </label>
                </div>
            </div>






            <!--Option 2-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement with Frame</b>
                    </div><br>
                    <label class="TickLabel" style="float:right" for="enlargement">
                        6 000 LKR.
                        <input type="checkbox" id="enlargement" name="enlargement" value="Enlargement_with_Frame ">
                        <input type="number" name="count" style="width:80px; height:40px" placeholder="No." min="1">
                    </label>
                </div>


                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement Size</b> <br>(Please choose the emlargement size)
                    </div>
                    <label class="TickLabel" style="float:right" for="enlargementsize">
                        <select name="enlargementsize" id="size" class="TickLabel" id="venue" style="border:none; box-shadow:none">
                            <option value="8x12 "> 8 x 12</option>
                            <option value="12x18 ">12 x 18</option>
                            <option value="16x24 ">16 x 24</option>
                            <option value="20x30 ">20 x 30</option>
                        </select>
                    </label>
                </div>
            </div>




            <!--Option 3-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Signature Board [16x24]</b>
                    </div><br>
                    <label class="TickLabel" style="float:right" for="signatureboard">
                        4 500 LKR.
                        <input type="checkbox" id="signatureboard" name="signatureboard" value="Signature_Board">
                    </label>
                </div>
            </div>


            <!--Option 4-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Mini Album</b>
                    </div><br>
                    <label class="TickLabel" style="float:right" for="minialbum">
                        5 000 LKR.
                        <input type="checkbox" id="minialbum" name=minialbum" value="Magazine_Mini_Album_">
                    </label>
                </div>
            </div>


            <!--Option 5-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Engagement coverage + Couple photo session
                            <br>
                            +Album [20 Spreads/40pgs + Photo Cover + Standard Box]</b>
                    </div><br>
                    <label class="TickLabel" style="float:right" for="engagementcoverage">
                        10 000 LKR.
                        <input type="checkbox" id="engagementcoverage" name="engagementcoverage">
                    </label>
                </div>
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size :</b> <br>(Please choose the album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="albumsize" id="pgs" class="TickLabel" id="venue" style="border:none; box-shadow:none">
                            <option value="8x12">8 x 12</option>
                            <option value="10x12">10 x 12</option>
                            <option value="12x15">12 x 15</option>
                        </select>
                    </label>
                </div>
            </div>

                <!--Buttons-->
                <div class="button-allign">
                    <button type="submit"> <b>Clear</b> </button>
                    <button type="submit" name="savedetails"> <b>Next</b> </button></a>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/view_details_engagement'">Close</button>

                </div>
            </form>

</div>

</body>

</html>