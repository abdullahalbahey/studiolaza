<?php
    class Portfolio {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function add_new_portfolio($data){
            $sql="INSERT INTO portfolio(name) VALUES(:name);";
            return $this->db->towriteDB($sql,$data);
        }
        
        public function add_pics_to_portfolio($data){
            $sql="INSERT INTO portfolio_image(image,portfolio_id) VALUES(:image,:portfolio_id);";
            return $this->db->towriteDB($sql,$data);
        }

        public function fetch_portfolio_albums(){
            $sql="SELECT * FROM portfolio";
            return $this->db->toreadDB($sql);
        }
        public function fetch_album_name($data){
            $sql="SELECT name FROM portfolio WHERE portfolio_id=:portfolio_id";
            return $this->db->toreadDB($sql,$data);   
        }

        public function fetch_album_pics($data){
            $sql="SELECT * FROM portfolio_image WHERE portfolio_id=:portfolio_id";
            return $this->db->toreadDB($sql,$data);   
        }
        public function fetch_image_details($data){
            $sql="SELECT * FROM portfolio_image WHERE image_id=:image_id";
            return $this->db->toreadDB($sql,$data);   
        }

        public function delete_pics($data){
            $sql="DELETE FROM portfolio_image WHERE image_id=:image_id";
            return $this->db->towriteDB($sql,$data); 
        }
        public function delete_album($data){
            $sql="DELETE FROM portfolio WHERE portfolio_id=:portfolio_id";
            return $this->db->towriteDB($sql,$data); 
        }
    }