<?php

class Ipay_Order
{
    public $orders = array();
    public static $dbname = 'orders.txt';

    public function __construct() {

    }

    public static function getOrder($id) {

        foreach (self::getOrders() as $order) {
            if ($order->PersonalAccount == $id) {
                return $order;
            }
        }

        return false;
    }

    public function addOrder(array $order) {
        array_push($this->orders,$order);
        $this->save();
    }

    public function getOrders() {
        return json_decode(file_get_contents(self::$dbname));
    }

    public function save() {
        file_put_contents(self::$dbname,json_encode(self::getOrders()));
    }

    public function deleteOrder($id) {
//        foreach($this->orders as $order) {
//            if ($order->PersonalAccount == $id) {
//
//            }
//        }
    }


}
