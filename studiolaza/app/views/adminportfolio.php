<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>




<?php
if (checksession()) {
    header('location:' . URLROOT . '/loginpage');
} ?>

<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/updatedstyle.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/register.css">
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
            text-align: center;
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

        .label {
            color: white;
        }
    </style>

</head>
<body class="" style="flex-direction: column; margin-bottom:-50px">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="signupFrm ">
            <h2>ADD NEW PORTFOLIO ALBUM</h2>
            <form action="<?php echo URLROOT ?>/adminportfolio/add_new" method="POST" style="width:80%">
                <div class="inputContainer">
                    <input class="input" type="text" name="name">
                    <label class="label">Name</label>
                    <span class="errormessage">
                        <?php echo $data["error"]; ?>
                    </span>

                </div>

                <div style="text-align:center;">
                    <button class="submitBtn" type="submit" name="add"> Add </button>
                </div>

            </form>
            <!--search form-->  
            <hr style="background-color:#890000">
            
            <h3 style="text-align:center">SEARCH PORTFOLIO ALBUM</h3>    
            <div class="inputContainer">
                        
                        <input type="text" class="input" id="fromDateReport" onkeyup="myFunction()" name="searchvalue" value="" placeholder="Search by name">
                        <label class="label" for="fromDateReport"><b>Search</b></label>
                </div>

                <script>

            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("fromDateReport");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    }       
                }
            }
        </script>
           
            <?php if (!empty($data['details'])) { ?>
            <table class="red_table" id="myTable">
                <thead>
                    <tr>
                        
                        <th>Name</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                        $x = count($data['details']);
                        for ($i = 0; $i < $x; $i++) { ?>
                            <tr>
                        
                                <td><?php echo $data['details'][$i]->name; ?></td>
                                <form action="<?php echo URLROOT; ?>/adminportfolio/show_pics" method="POST" ?>
                                    <input type="hidden" name="id" value="<?php echo $data['details'][$i]->portfolio_id; ?>">
                                    <input type="hidden" name="name" value="<?php echo $data['details'][$i]->name; ?>">
                                    <td><button type="submit">Update</button></td>
                                    <td><button type="submit" name="delete">Delete</button></td>
                                </form>
                            </tr>
                    <?php
                        }
                    
                    ?>

                </tbody>

            </table>
            <?php } ?>

        </div>
    </div>

</body>

</html>