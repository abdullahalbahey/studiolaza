<?php
    class Manager {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function fetchmanagerdetails($data){
            $sql="SELECT * FROM user WHERE user_id=:io;";
            return $this->db->toreadDB($sql,$data);
        }

        function updatemanager($data){
            $sql="UPDATE user SET username=:username,password=:password,email=:email,image=:image WHERE user_id=:user_id;";
            return $this->db->towriteDB($sql,$data);
        }
    }