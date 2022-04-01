<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /*
    label {
            display: inline-block;
            width: 72%;
            color: #890000;
        }
        */
        
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
            flex-direction: row;
            flex-direction: column;
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

    <div class="middle_2 signupFrm" id="backgroundIMG">

        <h2>HomeComing Form</h2>

        <form class="form" style="display: flex;flex-direction: column; width: 90%;align-content: space-between;"action="<?php echo URLROOT; ?>/customerbooking/homecomingform" method="post" enctype="multipart/form-data">

            <!--Option 1-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Main Album [30sheets/60pgs] + Photo Cover + Standard Box</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="bridepreparation">
                        30 000 LKR.
                        <input type="checkbox" id="bridepreparation" name="mainalbum" value="Magazine_Album_[30sheets/60pgs]_">
                    </label>
                </div>
                
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="mainalbumsize" id="pgs" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="10x12">10 x 12 </option>
                            <option value="12x15">12 x 15</option>
                        </select>
                    </label>
                </div>
            </div>



            <!--Option 2-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Family Album [8 x 12] + Photo Cover</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="familyalbum">
                        10 000 LKR.
                        <input type="checkbox" name="familyalbum" id="familyalbum" Value="Magazine_Family_Album-Photo_Cover_[8x12]_">
                    </label>
                </div>
                
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="familyalbumsize" id="pgs" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="10/20 ">10 Sheets/20pgs </option>
                            <option value="15/30 ">15 Sheets/30pgs</option>
                        </select>
                    </label>
                </div>
            </div>


            <!--Option 3-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement with Frame</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="enlargement">
                        6 000 LKR.
                        <input type="checkbox" name="enlargement" id="enlargement" value="Enlargement_with_Frame ">
                    </label>
                </div>
                
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement Size</b> <br>(Please choose the preferred enlargement size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="enlargementsize" id="size" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="8x12 "> 8 x 12</option>
                            <option value="12x18 ">12 x 18</option>
                            <option value="16x24 ">16 x 24</option>
                            <option value="20x30 ">20 x 30</option>
                        </select>
                    </label>
                </div>
            </div>

            <!--Option 4-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Thanking Cards</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="thankingcard">
                        100 LKR.
                        <input type="checkbox" name="thankingcard" id="thankingcard" value="ThankingCard_">
                        <input type="number" style="width:80px; height:40px" name="count" id="thankingcard" placeholder="No." min="50" max="1000" step="10">
                    </label>
                </div>
                
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Thanking card Size</b> <br>(Please choose the preferred thanking card size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="thankingcardsize" id="size" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="6x6 ">6 x 6</option>
                            <option value="6x8 ">6 x 8</option>
                        </select>
                    </label>
                </div>
            </div>


            <!--Option 5-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Mini Album</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="minialbum">
                        5 000 LKR
                        <input type="checkbox" name="minialbum" id="minialbum" value="Magazine_Mini_Album_">
                    </label>
                </div>

            </div>

            <!--Option 6-->

            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>HomeComing/ Reception Coverage/ Couple photo session</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="homecomingcoverage">
                        10 000 LKR.
                        <input type="checkbox" id="homecomingcoverage" name="homecomingcoverage">
                    </label>
                </div>
                
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Choose preferred option</b> <br>(Please choose the preferred option)
                    </div>
                    <label class="TickLabel" style="float:right;width:auto" for="pgs">
                        <select name="options" style="width:auto" id="pgs" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="HRC">Home Coming / Reception Coverage + Couple Photo Session </option>
                            <option value="HR">Home Coming / Reception Coverage </option>
                            <option value="HC">Home Coming / Couple Photo Session </option>
                        </select>
                    </label>
                </div>
            </div>

                <!--Buttons-->
                <div class="button-allign">
                    <button type="submit"> <b>Clear</b> </button>
                    <button type="submit" name="savedetails"> <b>Next</b> </button></a>
                    <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/view_details_homecoming'">Close</button>

                </div>

            </form>
    </div>
    </div>

</body>

</html>