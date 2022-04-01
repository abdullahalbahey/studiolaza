<?php
class Managercalendar extends Controller {
    public function __construct() {
        $this->bookingmodel = $this->model('Booking');
        $this->calendarmodel = $this->model('Calendar');
    }

    public function index() {
        $data['tentatives']=$this->bookingmodel->fetch_tentatives();
        $data['confirmed']=$this->bookingmodel->fetch_confirmed();
        
        $calendarDetails = $this->calendarmodel->readCalendar();
        $data["tentativedetails"]=$calendarDetails;

        $calendarConDetails = $this->calendarmodel->readConCalendar();
        $data["confirmeddetails"]=$calendarConDetails;
        


        $this->view('m_calendar', $data);  
  
    }

    
}
