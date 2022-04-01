<?php
    class Review {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        function add_review($data){
            $sql="INSERT INTO review(content,date,time,rating,customer_id) VALUES(:content,:date,:time,:rating,:customer_id);";
            return $this->db->towriteDB($sql,$data);
        }
        
        function fetch_review($data){
            $sql="SELECT review_id,content,rating FROM review WHERE customer_id=:customer_id;";
            return $this->db->toreadDB($sql,$data);
        }   

        function fetchreview() {
            $sql="SELECT customer.name,review.content,review.date,review.rating FROM customer INNER JOIN review ON customer.customer_id=review.customer_id ORDER BY review.date DESC";
            return $this->db->toreadDB($sql);
        }

        function update_review($data){
            $sql="UPDATE review SET content=:content,date=:date,time=:time,rating=:rating WHERE review_id=:review_id";
            return $this->db->towriteDB($sql,$data);
        }   

        function delete_review($data){
            $sql="DELETE from review WHERE review_id=:review_id";
            return $this->db->towriteDB($sql,$data);
        }   
    }