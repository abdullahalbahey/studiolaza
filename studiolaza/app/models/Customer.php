<?php
    class Customer {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function fetchcustomerdetails($data){
            $sql="SELECT * FROM user INNER JOIN customer ON user.user_id=customer.user_id where user.user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function updatecustomerinuser($data){
            $sql="UPDATE user SET username=:username,password=:password,email=:email,image=:image WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function updatecustomerincustomer($data){
            $sql="UPDATE customer SET name=:name,nic=:nic,line1=:line1,city=:city,contact=:contact WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetchcustomerid($data){
            $sql="SELECT customer_id FROM customer where user_id=:id;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_customer_details($data){
            $sql="SELECT * FROM customer where user_id=:id;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_customer_details_2($data){
            $sql="SELECT * FROM customer where customer_id=:customer_id;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_user_id($data){
            $sql="SELECT user_id FROM customer where customer_id=:customer_id;";
            return $this->db->toreadDB($sql,$data);
        }

        function update_vstatus($data){
            $sql="UPDATE customer SET v_status=1 WHERE user_id=:user_id; ";
            return $this->db->towriteDB($sql,$data);
        }

        function fetch_status($data){
            $sql="SELECT v_status FROM customer WHERE user_id=:user_id; ";
            return $this->db->toreadDB($sql,$data);
        }

    }