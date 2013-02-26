<?php

class Ipay_Transaction
{
    public $transaction;
//    public $id;
//    public $transactionId;
//    public $amount;
//    public $agent;
//    public $authorisationType;

    public function __construct($transaction) {
        $this->transaction = $transaction;
//        print_r($this->transaction);
    }

    public function __get($param) {
        return $this->transaction->{$param};
    }

    public function __set($param,$value) {
        $this->transaction->{$param} = $value;
    }

    public function save() {
        Ipay_Transaction_Manager::saveTransaction($this->transaction);
    }

    public function getTransaction(){
        return $this->transaction;
    }
}
