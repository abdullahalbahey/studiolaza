<?php
    class Costume {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function fetchcostumedetails(){
            $sql="SELECT * FROM costume;";
            return $this->db->toreadDB($sql);
        }

        function fetch_costume_to_form($data){
            $sql="SELECT costume.costume_id FROM costume INNER JOIN wedding ON costume.costume_id=wedding.costume_id WHERE wedding.datew BETWEEN :date1 AND :date2;";
            return $this->db->toreadDB($sql,$data);
        }

        function addcostume($data){
            $sql="INSERT INTO costume(name,image,price,description) VALUES (:name,:image,:price,:description);";
            return $this->db->towriteDB($sql,$data);

        }
        function update_costume($data){
            $sql="UPDATE costume SET name=:name,image=:image,price=:price,description=:description WHERE costume_id=:id;";
            return $this->db->towriteDB($sql,$data);

        }

        function delete_costume($data){
            $sql="DELETE FROM costume WHERE costume_id=:costume_id;";
            return $this->db->towritedb($sql,$data);
        }
        
        function fetchcostumedetailforadmintoupdate($data){
            $sql="SELECT * FROM costume WHERE costume_id=:costume_id;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_costume_name(){
            $sql="SELECT name FROM costume";
            return $this->db->toreadDB($sql);
        }

        function check_costume_exists($data){
            $sql="SELECT wedding_id FROM wedding WHERE costume_id=:thankingcard_id AND progress < 2;";
            return $this->db->toreadDB($sql,$data);
        }

        function fetch_costume_price($data){
            $sql="SELECT price FROM costume WHERE costume_id=:costume_id;";
            return $this->db->toreadDB($sql,$data);
        }

    }