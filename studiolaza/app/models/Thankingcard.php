<?php
    class Thankingcard {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function fetchthankingcarddetails(){
            $sql="SELECT * FROM thankingcard;";
            return $this->db->toreadDB($sql);
        }

        function addthankingcard($data){
            $sql="INSERT INTO thankingcard(name,image,description) VALUES (:name,:image,:description);";
            return $this->db->towriteDB($sql,$data);

        }
        function update_thankingcard($data){
            $sql="UPDATE thankingcard SET name=:name,image=:image,description=:description WHERE thankingcard_id=:id;";
            return $this->db->towriteDB($sql,$data);

        }

        function delete_thankingcard($data){
            $sql="DELETE FROM thankingcard WHERE thankingcard_id=:thankingcard_id;";
            return $this->db->towritedb($sql,$data);
        }

        function fetchthankingcarddetailfromsearch($data){
            $sql="SELECT thankingcard_id,name,image,description FROM thankingcard WHERE name LIKE :searchvalue;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetchthankingcarddetailforadmintoupdate($data){
            $sql="SELECT * FROM thankingcard WHERE thankingcard_id=:thankingcard_id;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_thankingcard_name(){
            $sql="SELECT name FROM thankingcard";
            return $this->db->toreadDB($sql);
        }

        function check_thankingcard_exists(){
            $sql="SELECT wedding_id FROM wedding WHERE thankingcard_id=:thankingcard_id AND progress < 2;";
            return $this->db->toreadDB($sql,$data);
        }

    }