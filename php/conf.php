<?php

class Conf
{
    private $directory = "res/conf.json";

    public $params = array(
        'sender_name' => '',
        'sender_address' => '',
        'reply_address' => '',
        'subscribe_link' => '',
        'unsubscribe_link' => '',
        'db_servername' => '',
        'db_username' => '',
        'db_password' => '',
        'db_name' => ''
    );

    public function load()
    {
        if (filesize($this->directory) <= 0) {
            $this->save();
            return;
        }
        $file = fopen($this->directory, "r");
        $json = fread($file, filesize($this->directory));
        fclose($file);
        $decoded = json_decode($json, true);
        $this->params = array_merge($this->params, $decoded);
    }

    public function set(){
        foreach ($this->params as $key => &$param){
            if(isset($_POST[$key])){
                $param = $_POST[$key];
            }
        }
    }

    public function save()
    {
        $file = fopen($this->directory, "w");
        $json = json_encode($this->params);
        fwrite($file, $json);
        fclose($file);
    }
}

$conf = new Conf;
$conf->load();