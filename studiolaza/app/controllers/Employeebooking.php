<?php
class Employeebooking extends Controller {
    public function __construct() {
        $this->usermodel = $this->model('User');
        $this->employeemodel = $this->model('Employee');
        $this->bookingmodel=$this->model('Booking');
        $this->customermodel = $this->model('Customer');
    }

    public function index() {
        header('location:'.URLROOT.'/employeebooking/bookingdetails');     
    }

    public function errormake(){
        $data=[
            "weddingdetails"=>"",
            "preshootdetails"=>"",
            "engagementdetails"=>"",
            "homecomingdetails"=>"",
            
        ];
        return $data;
    }

    public function bookingdetails() {
        $data=$this->errormake();

        $fetchdetails=[
            "io"=>$_SESSION['id']
        ];  
        $employee_details=$this->usermodel->fetchemployeedetails($fetchdetails);

        $employee['id']=$employee_details[0]->employee_id;
        $data['employee_id']=$employee_details[0]->employee_id;

        $data['weddingbookings']=$this->employeemodel->fetch_all_wedding_bookings($employee);
        $data['preshootbookings']=$this->employeemodel->fetch_all_preshoot_bookings($employee);
        $data['engagementbookings']=$this->employeemodel->fetch_all_engagement_bookings($employee);
        $data['homecomingbookings']=$this->employeemodel->fetch_all_homecoming_bookings($employee);

        
        //$date_array
        $this->view('employeebookingsearch', $data);  
        
        
    }

    public function fetchweddingdetails(){
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];
        
        
        $booking_data=$this->bookingmodel->fetchbooking($id);
        $customer_data['customer_id']=$booking_data[0]->customer_id;
        $data['customer_data']=$this->customermodel->fetch_customer_details_2($customer_data);
        $weddingdetails=$this->bookingmodel->fetchweddingdetails($id);
        $data["weddingdetails"]=$weddingdetails;
        $this->view('employee_page', $data);
    }

    public function fetchpreshootdetails(){
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];

        $booking_data=$this->bookingmodel->fetchbooking($id);
        $customer_data['customer_id']=$booking_data[0]->customer_id;
        $data['customer_data']=$this->customermodel->fetch_customer_details_2($customer_data);

        $preshootdetails=$this->bookingmodel->fetchpreshootdetails($id);
        $data["preshootdetails"]=$preshootdetails;
        $this->view('employee_page', $data);
    }

    public function fetchengagementdetails(){
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];

        $booking_data=$this->bookingmodel->fetchbooking($id);
        $customer_data['customer_id']=$booking_data[0]->customer_id;
        $data['customer_data']=$this->customermodel->fetch_customer_details_2($customer_data);

        $engagementdetails=$this->bookingmodel->fetchengagementdetails($id);
        $data["engagementdetails"]=$engagementdetails;
        $this->view('employee_page', $data);
    }

    public function fetchhomecomingdetails(){
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];
        $booking_data=$this->bookingmodel->fetchbooking($id);
        $customer_data['customer_id']=$booking_data[0]->customer_id;
        $data['customer_data']=$this->customermodel->fetch_customer_details_2($customer_data);
        $homecomingdetails=$this->bookingmodel->fetchhomecomingdetails($id);
        $data["homecomingdetails"]=$homecomingdetails;
        $this->view('employee_page', $data);
    }

    

    public function view_details_wedding(){
        $data=$this->errormake();
        
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($id);
            $data['details']=$data['weddingdetails'][0]->progress;
            
        $this->view('employeebooking', $data);
    }

    public function view_details_preshoot(){
        $data=$this->errormake();
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["preshootdetails"]=$this->bookingmodel->fetchpreshootdetails($id);
            $data["details"]=$data['preshootdetails'][0]->progress;
        $this->view('employeebooking', $data);
    }

    public function view_details_engagement(){
        $data=$this->errormake();
       
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["engagementdetails"]=$this->bookingmodel->fetchengagementdetails($id);
            $data['details']=$data['engagementdetails'][0]->progress;
        $this->view('employeebooking', $data);
    }

    public function view_details_homecoming(){
        $data=$this->errormake();
        
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            $data["homecomingdetails"]=$this->bookingmodel->fetchhomecomingdetails($id);
            $data['details']=$data['homecomingdetails'][0]->progress;
        $this->view('employeebooking', $data);
    }
    


    
}
