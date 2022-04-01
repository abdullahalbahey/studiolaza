<?php
    class Report {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        /*function add_login_data($data){
            $sql="INSERT INTO logs(username,type,date,time) VALUES(:username,:type,:date,:time);";
            return $this->db->towriteDB($sql,$data);
        }*/

        function fetch_calendar($data){
            $sql="SELECT * FROM finance WHERE financeDate BETWEEN :fromDate AND :toDate;";
            return $this->db->toreadDB($sql,$data);
        }

        

    }