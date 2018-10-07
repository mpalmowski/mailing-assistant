<?php

class Database
{
    private $db, $connected;

    public function __construct($servername, $username, $password, $db_name){
        if(!$this->connect($servername, $username, $password, $db_name))
            $this->connected = false;
    }

    public function select($columns, $tables, $conditions=NULL){
        $query = "SELECT $columns FROM $tables";
        if($conditions != NULL)
            $query .= " WHERE $conditions";
        return $this->db->query($query);
    }

    public function insert($table, $columns, $values){
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->db->query($query);
    }

    public function connect($servername, $username, $password, $db_name){
        $this->db = new mysqli($servername, $username, $password, $db_name);
        if ($this->db->connect_error) {
            return false;
        }
        return true;
    }
}