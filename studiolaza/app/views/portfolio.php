<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/imgsliderstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .grid {

            
            display: inline-grid;
            grid-template-columns: auto auto auto auto;
            grid-template-columns: repeat(autofill);
            column-gap: 30px;
            row-gap: 30px;
            margin-top: 40px;
            justify-content: center;
            align-items: center;
            padding: 10px;
            margin-left: 10%;
            width:80%;

            }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_2 brownbox">
        
            
                <div class="grid">
                    <?php
                        if(!empty($data['albums'])){
                            $x=count($data['albums']);
                            for($i=0;$i<$x;$i++){?>
                                <p><?php echo $data['albums'][$i]->name;?></p>
                                <form action="<?php echo URLROOT?>/landing/portfolioalbum" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $data['albums'][$i]->portfolio_id;?>">                       
                                    <button type="submit" name="view" >View Album</button>
                                </form>
                            <?php
                                    }
                                }else{ 
                            ?>
                            <p>NO ALBUMS UPLOADED YET</p>
                            <?php

                                }

                            ?>
                </div>

            
        
    </div>


    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>