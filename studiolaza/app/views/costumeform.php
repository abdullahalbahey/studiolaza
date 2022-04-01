<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/thankingcard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        .form {
            width: 100%;
        }

        .signupFrm {
            width: 60%;
            flex-direction: row;
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
    </style>
</head>

<script type="text/javascript">
    function toggle(q, r, s, t) {
        document.getElementById("abcd").value = parseInt(s);
        document.getElementById("abcdf").value = parseInt(t);
        var popup = document.getElementById('popup');
        popup.classList.toggle('active');
        document.getElementById("ab").src = q;
        document.getElementById("abc").innerHTML = r;
        document.getElementById("abcde").innerHTML = t;

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

    <div class="middle_2 signupFrm" style="display:flex;flex-direction: column; justify-content: flex-start;  align-items: center;">

        <div class="inputContainer" style="display:flex;flex-direction: column;
    align-items: center;align-items: center;justify-content: space-between;">
            <div>
                <b>Do you need costumes for your wedding (Only bridal selections)</b>
            </div>
            
            <div style="display:flex">
            <br>
                <label class="TickLabel" style="float:right" for="option1">
                    YES
                    <input type="checkbox" id="option1" onclick="showHide1()">
                </label>
            </div>

        </div>




        <button type="submit" class="submitBtn" onclick="location.href='<?php echo URLROOT ?>/booknow/preshootform'">Next</button>



        <div id="hiddenField1" style="display:none">
            <h2>Choose your costume </h2>

            <div class="container" id="blur">

                <!--start of grid-->
                <div class="main" style="margin-left:-15">
                    <?php
                    if (!empty($data['costumedetails'])) {
                        $x = count($data['costumedetails']);
                        for ($i = 0; $i < $x; $i++) {
                            if (!empty($data['costumedetails2'])) {
                                if (in_array($data['costumedetails'][$i]->costume_id, $data['costumedetails2'])) {
                                    continue;
                                }
                            } else {
                    ?>
                                <a href='#' onclick="toggle('<?php echo URLROOT . '/' . $data['costumedetails'][$i]->image; ?>','<?php echo $data['costumedetails'][$i]->description; ?>','<?php echo $data['costumedetails'][$i]->costume_id; ?>','<?php echo $data['costumedetails'][$i]->price; ?>')"> <img src="<?php echo URLROOT . "/" . $data["costumedetails"][$i]->image; ?>"></a>

                    <?php }
                        }
                    }

                    ?>

                </div>
                <!--end of grid-->

            </div>

            <div id="popup">

                <h2>Costume </h2>

                <div class="card">
                    <img id="ab" src="" />
                </div>

                <form action="<?php echo URLROOT; ?>/booknow/costumeform" method="POST">
                    <div class="button-allign">

                        <input type="text" id="abcd" hidden name="costumeid" value="">
                        <input type="text" id="abcdf" hidden name="price" value="">
                        <input type="submit" name="savedetails" class="button" value="Select">

                        <button type="submit" onclick="location.href='<?php echo URLROOT ?>/booknow/costumeform'">Close</button>
                    </div>

                </form>

            </div>
        </div>



    </div>


</body>

</html>