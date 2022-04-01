<?php
class Forgotpassword extends Controller {
    public function __construct() {
        require "../app/Mailserver/Mail.php";//email function required...
        $this->usermodel = $this->model('User');
        $this->forgetpasswordmodel = $this->model('Forgetpassword');
    }

    public function index() {
        header('location:' . URLROOT . '/forgotpassword/emailerrormake');
             
    }
    public function errormake()
    {
        $error = [
            "emailerror"=>"",
            
        ];
        return $error;
    }

    public function emailerrormake(){
        $data = $this->errormake();

        if (isset($_POST['submit'])) {
            $resetpwemailv = [
                "email" => trim($_POST['email'])
            ];
            if (empty($resetpwemailv['resetpwemail'])) {
                $data['emailerror'] = 'Please enter your username or email address to send the reset link!';
            }
            $detail=$this->forgetpasswordmodel->check_email_username($resetpwemailv);
            if($detail){
                if($this->makeemail($detail)){
                    $data['emailerror'] = 'An email has been sent for you to reset password.Note that the link will only work for 30 minutes';
           
                }
            }
            
           

        }
        $this->view('forgotpassword', $data);
    }

    public function makeemail($detail){
        $token=mt_rand(1000000000000000,9999999999999999);
        $timecheck=date("U")+1800;
        $resetlink=URLROOT."/forgotpassword/resetpassword?token=".$token."&request_no=".$timecheck;
        $resetdata=[
            "email"=>$detail[0]->email,
            "token"=>$token,
            "timecheck"=>$timecheck
        ];
        if($this->forgetpasswordmodel->addrequest($resetdata)){

            $receivermail=$detail[0]->email;
            $subject="Password recovery link ";
            $body="<p>Hello ".$detail[0]->username."! We have got a password reset request for your account.Below is the link, </p>
            <a href=".$resetlink.">Reset password link</a>";
            if(sendMail($receivermail,$subject,$body)){//email function call
                return true;
            }
        }
        
        
    }

    public function resetpassword(){
        $data['passworderror']="";
        $data['conf_passworderror']="";
        $timecheck=date("U");
        $forgotpassword=[
            "token"=>$_GET['token'],
            "timecheck1"=>$_GET['request_no'],
            "timecheck2"=>$timecheck,
        ];
        $forgotdetails=$this->forgetpasswordmodel->checktoken($forgotpassword);
        if($forgotdetails){
            
            $_SESSION['emailforp']=$forgotdetails[0]->email;
            $this->view('resetpassword',$data);
        }else{
            echo "<script>window.alert('Time limit exceeded')</script>";
            
        }
    }

    public function setpassword(){
        
        $data['passworderror']="";
        $data['conf_passworderror']="";
        
        if(isset($_POST['update'])){
            
            if(empty($_POST['password'])){
                $data['passworderror']='Please enter password';
            }else{
                if(strlen(trim($_POST['password']))<8 || strlen(trim($_POST['password']))>40){
                    $data['passworderror']='Password must be between 8-40 characters long';
                }
            }

            if((trim($_POST['conf_password']))==""){
                $data["conf_passworderror"]="Please Re enter password";
            }else{
                if($_POST['password']!=trim($_POST['conf_password'])){
                    $data['conf_passworderror']="Passwords mismatch";
                }
            }
            if(empty($data['passworderror']) && empty($data['conf_passworderror'])){
                $x=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
                $updatepassword=[
                    "password"=>$x,
                    "email"=>$_SESSION['emailforp']
                ];
                if($this->forgetpasswordmodel->updatepassword($updatepassword)){
                    unset($_SESSION['emailforp']);
                    echo "<script>window.alert('Password updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/loginpage'</script>";
                }
            }
        }

        $this->view('resetpassword',$data);
    
    }
}