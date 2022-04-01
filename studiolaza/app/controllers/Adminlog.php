<?php
class Adminlog extends Controller {
    public function __construct() {
        $this->logsmodel=$this->model('Logs');
    }

    public function index() {      
        header('location:'.URLROOT.'/adminlog/view_logs');
    }

    public function view_logs(){
        $data['details']="";
        if(isset($_POST['submit'])){
            $x=[
                'date1'=>$_POST['date1'],
                'date2'=>$_POST['date2']
            ];
            
            $data['details']=$this->logsmodel->fetch_logs($x);
            $data['count']=$this->logsmodel->fetch_count($x);
            
            
        }
        
        $this->view('adminlogview',$data);
    }

    
}
