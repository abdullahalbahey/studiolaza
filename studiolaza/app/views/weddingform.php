<html>

<head>
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/cusbooking.css"> -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">

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

        @media screen and (max-width: 1035px) {
            img {
                display: none;
            }

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

        h2 {
            text-align: center;
        }

        a {
            text-decoration: none;
        }

        .form-box {
            padding: 1rem 1rem 1rem 1rem;
            width: 100%;
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
            height: 2.1rem;
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
            width: 80px;
            height: 40px;
            float: right;
            align-content: center;
        }

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

        #backgroundIMG {
            border: 2px solid black;
            padding: 25px;
            background: url(<?php echo URLROOT . '/public/img/img/wedding.svg' ?>);
            background-repeat: no-repeat;
            background-size: auto;


        }
    </style>

</head>

<body class="brownbox" style="flex-direction: column; ">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class=" middle_2  signupFrm" id="backgroundIMG">

        <form class="form" action="<?php echo URLROOT; ?>/booknow/weddingform" method="post" enctype="multipart/form-data">

            <h2>WEDDING DETAILS</h2><br>
            <p style="color:#696969">
                <b style="text-transform:uppercase;text-align:center">
                    Please choose your preferred value additions ( <b style="color:red;font-size:20px">*</b> <b> Compulsory Package Options</b> ) and their respective options.
                </b>



            </p>
            <!--Option 1-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Bride's Preparation Shoot</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="bridepreparation">
                        15 000 LKR.
                        <input type="checkbox" id="bridepreparation" name="bridepreparation" value="Bride's_Preparation_Shoot">
                    </label>
                </div>
                <!--Option 2 ENDS HERE-->

                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Venue prefered</b> <br>(Please choose the preferred venue)
                    </div>
                    <label class="TickLabel" style="float:right" for="bridepreparation">
                        <select name="venue" class="TickLabel" id="venue" style="border:none; box-shadow:none">
                            <option value="In_Salon ">In Salon </option>
                            <option value="Venue_of_Function ">Venue of Function</option>
                        </select>
                    </label>
                </div>
            </div>
            <!--Option 3-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Groom's Preparation Shoot [Venue of Function]</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="groompreparation">
                        10 000 LKR.
                        <input type="checkbox" id="groompreparation" name="groompreparation" value="Groom's_Preparation_Shoot_[Venue_of_Function]">
                    </label>
                </div>
            </div>
            <!--Option 4-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Main Album [30sheets/60pgs] + Photo Cover+Standard Box<b style="color:red;font-size:20px">*</b></b>
                    </div>
                    <label class="TickLabel" style="float:right" for="mainalbum">
                        30 000 LKR.
                        <input type="checkbox" id="mainalbum" name="mainalbum" checked onclick="return false" value="Magazine_Album_[30sheets/60pgs]_">
                    </label>
                </div>

                <!--Option 5-->
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="magazinealbumsize" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="10x12">10 x 12 </option>
                            <option value="12x15">12 x 15</option>
                        </select>
                    </label>
                </div>

            </div>
            <!--Option 6-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Magazine Mini Album</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="minialbum">
                        5 000 LKR.
                        <input type="checkbox" id="minialbum" name="minialbum" value="Magazine_Mini_Album_">
                    </label>
                </div>
            </div>

            <!--Option 7-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Family Album [8x12] + Photo Cover <b style="color:red;font-size:20px">*</b></b>
                    </div>
                    <label class="TickLabel" style="float:right" for="familyalbum">
                        10 000 LKR.
                        <input type="checkbox" id="familyalbum" onclick="return false" checked  name="familyalbum" Value="Magazine_Family_Album-Photo_Cover_[8x12]_">
                    </label>
                </div>



                <!--Option 8-->
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Album Size</b> <br>(Please choose the preferred album size)
                    </div>
                    <label class="TickLabel" style="float:right" for="pgs">
                        <select name="familyalbumsize" style="border:none; box-shadow:none" class="TickLabel" id="pgs">
                            <option value="10/20">10 Sheets/20pgs </option>
                            <option value="15x30">15 Sheets/30pgs</option>
                        </select>
                    </label>
                </div>
            </div>

            <!--Option 9-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement with Frame</b> <br>(Please enter the number of enlargements)
                    </div>
                    <label class="TickLabel" style="float:right" for="enlargement">
                        6 000 LKR.
                        <input type="checkbox" id="enlargement" name="enlargement" value="Enlargement_with_Frame ">
                        <input type="number" name="enlargementcount" placeholder="No." min="1">
                    </label>
                </div>



                <!--Option 10-->
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Enlargement Size</b> <br>(Please choose the preferred enlargement size)
                    </div>
                    <label class="TickLabel" style="float:right" for="size">
                        <select name="enlargementsize" style="border:none; box-shadow:none" class="TickLabel" id="size">
                            <option value="8x12 "> 8 x 12</option>
                            <option value="12x18 ">12 x 18</option>
                            <option value="16x24 ">16 x 24</option>
                            <option value="20x30 ">20 x 30</option>
                        </select>
                    </label>
                </div>
            </div>

            <!--Option 11-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Group photos with Frame [12x18]</b><br>(Please enter the number of photo frames you'll be needing)
                    </div>
                    <label class="TickLabel" style="float:right" for="groupphotoswithframe">
                        15 000 LKR.
                        <input type="checkbox" name="groupphotoswithframe" id="groupphotoswithframe" value="Group_photos_with_Frame ">
                        <input type="number" class="" name="framecount" placeholder="No." min="1">
                    </label>
                </div>
            </div>

            <!--Option 12-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Signature Board [16x24]</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="signatureboard">
                        4,500 LKR.
                        <input type="checkbox" name="signatureboard" id="signatureboard" value="Signature_Board ">
                    </label>
                </div>
            </div>

            <!--Option 13-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>All Soft Copies in DVD</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="dvdcopy">
                        5,000 LKR.
                        <input type="checkbox" name="dvdcopy" id="dvdcopy" Value="DVD_soft_copies ">
                    </label>
                </div>
            </div>



            <!--Option 14-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Wedding Day Shoot Slide Show</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="weddingslideshow">
                        5,000 LKR.
                        <input type="checkbox" name="weddingslideshow" id="weddingslideshow" value="WeddingDay_Shoot_SlideShow ">
                    </label>
                </div>
            </div>



            <!--Option 15-->
            <div class="borderforcels">
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Online Storybook</b>
                    </div>
                    <label class="TickLabel" style="float:right" for="onlinestorybook">
                        5,000 LKR.
                        <input type="checkbox" name="onlinestorybook" id="onlinestorybook" value="Online_Story_book_">
                    </label>
                </div>


                <!--Option 16-->
                <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                    <div>
                        <b>Private / Public</b> (Do you want the Online Storybook to be private or public?)
                    </div>
                    <label class="TickLabel" style="float:right" for="p">
                        <select name="storybook" style="border:none; box-shadow:none" class="TickLabel" id="p">
                            <option value="Private ">Private</option>
                            <option value="Public ">Public</option>
                        </select>
                    </label>
                </div>
            </div>


            <!--Buttons-->
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

    </div>





</body>

</html>