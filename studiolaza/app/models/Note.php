<?php
    class Note {
        public $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function add_note($data){
            $sql="INSERT INTO notes(content,date,time,event_type,event_id,employee_id) VALUES (:note,:date,:time,:event_type,:event_id,:employee_id);";
            return $this->db->towriteDB($sql,$data);
        }

        public function update_note($data){
            $sql="UPDATE notes SET content=:note WHERE note_id=:note_id;";
            return $this->db->towriteDB($sql,$data);
        }

        public function fetch_notes($data){
            $sql="SELECT * FROM notes WHERE (event_type=:event_type AND event_id=:event_id) AND employee_id=:employee_id;";
            return $this->db->toreadDB($sql,$data);
        }

        public function fetchnotedetailtoupdate($data){
            $sql="SELECT note_id,content FROM notes WHERE note_id=:note_id;";
            return $this->db->toreadDB($sql,$data);
        }

        public function delete_note($data){
            $sql="DELETE FROM notes WHERE note_id=:note_id;";
            return $this->db->towriteDB($sql,$data);
        }
        

    }