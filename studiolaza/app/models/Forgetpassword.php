<?php
    class Forgetpassword {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }
        function addrequest($data){
            $sql="INSERT INTO forgetpassword(email,token,timecheck) VALUES (:email,:token,:timecheck);";
            return $this->db->towriteDB($sql,$data);
        }
        
        function checktoken($data){
            $sql="SELECT email FROM forgetpassword WHERE (token=:token AND timecheck=:timecheck1) AND timecheck>=:timecheck2; ";
            return $this->db->toreadDB($sql,$data);
        }

        function updatepassword($data){
            $sql="UPDATE user SET password=:password WHERE email=:email;";
            return $this->db->towriteDB($sql,$data);
        }

        function check_email_username($data){
            $sql="SELECT username,email FROM user  WHERE username=:email OR email=:email ;";
            return $this->db->toreadDB($sql,$data); 
        }


    }