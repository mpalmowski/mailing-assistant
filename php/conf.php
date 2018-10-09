<?php

class Conf
{
    private $directory = "res/conf.json";

    public $params = [
        'sending' => [
            'sender_name' => '',
            'sender_address' => '',
            'reply_address' => '',
            'subscribe_link' => '',
            'unsubscribe_link' => ''
        ],
        'database' => [
            'db_servername' => '',
            'db_username' => '',
            'db_password' => '',
            'db_name' => ''
        ]
    ];

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

    public function set(){
        foreach ($this->params as &$category){
            foreach ($category as $key => &$param){
                if(isset($_POST[$key])){
                    $param = $_POST[$key];
                }
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

    public function get($key){
        foreach ($this->params as $category){
            if (array_key_exists($key, $category)){
                return $category[$key];
            }
        }
        return "";
    }
}

$conf = new Conf;
$conf->load();