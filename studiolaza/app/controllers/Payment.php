<?php
class Payment extends Controller {
    public function __construct() {
        require "../app/Mailserver/Mail.php";
        $this->usermodel = $this->model('User');
        $this->customermodel=$this->model('Customer');
        $this->bookingmodel=$this->model('Booking');
    }

    public function index() {

    }

    public function advancepayment(){
        
        $booking_id['bookingid']=$_GET['bookingid'];
        $user_id['io']=$_GET['userid'];
        
        if($this->bookingmodel->fetchbooking($booking_id)){
            $data['bookingdetails']=$this->bookingmodel->fetchbooking($booking_id);
            $data['customerdetails']=$this->usermodel->fetchcustomerdetails($user_id);
            $this->view('paymentform',$data);
        }else{
            echo "<script>window.alert('Something went wrong')</script>";
                
        }
        
    }

    public function update_payment(){

        $booking_id['bookingid']=$_GET['order_id'];
        $booking_details=$this->bookingmodel->fetchbooking($booking_id);
        $balance=$booking_details[0]->price-25000;
        $price=[
            'status'=>1,
            'balance'=>25000,
            'booking_id'=>$_GET['order_id']
        ];
        
        
        if($this->bookingmodel->confirm_booking($price)){
            $financedata = [
                "searchorder_fin" => $price['booking_id'],
                "financePurpose" => 'Advance Payment',
                "otherfinancePurpose" =>'',
                "financeDate" => date('Y-m-d'),
                "financeAmount" => 25000,
                "financeType" => 'income'
            ];
            if ($this->financeModel->addfinance($financedata)) {
                $progress=[
                    'progress'=>0,
                    'booking_id'=>$_SESSION['bookingid']
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
                
                
                $price_80=$balance*0.8;
    
                $customer_id['customer_id']=$booking_details[0]->customer_id;
                $customer_details=$this->customermodel->fetch_user_id($customer_id);
    
                $user_id['io']=$customer_details[0]->user_id;
                $user_details=$this->usermodel->fetchuserdetails($user_id);
    
                $receivermail=$user_details[0]->email;
                $subject="Confirmation of booking ";
                $body="<p>Hello ".$user_details[0]->username."! Your booking has been confirmed. Please make sure you pay Rs.".$price_80." before the coverage of the event </p>";
                if(sendMail($receivermail,$subject,$body)){
                    echo "<script>window.alert('Booking confirmed')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                }
            }
            

        }
        
    }
    public function cancel_payment(){
        header('location:'.URLROOT.'/customerbooking');
    }

    
}