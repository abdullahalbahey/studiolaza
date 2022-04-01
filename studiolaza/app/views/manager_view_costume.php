<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        /*
    label {
            display: inline-block;
            width: 72%;
            color: #890000;
        }
        */
        
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

        .form {
            width: 100%;
        }

        .signupFrm {
            width: 60%;
            display: flex;
            flex-direction: row;
            flex-direction: column;
        }


        .borderforcels {
            border: 2px solid #e0e0e0;
            padding: 10px 20px 0 20px;
            border-radius: 10px;
            margin: 10px 0 10px 0;

        }
    </style>

</head>

<body class="brownbox" style="flex-direction: column; ">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>

    <div class="middle_2 signupFrm" id="backgroundIMG">

        <h2>CHOSEN COSTUME</h2>
        <img src="<?php echo URLROOT."/".$data['costume']; ?>" style="width:300px;height:300px"></ >
        <button type="button" class="submitBtn" onclick="location.href='<?php echo URLROOT ?>/managerbookings/'"> Close </button>
        
    </div>
    </div>




</body>

</html>