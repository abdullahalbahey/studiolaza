<?php
    class Logs {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function add_login_data($data){
            $sql="INSERT INTO logs(username,type,date,time) VALUES(:username,:type,:date,:time);";
            return $this->db->towriteDB($sql,$data);
        }

        function fetch_logs($data){
            $sql="SELECT * FROM logs WHERE date BETWEEN :date1 AND :date2;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_count($data){
            $sql="SELECT COUNT(type) as abc FROM logs WHERE type='C' AND date BETWEEN :date1 AND :date2 ;";
            return $this->db->toreadDB($sql,$data);
        }

        

    }