<div class="sidenav brownbox" style="height:100%">
    <div style="text-align: center;">
        <?php
        if (empty($_SESSION["image"])) {
            echo "<img class='logo_dp' width='200px' height='200px' alt='' src=" . URLROOT . "/img/avatar.png />";
        } else {
            echo "<img class='logo_dp' width='200px' height='200px' alt='' src=" . URLROOT . "/" . $_SESSION["image"] . " />";
        } ?>
    </div>

    <hr>
    <p class="sidenavName" style="text-transform: uppercase;">
        <?php echo $_SESSION["name"]; ?>
    </p>
    <hr>
    <a href="<?php echo URLROOT; ?>/managerbookings">Bookings</a>
    <a href="<?php echo URLROOT; ?>/update">Update Profile</a>
    <a href="<?php echo URLROOT; ?>/Managerfinance">Payments/Expenses</a>
    <a href="<?php echo URLROOT; ?>/Managerreport">Report</a>
    <a href="<?php echo URLROOT; ?>/Managercalendar">Calendar</a>
    <a href="<?php echo URLROOT; ?>/Managertentatives">Tentatives</a>
    <a href="<?php echo URLROOT; ?>/Managermessages">Messages</a>

</div>