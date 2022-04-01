<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
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

        label {
            display: inline-block;
            width: 200px;
            color: #777777;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: 50%;
            height: 30px;
            padding-left: 20px;
        }

        .inputContainer {
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .middle_2 {
            height: auto;
        }
    </style>
    <script>
        function showHide1() {
            if (document.getElementById('option1').checked) {
                document.getElementById('hiddenField1').style.display = 'block';
            } else {
                document.getElementById('hiddenField1').style.display = 'none';
            }
        }

        function showHide2() {
            if (document.getElementById('option2').checked) {
                document.getElementById('hiddenField2').style.display = 'block';
            } else {
                document.getElementById('hiddenField2').style.display = 'none';
            }
        }

        function showHide3() {
            if (document.getElementById('option3').checked) {
                document.getElementById('hiddenField3').style.display = 'block';
            } else {
                document.getElementById('hiddenField3').style.display = 'none';
            }
        }

        function hello() {
            var y = document.querySelector('input').value;
            var z = document.getElementById('date');

            var jArray = <?php echo json_encode($_SESSION['dates']) ?>;
            for (var i = 0; i < jArray.length; i++) {
                if (y == jArray[i]) {
                    window.alert('The date is already selected');
                    z.value = "";
                }
            }
            if (y == document.querySelector(".homecoming").value || y == document.querySelector(".engagement").value || y == document.querySelector(".preshoot").value) {
                window.alert('Same dates cannot be selected for seperate events');
                z.value = "";
            }

        }

        function hello1() {
            var x = document.querySelector(".homecoming").value;
            var z = document.getElementById('date1');
            var bArray = <?php echo json_encode($_SESSION['dates']) ?>;
            for (var i = 0; i < bArray.length; i++) {
                if (x == bArray[i]) {
                    window.alert('The date is already selected');
                    z.value = "";
                }
            }
            if (x == document.querySelector(".wedding").value || x == document.querySelector(".engagement").value || x == document.querySelector(".preshoot").value) {
                window.alert('Same dates cannot be selected for seperate events');
                z.value = "";
            }

        }

        function hello2() {
            var y = document.querySelector(".engagement").value;
            var z = document.getElementById('date2');
            var jArray = <?php echo json_encode($_SESSION['dates']) ?>;
            for (var i = 0; i < jArray.length; i++) {
                if (y == jArray[i]) {
                    window.alert('The date is already selected');
                    z.value = "";
                }
            }
            if (y == document.querySelector(".wedding").value || y == document.querySelector(".homecoming").value || y == document.querySelector(".preshoot").value) {
                window.alert('Same dates cannot be selected for seperate events');
                z.value = "";
            }


        }

        function hello3() {
            var y = document.querySelector(".preshoot").value;
            var z = document.getElementById('date3');

            var jArray = <?php echo json_encode($_SESSION['dates']) ?>;
            for (var i = 0; i < jArray.length; i++) {
                if (y == jArray[i]) {
                    window.alert('The date is already selected');
                    z.value = "";
                }
            }
            if (y == document.querySelector(".wedding").value || y == document.querySelector(".engagement").value || y == document.querySelector(".homecoming").value) {
                window.alert('Same dates cannot be selected for seperate events');
                z.value = "";
            }

        }
    </script>


</head>


<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_2" style="display: flex; border-radius: 2%;    margin: 6% auto;  height:auto;  background-color: white; border: 2.5px solid #dadce0;">
        <h1 style="text-align:center">New Booking</h1>
        <form class="" style=" height:100%" action="<?php echo URLROOT; ?>/booknow/newbooking" method="post" enctype="multipart/form-data">
            <h3 style="text-align:center">Please choose the following options for the wedding booking!</h3>

            <!--Get wedding details-->
            <?php $date = date("Y-m-d"); ?>

            <div class="details">

                <div class="inputContainer">
                    <label>Date : </label>
                    <input type="date" onkeydown="return false" <?php if (!empty($_SESSION['dates'])) { ?>onchange="hello()" <?php } ?> id="date" class="wedding" min="<?php echo date('Y-m-d', strtotime($date . ' + 10 days'));  ?>" name="datew" required>
                </div>

                <div class="inputContainer">
                    <label>Time : </label>
                    <input type="time" name="timew" id="time" required>
                </div>
                <div class="inputContainer">
                    <label>Venue : </label>
                    <input type="text" name="venuew" id="venue" required>
                </div>

            </div>

            <hr>
            <div style="text-align:center;">
                <b>Additional Packages Available</b><br>
                (Please click the checkbox to select the package)
            </div>

            <hr>

            <!--Option 1-->

            <div class="inputContainer">
                <label for="option1" style="cursor: pointer;"><b>Home Coming</b></label>
                <input type="checkbox" name="homecoming" id="option1" onclick="showHide1()" />
            </div>

            <!--Home coming details-->
            <div class="details" id="hiddenField1" style="display:none">

                <div class="inputContainer ">
                    <label>Date : </label>
                    <input type="date" onkeydown="return false" <?php if (!empty($_SESSION['dates'])) { ?>onchange="hello1()" <?php } ?> id="date1" class="homecoming" min="<?php echo date('Y-m-d', strtotime($date . ' + 10 days'));  ?>" name="dateh">
                </div>
                <div class="inputContainer">
                    <label>Time : </label>
                    <input type="time" name="timeh" id="time">
                </div>
                <div class="inputContainer">
                    <label>Venue : </label>

                    <input type="text" name="venueh" id="venue">
                </div>

            </div>

            <!--Option 2-->
            <hr>
            <div class="inputContainer">
                <label for="option2" style="cursor: pointer;"><b>Engagement</b></label>
                <input type="checkbox" name="engagement" id="option2" onclick="showHide2()">
            </div>
            <!--Engagement details-->
            <div class="details" id="hiddenField2" style="display:none">

                <div class="inputContainer">
                    <label>Date : </label>
                    <input type="date" onkeydown="return false" name="datee" <?php if (!empty($_SESSION['dates'])) { ?>onchange="hello2()" <?php } ?> id="date2" class="engagement" min="<?php echo date('Y-m-d', strtotime($date . ' + 10 days'));  ?>">
                </div>
                <div class="inputContainer">
                    <label>Time : </label>
                    <input type="time" name="timee" id="time">
                </div>

                <div class="inputContainer">
                    <label>Venue : </label>
                    <input type="text" name="venuee" id="venue">
                </div>

            </div>
            <hr>
            <!--Option 3-->

            <div class="inputContainer">
                <label for="option3" style="cursor: pointer;"><b>Pre Wedding Shoot</b></label>
                <input type="checkbox" name="preshoot" id="option3" onclick="showHide3()" />
            </div>
            <!--Pre Wedding Shoot details-->
            <div class="details" id="hiddenField3" style="display:none">

                <div class="inputContainer">
                    <label>Date : </label>
                    <input type="date" onkeydown="return false" name="datep" <?php if (!empty($_SESSION['dates'])) { ?>onchange="hello3()" <?php } ?> id="date3" class="preshoot" min="<?php echo date('Y-m-d', strtotime($date . ' + 10 days'));  ?>">
                </div>
                <div class="inputContainer">
                    <label>Time : </label>
                    <input type="time" name="timep" id="time">
                </div>

                <div class="inputContainer">
                    <label>Venue : </label>
                    <input type="text" name="venuep" id="venue">
                </div>

            </div>

            <span class="errormessage">
                <?php echo $data["mainerror"]; ?>
            </span>

            
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




</body>

</html>