<?php
class Calendar 
{
    public $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    
    function readCalendar()
    {
        $sql = "SELECT booking.booking_id, booking.booking_date, customer.name FROM booking INNER JOIN customer ON booking.customer_id = customer.customer_id WHERE status = 0 ORDER BY booking.booking_date DESC";
        /*  Name of the Customer 
                Order ID
                Total Budget
            */
        return $this->db->toreadDB($sql);
    }
    function readConCalendar()
    {
        $sql = "SELECT booking.booking_id, booking.booking_date, customer.name FROM booking INNER JOIN customer ON booking.customer_id = customer.customer_id WHERE status = 1 ORDER BY booking.booking_date DESC";
        /*  Name of the Customer 
                Order ID
                Total Budget
            */
        return $this->db->toreadDB($sql);
    }
}
