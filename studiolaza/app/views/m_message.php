<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

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

        .labelbox {
            color: white;
            background-color: #c70039;
            height: 50px;
            width: 500px;
            margin: auto;
            justify-content: center;
            display: flex;
            align-items: center;
            border-radius: 6px;
            cursor: pointer;
        }

        input[type="file"] {
            display: none;
        }

        .labelbox:hover {
            background-color: #890000;
            border: 2px solid #890000;
            color: #f2f2f2;
        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox" style="margin-top:51px">
            <?php include 'includes/managersidenav.php' ?>
        </div>
        <div class="content brownbox">
            <table class="red_table" style="width:100%; text-align:center; border:none;">
                <thead>
                    <tr>
                        <th style="width:15%" ;>First Name</th>
                        <th style="width:15%" ;>Last Name</th>
                        <th style="width:30%" ;>Email</th>
                        <th style="width:40%" ;>Message</th>
                        <th style="width:40%" ;>Message Reply</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['details'])) {
                        $x = count($data['details']);
                        for ($i = 0; $i < $x; $i++) {
                    ?>
                            <tr>
                                <td>
                                    <?php echo $data['details'][$i]->fname; ?>
                                </td>
                                <td>
                                    <?php echo $data['details'][$i]->lname ?></td>
                                <td>
                                    <?php echo $data['details'][$i]->email ?></td>

                                <td>
                                    <?php echo $data['details'][$i]->message ?>
                                    <br>
                                    
                                    <form action="<?php echo URLROOT; ?>/managermessages/emailreply" method="post"">
                                        <input type="text" name="messagereply" id="messagereply">
                                        
                                        <input type="hidden" name="fname" value="<?php echo $data['details'][$i]->fname; ?>">
                                        <input type="hidden" name="email" value="<?php echo $data['details'][$i]->email ?>">
                                        <input type="hidden" name="message_id" value="<?php echo $data['details'][$i]->contact_id; ?>">
                                        <input type="hidden" name="message_received" value="<?php echo $data['details'][$i]->message ?>">
                                        <input class="button" name="reply" value="Reply" type="submit">
                                    </form>
                                </td>
                                
                                <td>
                                        
                                        <?php echo $data['details'][$i]->message_replied ?>
                                </td>



                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

 



</body>

</html>