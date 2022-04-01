<?php
class Reschedule extends Controller {
    
    public function __construct() {
        $this->bookingmodel = $this->model('Booking');
    }
    public function index(){
        $booked_dates=$this->bookingmodel->fetch_booked_dates();
        if($booked_dates){
            $count=count($booked_dates);
            for($i=0;$i<$count;$i++){
                $_SESSION['dates'][$i]=$booked_dates[$i]->date;
            }
        }
        $_SESSION['booking_id_l']=$_POST['id'];
        $_SESSION['event_type_to_update']=$_POST['type'];
        if(isset($_POST['update'])){
            $this->view('update_date');
        }
        if(isset($_POST['cancel'])){
            $booking['bookingid']=$_SESSION['booking_id_l'];

            
            $booking_details=$this->bookingmodel->fetchbooking($booking);

            $booking_status['status']=1;
            $booking_status['booking_id']=$_SESSION['booking_id_l'];
            $wedding_details=$this->bookingmodel->fetchweddingdetails($booking);
            $preshoot_details=$this->bookingmodel->fetchpreshootdetails($booking);
            $engagement_details=$this->bookingmodel->fetchengagementdetails($booking);
            $homecoming_details=$this->bookingmodel->fetchhomecomingdetails($booking);

            if($_SESSION['event_type_to_update']=='wedding'){
                $booking_status['status']=3;
                $price['price']=0;
                $price['booking_id']=$_SESSION['booking_id_l'];
                $y=$this->bookingmodel->update_price($price);

                if($this->bookingmodel->cancel_wedding($booking)){
                    if($preshoot_details){
                        $x=$this->bookingmodel->cancel_preshoot($booking);
                    }
                    if($engagement_details){
                        $y=$this->bookingmodel->cancel_engagement($booking);
                    }
                    if($homecoming_details){
                        $z=$this->bookingmodel->cancel_homecoming($booking);
                    }
                    if($this->bookingmodel->update_booking_cancel($booking_status)){
                        echo "<script>window.alert('Booking cancelled. Please note advance won't be repaid.')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                    }
                }
            }

            if($_SESSION['event_type_to_update']=='preshoot'){
                if($this->bookingmodel->cancel_preshoot($booking)){
                    $price['price']=$booking_details[0]->price-$preshoot_details[0]->price;
                    $price['booking_id']=$_SESSION['booking_id_l'];
                    $y=$this->bookingmodel->update_price($price);
                    if($y){
                        echo "<script>window.alert('Preshoot cancelled.')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                    }
                }
            }

            if($_SESSION['event_type_to_update']=='engagement'){
                if($this->bookingmodel->cancel_engagement($booking)){
                    $price['price']=$booking_details[0]->price-$engagement_details[0]->price;
                    $price['booking_id']=$_SESSION['booking_id_l'];
                    $y=$this->bookingmodel->update_price($price);
                    if($y){
                        echo "<script>window.alert('Engagement cancelled.')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                    }
                }
            }

            if($_SESSION['event_type_to_update']=='homecoming'){
                if($this->bookingmodel->cancel_homecoming($booking)){
                    $price['price']=$booking_details[0]->price-$homecoming_details[0]->price;
                    $price['booking_id']=$_SESSION['booking_id_l'];
                    $y=$this->bookingmodel->update_price($price);
                    if($y){
                        echo "<script>window.alert('Homecoming cancelled.')</script>";
                        echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking'</script>";
                    }
                }
            }
        }
        
    }

    public function update(){
        $booking = [
            "date"=>$_POST['datew'],
            "time"=>$_POST['timew'],
            "venue"=>$_POST['venuew'],
            "booking_id"=>$_SESSION['booking_id_l']

        ];
        if(isset($_POST['update'])){
            if($_SESSION['event_type_to_update']=='wedding'){
        
                if($this->bookingmodel->update_wedding_date($booking)){
                    unset($_SESSION['booking_date_l']);
                    unset($_SESSION['event_type_to_update']);
                    unset($_SESSION['dates']);
                    echo "<script>window.alert('Wedding date updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/fetchbookingdetails'</script>";
                    
                }
            }
            if($_SESSION['event_type_to_update']=='engagement'){
                if($this->bookingmodel->update_engagement_date($booking)){
                    unset($_SESSION['booking_date_l']);
                    unset($_SESSION['event_type_to_update']);
                    unset($_SESSION['dates']);
                    echo "<script>window.alert('Engagement date updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/fetchbookingdetails'</script>";  
                }
            }
            if($_SESSION['event_type_to_update']=='preshoot'){
                if($this->bookingmodel->update_preshoot_date($booking)){
                    unset($_SESSION['booking_date_l']);
                    unset($_SESSION['event_type_to_update']);
                    unset($_SESSION['dates']);
                    echo "<script>window.alert('Pre wedding shoot date updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/fetchbookingdetails'</script>";  
                }
            }
            if($_SESSION['event_type_to_update']=='homecoming'){
                if($this->bookingmodel->update_homecoming_date($booking)){
                    unset($_SESSION['booking_date_l']);
                    unset($_SESSION['event_type_to_update']);
                    unset($_SESSION['dates']);
                    echo "<script>window.alert('Homecoming date updated')</script>";
                    echo "<script>window.location.href = 'http://localhost/studiolaza/customerbooking/fetchbookingdetails'</script>";   
                }
            }

        }
        $this->view('update_date',$data);
    }
    
}