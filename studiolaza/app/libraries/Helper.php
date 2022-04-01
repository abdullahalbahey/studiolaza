<?php
//used for functions which are common in many pages
    session_start();

    function checksession(){
        
        if(isset($_SESSION["id"])){
            return false;
        }else{
            return true;
        }
    }