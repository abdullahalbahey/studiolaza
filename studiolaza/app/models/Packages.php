<?php
    class Packages {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function fetchdetails(){
            $sql="SELECT * FROM packages ;";
            return $this->db->toreadDB($sql);
        }

        
        public function fetchpricedetails(){
            $sql="SELECT price FROM packages ;";
            return $this->db->toreadDB($sql);
        }

        public function fetchpackagedetail($data){
            $sql="SELECT * FROM packages WHERE package_id=:package_id;";
            return $this->db->toreadDB($sql,$data);
        }

        public function update_price($data){
            $sql="UPDATE packages SET price=:price WHERE package_id=:package_id; ";
            return $this->db->towriteDB($sql,$data);
        }
    }