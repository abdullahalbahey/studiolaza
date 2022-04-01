<?php
    class Employee {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }


        function fetchemployeedetails($data){
            $sql="SELECT * FROM user INNER JOIN employee ON user.user_id=employee.user_id where user.user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function updateemployeeinuser($data){
            $sql="UPDATE user SET username=:username,password=:password,email=:email,image=:image WHERE user_id=:user_id; ";
            return $this->db->towriteDB($sql,$data);
        }

        function updateemployeeinemployee($data){
            $sql="UPDATE employee SET name=:name,nic=:nic,line1=:line1,city=:city,contact=:contact WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetchempdetailforadmin(){
            $sql="SELECT employee_id,name,roles,emptype FROM employee;";
            return $this->db->toreadDB($sql);
        }

        function fetchempdetailforadmintoupdate($data){
            $sql="SELECT employee_id,name,roles,emptype FROM employee WHERE employee_id=:employee_id;";
            return $this->db->toreadDB($sql,$data);
        }

        function update_employee_admin($data){
            $sql="UPDATE employee SET roles=:role,emptype=:emptype WHERE employee_id=:employee_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetchempdetailfromsearch($data){
            $sql="SELECT employee_id,name,roles,emptype FROM employee WHERE name LIKE :searchvalue;";
            return $this->db->toreadDB($sql,$data);
        }

        //related to booking for employee
        function fetch_all_wedding_bookings($data){
            $sql="SELECT wedding_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM wedding WHERE photographer_id=:id OR editor_id=:id AND progress >= 0 AND ORDER BY datew ASC, progress;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_preshoot_bookings($data){
            $sql="SELECT preweddingshoot_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM preweddingshoot WHERE photographer_id=:id OR editor_id=:id AND progress >= 0 ORDER BY dateh ASC, progress;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_engagement_bookings($data){
            $sql="SELECT engagement_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM engagement WHERE photographer_id=:id OR editor_id=:id AND progress >= 0  ORDER BY datee ASC, progress;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_homecoming_bookings($data){
            $sql="SELECT homecoming_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM homecoming WHERE photographer_id=:id OR editor_id=:id AND progress >= 0 ORDER BY datew ASC ,progress;";
            return $this->db->toreadDB($sql,$data);
        }

        //earnings
        function fetch_all_wedding_earnings($data){
            $sql="SELECT wedding_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM wedding WHERE photographer_id=:id OR editor_id=:id ORDER BY datew ASC;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_preshoot_earnings($data){
            $sql="SELECT preweddingshoot_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM preweddingshoot WHERE photographer_id=:id OR editor_id=:id ORDER BY dateh ASC;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_engagement_earnings($data){
            $sql="SELECT engagement_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM engagement WHERE photographer_id=:id OR editor_id=:id ORDER BY datee ASC;";
            return $this->db->toreadDB($sql,$data);
        }
        function fetch_all_homecoming_earnings($data){
            $sql="SELECT homecoming_id,booking_id,photographer_id,editor_id,p_charges,e_charges FROM homecoming WHERE photographer_id=:id OR editor_id=:id ORDER BY datew ASC;";
            return $this->db->toreadDB($sql,$data);
        }


        //fetch photographer name
        function fetch_photographer_name($data){
            $sql="SELECT name FROM employee WHERE employee_id=:photographer_id";
            return $this->db->toreadDB($sql,$data);
        }
         //fetch editor name
        function fetch_editor_name($data){
            $sql="SELECT name FROM employee WHERE employee_id=:editor_id";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_employee_id($data){
            $sql="SELECT employee_id FROM employee WHERE user_id=:id; ";
            return $this->db->toreadDB($sql,$data);

        }
    }