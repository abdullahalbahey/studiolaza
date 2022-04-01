<?php
    class User {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        
        public function login($user){

                $sql="SELECT * FROM user WHERE username=:username" ;

                $arr=$this->db->toreadDB($sql,$user);

               
                return $arr;
        }
        public function loginma($user){

            $sql="SELECT * FROM user WHERE username=:username && password=:password" ;

            $arr=$this->db->toreadDB($sql,$user);

           
            return $arr;
    }

        function registeruser($data){
               
                $sql="INSERT INTO user(username,password,type,email,image) VALUES (:username,:password,:type,:email,:image);";
                return $this->db->towriteDB($sql,$data);

        }

        function fetchid($userdata){
            $sql="SELECT user_id,email FROM user WHERE username=:username ";
            $re=$this->db->toreadDB($sql,$userdata);
            return $re;

        }

        function registercustomer($datat){
            $sqlt="INSERT INTO customer(name,nic,line1,city,contact,v_status,user_id) VALUES (:name,:nic,:line1,:city,:contact,:v_status,:user_id);";

            return $this->db->towriteDB($sqlt,$datat);
        }

        function registeremployee($datat){
            $sqlt="INSERT INTO employee(name,nic,line1,city,contact,enrolled,roles,emptype,user_id) VALUES (:name,:nic,:line1,:city,:contact,:date,:role,:emptype,:user_id);";

            return $this->db->towriteDB($sqlt,$datat);
        }

        function checkemail($email){
            $sql="SELECT * FROM user WHERE email=:email;";
            return $this->db->toreadDB($sql,$email);   
        }
        function checkusername($data){
            $sql="SELECT * FROM user WHERE username=:username;";
            return $this->db->toreadDB($sql,$data);   
        }
        function fetchuserdetails($data){
            $sql="SELECT * FROM user where user.user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetchcustomerdetails($data){
            $sql="SELECT * FROM user INNER JOIN customer ON user.user_id=customer.user_id where user.user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }
        function updatecustomer($data){
            $sql="UPDATE customer SET name=:name,nic=:nic,line1=:line1,city=:city,contact=:contact WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetchemployeedetails($data){
            $sql="SELECT * FROM user INNER JOIN employee ON user.user_id=employee.user_id where user.user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }
        function updateemployee($data){
            $sql="UPDATE employee SET name=:name,nic=:nic,line1=:line1,city=:city,contact=:contact WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function updateuser($data){
            $sql="UPDATE user SET email=:email,image=:image WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

        function deleteimage($data){
            $sql="DELETE image FROM user WHERE user_id=:io;";
            return $this->db->towriteDB($sql,$data);
        }

        function fetchpassword($data){
            $sql="SELECT password FROM user where user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function updatepassword($data){
            $sql="UPDATE user SET password=:newpassword where user_id=:io;";
            return $this->db->towriteDB($sql,$data);
        }

        
    }
