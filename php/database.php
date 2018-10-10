<?php

class Database
{
    private $db, $connected;
    private $columns = [
        "ID",
        "EMail",
        "SubscriberType"
    ];

    public function __construct($servername, $username, $password, $db_name){
        if(!$this->connect($servername, $username, $password, $db_name))
            $this->connected = false;
        else
            $this->connected = true;
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

    public  function isConnected(){
        return $this->connected;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function create($table_name){
        $query = <<< SQL
        CREATE TABLE IF NOT EXISTS $table_name (
            ID int NOT NULL AUTO_INCREMENT,
            EMail varchar(255) NOT NULL,
            SubscriberType varchar(255),
            PRIMARY KEY (ID)
        );
SQL;
        $this->db->query($query);
    }
}