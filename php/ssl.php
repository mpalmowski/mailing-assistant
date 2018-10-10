<?php

class Ssl
{
    private $key;
    private $iv;
    private $encrypt_method = "AES-256-CBC";
    private $algorythm = 'sha256';

    function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }

    public function encrypt($input)
    {
        $key = hash($this->algorythm, $this->key);
        $iv = substr(hash($this->algorythm, $this->iv), 0, 16);

        $output = openssl_encrypt($input, $this->encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    public function decrypt($input)
    {
        $key = hash($this->algorythm, $this->key);
        $iv = substr(hash($this->algorythm, $this->iv), 0, 16);

        $output = openssl_decrypt(base64_decode($input), $this->encrypt_method, $key, 0, $iv);
        return $output;
    }
}