<?php

class Sender
{
    private $sender_name, $sender_address, $reply_address, $subscribe_link, $unsubscribe_link, $header;
    private $variables, $links;

    public function __construct($sender_name, $sender_address, $reply_address, $subscribe_link, $unsubscribe_link)
    {
        $this->sender_name = $sender_name;
        $this->sender_address = $sender_address;
        $this->reply_address = $reply_address;
        $this->subscribe_link = $subscribe_link;
        $this->unsubscribe_link = $unsubscribe_link;

        $this->header = "MIME-Version: 1.0" . "\r\n";
        $this->header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $this->header .= "From: " . $this->sender_name . "<" . $this->sender_address . ">" . "\r\n";
        $this->header .= "Reply-To: " . $this->reply_address . "\r\n";
    }

    public function send($subject, $message, $address, $type="")
    {
        $address = trim($address);

        if (!strlen($address))
            return true;

        if (!$this->validateAddress($address))
            return false;

        $this->variables = [
            "e-mail" => $address,
            "subscriber_type" => $type
        ];
        $subscribe_link = $this->insertVariables($this->subscribe_link);
        $unsubscribe_link = $this->insertVariables($this->unsubscribe_link);

        $this->links = [
            "subscribe_link" => $subscribe_link,
            "unsubscribe_link" => $unsubscribe_link
        ];
        $message = $this->insertLinks($message);

        return mail($address, $subject, $message, $this->header);
    }

    public function validateAddress($address)
    {
        $mail_regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
        return preg_match($mail_regex, $address);
    }

    private function insertLinks($string)
    {
        $new_string = $string;
        foreach ($this->links as $name => $value) {
            $new_string = str_replace("_insert_" . $name . "_", $value, $new_string);
        }
        return $new_string;
    }

    private function insertVariables($string)
    {
        $new_string = $string;
        foreach ($this->variables as $name => $value) {
            $new_string = str_replace("_insert_" . $name . "_", $value, $new_string);
        }
        return $new_string;
    }
}