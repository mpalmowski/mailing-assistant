<?php

class Database
{
    /**
     * @var mysqli $db
     */
    private $db, $connected, $conf, $subscribersTable;
    private $id_col = "ID";
    private $e_mail_col = "EMail";
    private $type_col = "SubscriberType";
    private $num_cols = 3;

    /**
     * Database constructor.
     * @param Conf $conf
     */
    public function __construct($conf)
    {
        $this->conf = $conf;
        $this->subscribersTable = $conf->get('subscribers_table');
        if (!$this->connect($conf->get('db_servername'), $conf->get('db_username'), $conf->get('db_password'), $conf->get('db_name')))
            $this->connected = false;
        else {
            $this->connected = true;
            $this->createSubscribersTable();
        }
    }

    public function getSubscribers()
    {
        return $this->select("*", $this->subscribersTable);
    }

    public function subscriberExists($e_mail, $type)
    {
        $existing = $this->select(
            "*",
            $this->subscribersTable,
            "$this->e_mail_col = '$e_mail' AND $this->type_col = '$type'"
        );
        if ($existing->num_rows == 0) {
            return false;
        }
        return true;
    }

    public function addSubscriber($e_mail, $type)
    {
        $this->insert(
            $this->subscribersTable,
            "$this->id_col,
            $this->e_mail_col, $this->type_col",
            "NULL, '$e_mail', '$type'"
        );
    }

    public function connect($servername, $username, $password, $db_name)
    {
        $this->db = new mysqli($servername, $username, $password, $db_name);
        if ($this->db->connect_error) {
            return false;
        }
        return true;
    }

    public function isConnected()
    {
        return $this->connected;
    }

    public function printSubscribers()
    {
        if (!$this->isConnected()) {
            return;
        }

        $result = $this->getSubscribers();
        $text = _s($this->subscribersTable);

        echo <<< HTML
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="$this->num_cols" scope="col">$text</th>
            </tr>
            <tr>
HTML;

        echo "<th scope='col'>"._s($this->id_col)."</th>";
        echo "<th scope='col'>"._s($this->e_mail_col)."</th>";
        echo "<th scope='col'>"._s($this->type_col)."</th>";

        echo <<< HTML
            </tr>
        </thead>
        <tbody>
HTML;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row[$this->id_col]."</td>";
                echo "<td>".$row[$this->e_mail_col]."</td>";
                echo "<td>"._s($row[$this->type_col])."</td>";
                echo "</tr>";
            }
        }

        echo <<< HTML
        </tbody>
    </table>
HTML;

    }

    private function select($columns, $tables, $conditions = NULL)
    {
        $query = "SELECT $columns FROM $tables";
        if ($conditions != NULL)
            $query .= " WHERE $conditions";
        return $this->db->query($query);
    }

    private function insert($table, $columns, $values)
    {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->db->query($query);
    }

    private function createSubscribersTable()
    {
        $query = <<< SQL
        CREATE TABLE IF NOT EXISTS $this->subscribersTable (
            ID int NOT NULL AUTO_INCREMENT,
            EMail varchar(255) NOT NULL,
            SubscriberType varchar(255),
            PRIMARY KEY (ID)
        );
SQL;
        $this->db->query($query);
    }
}