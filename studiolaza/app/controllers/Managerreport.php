<?php
class Managerreport extends Controller
{
    public function __construct()
    {
        $this->reportModel = $this->model('Report');
    }
    public function index()
    {
        
        
        /*$reportDetails = $this->reportModel->fetch_calendar();*/
        $data["details"]="";
        $this->view('genreport', $data);
    }
    public function goreport(){
        
        $data['details']="";
        if(isset($_POST['submit'])){

           
            $x=[
                'fromDate'=>$_POST['fromDate'],
                'toDate'=>$_POST['toDate']
            ];
            $datedetails['datedetails']= $x['fromDate'];
            $data['details']=$this->reportModel->fetch_calendar($x);
            
        
        }
       
        $this->view('genreport', $data);
    }


}
