<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        input[type=text],
        input[type=email],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #f1f1f1;
            color: #890000;
            padding: 12px 20px;
            border: 3px solid #890000;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;

        }

        input[type=submit]:hover {
            background-color: #890000;
            color: #f1f1f1;
            font-weight: bold;

        }

        .container {
            border-radius: 15px;
            background-color: #fff;
            padding: 20px 0;
            color: black;
        }



        .col-25 {
            float: left;
            width: 20%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 70%;
            margin-top: 6px;
        }


        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }
    </style>


</head>

<body class="">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>
    <div class="middle_2">
        <div style="margin-top:50px">
            <div class="text">
                <h2 style="text-align:center; text-transform: uppercase;">Contact Us</h2>
                <br>
            </div>
            <div class="singlereviewbox" style="display:flex; width:99%">

                <div class="mapouter">
                    <div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=che%20studio&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br>
                        <style>
                            .mapouter {
                                position: relative;
                                text-align: right;
                                width: 45%;
                            }
                            .gmap_canvas {
                                overflow: hidden;
                                background: none !important;
                                height: 100%;
                                width: 100%;
                            }
                        </style>
                    </div>
                </div>


                <div class="container" style="width:100% ;text-align: center">
                    <h3 style="text-transform: uppercase;">Feel free to contact us in any case of need. We are open to our service 24X7</h3>
                    <form action="<?php echo URLROOT; ?>/landing/contactus" method="post">
                        <div class="row">
                            <div class="col-25">
                                <label for="fname">First Name</label>
                            </div>
                            <div class="col-75">
                                <input type="text" class="input" id="fname" name="firstname" placeholder="Your name..">
                                <span class="errormessage">
                                    <?php echo $data["firstnameerror"]; ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="lname">Last Name</label>
                            </div>
                            <div class="col-75">
                                <input type="text" id="lname" name="lastname" placeholder="Your last name..">
                                <span class="errormessage">
                                    <?php echo $data["lastnameerror"]; ?>
                                </span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="email">Email</label>
                            </div>
                            <div class="col-75">
                                <input type="email" id="email" name="email" placeholder="abc@abc.com">
                                <span class="errormessage">
                                    <?php echo $data["emailerror"]; ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-25">
                                <label for="subject">Your Message</label>
                            </div>
                            <div class="col-75">
                                <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
                                <span class="errormessage">
                                    <?php echo $data["messageerror"]; ?>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <input type="submit" name="contactussubmit" value="Submit">
                        </div>
                    </form>
                </div>


            </div>

        </div>
    </div>


    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>