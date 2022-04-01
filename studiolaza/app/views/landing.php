<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    

    <style>
        .singlereviewbox{
            width: 100%;
            height: auto;
            background-color: #f2f2f2;
            border-radius: 30px;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-right: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin: 10px;
        }
    </style>
</head>

<script>
        function showHide1() {
            if (document.getElementById('hiddenField1').style.display == 'none') {
                document.getElementById('hiddenField1').style.display = 'block';
                document.getElementById('readmore').value='Close';
            }
            else if (document.getElementById('hiddenField1').style.display == 'block') {
                document.getElementById('hiddenField1').style.display = 'none';
                document.getElementById('readmore').value='Read More Reviews';
            }
        }
</script>

<body>
    <div class="header" >
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_2" >
        <div class="container" style="text-align:center">
            <div class="slider " style="margin-top:-40px; border-radius:20px">
                <?php include 'includes/slider.php' ?>
            </div>
            <br>
            <div class="singlereviewbox" style="padding:0px 0 20px 0">
                <h2 style="margin-top:10px; padding-top:20px">
                        We make your memorable day seen forever in the best ever way someone could. <br>
                    #studiolaza
                </h2>
                <p style="text-align:center; font-size:20px">
                       <b> Studiolaza</b> is an online studio booking system that allows the customers to book a time slot for their wedding and a pre-shoot if wanted as well. <br>
                        It has a fully customizable package choosing option which is unique and hard to find anywhere in the market. 
                        <br>
                         We also provide facilities to choose a costume if needed for both your wedding and pre-shoots. Our platform is a user-friendly and customer-centric site that allows users to book a perfect and flexible booking online. Our platform also allows the customers to have their own account which can hold their data, update if necessary, and keep track of their photoshoot works as well.
                </p>
            </div><br>
            <div class="" width="50%">
                <h2>
                    WHAT DO OUR CLIENTS TALK?
                </h2>
            </div>
            <div class="indexreview">
                <?php include 'indexreview.php' ?>
                <input type="button" id="readmore" onclick="showHide1()" class="button" value="Read more Reviews">
            </div>
        </div>
        <div>
            <h2 style="text-align:center">Visit us at</h2>
        </div>
        <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="150px" id="gmap_canvas" src="https://maps.google.com/maps?q=che%20studio&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.whatismyip-address.com/divi-discount/"></a><br><style>.mapouter{position:relative;text-align:right;height:150px;width:100%;}</style><style>.gmap_canvas {overflow:hidden;background:none!important;height:150px;width:100%;}</style></div></div>
    </div>


    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>
