<?php
class Employeenotes extends Controller {
    public function __construct() {
        $this->notemodel = $this->model('Note');
        $this->employeemodel=$this->model('Employee');
    }

    public function errormake(){
        $error=[
            "noteerror"=>"",
            "notedetails"=>""
        ];

        return $error;
    }

    public function index(){
        $_SESSION['n_description']="";
        
        header('location:'.URLROOT.'/employeenotes/add');  
    }

    public function add(){
        $data=$this->errormake();
        $employee['id']=$_SESSION['id'];
        $employee_id=$this->employeemodel->fetch_employee_id($employee);
        if(isset($_POST['wedding_view'])){
            $_SESSION['event_id']=$_POST['id'];
            $_SESSION['event_type']=1;
        }
        if(isset($_POST['preshoot_view'])){
            $_SESSION['event_id']=$_POST['id'];
            $_SESSION['event_type']=2;
        }
        if(isset($_POST['engagement_view'])){
            $_SESSION['event_id']=$_POST['id'];
            $_SESSION['event_type']=3;
        }
        if(isset($_POST['homecoming_view'])){
            $_SESSION['event_id']=$_POST['id'];
            $_SESSION['event_type']=4;
        }
        
        $allnotes=[
            "event_type"=>$_SESSION['event_type'],
            "event_id"=>$_SESSION['event_id'],
            "employee_id"=>$employee_id[0]->employee_id
        ];
        $notedetails=$this->notemodel->fetch_notes($allnotes);
        $data["notedetails"]=$notedetails;
        
        if(isset($_POST['add'])){
            $_SESSION['n_description']=trim($_POST['note']);
            if(!strlen(trim($_POST['note']))){
                $data['noteerror']="This field can't be empty";
            }else{
                  
                $notedata=[
                    'note'=>$_POST['note'],
                    "date"=>date('Y-m-d'),
                    "time"=>date("H:i:s"),
                    "event_type"=>$_SESSION['event_type'],
                    "event_id"=>$_SESSION['event_id'],
                    "employee_id"=>$employee_id[0]->employee_id
                ];
              
                if($this->notemodel->add_note($notedata)){
                    unset($_SESSION['n_description']);
                    echo "<script>window.alert('Note added')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/employeenotes/add'</script>";  
                }
            }
        }

        
        $this->view('employeenotes',$data);
    }


    public function change(){
        $data=$this->errormake();
        if(isset($_POST['update'])){
            $fetchdetails=[
                "note_id"=>$_POST['id']
            ];     
            
            $getdetails=$this->notemodel->fetchnotedetailtoupdate($fetchdetails);
            
            
            $data["id"]=$getdetails[0]->note_id;
            $data["content"]=$getdetails[0]->content;
            
            

            $this->view('employeenoteupdate',$data);
        }

        if(isset($_POST['delete'])){
            $delete_id['note_id']=$_POST['id'];
            if($this->notemodel->delete_note($delete_id)){
                echo "<script>window.alert('Note deleted')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/employeenotes'</script>";
            }
        }
    }

    public function update(){
        $data=$this->errormake();

        if(!strlen(trim($_POST['note']))){
            $fetchdetails=[
                "note_id"=>$_POST['id']
            ];     
            
            $getdetails=$this->notemodel->fetchnotedetailtoupdate($fetchdetails);
            $data['noteerror']="This field can't be empty";
            $data["content"]="";
            $data["id"]=$getdetails[0]->note_id;
        }else{
              
            $notedata=[
                'note'=>$_POST['note'],
                'note_id'=>$_POST['id']
            ];
          
            if($this->notemodel->update_note($notedata)){

                echo "<script>window.alert('Note updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/employeenotes'</script>";  
            }
        }
        $this->view('employeenoteupdate',$data);
    }
}