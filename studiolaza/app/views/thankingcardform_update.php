<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/thankingcard.css">
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

        /*checkbox*/
        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
        }

         .checkbox {
            float: right;
            height: 2.1rem;
            width: 5%;
            color: rgb(0, 0, 0);
            font-size: 1rem;
            border: 0.04rem solid rgb(126, 124, 124);
            padding: 0.5rem 0.5rem;
            align-items: center;
            cursor: pointer;
            text-align: center;
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

        /* label {
            display: inline-block;
            width: 72%;
            color: #890000;
        } */

        select {
            margin-bottom: 40px;
            margin-left: 10px;
            width:20%;
            border: 3px solid #890000;

        }
</style>
<script type="text/javascript">
            function toggle(q,r,s) {

                var popup = document.getElementById('popup');
                popup.classList.toggle('active');
                document.getElementById("ab").src =q;
                document.getElementById("abc").innerHTML =r; 
                document.getElementById("abcd").value=s;  
            }

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
            
 </script>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="middle_2 brownbox">
    <?php if($data['weddingdetails'][0]->thankingcard_id!=NULL){ ?>
        <div>
            <p>Chosen thankingcard</p>
            <img src="<?php echo URLROOT."/".$data["thankingcardimage"][0]->image ;?>" height="200px" width="200px">
            <form action="<?php echo URLROOT; ?>/customerbooking/thankingcardform" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['weddingdetails'][0]->thankingcard_id; ?>">
                <input type="submit" name="remove" value="Remove thankingcard">
            </form>
        </div>
    <?php } ?>
    <p><?php if($data['weddingdetails'][0]->thankingcard_id!=NULL){ echo "Change"; }else{ echo "Add";}?> thanking card</p>
        <input type="checkbox" name="thankingcard" value="ThankingCard_"  id="option2" onclick="showHide2()">
    
    <div id="hiddenField2" style="display:none"> 
    <form action="<?php echo URLROOT; ?>/customerbooking/thankingcardform" method="POST">
            <div class="formcontent">
                
                <label><b>Thanking Cards</b></label>

                <div class="option">
                    <input type="number" name="cardcount" placeholder="No." min="50" max="1000" step="10">
                    <div class="price">
                        100 LKR.
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="thankingcard" value="ThankingCard_"  id="option1" onclick="showHide1()"> 
                    </div>
                </div>
            </div>

            <label for="pgs">Thanking card Size :</label>
            <select name="thankingcardsize" id="size">
                <option value="6x6 ">6 x 6</option>
                <option value="6x8 ">6 x 8</option>
            </select>

        
            <br>
        
            
    
        <div id="hiddenField1" style="display:none">
            <h2>Choose your Thanking card </h2>
    
            <div class="container" id="blur">

                <!--start of grid-->
                <div class="main" style="margin-left:-15">
                <?php
                    
                    $x=count($data["thankingcarddetails"]);
                    for($i=0;$i<$x;$i++) {
                        ?>
                    <a href='#' onclick="toggle('<?php echo URLROOT.'/'.$data['thankingcarddetails'][$i]->image;?>','<?php echo $data['thankingcarddetails'][$i]->description;?>','<?php echo $data['thankingcarddetails'][$i]->thankingcard_id;?>')"> <img src="<?php echo URLROOT."/".$data["thankingcarddetails"][$i]->image ;?>"></a>
                    
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
                    
                	<input type="text" id="abcd" hidden name="thankingcardid"  value="1">
                	<input type="submit" name="savedetails" class="button" value="Change">
                	<button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/thankingcardform'">Close</button>
            	    </div>

                </form>

            </div>
        </div>
        </div>
        <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/view_details_wedding'">Close</button>
        
        
       
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>

</body>

</html>