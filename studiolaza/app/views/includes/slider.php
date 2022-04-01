<html>

<body>
    <div class="container flex-center">
        <!-- Will be the content part -->

        <div class="slidershow middle">
            <!-- Will be the TOTAL image slider part -->

            <div class="imgslider">
                <!-- Will be the image slider part -->

                <input type="radio" name="r" id="rad1" checked>
                <input type="radio" name="r" id="rad2">
                <input type="radio" name="r" id="rad3">
                <input type="radio" name="r" id="rad4">
                <input type="radio" name="r" id="rad5">

                <div class="img-content s1">
                    <img class="imgslide" src="<?php echo URLROOT; ?>/public/img/bahey/slide1.PNG" style="width:100%">
                </div>
                <div class="img-content">
                    <img class="imgslide" src="<?php echo URLROOT; ?>/public/img/bahey/slide2.PNG" style="width:100%">
                </div>
                <div class="img-content">
                    <img class="imgslide" src="<?php echo URLROOT; ?>/public/img/bahey/slide3.PNG" style="width:100%">
                </div>
                <div class="img-content">
                    <img class="imgslide" src="<?php echo URLROOT; ?>/public/img/bahey/slide4.PNG" style="width:100%">
                </div>
                <div class="img-content">
                    <img class="imgslide" src="<?php echo URLROOT; ?>/public/img/bahey/slide5.PNG" style="width:100%">
                </div>
            </div> <!-- imgslider ending -->
            <div class="navigation">
                <label for="rad1" class="bar"></label>
                <label for="rad2" class="bar"></label>
                <label for="rad3" class="bar"></label>
                <label for="rad4" class="bar"></label>
                <label for="rad5" class="bar"></label>
            </div>
        </div> <!-- CLOSING TOTAL image slider part -->



    </div>


</body>

</html>