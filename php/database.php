<?php

class Database
{
    public function connect($servername, $username, $password, $db_name){
        $db = new mysqli($servername, $username, $password, $db_name);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        return $db;
    }
}

$database = new Database();