<?php
class Message
{
    public $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    function writeMessage($data)
    {
        $sql = "INSERT INTO   contact_us(fname,lname,email,message) VALUES (:firstnameCon,:lastnameCon,:emailCon,:messageCon);";
        return $this->db->towriteDB($sql, $data);
    }
    function updateMessage($data)
    {
        $sql = "UPDATE contact_us SET message_replied=:messagereply WHERE contact_id=:message_id;";
        return $this->db->towriteDB($sql, $data);
    }
    function readMessage()
    {
        $sql = "SELECT * FROM contact_us ORDER BY contact_id DESC;";
        /*  Name of the Customer 
                Order ID
                Total Budget
            */
        return $this->db->toreadDB($sql);
    }
}
