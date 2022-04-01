<div class="sidenav brownbox">
<div style="text-align: center;">
    <?php
                        if(empty($_SESSION["image"])){
                            echo "<img class='logo_dp' width='200px' height='200px' alt='' src=".URLROOT."/img/avatar.png />";
                        }else{
                            echo "<img class='logo_dp' width='200px' height='200px' alt='' src=".URLROOT."/".$_SESSION["image"]." />";
                        }?>
    </div>
    <hr>
    <p class="sidenavName"style="text-transform: capitalize;">
        <?php echo "EMP: ".$_SESSION["name"]; ?>
    </p><hr>
    <a href="<?php echo URLROOT?>/employeebooking">Bookings</a>
    <a href="<?php echo URLROOT?>/update">Update Profile</a>
    
</div>