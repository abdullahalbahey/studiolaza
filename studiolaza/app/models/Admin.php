<?php
    class Admin {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function fetchadmindetails($data){
            $sql="SELECT * FROM user WHERE user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function updateadmin($data){
            $sql="UPDATE user SET username=:username,password=:password,email=:email,image=:image WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }

    }