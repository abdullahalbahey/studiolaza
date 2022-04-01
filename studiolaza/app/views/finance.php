<html>

<head>
    <title>
        Finance Update
    </title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">

    <script type="text/javascript">
        function CheckPurpose(val) {
            var element = document.getElementById('financePurpose');
            if (val == 'pick a color' || val == 'others')
                element.style.display = 'block';
            else
                element.style.display = 'none';
        }
    </script>
</head>

<body>
    <div >
        <div>
            <form id="addFinance" action="<?php echo URLROOT; ?>/managerfinance/addfinance" method="post">
                <table class="red_table">
                    <tr class="thead">
                        <th>Enter order ID</th>
                        <th>Transaction Purpose</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Income/Expense</th>
                    </tr>
                    <tr>
                        <td>
                            <form action="" id="searchorder_sm">
                                <input type="text" placeholder="#" name="searchorder_fin">
                                <span class="errormessage">
                                    <?php echo $data["findordererror"]; ?>
                                </span>
                        </td>
                        <td>
                            <select style="width: 190px; height: 30px;" name="financePurpose" onchange='CheckPurpose(this.value);'>
                                <option value="Balance Payment">Balance Payment</option>
                                <option value="Employee Salary">Salary Payment</option>
                                <option value="Traveling Cost">Traveling Cost</option>
                                <option value="others">others</option>
                            </select>
                            <input type="text" name="otherfinancePurpose" id="financePurpose" style='display:none;' />
                        </td>
                        <td>
                            <input type="date" name="financeDate" id="" value="<?php echo date("Y-m-d"); ?>">
                        </td>
                        <td>
                            <input type="number" name="financeAmount" placeholder="100" value="">
                            <span class="errormessage">
                                <?php echo $data["amounterror"]; ?>
                            </span>
                        </td>
                        <td><select style="width: 190px; height: 30px;" name="financeType" onchange='CheckPurpose(this.value);'>
                                <option checked value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>

                        </td>

                    </tr>
                </table>
                <br>
                
                <div class="button-allign" style="text-align: center";>
                    <input type="submit" class="button" name="submit" value="Add">
                    <input type="button" class="button" value="Clear" onclick="clearFunction()">
                </div>
            </form>

        </div>



        <script>
            function clearFunction() {
                document.getElementById("addFinance").reset();
            }
        </script>





        <form action="">
            <table class="red_table">
                <tr>
                    <th width="10%">Order ID</th>
                   <!-- <th>Customer Name</th>-->
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Income/ Expense</th>
                    <th width="25%">Purpose Note</th>
                   
                </tr>
                <?php
                if (!empty($data['details'])) {
                    $x = count($data['details']);
                    for ($i = 0; $i < $x; $i++) {
                ?>

                        <tr>
                            <td><?php echo $data['details'][$i]->orderID; ?></td>
                           <!-- <td><?php echo $data['financeCusName'][$i]->name; ?></td> -->
                            <td><?php echo $data['details'][$i]->financeDate ?></td>
                            <td>LKR. <?php echo $data['details'][$i]->financeAmount ?></td>
                            <td><?php echo $data['details'][$i]->financeType; ?></td>
                            <td><?php echo $data['details'][$i]->financePurpose; ?> <br>
                                <?php echo $data['details'][$i]->otherFinancePurpose; ?>
                            </td>
                            

                        </tr>
                    <?php
                    }
                } else { ?>
                    <tr>
                        <td colspan="5">No Financial records</td>
                    </tr>
                <?php
                }
                ?>

            </table>

        </form>
    </div>
</body>

</html>