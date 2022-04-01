<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/thankingcard.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
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
        width: 4rem;
        height: 2rem;
        float: right;
        align-content: center;
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


    select {
        margin-bottom: 40px;
        margin-left: 10px;
        width: 20%;
        border: 3px solid #890000;

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
<script type="text/javascript">
    function toggle(q, r, s) {

        var popup = document.getElementById('popup');
        popup.classList.toggle('active');
        document.getElementById("ab").src = q;
        document.getElementById("abc").innerHTML = r;
        document.getElementById("abcd").value = s;
    }

    function showHide1() {
        if (document.getElementById('option1').checked) {
            document.getElementById('hiddenField1').style.display = 'block';
        } else {
            document.getElementById('hiddenField1').style.display = 'none';
        }
    }
</script>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="middle_2 signupFrm" style="flex-wrap: wrap;
    align-content: flex-start;">
        <div>
            <h2>THANKING CARD OPTIONS</h2><br>
        </div>

        <form class="form" style="display:flex;   flex-direction: column;" action="<?php echo URLROOT; ?>/booknow/thankingcardform" method="POST">
            <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                <div>
                    <b>Thanking Cards [Min 50]</b> <br>(Please click the option and enter the number of thanking cards to be printed)
                </div>
                <label class="TickLabel" style="float:right" for="option1">
                    100 LKR.
                    <input type="checkbox" name="thankingcard" value="ThankingCard_" id="option1" onclick="showHide1()">
                    <input type="number" name="cardcount" placeholder="No." min="50" max="1000" step="10">
                </label>
            </div>
            <br><br><br>

            <div class="inputContainer" style="display:flex;direction:row;align-items: center;justify-content: space-between;">
                <div>
                    <b>Thanking card Size</b> <br>(Please choose the preferred album size)
                </div>
                <label class="TickLabel" style="float:right;max-height:30px;flex-direction: column;" for="size">
                    <select name="thankingcardsize" id="size" style="border:none; box-shadow:none;" class="TickLabel">
                        <option value="6x6 ">6 x 6</option>
                        <option value="6x8 ">6 x 8</option>
                    </select>
                </label>
            </div>


            <br><br>

            <button class="submitBtn" type="button" onclick="location.href='<?php echo URLROOT ?>/booknow/costumeform'">Next</button>

            <div id="hiddenField1" style="display:none">
                <h2>Choose your Thanking card </h2>

                <div class="container" style="padding:-40" id="blur">

                    <!--start of grid-->
                    <div class="main" style="margin-left:-15">
                        <?php

                        $x = count($data["thankingcarddetails"]);
                        for ($i = 0; $i < $x; $i++) {
                        ?>

                            <a href='#' onclick="toggle('<?php echo URLROOT . '/' . $data['thankingcarddetails'][$i]->image; ?>','<?php echo $data['thankingcarddetails'][$i]->description; ?>','<?php echo $data['thankingcarddetails'][$i]->thankingcard_id; ?>')"> <img src="<?php echo URLROOT . "/" . $data["thankingcarddetails"][$i]->image; ?>" height="40%"></a>

                        <?php }

                        ?>

                    </div>
                    <!--end of grid-->

                </div>

                <div id="popup">

                    <h2>Thanking Card </h2>

                    <div class="card">
                        <img id="ab" src="" />
                    </div>


                    <div class="button-allign">
                        <!--<p id="abc"></p>-->

                        <input type="text" id="abcd" hidden name="thankingcardid" value="1">
                        <input type="submit" name="savedetails" class="button" value="Select">

                        <button type="submit" onclick="location.href='<?php echo URLROOT ?>/booknow/thankingcardform'">Close</button>
                    </div>

        </form>

    </div>
    </div>



    </div>


</body>

</html>