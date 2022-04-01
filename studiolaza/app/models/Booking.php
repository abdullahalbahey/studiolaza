<?php
    class Booking {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function newbooking($data) {
            $sql="INSERT INTO booking(customer_id,booking_date,status) VALUES (:customerid,:date,:status);";
            return $this->db->towriteDB($sql,$data);
        }

        public function fetchbookingid($data) {
            $sql="SELECT booking_id FROM booking where customer_id=:customerid order by booking_id desc limit 1;";
            return $this->db->toreadDB($sql,$data);
        }
        public function fetchbooking($data) {
            $sql="SELECT * FROM booking where booking_id=:bookingid;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetch_all_bookings(){
            $sql="SELECT booking.booking_id, customer.customer_id, customer.name FROM booking INNER JOIN customer ON booking.customer_id=customer.customer_id WHERE booking.status=1;";
            return $this->db->toreadDB($sql);
        }
        function fetchcustomerdetails($data){
            $sql="SELECT * FROM customer INNER JOIN booking ON customer.customer_id=booking.customer_id where customer.customer_id=:customer_id;";
            return $this->db->toreadDB($sql,$data);
        }

        public function newwedding($data) {
            $sql="INSERT INTO wedding(datew,timew,venuew,booking_id) VALUES (:date,:time,:venue,:bookingid);";
            return $this->db->towriteDB($sql,$data);
        }

        public function newhomecoming($data) {
            $sql="INSERT INTO homecoming(datew,timew,venuew,booking_id) VALUES (:date,:time,:venue,:bookingid);";
            return $this->db->towriteDB($sql,$data);
        }

        public function newengagement($data) {
            $sql="INSERT INTO engagement(datee,timee,venuee,booking_id) VALUES (:date,:time,:venue,:bookingid);";
            return $this->db->towriteDB($sql,$data);
        }

        public function newpreshoot($data) {
            $sql="INSERT INTO preweddingshoot(dateh,timeh,venueh,booking_id) VALUES (:date,:time,:venue,:bookingid);";
            return $this->db->towriteDB($sql,$data);
        }
        
        public function fetchweddingdetails($data) {
            $sql="SELECT * FROM wedding where booking_id=:bookingid ;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetchpreshootdetails($data) {
            $sql="SELECT * FROM preweddingshoot where booking_id=:bookingid ;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetchengagementdetails($data) {
            $sql="SELECT * FROM engagement where booking_id=:bookingid ;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetchhomecomingdetails($data) {
            $sql="SELECT * FROM homecoming where booking_id=:bookingid ;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetchingbookingnumber($data) {
            $sql="SELECT booking_id FROM booking where customer_id=:customerid AND status=1 ORDER BY booking_id DESC;";
            return $this->db->toreadDB($sql,$data);
        }

        public function addingweddingdetails($data) {
            $sql="UPDATE wedding SET weddingdetails=:details,price=:price WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function addingpreshootdetails($data) {
            $sql="UPDATE preweddingshoot SET preweddingshootdetails=:details,price=:price WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function addinghomecomingdetails($data) {
            $sql="UPDATE homecoming SET homecomingdetails=:details,price=:price WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function addingengagementdetails($data) {
            $sql="UPDATE engagement SET engagementdetails=:details,price=:price WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function addingthankingcarddetails($data) {
            $sql="UPDATE wedding SET price=:price,thankingcard_id=:thankingcardid,thankingcard_price=:thankingcard_price,thankingcard_detail=:thankingcard_detail WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function addingcostumedetails($data) {
            $sql="UPDATE wedding SET costume_id=:costumeid,price=:price WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        public function update_price($data){
            $sql="UPDATE booking SET price=:price WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        public function costume_check($data){
            $sql="SELECT costume_id FROM wedding WHERE booking_id=:booking_id;";
            return $this->db->toreadDB($sql,$data);
        }

        public function total_price($data){
            $sql="UPDATE booking SET price=:price,status=:status,balance=:balance WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        public function confirm_booking($data){
            $sql="UPDATE booking SET status=:status,balance=:balance WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        public function fetch_tentatives(){
            $sql="SELECT * FROM booking WHERE status=0;";
            return $this->db->toreadDB($sql);
        }
        public function fetch_confirmed(){
            $sql="SELECT * FROM booking WHERE status=1;";
            return $this->db->toreadDB($sql);
        }

        //updating progress regarding specific bookings
        public function update_progress_wedding($data){
            $sql="UPDATE wedding SET progress=:progress WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        public function update_progress_preshoot($data){
            $sql="UPDATE preweddingshoot SET progress=:progress WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        public function update_progress_engagement($data){
            $sql="UPDATE engagement SET progress=:progress WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        public function update_progress_homecoming($data){
            $sql="UPDATE homecoming SET progress=:progress WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        //updating employees of specific bookings
        function update_employee_wedding($data){
            $sql="UPDATE wedding SET photographer_id=:photographer_id,p_charges=:p_charges,editor_id=:editor_id,e_charges=:e_charges WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        function update_employee_preshoot($data){
            $sql="UPDATE preweddingshoot SET photographer_id=:photographer_id,p_charges=:p_charges,editor_id=:editor_id,e_charges=:e_charges WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        function update_employee_engagement($data){
            $sql="UPDATE engagement SET photographer_id=:photographer_id,p_charges=:p_charges,editor_id=:editor_id,e_charges=:e_charges WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        function update_employee_homecoming($data){
            $sql="UPDATE homecoming SET photographer_id=:photographer_id,p_charges=:p_charges,editor_id=:editor_id,e_charges=:e_charges WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        //deleting a booking or declining a tentative
        function delete_booking($data){
            $sql="UPDATE booking SET status=3 WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
        

        //
        function fetch_booked_dates(){
            $sql="SELECT wedding.datew AS date FROM wedding INNER JOIN booking ON wedding.booking_id=booking.booking_id WHERE wedding.datew >= CURRENT_DATE() + 10 AND booking.status=2 UNION SELECT datee AS date FROM engagement INNER JOIN booking ON engagement.booking_id=booking.booking_id WHERE engagement.datee >= CURRENT_DATE() + 10 AND booking.status=2 UNION SELECT datew AS date FROM homecoming INNER JOIN booking ON homecoming.booking_id=booking.booking_id WHERE homecoming.datew >= CURRENT_DATE() + 10 AND booking.status=2 UNION SELECT dateh AS date FROM preweddingshoot INNER JOIN booking ON preweddingshoot.booking_id=booking.booking_id WHERE preweddingshoot.dateh >= CURRENT_DATE() + 10 AND booking.status=2;";
            return $this->db->toreadDB($sql);
        }

        function update_wedding_date($data){
            $sql="UPDATE wedding SET datew=:date,timew=:time,venuew=:venue WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }    
        
        function update_engagement_date($data){
            $sql="UPDATE engagement SET datee=:date,timee=:time,venuee=:venue WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function update_homecoming_date($data){
            $sql="UPDATE homecoming SET datew=:date,timew=:time,venuew=:venue WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function update_preshoot_date($data){
            $sql="UPDATE preweddingshoot SET dateh=:date,timeh=:time,venueh=:venue WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetch_date_cancel($data){
            $sql="SELECT datew as date FROM wedding WHERE booking_id=:bookingid UNION SELECT datee as date FROM engagement WHERE booking_id=:bookingid UNION SELECT datew as date FROM homecoming WHERE booking_id=:bookingid UNION SELECT dateh as date FROM preweddingshoot WHERE booking_id=:bookingid ORDER BY date ASC;";
            return $this->db->toreadDB($sql,$data);
        }

        function cancel_wedding($data){
            $sql="DELETE FROM wedding WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }
        function cancel_preshoot($data){
            $sql="DELETE FROM preweddingshoot WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }
        function cancel_engagement($data){
            $sql="DELETE FROM engagement WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }
        function cancel_homecoming($data){
            $sql="DELETE FROM homecoming WHERE booking_id=:bookingid;";
            return $this->db->towriteDB($sql,$data);
        }

        function update_booking_cancel($data){
            $sql="UPDATE booking SET status=:status WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function update_thankingcard_in_wedding($data){
            $sql="UPDATE wedding SET thankingcard_id=NULL,thankingcard_price=NULL,thankingcard_detail=NULL,price=:price WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function update_costume_in_wedding($data){
            $sql="UPDATE wedding SET costume_id=NULL,price=:price WHERE booking_id=:booking_id;";
            return $this->db->towriteDB($sql,$data);
        }
            
        
    }



