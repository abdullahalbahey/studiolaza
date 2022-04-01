<?php
class Managerbookings extends Controller {
    public function __construct() {
        $this->customermodel = $this->model('Customer');
        $this->bookingmodel = $this->model('Booking');
        $this->thankingcardmodel = $this->model('Thankingcard');
        $this->costumemodel = $this->model('Costume');
        $this->packagesmodel = $this->model('Packages');
        $this->employeemodel = $this->model('Employee');
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

    public function index() {
        header('location:'.URLROOT.'/Managerbookings/bookingnumber');
    }

    public function bookingnumber() {
        $data['numberofbookings']=$this->bookingmodel->fetch_all_bookings();
        $this->view('manager_search_booking',$data);
    }

    public function fetchbookingdetails() {
        
        $data=$this->errormake();
        if(isset($_POST['view_details'])){
            $_SESSION['bookingid']=$_POST['id'];
        }
            $id = [
                "bookingid"=>$_SESSION['bookingid']
            ];
            
            $booking_data=$this->bookingmodel->fetchbooking($id);
            $customer_data['customer_id']=$booking_data[0]->customer_id;
            
            $weddingdetails=$this->bookingmodel->fetchweddingdetails($id);
            $preshootdetails=$this->bookingmodel->fetchpreshootdetails($id);
            $homecomingdetails=$this->bookingmodel->fetchhomecomingdetails($id);
            $engagementdetails=$this->bookingmodel->fetchengagementdetails($id);
            
            $data['bookingdetails']=$booking_data;
            $data['customer_data']=$this->customermodel->fetch_customer_details_2($customer_data);
            $data["weddingdetails"]=$weddingdetails;
            $data["homecomingdetails"]=$homecomingdetails;
            $data["preshootdetails"]=$preshootdetails;
            $data["engagementdetails"]=$engagementdetails;
            
        $this->view('manager_page', $data);
    }

    public function view_details_wedding(){
        $id=[
            "bookingid"=>$_SESSION['bookingid']
        ];

        $data["weddingdetails"]=$this->bookingmodel->fetchweddingdetails($id);
        $data['details']=$data['weddingdetails'][0]->progress;
       
        $employee_details=$this->employeemodel->fetchempdetailforadmin();
        $data['empdetails']=$employee_details;

        $data['photographer']="";
        $data['editor']="";

        if($data['weddingdetails'][0]->photographer_id!=NULL && $data['weddingdetails'][0]->editor_id!=NULL){

            $photographer['photographer_id']=$data['weddingdetails'][0]->photographer_id;
            $editor['editor_id']=$data['weddingdetails'][0]->editor_id;

            $data['photographer']=$this->employeemodel->fetch_photographer_name($photographer);
            $data['editor']=$this->employeemodel->fetch_editor_name($editor);
        }
        $data['photographer_charges']=$data['weddingdetails'][0]->p_charges;
        $data['editor_charges']=$data['weddingdetails'][0]->e_charges;

        if(isset($_POST['submit'])){//progress update
            $progress=[
                'progress'=>$_POST['progress'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_progress_wedding($progress)){
                echo "<script>window.alert('Progress updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_wedding'</script>";
            }
        }

        if(isset($_POST['update_employee'])){//employee update
            
            $employee=[
                'photographer_id'=>$_POST['photographer'],
                'p_charges'=>$_POST['p_charges'],
                'editor_id'=>$_POST['editor'],
                'e_charges'=>$_POST['e_charges'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_employee_wedding($employee)){
                echo "<script>window.alert('Employee assigned')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_wedding'</script>";
            }
        }
       
        $this->view('manager_view_details', $data);
            
    }

    public function view_details_preshoot(){
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];
        $data["preshootdetails"]=$this->bookingmodel->fetchpreshootdetails($id);
        $data['details']=$data['preshootdetails'][0]->progress;
        $employee_details=$this->employeemodel->fetchempdetailforadmin();
        $data['empdetails']=$employee_details;

        if($data['preshootdetails'][0]->photographer_id!=NULL && $data['preshootdetails'][0]->editor_id!=NULL){
            $photographer['photographer_id']=$data['preshootdetails'][0]->photographer_id;
            $editor['editor_id']=$data['preshootdetails'][0]->editor_id;

            $data['photographer']=$this->employeemodel->fetch_photographer_name($photographer);
            $data['editor']=$this->employeemodel->fetch_editor_name($editor);
        }
        $data['photographer_charges']=$data['preshootdetails'][0]->p_charges;
        $data['editor_charges']=$data['preshootdetails'][0]->e_charges;

        if(isset($_POST['submit'])){//progress update
            $progress=[
                'progress'=>$_POST['progress'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_progress_preshoot($progress)){
                echo "<script>window.alert('Progress updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_preshoot'</script>";
            }
        }

        if(isset($_POST['update_employee'])){//employee update
            $employee=[
                'photographer_id'=>$_POST['photographer'],
                'p_charges'=>$_POST['p_charges'],
                'editor_id'=>$_POST['editor'],
                'e_charges'=>$_POST['e_charges'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_employee_preshoot($employee)){
                echo "<script>window.alert('Employee assigned')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_preshoot'</script>";
            }
        }
       
        $this->view('manager_view_details', $data);
    }

    public function view_details_engagement(){
        $id = [
            "bookingid"=>$_SESSION['bookingid']
        ];
        $data["engagementdetails"]=$this->bookingmodel->fetchengagementdetails($id);
        $data['details']=$data['engagementdetails'][0]->progress;    
        $employee_details=$this->employeemodel->fetchempdetailforadmin();
        $data['empdetails']=$employee_details;

        if($data['engagementdetails'][0]->photographer_id!=NULL && $data['engagementdetails'][0]->editor_id!=NULL){
            $photographer['photographer_id']=$data['engagementdetails'][0]->photographer_id;
            $editor['editor_id']=$data['engagementdetails'][0]->editor_id;

            $data['photographer']=$this->employeemodel->fetch_photographer_name($photographer);
            $data['editor']=$this->employeemodel->fetch_editor_name($editor);
        }
        $data['photographer_charges']=$data['engagementdetails'][0]->p_charges;
        $data['editor_charges']=$data['engagementdetails'][0]->e_charges;

        if(isset($_POST['submit'])){
            $progress=[
                'progress'=>$_POST['progress'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_progress_engagement($progress)){
                echo "<script>window.alert('Progress updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_engagement'</script>";
            }
        }
        if(isset($_POST['update_employee'])){
            $employee=[
                'photographer_id'=>$_POST['photographer'],
                'p_charges'=>$_POST['p_charges'],
                'editor_id'=>$_POST['editor'],
                'e_charges'=>$_POST['e_charges'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_employee_engagement($employee)){
                echo "<script>window.alert('Employee assigned')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_engagement'</script>";
            }
        }
       $this->view('manager_view_details', $data);
    }

    public function view_details_homecoming(){
        $id =[
           "bookingid"=>$_SESSION['bookingid']
        ];
        $data["homecomingdetails"]=$this->bookingmodel->fetchhomecomingdetails($id);
        $data['details']=$data['homecomingdetails'][0]->progress;
        $employee_details=$this->employeemodel->fetchempdetailforadmin();
        $data['empdetails']=$employee_details;

        if($data['homecomingdetails'][0]->photographer_id!=NULL && $data['homecomingdetails'][0]->editor_id!=NULL){
            $photographer['photographer_id']=$data['homecomingdetails'][0]->photographer_id;
            $editor['editor_id']=$data['homecomingdetails'][0]->editor_id;

            $data['photographer']=$this->employeemodel->fetch_photographer_name($photographer);
            $data['editor']=$this->employeemodel->fetch_editor_name($editor);
        }
        $data['photographer_charges']=$data['homecomingdetails'][0]->p_charges;
        $data['editor_charges']=$data['homecomingdetails'][0]->e_charges;

        if(isset($_POST['submit'])){
            $progress=[
                'progress'=>$_POST['progress'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_progress_homecoming($progress)){
                echo "<script>window.alert('Progress updated')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_homecoming'</script>";
            }
        }
        if(isset($_POST['update_employee'])){
            $employee=[
                'photographer_id'=>$_POST['photographer'],
                'p_charges'=>$_POST['p_charges'],
                'editor_id'=>$_POST['editor'],
                'e_charges'=>$_POST['e_charges'],
                'booking_id'=>$_SESSION['bookingid']
            ];
            if($this->bookingmodel->update_employee_homecoming($employee)){
                echo "<script>window.alert('Employee assigned')</script>";
                echo "<script>window.location.href = 'http://localhost/studiolaza/managerbookings/view_details_homecoming'</script>";
            }
        }
        $this->view('manager_view_details', $data);
    }

    public function show_update_form(){
        $booking['booking_id']=$_SESSION['booking'];
        $data['costume']="";
        $data['thanking']="";
        if(isset($_POST['costume'])){
            $costume=$this->costumemodel->fetch_costume_image($booking);
            $data['costume']=$costume[0]->image;
        }
        if(isset($_POST['costume'])){
            $thanking=$this->thankingcardmodel->fetch_thanking_image($booking);
            $data['thanking']=$costume[0]->image;
        }
        
       
    }
    
}
