<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/thankingcard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<script type="text/javascript">
            function toggle(q,r,s,t) {
                document.getElementById("abcd").value=parseInt(s);  
                document.getElementById("abcdf").value=parseInt(t);  
                var popup = document.getElementById('popup');
                popup.classList.toggle('active');
                document.getElementById("ab").src =q;
                document.getElementById("abc").innerHTML =r; 
                document.getElementById("abcde").innerHTML =t;

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
    <?php if($data['weddingdetails'][0]->costume_id!=NULL){ ?>
        <div>
            <p>Chosen costume</p>
            <img src="<?php echo URLROOT."/".$data["costumeimage"][0]->image ;?>" height="200px" width="200px">
            <form>
                <input type="hidden" name="id" value="<?php echo $data['weddingdetails'][0]->costume_id; ?>">
                <input type="submit" name="remove" value="Remove thankingcard">
            </form>
        </div>
    <?php } ?>

    <p><?php if($data['weddingdetails'][0]->costume_id!=NULL){ echo "Change"; }else{ echo "Add";}?> Costume</p>
        <input type="checkbox"  id="option2" onclick="showHide2()">
    
    <div id="hiddenField2" style="display:none"> 
    
            
                <label><b>Do you need costumes for your wedding(Only bridal selections)</b></label>

                
                    <div class="checkbox">
                        <input type="checkbox" id="option1" onclick="showHide1()"> 
                    </div>
                    
        <div id="hiddenField1" style="display:none">
            <h2>Choose your costume </h2>
    
            <div class="container" id="blur">

                <!--start of grid-->
                <div class="main" style="margin-left:-15">
                <?php
                    if(!empty($data['costumedetails'])){
                    $x=count($data['costumedetails']);
                    for($i=0;$i<$x;$i++) {
                        if(!empty($data['costumedetails2'])){
                            if(in_array($data['costumedetails'][$i]->costume_id,$data['costumedetails2'])){
                                continue;
                            }
                        }else{
                        ?>
                    <a href='#' onclick="toggle('<?php echo URLROOT.'/'.$data['costumedetails'][$i]->image;?>','<?php echo $data['costumedetails'][$i]->description;?>','<?php echo $data['costumedetails'][$i]->costume_id;?>','<?php echo $data['costumedetails'][$i]->price;?>')"> <img src="<?php echo URLROOT."/".$data["costumedetails"][$i]->image ;?>"></a>
                    
                    <?php }}}
                    
                ?>

                </div>
                <!--end of grid-->

            </div>

            <div id="popup">

                <h2>Costume </h2>

                <div class="card">
                <img id="ab" src="" /> 
                </div>

                    <form action="<?php echo URLROOT; ?>/customerbooking/costumeform" method="POST">
                    <div class="button-allign">

                        <input type="text" id="abcd" hidden name="costumeid"  value="">
                        <input type="text" id="abcdf" hidden name="price"  value="">
                        <input type="submit" name="savedetails" class="button" value="Select">
                        
                        <button type="button" onclick="location.href='<?php echo URLROOT ?>/customerbooking/costumeform'">Close</button>
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