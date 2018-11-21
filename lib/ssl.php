<?php

class Ssl
{
    private $key, $iv, $encrypt_method;

    public function __construct($conf)
    {
        $this->key = $conf->get('ssl_key');
        $this->iv = $conf->get('ssl_iv');
        $this->encrypt_method = $conf->get('ssl_encryption_method');
    }

    public function hash($input)
    {
        return substr(hash('sha256', $input), 0, 16);
    }

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
}