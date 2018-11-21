<?php

class Conf
{
    private $params = [
        'language' => 'en',
        'sender_name' => '',
        'sender_address' => '',
        'reply_address' => '',
        'unsubscribe_link' => ''
    ];

    private $conf_dir = "conf/conf.ini";
    private $params_dir = "conf/params.json";
    private $configuration;

    function __construct()
    {
        $this->conf_dir = dirname(__DIR__) . "/" . $this->conf_dir;
        $this->load();
        $this->set();
        $this->save();
    }

    public function load()
    {
        if (!file_exists($this->conf_dir)) {
            error_log("Configuration file missing: ".$this->conf_dir);
            return;
        }
        $this->configuration = parse_ini_file($this->conf_dir);

        if (!file_exists($this->params_dir)) {
            $this->save();
            return;
        }
        $file = fopen($this->params_dir, "r");
        $json = fread($file, filesize($this->params_dir));
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
        $file = fopen($this->params_dir, "w");
        $json = json_encode($this->params);
        fwrite($file, $json);
        fclose($file);
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