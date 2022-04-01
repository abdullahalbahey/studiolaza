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
        /* search bar styling */

        * {
  box-sizing: border-box;
}

#search_input {
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myUL {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li  {
    width:100%;
  border: 1px solid #ddd;
  margin-top: -1px; /* Prevent double borders */
  background-color: maroon;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  color: white;
  display: block;
}

#myUL li:hover:not(.header) {
  background-color: #eee;
}

    </style>

</head>

<body class="brownbox">
    <div class="header">
        <?php include 'includes/header.php' ?>
    </div>


    <div class="middle_1">
        <div class="sidenavigation brownbox">
            <?php include 'includes/adminsidenav.php' ?>
        </div>
        <div class="content brownbox">
            <h1>Add Thankingcard</h1>
            <form class="" action="<?php echo URLROOT; ?>/adminthankingcard/add" method="post" enctype="multipart/form-data">
              <h4>Add New</h4>
                <label>Name</label>
                <input type="text" name="name" value="<?php if(empty($data['error']['nameerror'])){echo $_SESSION['t_name']; } ?>"><br>
                <span class="errormessage">
                        <?php 
                        if(!empty($data['error'])){
                            echo $data['error']['nameerror'];
                        }?> 
                </span><br>
                <label><b>Thankingcard description:</b></label> <br><br>
                <textarea  name="description" style="width:30%;height:150px"> <?php if(empty($data['error']['descriptionerror'])){echo $_SESSION['t_description']; } ?></textarea><br>
                <span class="errormessage">
                        <?php 
                        if(!empty($data['error'])){
                            echo $data['error']['descriptionerror'];
                        }?> 
                </span><br>
                <br><br>
                <div class="labelbox">
                    <label for="profile_pic"><b>Choose Image</b></label>
                    <input type="file" id="profile_pic"  name="image" >
                </div>
                 
               
                <span class="errormessage">
                    <?php echo $data["imageerror"];?> 
                </span><br><br>

                <div style="text-align:center;">
                        <button class="button" type="submit" name="add"> Add </button>
                </div>
              
            </form>
            <!--search-->                

                <input type="text" id="search_input" name="searchvalue" onkeyup="myFunction()" value="" placeholder="Search using thanking card name"><br>
            <script>
                function myFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("search_input");
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
            <?php 
                if(!empty($data['thankingcarddetails'])){ ?>

            <table class="red_table" id="myTable">
                    <thead>
                        <tr>
                           
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Update</th>
                            <th>Delete</th>         
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                                $x=count($data['thankingcarddetails']);
                                for($i=0;$i<$x;$i++){

                        ?>
                        <tr>
                        
                        <td><img src="<?php echo URLROOT."/".$data['thankingcarddetails'][$i]->image; ?>" style="width:300px;height:300px"></td>
                        <td><?php echo $data['thankingcarddetails'][$i]->name ?></td>
                        <td><?php echo $data['thankingcarddetails'][$i]->description ?></td>
                        <form action="<?php echo URLROOT; ?>/adminthankingcard/update" method="POST">
                        <input type="textbox" hidden name="id" value="<?php echo $data['thankingcarddetails'][$i]->thankingcard_id ; ?>">
                        <td><button type="submit" name="update">Update</button></a></td>
                        <td><button type="delete" name="delete">Delete</button></a></td>
                        </form>
                        </tr>            
                        <?php
                            } ?> 
                    
                    </tbody>
            </table>
            <?php } ?>
        </div>
    </div>

    <div class="footer">
        <?php include 'includes/footer.php' ?>
    </div>




</body>

</html>
