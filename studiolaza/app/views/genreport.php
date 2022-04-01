<html>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        input[type="date"] {

            margin-left: 10px;
            font-size: 16px;
        }
    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox" style="margin-top:50px">
            <?php include 'includes/managersidenav.php' ?>
        </div>
        <div class="content brownbox" style="margin-top:50px">

            <div>
                <h1 style="text-align: center">Report</h1>
                <h2 class="brownText">Choose Period</h2>
                <form action="<?php echo URLROOT; ?>/managerreport/goreport" style="text-align: center;" method="post">
                    <p class="h2report ">
                        <b>From:</b> <input type="date" name="fromDate" id="fromDateReport" style="height: 40px; margin-right: 60px;" >
                        <!--  input a date which is not less than fromDate-->
                        

                        
                        
                           <?php
                           $fromDate="";
                          
                           $dataa = date("Y-m-d"); ?>
                        

                        <b>To: </b><input type="date" name="toDate" id="toDateReport" style="height: 40px;" min="<?php echo date('Y-m-d', strtotime($dataa . ''));  ?>" ><br><br>
                        <input type="submit" value="Go" class="button" name="submit" id="goReport">
                    </p>
                    <br>
                </form>
                <div class="indexReview">
                    <?php
                    if (!empty($data['details'])) {
                        $x = count($data['details']);
                        $totalExpense = 0;
                        $totalIncome = 0;
                       

                        for ($i = 0; $i < $x; $i++) { {
                            if ($data['details'][$i]->financeType == "income") {
                                $totalIncome+= $data['details'][$i]->financeAmount;
                            } else {
                                $totalExpense+= $data['details'][$i]->financeAmount;;
                            }}
                        }?>
                        <div class="singlereviewbox brownbox">
                                <div class="reviewerName">
                                <h2> <?php echo $totalExpense; ?> </h2>
                                <p>Total Expense in the time period</p><br>
                            </div>
                        </div>

                        <div class="singlereviewbox brownbox">
                                <div class="reviewerName">        
                                <h2> <?php echo $totalIncome; ?> </h2>
                                <p>Total Income in the given time period </p>
                            </div>
                        </div>
                    
                    <?php
                    }
                    
                      ?>      
                            
                        
                </div>

                <table class="red_table">
                    <tr>
                        <th width="15%">Order Number</th>
                        <th>Date</th>
                        <th>Income</th>
                        <th>Expense</th>
                        <th width="25%">Purpose Note</th>
                    </tr>
                    <?php
                    if (!empty($data['details'])) {
                        $j = count($data['details']);
                        for ($i = 0; $i < $j; $i++) {
                    ?>
                            <tr>
                                <td><?php echo $data['details'][$i]->orderID; ?></td>
                                <td><?php echo $data['details'][$i]->financeDate; ?></td>
                                <td><?php
                                    if ($data['details'][$i]->financeType == "income") {
                                        echo $data['details'][$i]->financeAmount;
                                    } else {
                                        echo "0";
                                    }

                                    ?></td>
                                <td><?php
                                    if ($data['details'][$i]->financeType == "expense") {
                                        echo $data['details'][$i]->financeAmount;
                                    } else{
                                        echo "0"; }?>
                                        
                                </td>
                                <td><?php echo $data['details'][$i]->financePurpose; ?><br><?php echo $data['details'][$i]->otherFinancePurpose; ?></td>
                            </tr>
                    <?php
                        }
                    }

                    ?>
                </table>

                <br><br>
                <div style="text-align: center;">
                    
                    <input type="button" class="button" value="Clear" onclick="clearFunction()">
                    <script>
                        function clearFunction() {
                            document.getElementById("goReport").reset();
                        }
                    </script>
                </div>

            </div>
        </div>
    </div>





</body>

</html>