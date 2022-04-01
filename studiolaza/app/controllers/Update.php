<?php
class Update extends Controller {
    
    public function __construct() {
        $this->usermodel = $this->model('User');
        $this->customermodel=$this->model('Customer');
    }

    public function errormake(){
        $error=[
            "nameerror"=>"",
            "nicerror"=>"",
            "emailerror"=>"",
            "line1error"=>"",
            "cityerror"=>"",
            "contacterror"=>"",
            "name"=>"",
            "nic"=>"",
            "email"=>"",
            "line1"=>"",
            "city"=>"",
            "contact"=>""

        ];

        return $error;
    }
    public function passworderrormake(){
        $error=[
            "passworderror"=>"",
            "newpassworderror"=>"",
            "conf_passworderror"=>""
        ];

        return $error;
    }

    public function index() {
        if($_SESSION['type']=="E" || $_SESSION['type']=="C"){
            header('location:'.URLROOT.'/update/update');
        }else{
            header('location:'.URLROOT.'/update/update_manager_admin'); 
        }
    }

    public function getdetails(){//getting details of employee/customer
        $fetchdetails=[
            "io"=>$_SESSION['id']
        ];     
        if($_SESSION['type']=="C"){
            return $this->usermodel->fetchcustomerdetails($fetchdetails);
        }
        if($_SESSION['type']=="E"){
            return $this->usermodel->fetchemployeedetails($fetchdetails);
        }
        if($_SESSION['type']=="M" || $_SESSION['type']=="A"){
            return $this->usermodel->fetchuserdetails($fetchdetails);
        }
    }

    public function getpassword(){
        $fetchpassword=[
            "io"=>$_SESSION['id']
        ];     
        
        return $this->usermodel->fetchpassword($fetchpassword);
    }

    public function update(){

        $data=$this->errormake();
        
        $getdetails=$this->getdetails();//feeding details to view

        $data["name"]=$getdetails[0]->name;
        $data["nic"]=$getdetails[0]->nic;
        $data["username"]=$getdetails[0]->username;
        $data["email"]=$getdetails[0]->email;
        $data["line1"]=$getdetails[0]->line1;
        $data["city"]=$getdetails[0]->city;
        $data["contact"]=$getdetails[0]->contact;

        if(isset($_POST['submit'])){
            
        $errorchecklist=[
            "email"=>trim($_POST['email']),  
            "name"=>trim($_POST['name']),
            "nic"=>trim($_POST['nic']),
            "line1"=>trim($_POST['line1']),
            "city"=>trim($_POST['city']),
            "contact"=>trim($_POST['contact']), 
            ];
 
        if(empty($errorchecklist['email'])){
            $data["emailerror"]="Please enter email";
        }else{
            if($errorchecklist['email']!=$data["email"]){
                $emailcheck=[
                    "email"=>$errorchecklist['email']
                ];
                if($this->usermodel->checkemail($emailcheck)){
                    $data["emailerror"]="Email already exists";
                }
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


        if(empty($data['emailerror']) && empty($data['nameerror']) && empty($data['nicerror']) && empty($data['line1error'])&& empty($data['cityerror']) && empty($data['contacterror'])){

        $allowedtypes[]="image/jpeg";
        $allowedtypes[]="image/png";
        $allowedtypes[]="image/jpg";

        $uploadedimage=$getdetails[0]->image;
        if($_FILES['image']['name']!="" && $_FILES['image']['error']==0 && in_array($_FILES['image']['type'],$allowedtypes)){
            unlink($uploadedimage);//deleting old image
            $uploadedimage="img/".$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],$uploadedimage);//uploading new image
        }
        if(isset($_POST['remove_image'])){
            unlink($uploadedimage);//deleting old image
            $uploadedimage=NULL;
        }
        $userdata=[
            "email"=>trim($_POST['email']),
            "image"=>$uploadedimage,
            "user_id"=>$getdetails[0]->user_id     
            ];
                 
            if($this->usermodel->updateuser($userdata)){
                $userdata=[
                    "name"=>trim($_POST['name']),
                    "nic"=>trim($_POST['nic']),
                    "line1"=>trim($_POST['line1']),
                    "city"=>trim($_POST['city']),
                    "contact"=>trim($_POST['contact']),
                    "user_id"=>$getdetails[0]->user_id
                ];
                if($_SESSION['type']=="C"){
                    if($this->usermodel->updatecustomer($userdata)){
                        echo "<script>window.alert('Profile updated')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/update'</script>";
                        
                    }else{
                        echo "could not update";
                     }
                }
                if($_SESSION['type']=="E"){
                    if($this->usermodel->updateemployee($userdata)){
                        echo "<script>window.alert('Profile updated')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/update'</script>";
                        
                    }else{
                        echo "<script>window.alert('Could not update')</script>";
                    
                    }
                }
            }
        }else{
            echo "<script>window.alert('Something went wrong')</script>";
            

        }
    }
        

        $user=[
            "username"=>$data["username"]
        ];
        $detail=$this->usermodel->login($user);
        $_SESSION["image"]=$detail[0]->image;  
        
        $this->view("update", $data);


    }

    public function update_manager_admin(){
        $data=$this->errormake();
        
        $getdetails=$this->getdetails();//feeding details to view
        
        $data["username"]=$getdetails[0]->username;
        $data["email"]=$getdetails[0]->email;

        if(isset($_POST['submit'])){
            
            $errorchecklist=[
                "email"=>trim($_POST['email']),  
               ];
            if(empty($errorchecklist['email'])){
                $data["emailerror"]="Please enter email";
            }else{
                if($errorchecklist['email']!=$data["email"]){
                    $emailcheck=[
                        "email"=>$errorchecklist['email']
                    ];
                    if($this->usermodel->checkemail($emailcheck)){
                        $data["emailerror"]="Email already exists";
                    }
                }
                
            }

            if(empty($data['emailerror'])){

                $allowedtypes[]="image/jpeg";
                $allowedtypes[]="image/png";
                $allowedtypes[]="image/jpg";
        
                $uploadedimage=$getdetails[0]->image;
                if($_FILES['image']['name']!="" && $_FILES['image']['error']==0 && in_array($_FILES['image']['type'],$allowedtypes)){
                    unlink($uploadedimage);//deleting old image
                    $uploadedimage="img/".$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'],$uploadedimage);//uploading new image
                }
                if(isset($_POST['remove_image'])){
                    unlink($uploadedimage);//deleting old image
                    $uploadedimage=NULL;
                }
                $userdata=[
                    "email"=>trim($_POST['email']),
                    "image"=>$uploadedimage,
                    "user_id"=>$getdetails[0]->user_id     
                    ];
                         
                    if($this->usermodel->updateuser($userdata)){
                        echo "<script>window.alert('Profile updated')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/update'</script>";
                    }else{
                        echo "<script>window.alert('Could not update')</script>";
                    }
                    
            }else{
                echo "<script>window.alert('Something went wrong')</script>";
        
            }
        }
                
        
        $user=[
                "username"=>$data["username"]
            ];
            $detail=$this->usermodel->login($user);
            $_SESSION["image"]=$detail[0]->image; 

        $this->view("update_manager_admin", $data);
    }
    



    public function updatepassword(){
        $data=$this->passworderrormake();
        $getpassword=$this->getpassword();

        if(isset($_POST['submit'])){
            $errorchecklist=[
                "password"=>trim($_POST['password']),
                "newpassword"=>trim($_POST['newpassword']),
                "conf_password"=>trim($_POST['conf_password'])
            ];
           
            
            if(empty($errorchecklist['password'])){
                $data['passworderror']='Please enter current password';
            }
            if(empty($errorchecklist['newpassword'])){
                $data['newpassworderror']='Please enter new password';
            }
            if(empty($errorchecklist['conf_password'])){
                $data['conf_passworderror']='Please re-enter password';
            }
            
            if(password_verify($errorchecklist['password'],$getpassword[0]->password) ){
                if(strlen(trim($errorchecklist['newpassword']))<8 || strlen(trim($errorchecklist['newpassword']))>40){
                    $data['newpassworderror']='Password must be between 8-40 characters long';
                }
                if($errorchecklist['newpassword']!=$errorchecklist['conf_password']){
                    $data['conf_passworderror']="Passwords mismatch";
                }
            }else{
                $data['passworderror']='The entered current password is incorrect';
            }

            if(empty($data['passworderror']) && empty($data['newpassworderror']) && empty($data['conf_passworderror'])){
                $x=password_hash(trim($errorchecklist['newpassword']),PASSWORD_DEFAULT);
                $passworddata=[
                    "io"=>$_SESSION['id'],
                    "newpassword"=>$x
                ];
                if($this->usermodel->updatepassword($passworddata)){
                    echo "<script>window.alert('Password updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/update'</script>";
                }
            }


            
        }
        $this->view('updatepassword',$data);
        
    }
    
    
}