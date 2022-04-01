<?php

class Loginpage extends Controller
{
    public function __construct()
    {
        $this->usermodel = $this->model('User');
        $this->logsmodel=$this->model('Logs');
    }


    public function errormake()
    {
        $error = [
            "usernameerror" => "",
            "passworderror" => "",
            "mainerror" => ""
        ];
        return $error;
    }

    //index ekak oneth na kelinma login ekenma view eka denna puluwang but nikan tiyanawa (puduma amaruwa...)
    public function index()
    {
        $data = $this->errormake();
        $_SESSION['username']="";
        $this->view('login', $data);
    }

    public function login()
    {
        $data = $this->errormake();
        $user = [
            "username" => trim($_POST['username']),
            "password" => trim($_POST['password'])
        ];
        if (empty($user['username'])) {
            $data['usernameerror'] = 'Please enter username';
        }

        if (empty($user['password'])) {
            $data['passworderror'] = 'Please enter password';
        }
        $_SESSION['username']=$user['username'];

        if (empty($data['usernameerror']) && empty($data['passworderror'])) {
            $username['username']=trim($_POST['username']);
            $detail=$this->usermodel->login($username);
            if($detail){
                if(password_verify(trim($_POST['password']),$detail[0]->password)){
                    unset($_SESSION['username']);
                    $_SESSION["id"] = $detail[0]->user_id;
                    $_SESSION["name"] = $detail[0]->username;
                    $_SESSION["image"] = $detail[0]->image;
                    $_SESSION["type"]=$detail[0]->type;
    
                    //Array x will sent the data to the logs table to keep login records
                    $x=[
                        "username"=>$detail[0]->username,
                        "type"=>$detail[0]->type,
                        "date"=>date('Y-m-d'),
                        "time"=>date("H:i:s")
                    ];
                    $k=$this->logsmodel->add_login_data($x); //Adding to logs table in database 
                    
    
                    if ($detail[0]->type == "C") {
                        echo "<script>window.alert('Login successful')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                    } elseif ($detail[0]->type == "M") {
                        echo "<script>window.alert('Login successful')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings'</script>";
                    } elseif ($detail[0]->type == "A") {
                        echo "<script>window.alert('Login successful')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/adminemployee'</script>";
                    } elseif ($detail[0]->type == "E") {
                        echo "<script>window.alert('Login successful')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/employeebooking'</script>";
                    }
                }else {
                    $data['mainerror'] = 'Invalid signin credentials';
                    $this->view("login", $data);
                }
            }else{
                $data['mainerror'] = 'Invalid signin credentials';
                $this->view("login", $data);
            }
            
            }else{
                    $this->view("login", $data);
                }
            
        
    }

    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        session_destroy();
        header('location:' . URLROOT . '/loginpage');
    }
}
