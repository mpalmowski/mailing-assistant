<?php

class Ssl
{
    private $key = 'noCai8080';
    private $iv = '4Kjj_AGDT9@4%n!L';
    private $encrypt_method = "AES-256-CBC";

    public function encrypt($input)
    {
        $key = hash('sha256', $this->key);
        $iv = substr(hash('sha256', $this->iv), 0, 16);

        $output = openssl_encrypt($input, $this->encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public function decrypt($input)
    {
        $key = hash('sha256', $this->key);
        $iv = substr(hash('sha256', $this->iv), 0, 16);

        $output = openssl_decrypt(base64_decode($input), $this->encrypt_method, $key, 0, $iv);
        return $output;
    }

    public function read_encrypted_file($directory)
    {
        if (filesize($directory) <= 0) {
            return "";
        }
        $file = fopen($directory, "r");

        $data = fread($file, filesize($directory));
        $data = $this->decrypt($data);

        fclose($file);

        return $data;
    }

    public function write_to_encrypted_file($directory, $data)
    {
        $file = fopen($directory, "w");

        $data = $this->encrypt($data);

        fwrite($file, $data);

        fclose($file);
    }

    public function append_file_without_repeats($directory, $new_data)
    {
        $data = $this->read_encrypted_file($directory);

        $exists = false;
        if(strpos($data, $new_data)!== false){
            $exists = true;
        }

        if(!$exists){
            $data .= $new_data;
            $this->write_to_encrypted_file($directory, $data);
        }

        return !$exists;
    }
}

$ssl = new Ssl;