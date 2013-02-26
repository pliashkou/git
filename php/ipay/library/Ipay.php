<?php

class Ipay
{
    public $request;
    public $result;

    public function __construct(){
        if ('POST' === $_SERVER['REQUEST_METHOD'])
            $this->request =  new SimpleXMLElement($_POST['XML']);
        return $this;
    }

    public function processRequest() {

        $class = 'Ipay_Request_'.$this->request->RequestType;
        $object = new $class();
        $this->result = $object->process($this->request);

        return $this;
    }

    public function getRequest() {
        return $this->request;
    }

    public function getResult() {
        return $this->result;
    }
}
