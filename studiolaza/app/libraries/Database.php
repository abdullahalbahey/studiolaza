<?php

class Database{

    public function connect(){

        try{
            $dbcon="mysql:host=".DB_HOST.";dbname=".DB_NAME.";";
            return $db=new PDO($dbcon,DB_USER,DB_PASS);
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function toreadDB($query,$data=[]){

        $DB=$this->connect();
        $stmt=$DB->prepare($query);

        if(count($data)==0){
            $stmt=$DB->query($query);
            $check=0;
            if($stmt){
                $check=1;
            }
        }else{
            $check=$stmt->execute($data);
        }

        if($check){
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        else{
            return false;
        }
    }

    public function towriteDB($query,$data=[]){
        $DB=$this->connect();
        $stmt=$DB->prepare($query);

        if(count($data)==0){
            $stmt=$DB->query($query);
            $check=0;
            if($stmt){
                $check=1;
            }
        }else{
            $check=$stmt->execute($data);
        }

        if($check){
            return true;
        }
        else{
            return false;
        }
    }
}