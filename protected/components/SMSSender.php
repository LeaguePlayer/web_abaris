<?php
/**
 * Created by JetBrains PhpStorm.
 * User: megakuzmitch
 * Date: 08.10.13
 * Time: 14:48
 * To change this template use File | Settings | File Templates.
 */

class SMSSender extends CComponent
{
    public $login;
    public $pwd;
    public $sender;
    public $translit = false;
    public $msglife = false;
    public $getcost = false;
    public $tf = false;

    private $_phones = array();
    private $_message;

    public function init()
    {
        return true;
    }

    public function addPhone($phone)
    {
        if (!in_array($phone, $this->_phones)) {
            $this->_phones[] = $phone;
        }
    }

    public function removePhone($phone)
    {
        foreach ($this->_phones as $key => $_ph) {
            if ( $_ph == $phone ) {
                unset($this->_phones[$key]);
                break;
            }
        }
        sort($this->_phones);
    }

    public function clearPhones()
    {
        $this->_phones = array();
    }

    public function getPhones()
    {
        return $this->_phones;
    }

    public function setMessage($message)
    {
        if ( $message === null or strlen(rawurlencode($message)) > 800 )
            throw new CException(0, 'Извините! Возникла неполадка при отправке СМС');
        $this->_message = $message;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    public function send($message = null, $phones = false)
    {
        $this->setMessage($message);
        return $this->processSend($phones);
    }

    protected function processSend($sendTo = false)
    {
        if ( is_array($sendTo) )
            $phones = $sendTo;
        else if (is_numeric($sendTo))
            $phones = array($sendTo);
        else
            $phones = $this->getPhones();

        $host = "api.infosmska.ru";
        $fp = fsockopen($host, 80);

        $get = "GET /interfaces/SendMessages.ashx" .
            "?login=" . rawurlencode($this->login) .
            "&pwd=" . rawurlencode($this->pwd) .
            "&phones=" . rawurlencode( implode(',', $phones) ) .
            "&message=" . rawurlencode($this->getMessage()) .
            "&sender=" . rawurlencode($this->sender);
        if ( $this->translit )  $get .= "&translit=" . rawurlencode($this->translit);
        if ( $this->msglife )   $get .= "&msglife=" . rawurlencode($this->msglife);
        if ( $this->getcost )   $get .= "&getcost=" . rawurlencode($this->getcost);
        if ( $this->tf )        $get .= "&tf=" . rawurlencode($this->tf);
        $get .= "  HTTP/1.1\r\nHost: $host\r\nConnection: Close\r\n\r\n";

        fwrite($fp, $get);
        fwrite($fp, "Host: " . $host . "\r\n");
        fwrite($fp, "\n");
        $response = '';
        while(!feof($fp)) {
            $response .= fread($fp, 1);
        }
        fclose($fp);

        list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
        list($other, $ids_str) = explode(":", $responseBody, 2);
        list($sms_id, $other) = explode(";", $ids_str, 2);

        return $sms_id;
    }
}