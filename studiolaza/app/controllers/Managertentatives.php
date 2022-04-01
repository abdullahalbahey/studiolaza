<?php
class Managertentatives extends Controller {
    public function __construct() {
        $this->bookingmodel = $this->model('Booking');
        $this->financeModel = $this->model('Finance');;
    }

    public function index(){
        
        header('location:'.URLROOT.'/Managertentatives/tentative');
    }

    public function tentative() {
        $data['tentatives']="";
        $x=$this->bookingmodel->fetch_tentatives();
        if($x){
            $data['tentatives']=$x;
        }
        
        if(isset($_POST['update'])){
            $booking_id['bookingid']=$_POST['id'];
            $booking_details=$this->bookingmodel->fetchbooking($booking_id);
            $balance=$booking_details[0]->price-25000;
            $price=[
                'status'=>1,
                'balance'=>25000,
                'booking_id'=>$_POST['id']
            ];
            
            if($this->bookingmodel->confirm_booking($price)){
                $financedata = [
                    "searchorder_fin" => $_POST['id'],
                    "financePurpose" => 'Advance Payment',
                    "otherfinancePurpose" =>'',
                    "financeDate" => date('Y-m-d'),
                    "financeAmount" => 25000,
                    "financeType" => 'income'
                ];
                if ($this->financeModel->addfinance($financedata)) { 
                    $progress=[
                        'progress'=>0,
                        'booking_id'=>$_POST['id']
                    ];
                    $a=$this->bookingmodel->update_progress_wedding($progress);
        
                    
                    if($this->bookingmodel->fetchpreshootdetails($booking_id)){
                        $b=$this->bookingmodel->update_progress_preshoot($progress);
                    }
                    if($this->bookingmodel->fetchengagementdetails($booking_id)){
                        $c=$this->bookingmodel->update_progress_engagement($progress);
                    }
                    if($this->bookingmodel->fetchhomecomingdetails($booking_id)){
                        $d=$this->bookingmodel->update_progress_homecoming($progress);
                    }
                    echo "<script>window.alert('Tentaive booking confirmed')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/managertentatives'</script>";
                }
            }
        }
        if(isset($_POST['delete'])){
            $booking_id['booking_id']=$_POST['id'];
            if($this->bookingmodel->delete_booking($booking_id)){
                echo "<script>window.alert('Tentative booking deleted')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managertentatives'</script>";
            }
        }
        $this->view('m_tentatives', $data);  
    }

    
}
