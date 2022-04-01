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
    <p class="sidenavName" style="text-transform: uppercase;" >
        <?php echo $_SESSION["name"]; ?>
    </p>
    <hr>
    <a href="<?php echo URLROOT;?>/customerbooking">Bookings</a>
    <a href="<?php echo URLROOT;?>/update">Update Profile</a>
    <a href="<?php echo URLROOT;?>/customerreview">Review</a>
</div>