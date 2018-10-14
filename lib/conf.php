<?php

class Conf
{
    private $params = [
        'language' => 'en',
        'sender_name' => '',
        'sender_address' => '',
        'reply_address' => '',
        'subscribe_link' => '',
        'unsubscribe_link' => ''
    ];

    private $conf_dir = "conf/conf.ini";
    private $configuration;

    function __construct()
    {
        $this->load();
        $this->set();
        $this->save();
    }

    public function load()
    {
        if (!file_exists($this->conf_dir)) {
            error_log("Configuration file missing");
            return;
        }
        $this->configuration = parse_ini_file($this->conf_dir);

        foreach ($this->params as $key => &$param) {
            if(isset($_COOKIE[$key])){
                $param = $_COOKIE[$key];
            }
        }
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
        $cookie_time = time() + (86400 * 365); //86400 - 1 day

        foreach ($this->params as $key => $param) {
            setcookie($key, $param, $cookie_time, '/');
        }
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        if (array_key_exists($key, $this->configuration)) {
            return $this->configuration[$key];
        }
        return NULL;
    }
}