<?php

class Conf
{
    private $directory = "conf/conf.json";

    public $params = [
        'language' => 'en',
        'sender_name' => '',
        'sender_address' => '',
        'reply_address' => '',
        'subscribe_link' => '',
        'unsubscribe_link' => '',
        'db_servername' => '',
        'db_username' => '',
        'db_password' => '',
        'db_name' => '',
        'ssl_key' => 'privateKey',
        'ssl_iv' => '1234abcdEFGH'
    ];

    function __construct()
    {
        $this->load();
        if($this->set())
            $this->save();
    }

    public function load()
    {
        if (!file_exists($this->directory)) {
            $this->save();
            return;
        }
        $file = fopen($this->directory, "r");
        $json = fread($file, filesize($this->directory));
        fclose($file);
        $decoded = json_decode($json, true);
        $this->params = array_merge($this->params, $decoded);
    }

    public function set()
    {
        $updated = false;
        foreach ($this->params as $key => &$param) {
            if (isset($_POST[$key])) {
                $param = $_POST[$key];
                $updated = true;
            }
        }
        return $updated;
    }

    public function save()
    {
        $file = fopen($this->directory, "w");
        $json = json_encode($this->params);
        fwrite($file, $json);
        fclose($file);
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return "";
    }

    public function getParams()
    {
        return $this->params;
    }
}

$conf = new Conf;