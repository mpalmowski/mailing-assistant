<?php

class Database
{
    /**
     * @var mysqli $db
     */
    private $db, $connected, $conf, $subscribers_table, $e_mail_col, $agreement_col, $num_cols;

    /**
     * Database constructor.
     * @param Conf $conf
     */
    public function __construct($conf)
    {
        $this->conf = $conf;
        $this->e_mail_col = $conf->get('e_mail_column');
        $this->agreement_col = $conf->get('agreement_col');
        $this->subscribers_table = $conf->get('subscribers_table');
        if (!$this->connect($conf->get('db_servername'), $conf->get('db_username'), $conf->get('db_password'), $conf->get('db_name')))
            $this->connected = false;
        else {
            $this->connected = true;
        }
        $this->num_cols = $this->getNumCols($conf->get('db_name'), $this->subscribers_table);
    }

    public function getSubscribers($all = false)
    {
        $condition = "";
        if(!$all)
            $condition .= $this->agreement_col."=1";
        return $this->select("*", $this->subscribers_table, $condition);
    }

    public function getSubscribersArray()
    {
        $result = $this->getSubscribers();
        $array = array();
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                array_push($array, $row[$this->e_mail_col]);
            }
        }
        return $array;
    }

    public function removeSubscriber($e_mail)
    {
        if(!$this->subscriberExists($e_mail))
            return 0;
        $query = "UPDATE $this->subscribers_table SET $this->agreement_col='0' WHERE $this->e_mail_col = '$e_mail'";
        if($this->db->query($query))
            return 1;
        else
            return -1;
    }

    public function subscriberExists($e_mail)
    {
        $existing = $this->select(
            $this->e_mail_col,
            $this->subscribers_table,
            "$this->e_mail_col = '$e_mail'"
        );
        if ($existing->num_rows == 0) {
            return false;
        }
        return true;
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

        $result = $this->getSubscribers(true);
        $text = _s($this->subscribers_table);

        echo <<< HTML
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="$this->num_cols" scope="col">$text</th>
            </tr>
            <tr>
HTML;

        echo "<th scope='col'>"._s($this->e_mail_col)."</th>";
        echo "<th scope='col'>"._s($this->agreement_col)."</th>";

        echo <<< HTML
            </tr>
        </thead>
        <tbody>
HTML;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row[$this->e_mail_col]."</td>";
                echo "<td>".$row[$this->agreement_col]."</td>";
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

    private function getNumCols($db_name, $table_name)
    {
        $query = "SELECT count(*) AS num_cols
                  FROM INFORMATION_SCHEMA.COLUMNS
                  WHERE table_schema = '$db_name'
                        AND table_name = '$table_name'";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['num_cols'];
    }
}