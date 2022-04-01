<?php 
    if(checksession()){
        header('location:'.URLROOT.'/loginpage');
    }?>


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
        <div class="sidenavigation brownbox"  style="margin-top:50px">
            <?php include 'includes/managersidenav.php' ?>
        </div>
        <div class="content brownbox"  style="margin-top:50px">
            <!--search form-->
            <input type="text" id="fromDateReport" name="searchvalue"  onkeyup="myFunction()" placeholder="Search by customer name" style="height: 40px;width:35%; margin-right: 60px;">

        <script>

            function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("fromDateReport");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1];
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

            <?php if(!empty($data['numberofbookings'])){ ?>
            <table id="myTable"  class="red_table">
                    <thead>
                        <tr>
                            <th>BookingId</th>
                            <th>Customer</th>
                            <th>View Details</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php   $x=count($data['numberofbookings']);
                                for($i=0;$i<$x;$i++){?>
                            <tr>
                                <td><?php echo $data['numberofbookings'][$i]->booking_id; ?></td>
                                <td><?php echo $data['numberofbookings'][$i]->name; ?></td>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/managerbookings/fetchbookingdetails" method="POST">
                                        <input type="textbox" hidden name="id" value="<?php echo $data['numberofbookings'][$i]->booking_id ; ?>">
                                        <button type="submit" name="view_details">View details</button>
                                    </form>
                                </td>
                        
                            </tr>
                        <?php } ?>
                    </tbody>
                    
            </table>
            <?php } ?>
        </div>
    </div>

   


</body style="padding-bottom: 0">

</html>