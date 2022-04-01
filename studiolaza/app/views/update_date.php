<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
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
       
    </style>
    <script>
        function hello(){
           var y=document.querySelector('input').value;
           var z=document.getElementById('date');
           
            var jArray =<?php echo json_encode($_SESSION['dates'])?>;
            for(var i = 0; i < jArray.length; i++){
                if(y==jArray[i]){
                    window.alert('The date is already selected');
                    z.value="";
                }
            }            
        }

        
    </script>


</head>


<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_2 brownbox" style="padding:0% 20%">
        <h1 style="text-align:center">Update Booking</h1>
        <form class="" action="<?php echo URLROOT; ?>/reschedule/update" method="post">

            <!--Get wedding details-->
            <?php $date=date("Y-m-d");?>

            <div class="details">
                
                <div class="date">
                    <label>Date : </label>
                    <input type="date" onkeydown="return false" <?php if(!empty($_SESSION['dates'])){?>onchange="hello()"<?php } ?> id="date" class="wedding" min="<?php echo date('Y-m-d', strtotime($date. ' + 10 days'));  ?>" name="datew" required>
                </div>

                <div>
                    <label>Time : </label>
                    <input type="time" name="timew" id="time" required>
                </div>
                <div>
                    <label>Venue : </label>
                    <input type="text" name="venuew" id="venue" required>
                </div>

            </div>

            <br>

            <button type="submit" name="update"> <b>Update</b> </button></a>
            <button type="button" onclick="location.href='<?php echo URLROOT?>/customerbooking/fetchbookingdetails'">Close</button>

        </form>
    </div>


    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>