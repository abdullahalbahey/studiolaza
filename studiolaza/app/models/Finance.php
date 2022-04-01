<?php
    class Finance {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }
        function addfinance($data){
            $sql="INSERT INTO finance(orderID,financePurpose,otherFinancePurpose,financeDate,financeAmount,financeType) VALUES (:searchorder_fin,:financePurpose,:otherfinancePurpose,:financeDate,:financeAmount,:financeType);";
            return $this->db->towriteDB($sql,$data);
        }
        function readfinance(){
            $sql="SELECT * FROM finance ORDER BY financeID DESC;";
            /*  Name of the Customer 
                Order ID
                Total Budget
            */
            return $this->db->toreadDB($sql);
        }
        function findorder(){
           
        }
        function getName (){
            $sql="SELECT * FROM customer INNER JOIN booking WHERE customer.customer_id=booking.customer_id;";
            return $this->db->toreadDB($sql);
        }
        



    }
