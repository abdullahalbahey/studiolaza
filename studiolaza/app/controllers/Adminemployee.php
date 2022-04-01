<?php
class Adminemployee extends Controller {
    public function __construct(){
        $this->usermodel = $this->model('User');
        $this->employeemodel = $this->model('Employee');
    }

    public function errormake(){
        $error=[
            "nameerror"=>"",
            "nicerror"=>"",
            "usernameerror"=>"",
            "passworderror"=>"",
            "conf_passworderror"=>"",
            "emailerror"=>"",
            "line1error"=>"",
            "cityerror"=>"",
            "contacterror"=>"",
            "roleerror"=>"",
            "emptypeerror"=>""
        ];

        return $error;
    }

    public function index() {
        $data = $this->errormake();
        $_SESSION['username']="";
        $_SESSION['email']="";
        $_SESSION['name_1']="";
        $_SESSION['nic']="";
        $_SESSION['line1']="";
        $_SESSION['city']="";
        $_SESSION['contact']="";

       $this->view('adminemployeecrud',$data);  
   }

    public function addemployee(){

        $data=$this->errormake();
        //for error checking
        if(!isset($_POST['role'])){
            $_POST['role']="";
        }
        if(!isset($_POST['emptype'])){
            $_POST['emptype']="";
        }
        $errorchecklist=[
            "username"=>trim($_POST['username']),
            "password"=>trim($_POST['password']),
            "email"=>trim($_POST['email']),  
            "name"=>trim($_POST['name']),
            "nic"=>trim($_POST['nic']),
            "line1"=>trim($_POST['line1']),
            "city"=>trim($_POST['city']),
            "contact"=>trim($_POST['contact']),
            "role"=>$_POST['role'],
            "emptype"=>$_POST['emptype'] 
            ];

            $_SESSION['username']=$errorchecklist['username'];
            $_SESSION['email']=$errorchecklist['email'];
            $_SESSION['name_1']=$errorchecklist['name'];
            $_SESSION['nic']=$errorchecklist['nic'];
            $_SESSION['line1']=$errorchecklist['line1'];
            $_SESSION['city']=$errorchecklist['city'];
            $_SESSION['contact']=$errorchecklist['contact'];
        

        if(empty($errorchecklist['username'])){
            $data["usernameerror"]="Please enter username";
        }else{
            $usernamecheck=[
                "username"=>$errorchecklist['username']
            ];
            if($this->usermodel->checkusername($usernamecheck)){
                $data["usernameerror"]="Username already exists";
            }
        }
    
        if(empty($errorchecklist['password'])){
            $data['passworderror']='Please enter password';
        }else{
            if(strlen(trim($_POST['password']))<8 || strlen(trim($_POST['password']))>40){
                $data['passworderror']='Password must be between 8-40 characters long';
            }
        }
    
        if((trim($_POST['conf_password']))==""){
            $data["conf_passworderror"]="Please enter password";
        }else{
           if($errorchecklist['password']!=trim($_POST['conf_password'])){
                $data['conf_passworderror']="Passwords mismatch";
            }
        }
    
        if(empty($errorchecklist['email'])){
            $data["emailerror"]="Please enter email";
        }else{
            $emailcheck=[
                "email"=>$errorchecklist['email']
            ];
            if($this->usermodel->checkemail($emailcheck)){
                $data["emailerror"]="Email already exists";
            }
        }

        if(empty($errorchecklist['name'])){
            $data['nameerror']='Please enter name';
        }
        if(empty($errorchecklist['nic'])){
            $data['nicerror']='Please enter nic';
        }
        if(empty($errorchecklist['line1'])){
            $data['line1error']='Please enter Address';
        }
        if(empty($errorchecklist['city'])){
            $data['cityerror']='Please enter City';
        }
        if(empty($errorchecklist['contact'])){
            $data['contacterror']='Please enter Contact';
        }
        if(empty($errorchecklist['role'])){
            $data['roleerror']='Please select role';
        }else{
            $concatenaterole=implode(",",$_POST["role"]);
        }

        if(empty($errorchecklist['emptype'])){
            $data['emptypeerror']='Please select type';
        }


        if(empty($data['usernameerror']) && empty($data['passworderror']) && empty($data['conf_passworderror']) && empty($data['emailerror']) && empty($data['nameerror']) && empty($data['nicerror']) && empty($data['line1error'])&& empty($data['cityerror']) && empty($data['contacterror']) && empty($data['roleerror']) && empty($data['emptypeerror'])){
            

            $allowedtypes[]="image/jpeg";
            $allowedtypes[]="image/png";
            $allowedtypes[]="image/jpg";

            $uploadedimage="";
            if($_FILES['image']['name']!="" && $_FILES['image']['error']==0 && in_array($_FILES['image']['type'],$allowedtypes)){
            
                $uploadedimage="img/".$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],$uploadedimage);
            }

            $x=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
            $userdata=[
                "username"=>trim($_POST['username']),
                "password"=>$x,
                "type"=>"E",
                "email"=>trim($_POST['email']),
                "image"=>$uploadedimage     
                 ];

            if($this->usermodel->registeruser($userdata)){

                $checkid=[
                    "username"=>trim($_POST['username'])
                ];
                $userid=$this->usermodel->fetchid($checkid);

            }

            $employeedata=[
                "name"=>trim($_POST['name']),
                "nic"=>trim($_POST['nic']),
                "line1"=>trim($_POST['line1']),
                "city"=>trim($_POST['city']),
                "contact"=>trim($_POST['contact']),
                "date"=>date('y-m-d'),
                "role"=>$concatenaterole,
                "emptype"=>$_POST['emptype'], 
                "user_id"=>$userid[0]->user_id,
            ];
            if($this->usermodel->registeremployee($employeedata)){
                unset($_SESSION['username']);
                unset($_SESSION['name_1']);
                unset($_SESSION['nic']);
                unset($_SESSION['contact']);
                unset($_SESSION['line1']);
                unset($_SESSION['city']);
                unset($_SESSION['email']);       
                echo "<script>window.alert('Employee added')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/adminemployee'</script>";
            }else{
                echo "<script>window.alert('Employee not added')</script>";
                
            }
            

        }else{
            echo "<script>window.alert('Something went wrong')</script>";
            

        }
     
        $this->view('adminemployeecrud',$data);
    
    }

    public function updateemployee(){
        $empdetails=$this->employeemodel->fetchempdetailforadmin();
        $data['details']="";
        if($empdetails){
            $data['details']=$empdetails;
        }
        
        
        $this->view('adminemployeeview',$data);
       

        
    }

    public function updatedetails(){
        $data['roleerror']="";
        $data['emptypeerror']="";
        if(isset($_POST['id'])){
            $_SESSION['employee_update_id']=$_POST['id'];
             
        }   
        $fetchdetails=[
            "employee_id"=>$_SESSION['employee_update_id']
        ]; 
        
        $getdetails=$this->employeemodel->fetchempdetailforadmintoupdate($fetchdetails);
        
        
        $data["id"]=$getdetails[0]->employee_id;
        $data["name"]=$getdetails[0]->name;
        $data["roles"]=$getdetails[0]->roles;
        $data["type"]=$getdetails[0]->emptype;

        if(isset($_POST['update'])){
            if(empty($_POST['role'])){
                $data['roleerror']='Please select role';
            }else{
                $concatenaterole=implode(",",$_POST["role"]);
            }

            if(empty($_POST['emptype'])){
                $data['emptypeerror']='Please select type';
            }
            if(empty($data['roleerror']) && empty($data['emptypeerror'])){
                echo "hello";
                $employee_data=[
                    "role"=>$concatenaterole,
                    "emptype"=>$_POST['emptype'],
                    "employee_id"=>$_SESSION['employee_update_id']
                ];
    
                if($this->employeemodel->update_employee_admin($employee_data)){
                    unset($_SESSION['employee_update_id']);
                    echo "<script>window.alert('Update successful')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/adminemployee/updateemployee'</script>";
                }
            }          
        }
        $this->view('adminemployeeupdate',$data);
        
    }

    
}