<?php

class Registrationpage extends Controller{
    
    public function __construct(){
        require "../app/Mailserver/Mail.php";
        $this->usermodel = $this->model('User');
        $this->customermodel=$this->model('Customer');
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
            "contacterror"=>""
        ];

        return $error;
    }

    public function index(){
        $data = $this->errormake();
        $_SESSION['username']="";
        $_SESSION['email']="";
        $_SESSION['name_1']="";
        $_SESSION['nic']="";
        $_SESSION['line1']="";
        $_SESSION['city']="";
        $_SESSION['contact']="";

        
    
        $this->view('registration', $data); 
        

    }

    public function register(){
        $data=$this->errormake();
        //for error checking
        $errorchecklist=[
            "username"=>trim($_POST['username']),
            "password"=>trim($_POST['password']),
            "email"=>trim($_POST['email']),  
            "name"=>trim($_POST['name']),
            "nic"=>trim($_POST['nic']),
            "line1"=>trim($_POST['line1']),
            "city"=>trim($_POST['city']),
            "contact"=>trim($_POST['contact']), 
            ];

            $_SESSION['username']=$errorchecklist['username'];
            $_SESSION['email']=$errorchecklist['email'];
            $_SESSION['name_1']=$errorchecklist['name'];
            $_SESSION['nic']=$errorchecklist['nic'];
            $_SESSION['line1']=$errorchecklist['line1'];
            $_SESSION['city']=$errorchecklist['city'];
            $_SESSION['contact']=$errorchecklist['contact'];

        if(empty($errorchecklist['username'])){
            $data['usernameerror']="Please enter username";
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
            $data["conf_passworderror"]="Please Re enter password";
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


        if(empty($data['usernameerror']) && empty($data['passworderror']) && empty($data['conf_passworderror']) && empty($data['emailerror']) && empty($data['nameerror']) && empty($data['nicerror']) && empty($data['line1error'])&& empty($data['cityerror']) && empty($data['contacterror'])){
            

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
                "type"=>"C",
                "email"=>trim($_POST['email']),
                "image"=>$uploadedimage     
                 ];
                 
            if($this->usermodel->registeruser($userdata)){
                $checkid=[
                    "username"=>trim($_POST['username'])
                ];
                $userid=$this->usermodel->fetchid($checkid);
            }

            $customerdata=[
                "name"=>trim($_POST['name']),
                "nic"=>trim($_POST['nic']),
                "line1"=>trim($_POST['line1']),
                "city"=>trim($_POST['city']),
                "contact"=>trim($_POST['contact']),
                "v_status"=>0,
                "user_id"=>$userid[0]->user_id
            ];
            if($this->usermodel->registercustomer($customerdata)){
                $link=URLROOT."/customerbooking/verifymail?mail_id=".$userid[0]->user_id;
                $receivermail=$userid[0]->email;
                $subject="Email verification link ";
                $body="<p>Hello there".$_SESSION['name_1']."! Use the link below to verify your email </p>
                <a href=".$link.">Click here to verify your email</a>";
                if(sendMail($receivermail,$subject,$body)){//email function call
                    unset($_SESSION['username']);
                    unset($_SESSION['name_1']);
                    unset($_SESSION['nic']);
                    unset($_SESSION['contact']);
                    unset($_SESSION['line1']);
                    unset($_SESSION['city']);
                    unset($_SESSION['email']);
                    
                    echo "<script>window.alert('Registrations Success! Please verify your email through the link sent.')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/loginpage'</script>";
                }
                
            }else{
                echo "<script>window.alert('Could not register')</script>";
                
            }
            

        }else{
            echo "<script>window.alert('Something went wrong ')</script>";
                

        }
     
        $this->view("registration", $data);
    }

}
